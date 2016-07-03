</div><!-- end of wrapper -->

<!-- footer -->
<footer id="footer" class="footer">
	<div class="flexboxer">
		<div class="wrap wrap--frame wrap--flex">
			<div class="wrap wrap--frame__middle">
				<ul>
					<li>&copy; <?php the_date('Y');?> <?php bloginfo('sitename'); ?></li>
				</ul>
		        <!-- middlemenu -->
		        <?php if (has_nav_menu('menufooter')) { ?>
		          <?php wp_nav_menu( array( 'theme_location' => 'menufooter', 'container' => false ) ); ?>
		        <?php } ?><!-- end of middlemenu -->
			</div>
			<div class="wrap wrap--frame__middle text--right">
				<ul>
					<li>
					<a href="https://www.facebook.com/aedisevilla/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/facebook-white.svg" alt="Facebook" class="icon icon--rrss"></a>
					<a href="https://twitter.com/AEDISevilla"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/svg/twitter-white.svg" alt="Twitter" class="icon icon--rrss"></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer> <!-- end footer -->

  <!-- inject:js -->
  <!-- endinject -->

<?php wp_footer(); ?>

</body>
</html> <!-- The End. what a ride! -->