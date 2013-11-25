<?php
class Custom_Content_List_Admin {
	
	function __construct() {
		add_action( 'admin_init', array ( __CLASS__, 'add_buttons' ) );
		add_action( 'wp_ajax_ccl_shortcodePrinter', array( __CLASS__, 'ajax_load_form' ) );
		add_action( 'wp_ajax_ccl_reload_terms', array( __CLASS__, 'ajax_reload_terms' ) );
	}

	/*
	 * The content of the javascript popin for the shortcode insertion
	 * 
	 * @author Benjamin Niess
	 */
	public static function ajax_load_form(){
		$tpl = Custom_Content_List_Client::get_template( 'admin/shortcode-insertion' );
		if ( empty( $tpl ) ) {
			exit;
		}
		
		include( $tpl );
		exit;
	}

	/*
	 * Add buttons to the tiymce bar
	 * 
	 * @author Benjamin Niess
	 */
	public static function add_buttons() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( !current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return false;
		}
		
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array ( __CLASS__, 'add_tinymce_script' ) );
			add_filter( 'mce_buttons', array ( __CLASS__, 'register_the_button' ) );
		}
	}

	/*
	 * Add buttons to the tiymce bar
	 * 
	 * @author Benjamin Niess
	 */
	public static function register_the_button( $buttons ) {
		array_push( $buttons, "|", "ccl" );
		
		return $buttons;
	}
	
	/*
	 * Ajax function that will reload terms depending on a taxonomy
	 * 
	 * @author : Benjamin Niess
	 */
	public static function ajax_reload_terms() {
		if ( !isset( $_GET['taxonomy'] ) ) {
			die( json_encode( array() ) );
		}
		
		$terms = get_terms( $_GET['taxonomy'], array( 'hide_empty ' => true ) );
		if ( !empty( $terms ) ) {
			die( json_encode( $terms ) );
		}
		
		die( json_encode( array() ) );
	}

	/*
	 * Load the custom js for the tinymce button
	 * 
	 * @author Benjamin Niess
	 */
	public static function add_tinymce_script( $plugin_array ) {
		$plugin_array['ccl'] = CCL_URL . '/inc/ressources/tinymce.js';
		
		return $plugin_array;
	}
}