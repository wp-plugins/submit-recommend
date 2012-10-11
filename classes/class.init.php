<?php
/**
* Class Exist Check
*/
if (!class_exists('rcmd_plugin')) {
	class rcmd_plugin {
		function __construct() {

			include "class.action.php";
			include "class.filter.php";
			include "class.shortcode.php";

			add_action('wp_head', 'basic_tag' );
			add_filter( 'the_content', 'rcmd_filter' );
			add_shortcode('rcmd_ranking', 'rcmd_ranking_sc' );
			add_shortcode('rcmd_recommend', 'rcmd_recommend_sc' );
			add_shortcode('rcmd_history', 'rcmd_history_sc' );

		}
	}
}

/* Define Class */
if (class_exists("rcmd_plugin")) { $rcmd_plugin = new rcmd_plugin(); }

?>