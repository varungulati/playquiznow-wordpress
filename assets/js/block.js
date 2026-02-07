( function ( blocks, element, blockEditor, components, i18n ) {
	var el = element.createElement;
	var __ = i18n.__;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody = components.PanelBody;
	var TextControl = components.TextControl;
	var SelectControl = components.SelectControl;

	blocks.registerBlockType( 'playquiznow/quiz', {
		title: __( 'PlayQuizNow', 'playquiznow' ),
		description: __( 'Embed an interactive quiz from PlayQuizNow.', 'playquiznow' ),
		icon: 'welcome-learn-more',
		category: 'embed',
		keywords: [ 'quiz', 'embed', 'playquiznow', 'assessment' ],
		attributes: {
			quizId: { type: 'string', default: '' },
			width: { type: 'string', default: '100%' },
			height: { type: 'number', default: 500 },
			theme: { type: 'string', default: 'light' },
		},
		supports: { html: false },

		edit: function ( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;

			var sidebar = el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __( 'Quiz Settings', 'playquiznow' ), initialOpen: true },
					el( TextControl, {
						label: __( 'Width', 'playquiznow' ),
						value: attributes.width,
						onChange: function ( val ) {
							setAttributes( { width: val } );
						},
						help: __( 'CSS value, e.g. "100%", "600px".', 'playquiznow' ),
					} ),
					el( TextControl, {
						label: __( 'Height (px)', 'playquiznow' ),
						type: 'number',
						value: String( attributes.height ),
						onChange: function ( val ) {
							setAttributes( { height: parseInt( val, 10 ) || 500 } );
						},
					} ),
					el( SelectControl, {
						label: __( 'Theme', 'playquiznow' ),
						value: attributes.theme,
						options: [
							{ label: __( 'Light', 'playquiznow' ), value: 'light' },
							{ label: __( 'Dark', 'playquiznow' ), value: 'dark' },
						],
						onChange: function ( val ) {
							setAttributes( { theme: val } );
						},
					} )
				)
			);

			if ( ! attributes.quizId ) {
				return el(
					element.Fragment,
					null,
					sidebar,
					el(
						'div',
						{
							className: 'playquiznow-block-empty',
							style: {
								border: '2px dashed #c7c7cc',
								borderRadius: '12px',
								padding: '48px 24px',
								textAlign: 'center',
								backgroundColor: '#fafafa',
							},
						},
						el(
							'div',
							{
								style: {
									width: '48px',
									height: '48px',
									margin: '0 auto 16px',
									borderRadius: '12px',
									backgroundColor: '#6366f1',
									display: 'flex',
									alignItems: 'center',
									justifyContent: 'center',
									color: '#fff',
									fontSize: '24px',
									fontWeight: 'bold',
								},
							},
							'Q'
						),
						el(
							'p',
							{
								style: {
									fontSize: '16px',
									fontWeight: '600',
									margin: '0 0 8px',
									color: '#1e1e1e',
								},
							},
							__( 'PlayQuizNow', 'playquiznow' )
						),
						el(
							'p',
							{
								style: {
									fontSize: '13px',
									color: '#757575',
									margin: '0 0 16px',
								},
							},
							__( 'Enter your quiz ID to embed it here.', 'playquiznow' )
						),
						el(
							'div',
							{ style: { maxWidth: '320px', margin: '0 auto' } },
							el( TextControl, {
								placeholder: __( 'e.g. my-quiz-id', 'playquiznow' ),
								value: attributes.quizId,
								onChange: function ( val ) {
									setAttributes( { quizId: val.trim() } );
								},
								__nextHasNoMarginBottom: true,
							} )
						),
						el(
							'p',
							{ style: { fontSize: '12px', margin: '12px 0 0', color: '#757575' } },
							__( "Don't have a quiz? ", 'playquiznow' ),
							el(
								'a',
								{
									href: 'https://playquiznow.com',
									target: '_blank',
									rel: 'noopener noreferrer',
									style: { color: '#6366f1' },
								},
								__( 'Create one free', 'playquiznow' )
							)
						)
					)
				);
			}

			var embedUrl =
				'https://playquiznow.com/embed/' +
				encodeURIComponent( attributes.quizId ) +
				'?theme=' +
				attributes.theme +
				'&source=wordpress';

			return el(
				element.Fragment,
				null,
				sidebar,
				el(
					'div',
					{
						className: 'playquiznow-block-preview',
						style: { width: attributes.width, maxWidth: '100%' },
					},
					el(
						'div',
						{
							style: {
								display: 'flex',
								alignItems: 'center',
								gap: '8px',
								marginBottom: '8px',
								fontSize: '12px',
								color: '#757575',
							},
						},
						el(
							'span',
							{
								style: {
									backgroundColor: '#6366f1',
									color: '#fff',
									padding: '2px 8px',
									borderRadius: '4px',
									fontWeight: '600',
								},
							},
							'PlayQuizNow'
						),
						el( 'span', null, attributes.quizId ),
						el(
							'button',
							{
								onClick: function () {
									setAttributes( { quizId: '' } );
								},
								style: {
									marginLeft: 'auto',
									background: 'none',
									border: 'none',
									color: '#757575',
									cursor: 'pointer',
									fontSize: '12px',
									textDecoration: 'underline',
								},
							},
							__( 'Change', 'playquiznow' )
						)
					),
					el( 'iframe', {
						src: embedUrl,
						title: 'PlayQuizNow Quiz: ' + attributes.quizId,
						width: '100%',
						height: attributes.height,
						frameBorder: '0',
						scrolling: 'no',
						sandbox: 'allow-scripts allow-same-origin allow-popups allow-forms',
						style: { borderRadius: '12px', border: '1px solid #e0e0e0' },
					} )
				)
			);
		},

		save: function () {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.i18n
);
