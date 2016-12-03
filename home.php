
<?php get_header(); ?> 

<?php
$product_args = array (
  'post_type' => array( 'product' ),
);
$product_query = new WP_Query( $product_args );
wp_reset_postdata();
?>

<!-- flexboxer -->
<div class="flexboxer flexboxer--background" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/box/box3.jpg')">
  <section class="wrap wrap--frame wrap--headlogo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-claim.svg" alt="">
  </section>
</div>

<div class="flexboxer flexboxer--presentation">
  <section class="wrap wrap--content wrap--spaced">
    <h1>#5SCD Sevilla Ciudad del Diseño</h1>
    <p>La SCD es el principal evento de diseño industrial desarrollado en Andalucía, de cuatro días de duración, que ha ido creciendo edición tras edición, y que reúne a estudiantes y profesionales de todo el Estado. Empezó como un evento local, ha crecido rápidamente hasta convertirse en una fecha de referencia obligada, que cuelga el cartel de agotadas localidades en pocas horas en todas las ediciones, y que año tras año cuenta con las figuras más importantes del panorama español.</p>
    <p>El éxito de la SCD es, en parte, gracias a un formato cercano al público, con un programa dinámico consistente en conferencias, debates, y múltiples workshops. La celebración de este evento en la capital andaluza supone un empuje para la región, al facilitar el acercamiento de profesionales y estudiantes a nuevas profesiones y sectores  relacionados con la innovación y la economía del conocimiento.</p>
  </section>
</div>

<div class="flexboxer flexboxer--leitmotiv">
  <section class="wrap wrap--content wrap--spaced wrap--flex">
    <div class="wrap wrap--frame wrap--frame__middle">
      <h1>USABLE % IMAGINABLE</h1>
      <p>La usabilidad, además de ser una materia importante y actual, es probablemente el área donde el Diseño Industrial juega un papel clave. El conocimiento del proceso de fabricación, vinculado a los aspectos cognitivos y emocionales del usuario requiere a profesionales del diseño industrial. El diseño centrado en el usuario es la materialización de la usabilidad.</p>

      <p>"Usabilidad es la eficacia, eficiencia y satisfacción con la que un producto permite alcanzar objetivos específicos a usuarios específicos en un contexto de uso específico".<br>
      - Definición ISO/IEC 9241.</p>


      <p>La usabilidad es una condición necesaria y forma parte de nuestro día a día. Es la máscara invisible que conecta a los objetos con los usuarios. Con la usabilidad aplicada al diseño industrial se cubren varias dimensiones de la interacción con el usuario, se desarrolla un diseño más funcional, efectivo y, sin embargo, eso no debe restar a la imaginación, que es lo que nos impulsa a ampliar la acción del objeto y del mismo usuario.</p>
    </div>
    <div class="wrap wrap--frame wrap--frame__middle">
      <img src="" alt="">
    </div>
  </section>
</div>

<div class="flexboxer flexboxer--program hidden">
  <h1>Ponentes</h1>
</div>

<div class="flexboxer flexboxer--program flexboxer--background" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/box/box.jpg')">
  <section class="wrap wrap--content wrap--flex wrap--spaced">
    <div class="wrap wrap--frame wrap--frame__middle">
      <h1>Ubicación</h1>
      <p>Las conferencias del viernes 17 y sábado 18 se desarrollarán en el Espacio Box Sevilla, un recinto escénico avanzado y multidisciplinar orientado a la celebración de todo tipo de eventos y acciones artísticas/tecnológicas de máxima calidad.<br>
      Un espacio de encuentro reconocido por la cultura de Sevilla como referente de innovación desde la Expo 92.</p>
    </div>
    <div class="wrap wrap--frame wrap--frame__middle"></div>
  </section>
</div>


<div class="flexboxer flexboxer--archive flexboxer--archive__product">
  <?php if ( $product_query->have_posts() ) { ?>
    <section class="wrap wrap--content">
      <h1>Compra tu entrada</h1>
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
      <p>Puedes pagar con Paypal o tarjeta de crédito (vía Paypal).</p>
      <p>Las entradas estarán rebajadas hasta el 6 de febrero.<br>
      La entrada general no incluye los workshops del sábado, que se venderán individualmente.</p>
      <p>Para descuento de grupo usar código <strong>GRUPO</strong> al ir a pagar el pedido.<br>
      Descuento aplicable para grupos de 12 o más personas.<br>
      Válido para la <strong>Entrada general</strong> y la <strong>Entrada con camiseta</strong>.</p>
    </section>
  <?php }else{ ?>
    <section class="wrap wrap--content  wrap--spaced">
      <h1>Compra tu entrada</h1>
      <p>Lo sentimos, no quedan entradas a la venta :(</p>
    </section>
  <?php } ?>
</div>

<div class="flexboxer flexboxer--program hidden">
  <h1>Patrocinadores</h1>
</div>

<div class="flexboxer flexboxer--program">
  <section class="wrap wrap--content">
    <h1>Organización y contacto</h1>
    <p><strong>Asociación de Estudiantes de Diseño Industrial</strong><br>
    <a href="http://www.aedisevilla.es">www.aedisevilla.es</a><br>
    scd@aedisevilla.es<br></p>
  </section>
</div>

<?php get_footer(); ?>
