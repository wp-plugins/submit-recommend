<?php
/*
Plugin Name: Recommend Engine
Plugin URI: http://recommend.submit.ne.jp/
Description: さぶみっと！レコメンド for WordPress Plugin
Version: 1.0.0
Author: e-agency
Text Domain: rcmd
Author URI: http://www.e-agency.co.jp/
License: GPL2

Copyright 2012 e-agency (email : recommend_support@dragon.jp )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Includes
include "class.php";

if( isset( $rcmd_plugin ) ){

//rcmd_filterをフィルターフック
add_action( 'admin_menu', 'rcmd_plugin_menu' );

//管理画面の追加
function rcmd_plugin_menu() {
	add_options_page( 'rcmd_options', 'レコメンドエンジン', 'manage_options', "rcmd_options.php" , 'rcmd_options_page' );
}

//設定画面の定義
function rcmd_options_page() {
	require('admin/rcmd.admin.php');
}

//Hook
/*
add_action('wp_head', 'basic_tag');
add_filter( 'the_content', 'rcmd_filter' );
add_shortcode('rcmd_ranking', 'rcmd_ranking_sc');
add_shortcode('rcmd_recommend', 'rcmd_recommend_sc');
add_shortcode('rcmd_history', 'rcmd_history_sc');
*/

function rcmd_admin_style() {
	require( dirname( __FILE__ ) . '/admin/style.php' );
}

add_action('admin_print_styles', 'rcmd_admin_style');


}

?>