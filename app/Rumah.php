<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Fuzzy;
use App\Pricermh;

class Rumah extends Model
{
    public function calculateFuzzy()
    {
        $fuzzy = new Fuzzy($this);
        return $fuzzy->calculate();
    }



    public function prices()
    {
        return $this->hasMany('App\Pricermh', 'rumah_id');
    }

    public function save(array $options = Array())
    {

        $fuzzy = $this->calculateFuzzy();
        $this->fuzzy_price = $fuzzy->result;
        $this->fuzzy_calculation = json_encode($fuzzy, JSON_PRETTY_PRINT);



        return parent::save($options);
    }

    public function delete()
    {
        $this->prices()->delete();
        return parent::delete();
    }
}
