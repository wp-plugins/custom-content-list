<?php
class Custom_Content_List_Client {
	
	function __construct() {
		add_shortcode( 'custom-list', array( &$this, 'shortcode' ) );
	}
	
	/*
	 * The shortcode function
	 * 
	 * @author Benjamin Niess
	 */
	function shortcode( $atts ) {
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
		if ( ! post_type_exists( $post_type ) )
			$post_type = "any";
		$args['post_type'] = $post_type;
		
		// Number of posts to show
		if ( (int) $showposts <= 0 )
			$args['nopaging'] = true;
		else
			$args['showposts'] = $showposts;
		
		// Taxonomy and terms
		if ( ! taxonomy_exists( $taxonomy ) )
			$taxonomy = '';
		if ( !empty( $taxonomy ) && !empty( $terms ) ) {
			$terms = explode(',', $terms);
			if ( !empty( $terms ) )
				$args['tax_query'] = array(
					array(
						'taxonomy' => $taxonomy,
						'field' => 'slug',
						'terms' => $terms
					)
				);
		}
		
		// ORDER
		if ( !empty( $orderby ) )
			$args['orderby'] = $orderby;
		
		if ( !empty( $order ) )
			$args['order'] = $order;
		
		
		// The WP Query
		$list_query = new WP_Query( $args );
		ob_start();
		if ( $list_query->have_posts() ) : ?>
			<div class="custom_content_list">
				<?php if ( !empty( $title ) ) echo '<h3>' . $title . '</h3>'; ?>
				
				<ul>
					<?php while ( $list_query->have_posts() ) : $list_query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>	
					<?php endwhile; ?>
				</ul>
				<?php // Link
				if ( !empty( $see_all_label ) && !empty( $see_all_link )  ) : ?>
					<span class="see_all"><a href="<?php echo esc_url( $see_all_link ); ?>"><?php echo $see_all_label; ?></a></span>
				<?php endif; ?>
			</div>
			<?php
		endif;
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
}
