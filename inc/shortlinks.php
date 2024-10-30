<?php

//block direct access
defined('ABSPATH') or die("Error");



function ictt_googl_shortlink($url, $post_id=false) {
	global $post;
	if (!$post_id && $post) {
		$post_id = $post->ID;
	} elseif ($post_id) {
		$post = get_post($post_id);
	} 
	if ($post && $post->post_status != 'publish' || get_option('ictt-shorten-urls') !== '1') {
		return "";
	}
	$shortlink = false;
	$shortlink = get_post_meta($post_id, 'ictt_googl_shortlink', true);
	if ($shortlink) {
		return $shortlink;
	}
	$permalink = get_permalink($post_id).'?utm_source=MAGNETIC%20Creative&utm_medium=Inline%20Click%20to%20Tweet&utm_campaign=Social%20Media';
	$shortlink = ictt_googl_shorten($permalink);
	if ($shortlink !== $url) {
		add_post_meta( $post_id, 'ictt_googl_shortlink', $shortlink, true );
		return $shortlink;
	} else {
		return $url;
	}
}
add_filter('get_shortlink', 'ictt_googl_shortlink', 9, 2);



function ictt_googl_shorten($url) {
	$result = wp_remote_post(add_query_arg('key', apply_filters('googl_api_key', 'AIzaSyBEPh-As7b5US77SgxbZUfMXAwWYjfpWYg'), 'https://www.googleapis.com/urlshortener/v1/url'), array(
		'body' => json_encode( array('longUrl' => esc_url_raw($url))),
		'headers' => array('Content-Type' => 'application/json'),
	));
	if (is_wp_error($result)) { return $url; }
	$result = json_decode( $result['body'] );
	$shortlink = $result->id;
	if ($shortlink) { return $shortlink; }
	return $url;
}



function ictt_googl_save_post( $post_ID, $post ) {
	if ('auto-draft' == $post->post_status || 'revision' == $post->post_type || get_option('ictt-shorten-urls') !== '1') {
		return;
	}
	delete_post_meta($post_ID, '_googl_shortlink');
}
add_action('save_post', 'ictt_googl_save_post', 10, 2);

