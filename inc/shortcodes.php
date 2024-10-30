<?php

//block direct access
defined('ABSPATH') or die("Error");


add_action('init', 'ictt_register_shortcodes');


function ictt_register_shortcodes() {
	add_shortcode('ictt-tweet-inline', 'ictt_do_inline_tweet');
	add_shortcode('ictt-tweet-blockquote', 'ictt_do_blockquote_tweet');
}


function ictt_do_inline_tweet($atts,$content=null) {
	extract(shortcode_atts(array(
		'hashtags' => get_option('ictt-twitter-hashtag'),
		'text' => strip_tags($content),
		'via' => get_option('ictt-twitter-handle')
		), $atts));

	$custom_color = get_option('ictt-css-color');

	$share_url = get_option('ictt-shorten-urls') === '1' ? wp_get_shortlink() : get_the_permalink();

	$tweet_extras = strlen($via) > 1 ? $share_url.' #'.$hashtags.' via @'.$via : $share_url.' #'.$hashtags;
	
	$text = html_entity_decode('"'.$text.'"');
	
	$text_limit = 137 - strlen($tweet_extras);

	$url_text = strlen($text) > $text_limit ? ictt_trimtext($text, $text_limit).'"' : $text;

	$twitter_url = 'https://twitter.com/share?url='.urlencode($share_url).'&text='.urlencode($url_text).'&hashtags='.$hashtags;
	if (strlen($via) !== 0) {
		$twitter_url .= '&via='.$via;
	}

	ob_start(); ?>

	<a class="htt-tweet htt-tweet-inline" href="<?php echo $twitter_url; ?>" target="_blank"><?php echo $content; ?><span class="htt-tweeticon"><svg viewBox="0 0 125.39 101.9" style="width:15px;height:13px;"><title>Twitter</title><path d="M125.39,12.06a51.43,51.43,0,0,1-14.78,4.05A25.8,25.8,0,0,0,121.93,1.88a51.51,51.51,0,0,1-16.34,6.24A25.75,25.75,0,0,0,61.75,31.59a73,73,0,0,1-53-26.88,25.75,25.75,0,0,0,8,34.35A25.62,25.62,0,0,1,5,35.84c0,0.11,0,.22,0,0.32A25.74,25.74,0,0,0,25.67,61.38a25.79,25.79,0,0,1-11.62.44,25.75,25.75,0,0,0,24,17.87,51.62,51.62,0,0,1-31.95,11A52.37,52.37,0,0,1,0,90.34,72.81,72.81,0,0,0,39.43,101.9c47.32,0,73.19-39.2,73.19-73.19q0-1.67-.07-3.33A52.28,52.28,0,0,0,125.39,12.06Z"/></svg></span></a>
	
	<?php 
	return ob_get_clean();
}



function ictt_do_blockquote_tweet($atts,$content=null) {
	extract(shortcode_atts(array(
		'hashtags' => get_option('ictt-twitter-hashtag'),
		'text' => strip_tags($content),
		'via' => get_option('ictt-twitter-handle')
		), $atts));

	$custom_color = get_option('ictt-css-color');

	$share_url = get_option('ictt-shorten-urls') === '1' ? wp_get_shortlink() : get_the_permalink();

	$tweet_extras = strlen($via) > 1 ? $share_url.' #'.$hashtags.' via @'.$via : $share_url.' #'.$hashtags;
	
	$text = html_entity_decode('"'.$text.'"');
	
	$text_limit = 137 - strlen($tweet_extras);

	$url_text = strlen($text) > $text_limit ? ictt_trimtext($text, $text_limit).'"' : $text;

	$twitter_url = 'https://twitter.com/share?url='.urlencode($share_url).'&text='.urlencode($url_text).'&hashtags='.$hashtags;
	if (strlen($via) > 1) {
		$twitter_url .= '&via='.$via;
	}

	ob_start(); ?>
	<div class="htt-tweet-blockquote">
		<a class="htt-tweet" href="<?php echo $twitter_url; ?>" target="_blank">
			<?php echo $text; ?> <span class="htt-tweeticon"><svg viewBox="0 0 125.39 101.9" style="width:22px;height:18px;"><title>Twitter</title><path d="M125.39,12.06a51.43,51.43,0,0,1-14.78,4.05A25.8,25.8,0,0,0,121.93,1.88a51.51,51.51,0,0,1-16.34,6.24A25.75,25.75,0,0,0,61.75,31.59a73,73,0,0,1-53-26.88,25.75,25.75,0,0,0,8,34.35A25.62,25.62,0,0,1,5,35.84c0,0.11,0,.22,0,0.32A25.74,25.74,0,0,0,25.67,61.38a25.79,25.79,0,0,1-11.62.44,25.75,25.75,0,0,0,24,17.87,51.62,51.62,0,0,1-31.95,11A52.37,52.37,0,0,1,0,90.34,72.81,72.81,0,0,0,39.43,101.9c47.32,0,73.19-39.2,73.19-73.19q0-1.67-.07-3.33A52.28,52.28,0,0,0,125.39,12.06Z" style="fill:<?php echo $custom_color; ?>"/></svg></span>
		</a>
	</div>
	<?php
	return ob_get_clean();
}
