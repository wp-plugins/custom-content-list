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