<?php

function derrick_test_register_block_dynamic() {
	wp_register_script(
		'derrick-test-block-dynamic',
		DERRICK_TEST_GUTENBERG_BLOCKS_URL . '/dist/test-block-dynamic.js',
		[
			'wp-blocks',
			'wp-data',
			'wp-element',
		],
		filemtime( DERRICK_TEST_GUTENBERG_BLOCKS_DIR . '/dist/test-block-dynamic.js' )
	);

	register_block_type(
		'derrick-test-blocks/test-block-dynamic',
		[
			'editor_script' => 'derrick-test-block-dynamic',
			'render_callback' => 'derrick_test_register_block_dynamic_render_callback'
		]
	);
}
add_action( 'init', 'derrick_test_register_block_dynamic' );

function derrick_test_register_block_dynamic_render_callback( $attributes, $content ) {
	$recent_posts = wp_get_recent_posts( [
		'numberposts' => 5,
		'post_status' => 'publish'
	] );

	if ( count( $recent_posts ) === 0 ) {
		return 'No posts.';
	}

	$post = $recent_posts[0];
	$post_id = $post['ID'];

	return sprintf(
		'<h3>Latest Post:</h3><p><a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a></p>',
		esc_url( get_permalink( $post_id ) ),
		esc_html( get_the_title( $post_id ) )
	);
}
