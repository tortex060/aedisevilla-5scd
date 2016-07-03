<?php get_header(); ?> 

  <!-- flexboxer -->
  <div id="flexboxer-<?php the_ID(); ?>" class="flexboxer flexboxer--index">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      
        <!-- thumbnail -->
        <?php if(has_post_thumbnail()){ ?>
          <section class="wrap wrap--frame">
            <header id="header-<?php the_ID(); ?>" class="header header--article">
              <figure id="thumbnail-<?php the_ID(); ?>" class="thumb thumb--article js-fullheight js-fullheight-thumb">
                <?php the_post_thumbnail('full');  ?>
              </figure>
              <div class="overflow overflow--black"></div>
              <div id="title-<?php the_ID(); ?>" class="title title--article">
                <div class="divtextarticle">
                  <h2 class="titletextarticle titlesarticle" ><?php the_title(); ?></h2>
                  <?php if(function_exists('the_subtitle')){?>
                    <h3 class="subtitletextarticle titlesarticle"><?php the_subtitle(); ?></h3>
                  <?php } ?>
                </div>
              </div>
              <div class="categoryarticle">
                <p><?php the_category(', ');?></p>
              </div>
            </header>
          </section>
        <?php }?><!-- end of thumbnail -->

        <!-- content -->
        <section class="wrap wrap--content">
          <h2><?php the_title();?></h2>
          <?php the_content();?>
        </section><!-- end of content -->

      <?php endwhile; ?>
    <?php else : ?>

      <!-- noinfo -->
      <section class="wrap wrap--content">
        <h2><php _e('No info', 'sanderblockecommerce' ) ?></h2>
      </section><!-- end of noinfo -->

    <?php endif; ?>
  </div><!-- end of flexboxer -->
<?php get_footer(); ?>