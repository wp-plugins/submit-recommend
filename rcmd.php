<?php
/*
Plugin Name: Recommend Engine
Plugin URI: http://recommend.submit.ne.jp/
Description: さぶみっと！レコメンド for WordPress Plugin
Version: 1.0.3
Author: e-agency
Text Domain: rcmd
Author URI: http://www.e-agency.co.jp/
License: GPL2

Copyright 2012 e-agency (email : product@dragon.jp )

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
include "classes/class.init.php";

if( isset( $rcmd_plugin ) ){

	//Hook rcmd_filter
	add_action( 'admin_menu', 'rcmd_plugin_menu' );

	//Add Admin Menu
	function rcmd_plugin_menu() {
		add_options_page( 'rcmd_options', 'レコメンドエンジン', 'manage_options', "rcmd_options.php" , 'rcmd_options_page' );
	}

	//Define Option Page
	function rcmd_options_page() {
		require('admin/rcmd.admin.php');
	}

}

?>