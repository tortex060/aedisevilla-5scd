</div><!-- end of wrapper -->

<!-- footer -->
<footer id="footer" class="wrap wrap--footer">
	<div class="flexboxer">
	
		<div class="wrap wrap--frame wrap--flex">
			<div class="wrap wrap--frame__middle">
				<ul>
					<li> &copy; <?php echo get_the_date('Y');?> <a href="http://www.aedisevilla.es" target="_blank">AEDI Sevilla</a></li>
				</ul>
		        <!-- middlemenu -->
		        <?php /* if (has_nav_menu('menufooter')) { ?>
		          <?php wp_nav_menu( array( 'theme_location' => 'menufooter', 'container' => false ) ); ?>
		        <?php } */ ?><!-- end of middlemenu -->
			</div>
			<div class="wrap wrap--frame__middle text--right">
				<ul>
					<li>
					<a href="https://www.facebook.com/aedisevilla/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/facebook-white.svg" alt="Facebook" class="icon icon--rrss"></a>
					<a href="https://twitter.com/AEDISevilla" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/twitter-white.svg" alt="Twitter" class="icon icon--rrss"></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer> <!-- end footer -->

  <!-- inject:js -->
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/d3/d3.min.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/chroma-js/chroma.min.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/5scd-game/chart.min.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/flickity/dist/flickity.pkgd.min.js"></script>
  <!-- endinject -->

<?php wp_footer(); ?>

</body>
</html> <!-- The End. what a ride! -->