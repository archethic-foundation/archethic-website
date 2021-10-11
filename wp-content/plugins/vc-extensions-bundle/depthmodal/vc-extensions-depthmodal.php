<?php
if (!class_exists( 'VC_Extensions_DepthModal' ) ) {

    class VC_Extensions_DepthModal {
        function __construct() {
            vc_map( array(
              "name" => esc_attr__("Depth Modal", "cq_allinone_vc"),
              "base" => "cq_vc_modal",
              "class" => "wpb_cq_vc_extension_depthmodal",
              "controls" => "full",
              "icon" => "cq_allinone_depthmodal",
              "category" => esc_attr__('Sike Extensions', 'js_composer'),
              'description' => esc_attr__( 'Popup modal', 'js_composer' ),
              "params" => array(
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Button text", "cq_allinone_vc"),
                  "param_name" => "buttontext",
                  "value" => "Button",
                  'group' => 'Button',
                  "description" => esc_attr__("Optional button under the content", "cq_allinone_vc")
                ),
                array(
                   "type" => "dropdown",
                   "edit_field_class" => "vc_col-xs-6 vc_column",
                   "holder" => "",
                   "heading" => esc_attr__("Button color", "cq_allinone_vc"),
                   "param_name" => "buttoncolor",
                   "value" => array('Blue' => 'blue', 'Turquoise' => 'turquoise', 'Pink' => 'pink', 'Violet' => 'violet', 'Peacoc' => 'peacoc', 'Chino' => 'chino', 'Vista Blue' => 'vista_blue', 'Black' => 'black', 'Grey' => 'grey', 'Orange' => 'orange', 'Sky' => 'sky', 'Green' => 'green', 'Sandy brown' => 'sandy_brown', 'Purple' => 'purple', 'White' => 'white'),
                  'std' => 'blue',
                  'group' => 'Button',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                   "type" => "dropdown",
                   "edit_field_class" => "vc_col-xs-6 vc_column",
                   "holder" => "",
                   "heading" => esc_attr__("Button size", "cq_allinone_vc"),
                   "param_name" => "buttonsize",
                   "value" => array('Mini' => 'xs', 'Small' => 'sm', 'Large' => 'lg'),
                   'std' => 'xs',
                   'group' => 'Button',
                   "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "dropdown",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "holder" => "",
                  "heading" => esc_attr__("Button shape", "cq_allinone_vc"),
                  "param_name" => "buttonshape",
                  "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                  'std' => 'rounded',
                  'group' => 'Button',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "dropdown",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "holder" => "",
                  "heading" => esc_attr__("Button alignment", "cq_allinone_vc"),
                  "param_name" => "align",
                  "value" => array('Inline' => 'inline', 'Left' => 'left', 'Center' => 'center', 'Right' => 'right'),
                  'std' => 'center',
                  'group' => 'Button',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "textarea_html",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Popup content", "cq_allinone_vc"),
                  "param_name" => "content",
                  "value" => esc_attr__("<p>I am test text block. Click edit button to change this text.</p>", "cq_allinone_vc"),
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Popup text color", 'vc_extend'),
                  "param_name" => "textcolor",
                  "value" => '#333',
                  "description" => esc_attr__("", 'vc_extend')
                ),
                array(
                  "type" => "colorpicker",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Popup background", 'vc_extend'),
                  "param_name" => "background",
                  "value" => '#fff',
                  "description" => esc_attr__("", 'vc_extend')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_modal_cq_tiny_text",
                  "heading" => esc_attr__("Popup width", "cq_allinone_vc"),
                  "param_name" => "width",
                  "value" => esc_attr__("640", "cq_allinone_vc"),
                  "description" => esc_attr__("A fixed value like 640, or a (responsive) percent value like 60%.", "cq_allinone_vc")
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_modal_cq_tiny_text",
                  "heading" => esc_attr__("Popup margin top", "cq_allinone_vc"),
                  "param_name" => "margintop",
                  "value" => esc_attr__("40", "cq_allinone_vc"),
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "cq_allinone_vc",
                "heading" => esc_attr__("Display the Popup in:", "cq_allinone_vc"),
                "param_name" => "popupposition",
                "value" => array("fixed" => "fixed", "absolute (work better for long contnet)" => "absolute"),
                "description" => esc_attr__("CSS position value for the Popup.", "cq_allinone_vc")
              ),
                array(
                  "type" => "checkbox",
                  "holder" => "",
                  "class" => "cq_allinone_vc",
                  "heading" => esc_attr__("Do not hide the popup content when page is loaded", "cq_allinone_vc"),
                  "param_name" => "loadedvisible",
                  "value" => array(esc_attr__("Yes, set the popup content visible by default", "cq_allinone_vc") => 'on'),
                  "description" => esc_attr__("Sometime you have to display the popup content when page is loaded, for example my hotspot plugin need it's container to be visible when loaded.", "cq_allinone_vc")
                )

              )
            ) );


            vc_map( array(
              "name" => esc_attr__("Scrolling Notification", 'vc_notify_cq'),
              "base" => "cq_vc_notify",
              "class" => "wpb_cq_vc_extension_scrollnotification",
              "controls" => "full",
              "icon" => "cq_allinone_scrollnotification",
              "category" => esc_attr__('Sike Extensions', 'js_composer'),
              'description' => esc_attr__( 'Popup notification', 'js_composer' ),
              'admin_enqueue_js' => array(plugins_url('js/vc_notify_cq_admin.js', __FILE__)),
              "params" => array(
                array(
                  "type" => "textarea_html",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Notification content", 'vc_notify_cq'),
                  "param_name" => "content",
                  "value" => esc_attr__("I am test text block. Click edit button to change this text.", 'vc_notify_cq'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("opacity", 'vc_notify_cq'),
                  "param_name" => "opacity",
                  "value" => esc_attr__("0.8", 'vc_notify_cq'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("easein", "vc_notify_cq"),
                  "param_name" => "easein",
                  "value" => array(esc_attr__("random", "vc_notify_cq") => 'random', esc_attr__("fadeIn", "vc_notify_cq") => "fadeIn", esc_attr__("wobble", "vc_notify_cq") => "wobble", esc_attr__("tada", "vc_notify_cq") => "tada", esc_attr__("shake", "vc_notify_cq") => "shake", esc_attr__("swing", "vc_notify_cq") => "swing", esc_attr__("pulse", "vc_notify_cq") => "pulse", esc_attr__("fadeInLeft", "vc_notify_cq") => "fadeInLeft", esc_attr__("fadeInRight", "vc_notify_cq") => "fadeInRight", esc_attr__("fadeInUp", "vc_notify_cq") => "fadeInUp", esc_attr__("fadeInDown", "vc_notify_cq") => "fadeInDown", esc_attr__("fadeInLeftBig", "vc_notify_cq") => "fadeInLeftBig", esc_attr__("fadeInRightBig", "vc_notify_cq") => "fadeInRightBig", esc_attr__("fadeInUpBig", "vc_notify_cq") => "fadeInUpBig", esc_attr__("fadeInDownBig", "vc_notify_cq") => "fadeInDownBig", esc_attr__("bounceInLeft", "vc_notify_cq") => "bounceInLeft", esc_attr__("bounceInRight", "vc_notify_cq") => "bounceInRight", esc_attr__("bounce", "vc_notify_cq") => "bounce", esc_attr__("bounceInUp", "vc_notify_cq") => "bounceInUp", esc_attr__("bounceInDown", "vc_notify_cq") => "bounceInDown", esc_attr__("rollIn", "vc_notify_cq") => "rollIn", esc_attr__("rotateIn", "vc_notify_cq") => "rotateIn", esc_attr__("rotateInDownLeft", "vc_notify_cq") => "rotateInDownLeft", esc_attr__("rotateInDownRight", "vc_notify_cq") => "rotateInDownRight", esc_attr__("rotateInUpLeft", "vc_notify_cq") => "rotateInUpLeft", esc_attr__("rotateInUpRight", "vc_notify_cq") => "rotateInUpRight", esc_attr__("flipInX", "vc_notify_cq") => "flipInX", esc_attr__("flipInY", "vc_notify_cq") => "flipInY", esc_attr__("lightSpeedIn", "vc_notify_cq") => "lightSpeedIn"),
                  "description" => esc_attr__("Select easin in animation type. Note: Works only in modern browsers.", "vc_notify_cq")
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("easeout", "vc_notify_cq"),
                  "param_name" => "easeout",
                  "value" => array(esc_attr__("random", "vc_notify_cq") => 'random', esc_attr__("fadeOut", "vc_notify_cq") => "fadeOut", esc_attr__("fadeOutLeft", "vc_notify_cq") => "fadeOutLeft", esc_attr__("fadeOutRight", "vc_notify_cq") => "fadeOutRight", esc_attr__("fadeOutUp", "vc_notify_cq") => "fadeOutUp", esc_attr__("fadeOutDown", "vc_notify_cq") => "fadeOutDown", esc_attr__("fadeOutLeftBig", "vc_notify_cq") => "fadeOutLeftBig", esc_attr__("fadeOutRightBig", "vc_notify_cq") => "fadeOutRightBig", esc_attr__("fadeOutUpBig", "vc_notify_cq") => "fadeOutUpBig", esc_attr__("fadeOutDownBig", "vc_notify_cq") => "fadeOutDownBig", esc_attr__("bounceOutLeft", "vc_notify_cq") => "bounceOutLeft", esc_attr__("bounceOutRight", "vc_notify_cq") => "bounceOutRight", esc_attr__("bounceOutUp", "vc_notify_cq") => "bounceOutUp", esc_attr__("bounceOutDown", "vc_notify_cq") => "bounceOutDown", esc_attr__("rollOut", "vc_notify_cq") => "rollOut", esc_attr__("rotateOut", "vc_notify_cq") => "rotateOut", esc_attr__("rotateOutDownLeft", "vc_notify_cq") => "rotateOutDownLeft", esc_attr__("rotateOutDownRight", "vc_notify_cq") => "rotateOutDownRight", esc_attr__("rotateOutUpLeft", "vc_notify_cq") => "rotateOutUpLeft", esc_attr__("rotateOutUpRight", "vc_notify_cq") => "rotateOutUpRight", esc_attr__("flipOutX", "vc_notify_cq") => "flipOutX", esc_attr__("flipOutY", "vc_notify_cq") => "flipOutY", esc_attr__("lightSpeedOut", "vc_notify_cq") => "lightSpeedOut"),
                  "description" => esc_attr__("Select easout in animation type. Note: Works only in modern browsers.", "vc_notify_cq")
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("Display the notification", "vc_notify_cq"),
                  "param_name" => "displaywhen",
                  "value" => array( esc_attr__("hidden by default, visible only when user scrolling", "vc_notify_cq") => "scrolling", esc_attr__("always visible", "vc_notify_cq") => "loaded", esc_attr__("visible by default, hidden when user scrolling", "vc_notify_cq") => "scrollhidden"),
                  "description" => esc_attr__("Choose when to display the notification.", "vc_notify_cq")
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("Put the close button on the", "vc_notify_cq"),
                  "param_name" => "closeposition",
                  "value" => array(esc_attr__("left", "vc_notify_cq") => "left", esc_attr__("right", "vc_notify_cq") => "right"),
                  "description" => esc_attr__("", "vc_notify_cq")
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("width", 'vc_notify_cq'),
                  "param_name" => "width",
                  "value" => esc_attr__("240", 'vc_notify_cq'),
                  "description" => esc_attr__("A fixed value like 640, or a percent value like 60%, or leave it to be blank equal to auto.", 'vc_notify_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("height", 'vc_notify_cq'),
                  "param_name" => "height",
                  "value" => esc_attr__("auto", 'vc_notify_cq'),
                  "description" => esc_attr__("A fixed value like 640, or a percent value like 60%, or leave it to be blank equal to auto.", 'vc_notify_cq')
                ),
                array(
                  "type" => "colorpicker",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Notification text color", 'vc_extend'),
                  "param_name" => "textcolor",
                  "value" => '#333',
                  "description" => esc_attr__("", 'vc_extend')
                ),
                array(
                  "type" => "colorpicker",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Notification background", 'vc_extend'),
                  "param_name" => "background",
                  "value" => '#fff',
                  "description" => esc_attr__("", 'vc_extend')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("top", 'vc_notify_cq'),
                  "param_name" => "top",
                  "value" => esc_attr__("", 'vc_notify_cq'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("right", 'vc_notify_cq'),
                  "param_name" => "right",
                  "value" => esc_attr__("10", 'vc_notify_cq'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("bottom", 'vc_notify_cq'),
                  "param_name" => "bottom",
                  "value" => esc_attr__("10", 'vc_notify_cq'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("left", 'vc_notify_cq'),
                  "param_name" => "left",
                  "value" => esc_attr__("", 'vc_notify_cq'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("Auto hide delay", 'vc_notify_cq'),
                  "param_name" => "autohidedelay",
                  "value" => esc_attr__("", 'vc_notify_cq'),
                  "description" => esc_attr__("For example, 5000 stand for 5 seconds, leave it to blank if you do not want it", 'vc_notify_cq')
                ),
                array(
                  "type" => "checkbox",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("After close, store it in cookie", 'vc_notify_cq'),
                  "param_name" => "cookie",
                  "value" => array(esc_attr__("yes", "vc_notify_cq") => 'on'),
                  "description" => esc_attr__("", 'vc_notify_cq')
                ),

                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_notify_cq",
                  "heading" => esc_attr__("After close, do not show the notification again for days", 'vc_notify_cq'),
                  "param_name" => "days",
                  "value" => esc_attr__("10", 'vc_notify_cq'),
                  "description" => esc_attr__("You have to enable the store in cookie", 'vc_notify_cq')
                )

              )
            ) );


            // gallery part
            vc_map( array(
              "name" => esc_attr__("Masonry Gallery", 'vc_gallery_cq'),
              "base" => "cq_vc_gallery",
              "class" => "wpb_cq_vc_extension_masonry",
              "controls" => "full",
              "icon" => "cq_allinone_masonry",
              "category" => esc_attr__('Sike Extensions', 'js_composer'),
              'description' => esc_attr__( 'Responsive grid gallery', 'js_composer' ),
              "params" => array(
                array(
                  "type" => "attach_images",
                  "heading" => esc_attr__("Images", "vc_gallery_cq"),
                  "param_name" => "images",
                  "value" => "",
                  "description" => esc_attr__("Select images from media library.", "vc_gallery_cq")
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "vc_gallery_cq",
                  "heading" => esc_attr__("On click", "vc_gallery_cq"),
                  "param_name" => "onclick",
                  "value" => array(esc_attr__("open large image (lightbox)", "vc_gallery_cq") => "link_image", esc_attr__("Do nothing", "vc_gallery_cq") => "link_no", esc_attr__("Open custom link", "vc_gallery_cq") => "custom_link"),
                  "description" => esc_attr__("Define action for onclick event if needed.", "vc_gallery_cq")
                ),
                array(
                  "type" => "exploded_textarea",
                  "heading" => esc_attr__("Custom links", "vc_gallery_cq"),
                  "param_name" => "custom_links",
                  "description" => esc_attr__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'vc_gallery_cq'),
                  "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
                ),
                array(
                  "type" => "dropdown",
                  "heading" => esc_attr__("Custom link target", "vc_gallery_cq"),
                  "param_name" => "custom_links_target",
                  "description" => esc_attr__('Select where to open custom links.', 'vc_gallery_cq'),
                  "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
                  'value' => array(esc_attr__("Same window", "vc_gallery_cq") => "_self", esc_attr__("New window", "vc_gallery_cq") => "_blank")
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_gallery_cq",
                  "heading" => esc_attr__("Thumbnail width", 'vc_gallery_cq'),
                  "param_name" => "itemwidth",
                  "value" => esc_attr__("240", 'vc_gallery_cq'),
                  "description" => esc_attr__("Width of each thumbnail in the masonry gallery.", 'vc_gallery_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_gallery_cq",
                  "heading" => esc_attr__("Thumbnail padding", 'vc_gallery_cq'),
                  "param_name" => "offset",
                  "value" => esc_attr__("4", 'vc_gallery_cq'),
                  "description" => esc_attr__("Padding between each thumbnail.", 'vc_gallery_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_gallery_cq",
                  "heading" => esc_attr__("Container offset", 'vc_gallery_cq'),
                  "param_name" => "outeroffset",
                  "value" => esc_attr__("0", 'vc_gallery_cq'),
                  "description" => esc_attr__("Offset of the whole gallery to it's container.", 'vc_gallery_cq')
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_gallery_cq",
                  "heading" => esc_attr__("minWidth", 'vc_gallery_cq'),
                  "param_name" => "minwidth",
                  "value" => esc_attr__("240", 'vc_gallery_cq'),
                  "description" => esc_attr__("Minimal width of the lightbox image.", 'vc_gallery_cq')
                ),
                array(
                  "type" => "checkbox",
                  "holder" => "",
                  "class" => "vc_gallery_cq",
                  "heading" => esc_attr__("Make the thumbnails retina?", 'vc_gallery_cq'),
                  "param_name" => "retina",
                  "value" => array(esc_attr__("Yes", "vc_gallery_cq") => 'on'),
                  "description" => esc_attr__("For example a 640x480 thumbnail will display as 320x240 in retina mode.", 'vc_gallery_cq')
                ),
                array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_gallery_cq",
                "heading" => esc_attr__("Layout before all images are loaded?", 'vc_gallery_cq'),
                "param_name" => "imagesload",
                "value" => array(esc_attr__("Yes", "vc_gallery_cq") => 'on'),
                "description" => esc_attr__("Defalut the masonry layout is generated after images are all loaded, you can check this if your theme support instant layout.<br />Note: this will break the layout and make the images stacked in some theme, so check it carefully.", 'vc_gallery_cq')
              )

              )
            ));

          add_shortcode( 'cq_vc_modal', array( &$this, 'cq_vc_modal_func') );
          add_shortcode( 'cq_vc_notify', array( &$this, 'cq_vc_notify_func') );
          add_shortcode( 'cq_vc_gallery', array( &$this, 'cq_vc_gallery_func') );

        }

    function cq_vc_modal_func( $atts, $content=null, $tag) {
          $buttoncolor = $buttontext = $buttonshape = $buttonsize = $align = "";
          extract( shortcode_atts( array(
            "buttontext" => "Button",
            "buttoncolor" => "blue",
            "buttonsize" => "xs",
            "buttonshape" => "rounded",
            "buttonstyle" => "modern",
            "align" => "center",
            'width' => '640',
            'textcolor' => '#333',
            'background' => '#fff',
            'margintop' => '40',
            'padding' => '0',
            'popupposition' => 'fixed',
            'loadedvisible' => 'off'
          ), $atts ) );
          wp_register_style( 'vc_modal_cq_style', plugins_url('css/avgrund.css', __FILE__) );
          wp_enqueue_style( 'vc_modal_cq_style' );
          wp_enqueue_script( 'vc_modal_cq_js', plugins_url('js/jquery.avgrund.min.js', __FILE__), array('jquery') );

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';
          $output .= "<div class='avgrund-container' data-width='${width}' data-textcolor='${textcolor}' data-background='${background}' data-loadedvisible='${loadedvisible}' data-margintop='${margintop}' data-popupposition='${popupposition}'><div class='avgrund-popup'>
              <div class='avgrund-content'>".
                $content
              ."</div>
              <a href='#' class='avgrund-close'><img width='24' height='24' src='".plugins_url('img/close.png', __FILE__)."' alt='close' /></a>
            </div><div class='avgrund-cover'></div>";
          $output .= "<a href='#' class='avgrund-btn'>";
          $output .= do_shortcode('[vc_btn title="'.$buttontext.'" color="'.$buttoncolor.'" style="'.$buttonstyle.'" shape="'.$buttonshape.'" align="'.$align.'" size="'.$buttonsize.'"]');
          $output .= "</a></div>";
          return $output;
        }

        function cq_vc_notify_func( $atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'width' => '240',
            'height' => '140',
            'textcolor' => '#333',
            'background' => '#fff',
            'easein' => 'fadeInLeft',
            'easeout' => 'fadeOutRight',
            'cookie' => 'false',
            'autohidedelay' => '',
            'days' => '10',
            'top' => '',
            'right' => '10',
            'bottom' => '10',
            'left' => '',
            'opacity' => '0.8',
            'displaywhen' => 'scrolling',
            'closeposition' => 'left'
          ), $atts ) );

          wp_register_style( 'vc_notify_cq_style', plugins_url('css/jquery.scroll-notify.css', __FILE__) );
          wp_enqueue_style( 'vc_notify_cq_style' );
          wp_register_style( 'animate', plugins_url('css/animate.min.css', __FILE__) );
          wp_enqueue_style( 'animate' );
          wp_register_script('modernizr_css3', plugins_url('js/modernizr.custom.49511.js', __FILE__), array("jquery"));
          wp_enqueue_script('modernizr_css3');
          wp_enqueue_script('jquery-cookie', plugins_url('js/jquery.cookie.js', __FILE__), array('jquery'));
          wp_enqueue_script( 'vc_notify_cq_js', plugins_url('js/jquery.scroll-notify.min.js', __FILE__), array('jquery') );
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';
            if(is_single()||is_page()){
              if($displaywhen=="scrollhidden"){
                return "<div id='cq-scroll-notification' data-width='${width}' data-height='${height}' data-textcolor='${textcolor}' data-background='${background}' data-easein='${easein}' data-easeout='${easeout}' data-positiontop='${top}' data-positionright='${right}' data-positionbottom='${bottom}' data-positionleft='${left}' data-cookie='${cookie}' data-days='${days}' data-autohidedelay='${autohidedelay}' data-displaywhen='loaded' data-opacity='${opacity}' data-from='0' data-to='all' data-closebutton='true' data-displaybydefault='on' data-closeposition='${closeposition}' class='cq-scroll-notification'> {$content} </div>";
              }else{
                return "<div id='cq-scroll-notification' data-width='${width}' data-height='${height}' data-textcolor='${textcolor}' data-background='${background}' data-easein='${easein}' data-easeout='${easeout}' data-positiontop='${top}' data-positionright='${right}' data-positionbottom='${bottom}' data-positionleft='${left}' data-cookie='${cookie}' data-days='${days}' data-autohidedelay='${autohidedelay}' data-displaywhen='${displaywhen}' data-opacity='${opacity}' data-from='0' data-to='all' data-closebutton='true' data-closeposition='${closeposition}' class='cq-scroll-notification' style='display:none'> {$content} </div>";

              }
            }
        }


        // the gallery shortcode
        function cq_vc_gallery_func( $atts, $content=null, $tag) {
          global $post;
          extract( shortcode_atts( array(
            'images' => '',
            'itemwidth' => '240',
            'minwidth' => '240',
            'offset' => '4',
            'onclick' => 'link_image',
            'custom_links' => '',
            'custom_links_target' => '',
            'outeroffset' => '0',
            'background' => '#fff',
            'retina' => 'off',
            'imagesload' => 'off',
            'margintop' => '40'
          ), $atts ) );

          wp_enqueue_style('cq_pinterest_style', plugins_url('css/jquery.pinterest.css', __FILE__));
          wp_register_script('imagesload', plugins_url('js/imagesloaded.pkgd.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('imagesload');
          wp_register_script('wookmark', plugins_url('js/jquery.wookmark.min.js', __FILE__), array('jquery', 'imagesload'));
          wp_enqueue_script('wookmark');

          if($onclick=='link_image'){
            wp_register_script('fs.boxer', plugins_url('js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
            wp_enqueue_script('fs.boxer');
            wp_register_style('fs.boxer', plugins_url('css/jquery.fs.boxer.css', __FILE__));
            wp_enqueue_style('fs.boxer');
          }else if($onclick=="custom_link"){
            $custom_links = explode( ',', $custom_links);
          }

          $imagesarr = explode(',', $images);
          $output = '';
          $output .= '<ul class="pinterest-container" data-onclick="'.$onclick.'" data-itemwidth="'.$itemwidth.'" data-minwidth="'.$minwidth.'" data-offset="'.$offset.'" data-outeroffset="'.$outeroffset.'" data-id="'.$post->ID.rand(0, 100).'" data-imagesload="'.$imagesload.'">';
          $i = -1;
          foreach ($imagesarr as $key => $value) {
              $i++;
              $output .= "<li style='list-style:none;display:none'>";
              if(wp_get_attachment_image_src(trim($value), 'full')){
                $attachment = get_post($value);
                $return_img_arr = wp_get_attachment_image_src(trim($value), 'full');

                $img = $thumbnail = $return_img_height = "";
                $fullimage = $return_img_arr[0];
                $thumbnail = $fullimage;
                if($itemwidth!=""){
                    if(function_exists('wpb_resize')){
                        $img = wpb_resize($value, null, $retina=="on"?$itemwidth*2:$itemwidth, null);
                        $thumbnail = $img['url'];
                        $return_img_height = $retina=="on"?$img['height']*0.5:$img['height'];
                        if($thumbnail=="") $thumbnail = $fullimage;
                    }
                }

                if($onclick=='link_image'){
                  $output .= "<a href='".$return_img_arr[0]."' class='lightbox-link' rel='cq-pinterst-".$post->ID."'>";
                  $output .= "<img src='".$thumbnail."' width='$itemwidth' height='".$return_img_height."' alt='".get_post_meta($attachment->ID, "_wp_attachment_image_alt", true )."' />";
                  $output .= "</a>";
                }else if($onclick=='custom_link'){
                  if($i<count($custom_links)){
                    $output .= "<a href='".$custom_links[$i]."' target='".$custom_links_target."'>";
                    $output .= "<img src='".$thumbnail."' width='$itemwidth' height='".$return_img_height."' alt='".get_post_meta($attachment->ID, "_wp_attachment_image_alt", true )."' />";
                    $output .= "</a>";
                  }else{
                    $output .= "<img src='".$thumbnail."' width='$itemwidth' height='".$return_img_height."' alt='".get_post_meta($attachment->ID, "_wp_attachment_image_alt", true )."' />";
                  }
                }else{
                  $output .= "<img src='".$thumbnail."' width='$itemwidth' height='".$return_img_height."' alt='".get_post_meta($attachment->ID, "_wp_attachment_image_alt", true )."' />";
                }
              }
              $output .= "</li>";
          }
          $output .= '</ul>';

          return $output;

        }



    }

}

?>
