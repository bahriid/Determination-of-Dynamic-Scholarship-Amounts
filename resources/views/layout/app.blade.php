
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- link rel="icon" href="../../favicon.ico" -->

    <title>Aplikasi Fuzzy Beasiswa</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}


    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style.css') }}" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCzX9p40w9AMetlyG_qUi_9rw0ifj9rhk&libraries=geometry,places"></script>
    <script type="text/javascript" src=" {{ asset('js/maps.google.polygon.containsLatLng.js') }} "></script>
    
    
    <style>
      body {
        padding-bottom: 20px;
        font-size: 13px;
      }

      .navbar {
        margin-bottom: 20px;
      }


      .list-main-btn {
        margin-bottom: 10px;
      }

      form.list-action {
        display: inline-block;
      }

      .wrapper {	
        margin-top: 80px;
        margin-bottom: 80px;
      }

      .form-signin {
        max-width: 380px;
        padding: 15px 35px 45px;
        margin: 0 auto;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,0.1);  
      }

      .form-signin input {
        margin-bottom: 8px;
      }

      /* CSS REQUIRED */
      .state-icon {
          left: -5px;
      }
      .list-group-item-primary {
          color: rgb(255, 255, 255);
          background-color: rgb(66, 139, 202);
      }

      /* DEMO ONLY - REMOVES UNWANTED MARGIN */
      .well .list-group {
          margin-bottom: 0px;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div id="app">
        
        @include('layout.partials.navigation')

        <div class="container">
            @yield('content')
        </div>
    </div>


    <script>
      $.fn.datepicker.defaults.format = "dd/mm/yyyy";
      $(function () {
          $('.list-group.checked-list-box .list-group-item').each(function () {
              
              // Settings
              var $widget = $(this),
                  $checkbox = $('<input type="checkbox" class="hidden" name="lokasiTanah[]" value="'+$(this).text()+'" />'),
                  color = ($widget.data('color') ? $widget.data('color') : "primary"),
                  style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),

                  settings = {
                      on: {
                          icon: 'glyphicon glyphicon-check'
                      },
                      off: {
                          icon: 'glyphicon glyphicon-unchecked'
                      }
                  };
                  
              $widget.css('cursor', 'pointer')
              $widget.append($checkbox);

              // Event Handlers
              $widget.on('click', function () {
                  $checkbox.prop('checked', !$checkbox.is(':checked'));
                  $checkbox.triggerHandler('change');
                  updateDisplay();
              });
              $checkbox.on('change', function () {
                  updateDisplay();
              });
                

              // Actions
              function updateDisplay() {
                  var isChecked = $checkbox.is(':checked');

                  // Set the button's state
                  $widget.data('state', (isChecked) ? "on" : "off");

                  // Set the button's icon
                  $widget.find('.state-icon')
                      .removeClass()
                      .addClass('state-icon ' + settings[$widget.data('state')].icon);

                  // Update the button's color
                  if (isChecked) {
                      $widget.addClass(style + color + ' act');
                  } else {
                      $widget.removeClass(style + color + ' act');
                  }
              }

              // Initialization
              function init() {
                  
                  if ($widget.data('checked') == true) {
                      $checkbox.prop('checked', !$checkbox.is(':checked'));
                  }
                  
                  updateDisplay();

                  // Inject the icon if applicable
                  if ($widget.find('.state-icon').length == 0) {
                      $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
                  }
              }
              init();
          });
          
          $('#get-checked-data').on('click', function(event) {
              event.preventDefault(); 
              var checkedItems = {}, counter = 0;
              $("#check-list-box li.act").each(function(idx, li) {
                  checkedItems[counter] = $(li).text();
                  counter++;
              });
              $('#display-json').html(JSON.stringify(checkedItems, null, '\t'));
          });
      });

      $(function () {   
          $('.list-group.checked-list-box2 .list-group-item').each(function () {
              
              // Settings
              var $widget = $(this),
                  $checkbox = $('<input type="checkbox" class="hidden" checked="checked" disabled readonly />'),
                  color = ($widget.data('color') ? $widget.data('color') : "primary"),
                  style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),

                  settings = {
                      on: {
                          icon: 'glyphicon glyphicon-check'
                      },
                      off: {
                          icon: 'glyphicon glyphicon-unchecked'
                      }
                  };

              $widget.append($checkbox);

              // Actions
              function updateDisplay() {
                  var isChecked = $checkbox.is(':checked');

                  // Set the button's state
                  $widget.data('state', (isChecked) ? "on" : "off");

                  // Set the button's icon
                  $widget.find('.state-icon')
                      .removeClass()
                      .addClass('state-icon ' + settings[$widget.data('state')].icon);

                  // Update the button's color
                  if (isChecked) {
                      $widget.addClass(style + color + ' act');
                  } else {
                      $widget.removeClass(style + color + ' act');
                  }
              }

              // Initialization
              function init() {
                  
                  if ($widget.data('checked') == true) {
                      $checkbox.prop('checked', !$checkbox.is(':checked'));
                  }
                  
                  updateDisplay();

                  // Inject the icon if applicable
                  if ($widget.find('.state-icon').length == 0) {
                      $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '" style="display:none;"></span>');
                  }
              }
              init();
          });
      });

    </script>
    @yield('content.js')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>
