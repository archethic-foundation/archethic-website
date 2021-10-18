// import assign from 'lodash.assign';

const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { PanelBody, SelectControl, ToggleControl, TextControl } = wp.components;
const { addFilter } = wp.hooks;   
const { __ } = wp.i18n;
const { InspectorControls, DimensionControl } = wp.blockEditor;
// Enable slider control on the following blocks
const EssGridGalleryAddOnBlocks = [
	'core/gallery',
];

/**
 * Add slider control attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */
const EssGridGalleryAddOnAddControl = ( settings, name ) => {
	// Do nothing if it's another block than our defined ones.
	// Or Default Grid is not set.
	if ( ! EssGridGalleryAddOnBlocks.includes( name ) ) {
		return settings;
	}

	settings.attributes = jQuery.extend(true, settings.attributes, {
		grid: {
			type: 'string',
			default: EssGridOptions.defGrid
		},
		customsettings: {
			type: 'boolean',
			default: false
		},
		entryskin: {
			tpye: 'string'
		},
		layoutsizing: {
			tpye: 'string'
		},
		gridlayout: {
			tpye: 'string'
		},
		tinyspacings: {
			tpye: 'string',
			default: '5'
		},
		rowsunlimited: {
			type: 'string',
			default: 'on'
		},
		tinyrows: {
			type: 'string',
			default: 3
		},
		gridanimation: {
			type: 'string'
		},
		usespinner: {
			type: 'string'
		}

	} );

	return settings;
};

addFilter( 'blocks.registerBlockType', 'essgrid-gallery-addon-gutenberg-extension/attribute/grid', EssGridGalleryAddOnAddControl );

/**
 * Add Slider Option to Block
 */
const EssGridGalleryAddOn = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		// Do nothing if it's another block than our defined ones.
		// Or do nothing when EssGrid Default Grid Option is not set
		if ( ! EssGridGalleryAddOnBlocks.includes( props.name ) || EssGridOptions.defGrid == "off" || EssGridOptions.defGrid == "" || !EssGridOptions.defGrid ) {
			
			return (
				<BlockEdit { ...props } />
			);
		}
		const MySnackbarNotice = () => (
			<Snackbar>
				Post published successfully.
			</Snackbar>
		);

		const { grid, entryskin, customsettings, layoutsizing, gridlayout, tinyspacings, rowsunlimited, tinyrows, gridanimation , usespinner} = props.attributes;

		// add essgrid-gallery-addon-alias prefix class name
		if ( grid ) {
			props.attributes.className = `essgrid-gallery-${ grid }`;
			
		}

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ 'Essential Grid' }
						initialOpen={ grid }
					>
						<SelectControl
							label={ __('Select Grid') }
							value={ grid }
							options={ EssGridOptions.arrGrids }
							onChange={ ( grid ) => {
								props.setAttributes( {
									grid
								} );
							} }
						/>
						{ grid &&
							<ToggleControl
								label={__("Custom Settings")}
								checked={ customsettings }
								onChange={ ( customsettings ) => {
									props.setAttributes( {
										customsettings
									} ) } }
							/>
						}
						{ grid && customsettings  && 
							[
								<SelectControl
									label={ __('Grid Skin') }
									value={ entryskin }
									options={ EssGridOptions.arrSkins }
									onChange={ ( entryskin ) => {
										props.setAttributes( {
											entryskin
										} );
									} }
								/>,
								<SelectControl
									label={ __('Layout') }
									value={ layoutsizing }
									options= { [
										{label: __('Boxed'), value: 'boxed'},
										{label: __('Fullwidth'), value: 'fullwidth'},
									]}
									onChange={ ( layoutsizing ) => {
										props.setAttributes( {
											layoutsizing
										} );
									} }
								/>,
								<SelectControl
									label={ 'Grid Layout' }
									value={ gridlayout }
									options= { [
										{value: 'even', label: __('Even')},
										{value: 'masonry', label: __('Masonry')},
										{value: 'cobbles', label: __('Cobbles')},
									]}
									onChange={ ( gridlayout ) => {
										props.setAttributes( {
											gridlayout
										} );
									} }
								/>,
								<TextControl
									label={__("Item Spacing (px)")}
									value={ tinyspacings }
									type = 'number'
									onChange = { ( tinyspacings ) => {
										props.setAttributes( {
											tinyspacings
										} );
									} }
								/>,
								<SelectControl
									label={ __('Pagination') }
									value={ rowsunlimited }
									options= { [
										{value: 'on', label: __('Disable')},
										{value: 'off', label: __('Enable')}
									]}
									onChange={ ( rowsunlimited ) => {
										props.setAttributes( {
											rowsunlimited
										} );
									} }
								/>,
								props.attributes.rowsunlimited == 'off' && 
									<TextControl
										label={__("Rows per Page")}
										value={ tinyrows }
										type = 'number'
										onChange = { ( tinyrows ) => {
											props.setAttributes( {
												tinyrows
											} );
										} }
									/>
								,
								<SelectControl
									label={ __('Filter & Page Animation')}
									value={ gridanimation }
									options={ [
										{value: 'fade', label: __('Fade')},
										{value: 'horizontal-slide', label: __('Horizontal Slide')},
										{value: 'vertical-slide', label: __('Vertical Slide')},
									]}
									onChange={ ( gridanimation ) => {
										props.setAttributes( {
											gridanimation
										} );
									} }
								/>,
								<SelectControl
									label={ __('Choose Spinner')}
									value={ usespinner }
									options= { [
										{value: '-1', label: __('Off')},
										{value: '0', label: '0'},
										{value: '1', label: '1'},
										{value: '2', label: '2'},
										{value: '3', label: '3'},
										{value: '4', label: '4'},
										{value: '5', label: '5'},
									]}
									onChange={ ( usespinner ) => {
										props.setAttributes( {
											usespinner
										} );
									} }
								/>,
							]

						}

					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'EssGridGalleryAddOn' );

addFilter( 'editor.BlockEdit', 'essgrid-gallery-addon-gutenberg-extension/with-grid-control', EssGridGalleryAddOn );

/**
 * Assign alias to block class name
 *
 * @param {object} saveElementProps Props of save element.
 * @param {Object} blockType Block type information.
 * @param {Object} attributes Attributes of block.
 *
 * @returns {object} Modified props of save element.
 */
const addEssGridExtraProps = ( saveElementProps, blockType, attributes ) => {
	// Do nothing if it's another block than our defined ones.
	if ( ! EssGridGalleryAddOnBlocks.includes( blockType.name ) ) {
		return saveElementProps;
	}
	
	//jQuery.extend(true, saveElementProps, { slider: { 'alias': attributes.slider } } );
	return saveElementProps;
};

addFilter( 'blocks.getSaveContent.extraProps', 'essgrid-gallery-addon-gutenberg-extension/get-save-content/extra-props', addEssGridExtraProps );
