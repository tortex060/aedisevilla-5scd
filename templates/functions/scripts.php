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


    jQuery(document).ready(function($) {

    });
  </script>

  <?php if(is_home() || is_page('shop') || is_archive('product')){ ?> 

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

      jQuery(window).load(function() { 

        jQuery('.js-imagefill').imagefill(); 
        
        jQuery('.js-slider').flickity({
          initialIndex: 2,
          wrapAround: true
        });
      });
*/
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