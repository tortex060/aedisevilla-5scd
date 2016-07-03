<?php
get_header();
$product = new WC_Product( get_the_ID() );
$price = get_post_meta( get_the_ID(), '_regular_price');
$price = $price[0];
$sale = get_post_meta( get_the_ID(), '_sale_price');
$sale = $sale[0];
?>

<!-- shop interface -->
<div class="flexboxer flexboxer--single flexboxer--single__product">

  <section class="wrap wrap--frame wrap--flex">
    <div class="wrap wrap--frame wrap--frame__middle">
      <div id="thumbproduct" class="thumb thumb--product">
        <?php echo get_the_post_thumbnail(get_the_ID(), 'large');?>
      </div>
    </div>

    <div class="wrap wrap--content wrap--content__middle content content--product">
      <div class="description description--product">
        <h2 class="title title--product title--product"><?php the_title();?></h2>
        <?php echo $post->post_content;?>
      </div>
      <?php echo do_shortcode('[add_to_cart id="'.$post->ID.'"]'); ?> 
    </div>
  </section>

</div><!-- end of shop interface -->


  


<?php get_footer(); ?>