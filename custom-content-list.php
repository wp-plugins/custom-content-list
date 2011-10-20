<?php
/*
Plugin Name: Custom Content List
Plugin URI: http://benjamin-niess.fr
Description: Allow to create custom lists of content based on post types, taxonomies and others params
Version: 1.0.1
Author: Benjamin Niess
Author URI: http://benjamin-niess.fr
Text Domain: ccl
Domain Path: /languages/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'CCL_URL', plugins_url('', __FILE__) );
define( 'CCL_DIR', dirname(__FILE__) );

require( CCL_DIR . '/inc/class.client.php');
require( CCL_DIR . '/inc/class.admin.php');

// Init the plugin
function Custom_Content_list_Init() {
	global $CustomContentList;
	
	load_plugin_textdomain( 'ccl', false, basename(rtrim(dirname(__FILE__), '/')) . '/languages' );

	// Load client
	$CustomContentList['client'] = new Custom_Content_List_Client();
	
	// Load admin
	if ( is_admin() )
		$CustomContentList['admin'] = new Custom_Content_List_Admin();
}
add_action( 'plugins_loaded', 'Custom_Content_list_Init' );
?>