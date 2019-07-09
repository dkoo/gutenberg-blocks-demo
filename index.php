<?php

/**
 * Plugin Name: Derrick’s Test Block
 */

define( 'DERRICK_TEST_GUTENBERG_BLOCKS_DIR', __DIR__ );
define( 'DERRICK_TEST_GUTENBERG_BLOCKS_URL', plugins_url( '', __FILE__ ) );

require DERRICK_TEST_GUTENBERG_BLOCKS_DIR . '/includes/derrick-test-block.php';
require DERRICK_TEST_GUTENBERG_BLOCKS_DIR . '/includes/derrick-test-block-dynamic.php';