<div id="menutop" class="menu menu--top js-menu animecubic550">

	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/svg/close.svg" alt="Close menu" class="icon icon--close" onclick="ToggleMenu('close')">
	
	<!-- topmenu -->
	<?php if (has_nav_menu('menutop')) { ?>
		<?php wp_nav_menu( array( 'theme_location' => 'menutop', 'container' => false ) ); ?>
	<?php } ?><!-- end of topmenu -->
</div>