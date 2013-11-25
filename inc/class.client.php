<?php
class Custom_Content_List_Client {
	
	function __construct() {
		add_shortcode( 'custom-list', array( __CLASS__, 'shortcode' ) );
	}
	
	/*
	 * The shortcode function
	 * 
	 * @author Benjamin Niess
	 */
	public static function shortcode( $atts ) {
		extract( shortcode_atts( array(
			'post_type' => "any",
			'taxonomy' => "any",
			'terms' => '',
			'order' => 'desc',
			'orderby' => 'menu_order',
			'title'=> '',
			'showposts' => 10,
			'see_all_label' => '',
			'see_all_link' => ''
		), $atts ) );
		
		$args = array();
		
		// CPT
		if ( ! post_type_exists( $post_type ) ) {
			$post_type = "any";
		}
		
		$args['post_type'] = $post_type;
		
		// Number of posts to show
		if ( (int) $showposts <= 0 ) {
			$args['nopaging'] = true;
		}
		else {
			$args['showposts'] = $showposts;
		}
		
		// Taxonomy and terms
		if ( ! taxonomy_exists( $taxonomy ) ) {
			$taxonomy = '';
		}
		if ( !empty( $taxonomy ) && !empty( $terms ) ) {
			$terms = explode(',', $terms);
			if ( !empty( $terms ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $taxonomy,
						'field' => 'slug',
						'terms' => $terms
					)
				);
			}
		}
		
		// ORDER
		if ( !empty( $orderby ) ) {
			$args['orderby'] = $orderby;
		}
		
		if ( !empty( $order ) ) {
			$args['order'] = $order;
		}
		
		// The WP Query
		$list_query = new WP_Query( $args );
		if ( !$list_query->have_posts() ) {
			return false;
		}
		
		// Get the tpl in the plugin folder or in theme folder
		$tpl = Custom_Content_List_Client::get_template( 'list' );
		if ( empty( $tpl ) ) {
			wp_reset_postdata();
			return false;
		}
		
		ob_start();
		
		include( $tpl );
		
		$content = ob_get_contents();
		ob_end_clean();
		
		wp_reset_postdata();
		
		return $content;
	}

	/**
	 * Get template file depending on theme
	 * 
	 * @param (string) $tpl : the template name
	 * @return (string) the file path | false
	 * 
	 * @author Benjamin Niess
	 */
	public static function get_template( $tpl = '' ) {
		if ( empty( $tpl ) ) {
			return false;
		}
		
		if ( is_file( STYLESHEETPATH . '/views/ccl/' . $tpl . '.tpl.php' ) ) {// Use custom template from child theme
			return ( STYLESHEETPATH . '/views/ccl/' . $tpl . '.tpl.php' );
		} elseif ( is_file( TEMPLATEPATH . '/ccl/' . $tpl . '.tpl.php' ) ) {// Use custom template from parent theme
			return (TEMPLATEPATH . '/views/ccl/' . $tpl . '.tpl.php' );
		} elseif ( is_file( CCL_DIR . 'views/' . $tpl . '.tpl.php' ) ) {// Use builtin template
			return ( CCL_DIR . 'views/' . $tpl . '.tpl.php' );
		}
		
		return false;
	}
}