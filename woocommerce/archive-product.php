<?php get_header(); ?>

<!-- products list -->
<div class="flexboxer flexboxer--archive flexboxer--archive__product">
  
  <?php if ( have_posts() ) { ?>

  <!-- introduction -->
  <section class="wrap wrap--content wrap--spaced">
    <h1>Compra de entradas</h1>
    <p>Escoge rápido, que se acaban!</p>
  </section><!-- end of introduction -->

    <section class="wrap wrap--frame wrap--masonry">
      <?php while ( have_posts() ) : the_post(); ?>
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
  <?php } else { ?>

  <!-- introduction -->
  <section class="wrap wrap--content wrap--spaced">
    <h1>Compra de entradas</h1>
    <p>En estos momentos no tenemos entradas a la venta.<br>
    <a href="<?php bloginfo('url'); ?>">Volver al inicio</p>
  </section><!-- end of introduction -->

  <?php }
  wp_reset_postdata();
  ?>
</div><!-- end of products list -->


<?php get_footer(); ?>
