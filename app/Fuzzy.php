<?php

namespace App;

use Stdclass;

use App\Fuzzyset;
use App\Fuzzyrange;
use Exception;

class Fuzzy
{
    const LOW = 'LOW';
    const MID = 'MID';
    const HIGH = 'HIGH';

    const PENGHASILAN_ORANGTUA = 'penghasilan_orangtua';
    const NILAI_AKADEMIK = 'nilai_akademik';
    const POIN_SERTIFIKAT = 'poin_sertifikat';

    private $rumah;

    public function __construct($rumah)
    {
      $this->rumah = $rumah;
    }

    public function getCode($type, $state)
    {
      $code = null;

      switch ($type) {
      case static::PENGHASILAN_ORANGTUA:
        $code = 'penghasilan_' . $state;
        break;
      case static::NILAI_AKADEMIK:
        $code = 'nilai_' . $state;
        break;
      case static::POIN_SERTIFIKAT:
        $code = 'poin_' . $state;
        break;       
      }

      return $code;
    }

    public function calculate()
    {
      // fuzzyfikasi
      $input_var = [
        static::PENGHASILAN_ORANGTUA => [
            static::LOW,
            static::MID,
            static::HIGH
        ],
        static::NILAI_AKADEMIK => [
            static::LOW,
            static::MID,
            static::HIGH
        ],
        static::POIN_SERTIFIKAT => [
            static::LOW,
            static::MID,
            static::HIGH
        ]
      ];

      $fuzzy = [];
      foreach($input_var as $key => $states) {
        foreach($states as $state) {
          // mengambil nilai value, apakah harga kompetitor,
          // harga sebelum, atau harga sekarang
          $value = 0;
          switch ($key) {
          case static::PENGHASILAN_ORANGTUA:
            $value = $this->rumah->penghasilan_orangtua;
            break;
          case static::NILAI_AKADEMIK:
            $value = $this->rumah->nilai_akademik;
            break;
          case static::POIN_SERTIFIKAT:
            $value = $this->rumah->poin_sertifikat;
            break;
          default:
            throw new Exception('FATAL ERROR');
          }
          // menghitung nilai fuzzy
          $fuzzy[$key][$state] = $this->calculateFuzzy($key, $value, $state);
        }
      }

      // inferensi
      $sets = Fuzzyset::get();
      $inference = [];
      foreach ($sets as $set) {
        $state = [
          $fuzzy[static::PENGHASILAN_ORANGTUA][$set->penghasilan_orangtua],
          $fuzzy[static::NILAI_AKADEMIK][$set->nilai_akademik],
          $fuzzy[static::POIN_SERTIFIKAT][$set->poin_sertifikat],
        ];

        $range = Fuzzyrange::where('code', '=', 'result_' . $set->result_price)->first();
        $infer = $this->calculateInference($state, $range);
        foreach($infer as $i) {
          $i->set = [
            static::PENGHASILAN_ORANGTUA => $set->penghasilan_orangtua,
            static::NILAI_AKADEMIK => $set->nilai_akademik,
            static::POIN_SERTIFIKAT => $set->poin_sertifikat,
            "RESULT" => $set->result_price,
          ];
          $i->set_value = $state;
        }

        $inference = array_merge($inference, $infer);
      }
      
      // defuzifikasi
      $result = $this->calculateDefuzzification($inference);

      $wrap = new Stdclass();
      $wrap->fuzzy = $fuzzy;
      $wrap->inference = $inference;
      $wrap->result = $result;

      return $wrap;
    }


    public function calculateFuzzy($type, $value, $state)
    {
      $code = $this->getCode($type, $state);
      $range = Fuzzyrange::where('code', '=', $code)->first();

      echo "<script>alert('".$state."')</script>";

      switch ($state) {
      case static::LOW:
        // grafik turun
        return $this->calculateFuzzyStepDown($value, $range);
        break;
      case static::MID:
        $middle = $range->middle;
        if ($value < $middle) {
          // nilai dibawah nilai tengah
          // ambil sebagai grafik naik
          $range->max = $middle;
          return $this->calculateFuzzyStepUp($value, $range);
        } else if ($value > $middle) {
          // nilai diatas nilai tengah
          // ambil sebagai grafik turun
          $range->min = $middle;
          return $this->calculateFuzzyStepDown($value, $range);
        } else {
          // pas di posisi nilai tengah
          // dianggap bernilai 1
          return 1;
        }
        break;
      case static::HIGH:
        // grafik naik
        return $this->calculateFuzzyStepUp($value, $range);
        break;
      default:
        throw new Exception('FATAL ERROR');
      }
    }

    public function calculateFuzzyStepUp($value, $range)
    {
      if ($value <= $range->min)
        return 0;

      if ($value >= $range->max)
        return 1;

      return ($value - $range->min) / ($range->max - $range->min);
    }

    public function calculateFuzzyStepDown($value, $range)
    {
      if ($value <= $range->min)
        return 1;

      if ($value >= $range->max)
        return 0;

      return ($range->max - $value) / ($range->max - $range->min);
    }

    public function calculateInference($state, $range)
    {
      $infer = new Stdclass();
      $infer->alpha = min($state);
      $range_state = explode('_', $range->code)[1];
      switch ($range_state) {
      case static::LOW:
        $infer->z = $range->max - $infer->alpha * ($range->max - $range->min);
        break;
      case static::MID:
        // aturan untuk middle
        $middle = $range->middle;
        $max = $range->max;
        
        $range->max = $middle;
        $infer->z = $infer->alpha * ($range->max - $range->min) + $range->min;
        
        $infer2 = new Stdclass();
        $infer2->alpha = $infer->alpha;

        $range->max = $max;
        $range->min = $middle;
        $infer2->z = $range->max - $infer2->alpha * ($range->max - $range->min);
        
        return [$infer, $infer2];
      case static::HIGH:
        $infer->z = $infer->alpha * ($range->max - $range->min) + $range->min;
        break;
      default:
        throw new Exception('FATAL ERROR, INVALID [' . $range_state . ']');
      }

      return [$infer];
    }

    public function calculateDefuzzification($inference)
    {
      $side_up = 0;
      $side_down = 0;

      foreach($inference as $infer) {
        $side_up += $infer->alpha * $infer->z;
        $side_down += $infer->alpha;
      }

      if ($side_down == 0)
        return 0;

      return $side_up / $side_down;
    }
}
