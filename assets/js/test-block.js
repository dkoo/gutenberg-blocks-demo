import '../css/styles.css';

const { registerBlockType } = wp.blocks;
const {
	AlignmentToolbar,
	BlockControls,
	RichText
} = wp.editor;

registerBlockType( 'derrick-test-blocks/test-block-01', {
	title: 'Derrick’s Test Block',
	icon: 'universal-access-alt',
	category: 'layout',
	attributes: {
		content: {
			type: 'array',
			source: 'children',
			selector: 'p'
		},
		alignment: {
			type: 'string',
			default: 'none'
		}
	},
	edit( props ) {
		const { attributes: { content, alignment }, setAttributes, className } = props;

		return (
			<div>
				{
					<BlockControls>
						<AlignmentToolbar
							value={ alignment }
							onChange={ ( newAligment ) => {
								props.setAttributes( { alignment: newAligment || 'none' } )
							} }
						/>
					</BlockControls>
				}
				<RichText
					tagName="p"
					className={ className }
					style={ { textAlign: alignment } }
					onChange={ ( newContent ) => {
						setAttributes( { content: newContent } )
					} }
					value={ content }
				/>
			</div>
		);
	},
	save( props ) {
		return (
			<RichText.Content
				tagName="p"
				style={ { textAlign: props.attributes.alignment } }
				value={ props.attributes.content }
			/>
		);
	}
} );
