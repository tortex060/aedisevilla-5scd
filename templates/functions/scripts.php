<?php 

add_action( 'wp_head', 'inject_in_all' );
function inject_in_all() { ?>

  <script>

    function ToggleMenu(args){
      if(jQuery('#'+args).hasClass('active') || args == 'close'){
        jQuery('.js-menu').removeClass("active");
        jQuery('#overlaybody').removeClass("active");
      }else{
        jQuery('.js-menu').removeClass("active");
        jQuery('#overlaybody').addClass("active");
        jQuery('#'+args).addClass("active");
      }
    }

    function ToggleSection(elem){
      var elem = jQuery(elem)[0];
      var section = jQuery(elem).data('section');

      if(jQuery(elem).hasClass('active') || section == 'close'){
        jQuery(elem).removeClass('active');
        jQuery('.js-section').removeClass("active");
        jQuery('.js-section-launch').removeClass("active");
      }else{
        jQuery('.js-section').removeClass("active");
        jQuery('.js-section-launch').removeClass("active");
        jQuery('.js-section-'+section).addClass("active");
        jQuery('#'+section).addClass("active");
        jQuery(elem).addClass('active');
      } 
    }

    function ToggleSelect(select_id){
      var section = jQuery('#'+select_id+' option:selected').val();
      if(jQuery('#js-select-'+section).hasClass('active') || select_id == 'close'){
        jQuery('.js-select-'+select_id).removeClass("active");
      }else{
        jQuery('.js-select-'+select_id).removeClass("active");
        jQuery('#js-select-'+section).addClass("active");
      }
    }

    function imageresize() {
        if (jQuery('.js-fullheight').length > 0) jQuery('.js-fullheight').css("height", jQuery(window).height() - jQuery('#headertop').outerHeight());
        if (jQuery('.js-fullheight-thumb').length > 0) jQuery('.js-fullheight-thumb').imagefill();
    }

    String.prototype.toHHMMSS = function() {
        var sec_num = parseInt(this, 10);
        var hours = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);
     
        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        var time = hours + ':' + minutes + ':' + seconds;
        return time;
    }
     
    function getValorOrden(contador) {
        var valorDefecto = "000000".substring(0, 6 - contador.toString().length);
        return valorDefecto + contador;
    }

    jQuery(document).ready(function($) {

      //Detect dragging in <game></game>
      if (jQuery('#chart .node').length > 0){
          var isDragging = false;
          $("#chart .node rect").mousedown(function() {
                  isDragging = false;
              })
              .mousemove(function() {
                  isDragging = true;
              })
              .mouseup(function() {
                  var wasDragging = isDragging;
                  isDragging = false;
                  if (!wasDragging) ga('send', 'event', 'Game', 'play', 'drag');
              });
      }        
     
      //Time counter
      var i = 1,
          time = 10;
      window.setInterval(function() {
          tiempo = (i * time).toString();
          if (i > 6 && i <= 180 && (i % 6) == 0) {
              ga('send', 'event', 'Tiempo', document.title, getValorOrden(i) + " " + tiempo.toHHMMSS(), 1);
          } else if (i <= 6) {
              ga('send', 'event', 'Tiempo', document.title, getValorOrden(i) + " " + tiempo.toHHMMSS(), 1);
          } else if (i > 180 && (i % 30) == 0) { // Mayor que 30 min
              ga('send', 'event', 'Tiempo', document.title, getValorOrden(i) + " " + tiempo.toHHMMSS(), 1);
          }
          i++;
      }, time * 1000);
     
    });


  </script>

  <?php if(is_home()){ ?> 

    <script>
/*      jQuery(document).ready(function($) {
        $('.add_to_cart_button').on("click", function(){

          var text_original = $(this).text();
          var text_temporal = "¡Añadido!";
          $(this).text(text_temporal);

          setTimeout(function(){
            $('.add_to_cart_button').text(text_original);
          }, 3000);

        });
      });
*/
      jQuery(window).load(function() { 
        
        jQuery('.js-slider').flickity({
          initialIndex: 2,
          freeScroll: true,
          wrapAround: true,
          autoPlay: 3000
        });
      });

    </script>

  <?php } if( is_singular('product')){ ?> 

    <script>
/*
      jQuery(document).ready(function($) {
        $('.js-imagefill').imagefill(); 
      });

      jQuery(window).load(function() { 
        jQuery('.js-slider').flickity({
          initialIndex: 2,
          wrapAround: true
        });

        jQuery('.carousel-cell img').on("click", function(){
          var src = jQuery(this).attr('src');
          jQuery('#thumbproduct img').attr('src', src);
        })

      });
*/
    </script>

  <?php } ?>

<?php } ?>