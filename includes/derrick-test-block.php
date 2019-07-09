<?php
function derrick_test_register_block() {
	wp_register_script(
		'derrick-test-block',
		DERRICK_TEST_GUTENBERG_BLOCKS_URL . '/dist/test-block.js',
		[
			'wp-blocks',
			'wp-element',
			'wp-editor'
		],
		filemtime( DERRICK_TEST_GUTENBERG_BLOCKS_DIR . '/dist/test-block.js' )
	);

	wp_register_style(
		'derrick-test-block-styles',
		DERRICK_TEST_GUTENBERG_BLOCKS_URL . '/dist/styles.css',
		[],
		filemtime( DERRICK_TEST_GUTENBERG_BLOCKS_DIR . '/dist/styles.css' )
	);

	register_block_type(
		'derrick-test/derrick-test-block',
		[
			'editor_script' => 'derrick-test-block',
			'editor_style' => 'derrick-test-block-styles',
			'style' => 'derrick-test-block-styles'
		]
	);
}

add_action( 'init', 'derrick_test_register_block' );