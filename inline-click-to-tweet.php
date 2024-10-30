<?php

/*
Plugin Name: Inline Click To Tweet
Description: Select text content from the Wordpress visual editor to be shared on Twitter.
Version: 1.0.0
Author: Magnetic Creative
Author URI: http://www.magneticcreative.com
Plugin URI: http://www.magneticcreative.com/lab/inline-click-to-tweet
License: GPL2
Text Domain: inline-clicktotweet
*/

//block direct access
defined('ABSPATH') or die("Error");



include('inc/functions.php');
include('inc/shortcodes.php');
include('inc/shortlinks.php');



//admin interface
add_action('admin_menu', 'ictt_admin_menu');

function ictt_admin_menu() {
	add_action('admin_init', 'ictt_register_settings', 100, 1);
	add_options_page('Inline Click to Tweet Options', 'Inline Click To Tweet', 'manage_options', 'inline-clicktotweet', 'ictt_settings_page');
}

function ictt_register_settings() {
	register_setting('ictt_tweet-options', 'ictt-twitter-handle', 'ictt_validate_twitter_handle');
	register_setting('ictt_tweet-options', 'ictt-twitter-hashtag', 'ictt_validate_twitter_hashtag');
	register_setting('ictt_tweet-options', 'ictt-shorten-urls', 'ictt_validate_checkbox');
	register_setting('ictt_tweet-options', 'ictt-disable-css', 'ictt_validate_checkbox');
	register_setting('ictt_tweet-options', 'ictt-css-color', 'ictt_validate_color');
}

function ictt_settings_page() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.', 'inline-clicktotweet'));
	}
	include('inc/admin-view.php');
}




//Tiny MCE Mods
add_action('admin_init', 'ictt_tinymce_loader');

function ictt_tinymce_loader() {
	add_filter('mce_external_plugins', 'ictt_tinymce_core');
	add_filter('mce_buttons', 'ictt_tinymce_buttons');
}

function ictt_tinymce_core($plugin_array) {
	$plugin_array['ictt'] = plugins_url('assets/js/ictt-tinymce.js', __FILE__);
	return $plugin_array;
}

function ictt_tinymce_buttons($buttons) {
	$sink = array_search('wp_adv', $buttons);
	if (!empty($sink)) {
		unset($buttons[$sink]);
	}
	array_push($buttons, 'ictt');
	if (!empty($sink)) {
		$buttons[] = 'wp_adv';
	}
	return $buttons;
}






//Plugin assets
add_action('wp_enqueue_scripts', 'ictt_frontend_assets');
add_action('admin_enqueue_scripts', 'ictt_admin_assets');
add_action('admin_footer', 'ictt_admin_js');
add_action('wp_head', 'ictt_customize_color');

function ictt_frontend_assets() {
	if (!is_admin()) {
		wp_register_style('ictt-frontend-css', plugins_url('assets/css/frontend.css',__FILE__), array(), false, 'all');
		wp_register_script('ictt-frontend-js', plugins_url('assets/js/frontend.js',__FILE__), false, '', true);
		if (get_option('ictt-disable-css') !== '1') {
			wp_enqueue_style('ictt-frontend-css');
		}
		wp_enqueue_script('ictt-frontend-js');
	} 
}

function ictt_admin_assets() {
	wp_enqueue_style('wp-color-picker'); 
  wp_enqueue_script('wp-color-picker');
  wp_register_style('ictt-admin-css', plugins_url('assets/css/admin.css',__FILE__), array(), false, 'all');
	wp_enqueue_style('ictt-admin-css');
}

function ictt_customize_color() {
	if (!is_admin() && get_option('ictt-css-color') !== '#55acee' && get_option('ictt-disable-css') !== '1') {
		ictt_shortcode_inline_styles(get_option('ictt-css-color'));
	}
}

function ictt_admin_js() { ?>
<script>
;(function($) {
	$(document).ready(function() {
		if (pagenow === 'settings_page_inline-clicktotweet') {
			$('#ictt-csscolor').wpColorPicker();
		}
	});
})(jQuery);
</script>
<?php }





//plugin uninstall
function ictt_do_uninstall() {
	delete_option('ictt-twitter-handle');
	remove_shortcode('ictt-tweet-inline');
	remove_shortcode('ictt-tweet-blockquote');
}
register_uninstall_hook(__FILE__, 'ictt_do_uninstall');
