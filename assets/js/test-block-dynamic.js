const { registerBlockType } = wp.blocks;
const { withSelect } = wp.data;

registerBlockType( 'derrick-test-blocks/test-block-dynamic', {
	title: 'Derrick’s Test Block: Last Post (dynamic)',
	icon: 'megaphone',
	category: 'widgets',

	edit: withSelect( select => {
		return {
			posts: select( 'core' ).getEntityRecords( 'postType', 'post' )
		};
	} )( ( { posts, className } ) => {
		if ( ! posts ) {
			return 'Loading...'
		}

		if ( posts && posts.length === 0 ) {
			return 'No posts.';
		}

		const post = posts[0];

		return (
			<div>
				<h3>Latest Post:</h3>
				<a className={ className } href={ post.link }>
					{ post.title.rendered }
				</a>
			</div>
		);
	} ),
	save() {
		return null;
	}
} );
