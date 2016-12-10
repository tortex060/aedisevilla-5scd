
<?php get_header(); ?> 

<?php
$product_args = array (
  'post_type' => array( 'product' ),
);
$product_query = new WP_Query( $product_args );
wp_reset_postdata();
?>

<!-- flexboxer -->
<?php $post_id = 51; $post_object = get_post( $post_id ); ?>
<div class="flexboxer flexboxer--background" style="background-image: url('<?php if (has_post_thumbnail($post_id)) echo get_the_post_thumbnail_url($post_id,'full'); else echo get_stylesheet_directory_uri().'/assets/img/box/box3.jpg'; ?>')">
  <section class="wrap wrap--frame wrap--headlogo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-claim.svg" alt="">
  </section>
</div>
<div class="flexboxer flexboxer--presentation">
  <section class="wrap wrap--content wrap--spaced">
    <h1><?php echo get_the_title($post_id);?></h1>
    <?php echo apply_filters('the_content',$post_object->post_content);?>
  </section>
</div>

<?php $post_id = 54; $post_object = get_post( $post_id ); ?>
<div class="flexboxer flexboxer--leitmotiv">
  <section class="wrap wrap--content wrap--spaced wrap--flex">
    <div class="wrap wrap--frame wrap--frame__middle">
      <h1><?php echo get_the_title($post_id);?></h1>
      <?php echo apply_filters('the_content',$post_object->post_content);?>
    </div>
    <div class="wrap wrap--frame wrap--frame__middle">
      <img src="" alt="">
    </div>
  </section>
</div>

<div class="flexboxer flexboxer--program hidden">
  <h1>Ponentes</h1>
</div>

<?php $post_id = 56; $post_object = get_post( $post_id ); ?>
<div class="flexboxer flexboxer--program flexboxer--background" style="background-image: url('<?php if (has_post_thumbnail($post_id)) echo get_the_post_thumbnail_url($post_id,'full'); else echo get_stylesheet_directory_uri().'/assets/img/box/box.jpg'; ?>')">
  <section class="wrap wrap--content wrap--flex wrap--spaced">
    <div class="wrap wrap--frame wrap--frame__middle">
      <h1><?php echo get_the_title($post_id);?></h1>
      <?php echo apply_filters('the_content',$post_object->post_content);?>
    </div>
    <div class="wrap wrap--frame wrap--frame__middle"></div>
  </section>
</div>


<?php $post_id = 58; $post_object = get_post( $post_id ); ?>
<div class="flexboxer flexboxer--archive flexboxer--archive__product">
  <?php if ( $product_query->have_posts() ) { ?>
    <section class="wrap wrap--content">
      <h1><?php echo get_the_title($post_id);?></h1>
    </section>
    <section class="wrap wrap--frame wrap--masonry">
      <?php while ( $product_query->have_posts() ) : $product_query->the_post(); ?>
        <div class="item">
          <div class="wrap wrap--frame wrap--thumb" >
            <div class="overflow">
              <?php woocommerce_template_loop_add_to_cart();?>
              <a href="<?php the_permalink();?>" class="moreinfo">Detalles</a>
            </div>
            <?php echo woocommerce_get_product_thumbnail();?>
          </div>
          <div class="wrap wrap--content wrap--flex">
            <div class="wrap wrap--frame wrap--frame__middle">
              <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
            </div>
            <div class="wrap wrap--frame wrap--frame__100 wrap--price">
              <?php woocommerce_template_single_price();?>
            </div>
          </div>
        </div><!-- end of item -->
      <?php endwhile; ?>
    </section>
    <section class="wrap wrap--content">
      <?php echo apply_filters('the_content',$post_object->post_content);?>
    </section>
  <?php }else{ ?>
    <section class="wrap wrap--content  wrap--spaced">
      <h1><?php echo get_the_title($post_id);?></h1>
      <p>Lo sentimos, no quedan entradas a la venta :(</p>
    </section>
  <?php } ?>
</div>

<div class="flexboxer flexboxer--program hidden">
  <h1>Patrocinadores</h1>
</div>

<?php $post_id = 61; $post_object = get_post( $post_id ); ?>
<div class="flexboxer flexboxer--program">
  <section class="wrap wrap--content">
    <h1><?php echo get_the_title($post_id);?></h1>
    <?php echo apply_filters('the_content',$post_object->post_content);?>
  </section>
</div>

<?php get_footer(); ?>
