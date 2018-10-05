 function func_notice($num, $str, $file, $line) {
      $css = '<style>/* The alert message box */
          .alert {
              font-family: Trebuchet MS !important;
              font-size: 14px;
              padding: 20px;
              background-color: #ff9800; /* Red */
              color: white;
              margin-bottom: 15px;
              opacity: 1;
              border-radius: 2px;
              transition: opacity 0.6s;
          }

          /* The close button */
          .closebtn {
              margin-left: 15px;
              color: white;
              font-weight: bold;
              float: right;
              font-size: 22px;
              line-height: 20px;
              cursor: pointer;
          }

          .closebtn:hover {
              color: black;
          }</style>';

          $js = '<script>
            // Get all elements with class="closebtn"
            var close = document.getElementsByClassName("closebtn");
            var i;

            // Loop through all close buttons
            for (i = 0; i < close.length; i++) {
                // When someone clicks on a close button
                close[i].onclick = function(){

                    // Get the parent of <span class="closebtn"> (<div class="alert">)
                    var div = this.parentElement;

                    // Set the opacity of div to 0 (transparent)
                    div.style.opacity = "0";

                    // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
                    setTimeout(function(){ div.style.display = "none"; }, 600);
                }
            }
            </script>';
            echo $js;
            echo $css;
            echo '<div class="alert">
                  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                  <strong>Notice!</strong> &nbsp;'.$num.' in '.$file.', line '.$str.'
                </div>';
     }

    function func_error($num, $str, $file, $line, $context) {
     echo "me Encountered error ".$num." in ".$file.", line ".$str." Context".$context;
     }

    set_error_handler("func_error", E_ALL);
    set_error_handler("func_notice", E_NOTICE);
