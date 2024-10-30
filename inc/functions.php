<?php

//block direct access
defined('ABSPATH') or die("Error");


//settings validation
function ictt_validate_twitter_handle($input) {
	return str_replace('@', '', strip_tags(stripslashes($input)));
}

function ictt_validate_twitter_hashtag($input) {
	return str_replace('#', '', strip_tags(stripslashes($input)));
}

function ictt_validate_checkbox($input) {
	return (!isset($input) || $input != '1') ? 0 : 1;
}

function ictt_validate_color($input) {
	$val =  strip_tags(stripslashes(trim($input)));
	if (preg_match('/^#[a-f0-9]{6}$/i', $val)) {
		return $val;
	} else {
		return '#55acee';
	}
}


//trims tweet text
function ictt_trimtext($input, $length) {
	$input = strip_tags($input);
	if (mb_strlen($input) <= $length) {
		return $input;
	}
	if (function_exists('mb_internal_encoding')) {
		$last_space   = mb_strrpos(mb_substr($input, 0, $length), ' ');
		$trimmed = mb_substr($input, 0, $last_space);
	} else {
		$last_space   = strrpos(substr($input, 0, $length), ' ');
		$trimmed = substr($input, 0, $last_space);
	}
	$trimmed .= "..";
	return $trimmed;
}



//shortcode helpers
function ictt_shortcode_inline_styles($custom_color) { ?>
	<style>
	.htt-tweet-blockquote a.htt-tweet:hover:before,
	a.htt-tweet:hover .htt-tweeticon {
		background: <?php echo $custom_color; ?>;
	}
	.htt-tweet-blockquote a.htt-tweet,
	a.htt-tweet.htt-tweet-inline {
		color: <?php echo $custom_color; ?> !important;
		border-bottom: 1px dotted <?php echo $custom_color; ?>;
	}
	.htt-tweet-blockquote a.htt-tweet .htt-tweeticon svg path,
	.htt-tweet-blockquote a.htt-tweet:hover .htt-tweeticon svg path {
		fill: <?php echo $custom_color; ?> !important;
	} 
	.htt-tweet-blockquote a.htt-tweet:hover,
	a.htt-tweet.htt-tweet-inline:hover {
		border-bottom: 1px solid <?php echo $custom_color; ?>;
	}
	span.htt-tweeticon svg path {
		fill: <?php echo $custom_color; ?>;
	}
	a.htt-tweet:hover .htt-tweeticon:before {
	  border-color: transparent <?php echo $custom_color; ?> transparent transparent;
	}
	</style>
<?php }



//RSS Feed
function ictt_rss_feed() {
	if (function_exists('fetch_feed')) {
		$feed = fetch_feed('http://www.magneticcreative.com/feed/');  
		if (is_wp_error($feed)) {
			$limit = 0;
			$items = 0;
		} else {
			$limit = $feed->get_item_quantity(5);                       
			$items = $feed->get_items(0, $limit);      
		}
	}
	return $limit == 0 ? false : $items;
}