<?php
if (!class_exists('VC_Extensions_MoreCaptionV2')) {
    class VC_Extensions_MoreCaptionV2{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("More Caption V2", 'cq_allinone_vc'),
            "base" => "cq_vc_morecaptionv2",
            "class" => "wpb_cq_vc_extension_morecaption",
            "icon" => "cq_vc_morecaptionv2",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Image with more text', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image:", "cq_allinone_vc"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the image?", "cq_allinone_vc"),
                "param_name" => "isresize",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "description" => esc_attr__("Choose to resize the image or not, useful if your original image is too large.", "cq_allinone_vc"),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "cq_allinone_vc"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Display the more caption area in:", "cq_allinone_vc"),
                "param_name" => "captionby",
                "value" => array('Click' => 'click', 'Hover' => 'hover'),
                'std' => 'click',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Whole element shape", "cq_allinone_vc"),
                "param_name" => "elementshape",
                "value" => array('Square' => 'square', 'Rounded' => 'rounded', 'Round' => 'round'),
                'std' => 'square',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__( "Link for the element (optional)", "cq_allinone_vc" ),
                "param_name" => "elementlink",
                "description" => esc_attr__( "", "cq_allinone_vc" )
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background color", 'cq_allinone_vc'),
                "param_name" => "bgcolor",
                "value" => "",
                "description" => esc_attr__("Background color for the hover animation background.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Close button color", 'cq_allinone_vc'),
                "param_name" => "closecolor",
                "value" => "",
                "description" => esc_attr__("Color for the close button, default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is auto, depends on the image, you can customize it with other value (like 320px etc).", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "class" => "cq_allinone_vc",
                "heading" => esc_attr__("Auto delay slideshow?", "cq_allinone_vc"),
                "param_name" => "autodelay",
                'value' => array(2, 3, 4, 5, 7, 10, esc_attr__( 'Disable (hide it by default)', 'cq_allinone_vc' ) => 0 ),
                'std' => 0,
                "description" => esc_attr__("Display the text block after X seconds.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title over the image (optional)", "cq_allinone_vc"),
                "param_name" => "title",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Title font size", "cq_allinone_vc"),
                "param_name" => "titlesize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is 1.5em. You can customize it with other value, like 14px or 1.2em etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Title color", 'cq_allinone_vc'),
                "param_name" => "titlecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
             ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Title background color", 'cq_allinone_vc'),
                "param_name" => "titlebgcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is light gray.", 'cq_allinone_vc')
             ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Sub title under the title (optional)", "cq_allinone_vc"),
                "param_name" => "subtitle",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
             array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Font size for the sub title", "cq_allinone_vc"),
                "param_name" => "subtitlesize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
             array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("sub title color", 'cq_allinone_vc'),
                "param_name" => "subtitlecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", 'cq_allinone_vc')
            ),
             array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("sub title background color", 'cq_allinone_vc'),
                "param_name" => "subtitlebgcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is light gray.", 'cq_allinone_vc')
             ),
             array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Title area padding (title and the sub title)", "cq_allinone_vc"),
                "param_name" => "titlepadding",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is 120px 24px 24px 64px. Use this to control the title and sub title position.", "cq_allinone_vc")
              ),
             array(
                "type" => "attach_image",
                "heading" => esc_attr__("Avatar image", "cq_allinone_vc"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Select image from media library.", "cq_allinone_vc")
              ),
             array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Avatar position", "cq_allinone_vc"),
                "param_name" => "avatarpos",
                "value" => array('Left top' => 'lefttop', 'Left bottom' => 'leftbottom', 'Right top' => 'righttop', 'Right bottom' => 'rightbottom'),
                'std' => 'rightbottom',
                "group" => "Avatar",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
             array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("More information popup size percent", "cq_allinone_vc"),
                "param_name" => "popupsize",
                "value" => array('30%' => '30', '40%' => '40', '50%' => '50', '60%' => '60', '70%' => '70', '80%' => '80', '90%' => '90', '100%' => '100',),
                'std' => '50',
                "group" => "Avatar",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the whole avatar", "cq_allinone_vc"),
                "param_name" => "avatarwidth",
                "value" => "80",
                "group" => "Avatar",
                "description" => esc_attr__('The avatar will be displayed in circle. Default is 80 (in pixel).', "cq_allinone_vc")
              ),
            array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library (optional icon before label)', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'captionicon',
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
             array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon for the label (optional)', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'fontawesome',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
             array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'openiconic',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'typicons',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Avatar",
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'linecons',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'material',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
            array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Avatar Background color", 'cq_allinone_vc'),
                "param_name" => "avatarbg",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Background color for the avatar.", 'cq_allinone_vc')
              ),
            array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Icon size", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is 24px.", "cq_allinone_vc")
              ),
             array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Color for the avatar icon.", 'cq_allinone_vc')
              ),
             array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Popup content position", "cq_allinone_vc"),
                "param_name" => "popuppos",
                "value" => array('Top' => 'top', 'Bottom' => 'bottom', 'Right' => 'right', 'Left' => 'left'),
                'std' => 'right',
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
            array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
            array(
                "type" => "textfield",
                "heading" => esc_attr__("Button text", "cq_allinone_vc"),
                "param_name" => "buttontext",
                "value" => "",
                'group' => 'Button',
                "description" => esc_attr__("Optional button under the title and description.", "cq_allinone_vc")
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
                "type" => "vc_link",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("URL (Optional link for the button)", "cq_allinone_vc"),
                "param_name" => "buttonlink",
                "value" => "",
                'group' => 'Button',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
             array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              )

           )
        ));

        add_shortcode('cq_vc_morecaptionv2', array($this,'cq_vc_morecaptionv2_func'));

      }

      function cq_vc_morecaptionv2_func($atts, $content=null, $tag) {
          $image = $imagewidth = $align = $title = $subtitle = $isdisplay = $titlecolor = $titlesize = $elementlink = $elementshape = $elementheight = $autodelay = $captionby = $captionicon = $subtitlesize = $subtitlecolor = $titlebgcolor = $subtitlebgcolor = $iconsize = $labelcolor = $avatarimage = $avatarbg = $iconcolor = $avatarwidth = $avatarpos = $popuppos = $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $titlepadding = $popupsize = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = '';
          extract(shortcode_atts(array(
            "image" => "",
            "avatarimage" => "",
            "avatarbg" => "",
            "iconcolor" => "",
            "avatarwidth" => "",
            "avatarpos" => "rightbottom",
            "popuppos" => "right",
            "buttontext" => "",
            "buttoncolor" => "blue",
            "buttonsize" => "xs",
            "buttonshape" => "rounded",
            "buttonstyle" => "modern",
            "buttonlink" => "",
            "align" => "center",
            "titlepadding" => "",
            "popupsize" => "50",
            "bgcolor" => "",
            "closecolor" => "",
            "iconsize" => "",
            "labelcolor" => "",
            "subtitlesize" => "",
            "subtitlecolor" => "",
            "titlebgcolor" => "",
            "subtitlebgcolor" => "",
            "captionby" => "click",
            "imagewidth" => "",
            "autodelay" => "0",
            "titlecolor" => "",
            "elementlink" => "",
            "titlesize" => "",
            "title" => "",
            "label" => "",
            "subtitle" => "",
            "elementshape" => "square",
            "elementheight" => "",
            "captionicon" => "entypo",
            "icon_fontawesome" => 'fa fa-share',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-comment',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "isresize" => "no",
            "isdisplay" => "",
            "bgheight" => "240",
            "contentcolor" => "",
            "captionoffset" => "",
            "captiontype" => "hideicon",
            "lightboxmargin" => "",
            "linktype" => "",
            "lightbox_url" => "",
            "videowidth" => "640",
            "cardlink" => "",
            "extraclass" => ""
          ), $atts));


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          $imagewidth = intval($imagewidth);
          $attachment = get_post($image);
          $imageurl = wp_get_attachment_image_src($image, 'full');
          $attachment = get_post($image);
          $resizedimage = $imageurl[0];
          if($imagewidth>0){
              if(function_exists('wpb_resize')){
                  $resizedimage = wpb_resize($image, null, $imagewidth, null);
                  $resizedimage = $resizedimage['url'];
                  if($resizedimage=="") $resizedimage = $imageurl[0];
              }
          }


        $avatarimagearr = wp_get_attachment_image_src(trim($avatarimage), 'full');
        $avatar_image_temp = $avatarimage_url = "";
        $avatar_full_image = $avatarimagearr[0];
        $avatarimage_url = $avatar_full_image;
        if($avatarwidth!=""){
            if(function_exists('wpb_resize')){
                $avatar_image_temp = wpb_resize($avatarimage, null, $avatarwidth*2, $avatarwidth*2, true);
                $avatarimage_url = $avatar_image_temp['url'];
                if($avatarimage_url=="") $avatarimage_url = $avatar_full_image;
            }
        }


          wp_register_style( 'vc-extensions-morecaption-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-morecaption-style' );


          wp_register_script('vc-extensions-morecaption-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-morecaption-script');

          $output = "";
          $text_str = "";
          $image_str = "";
          $style_str = "";

          if($captionicon != "captionicon"){
              vc_icon_element_fonts_enqueue('entypo');
          }
          vc_icon_element_fonts_enqueue($captionicon);

          $elementlink = vc_build_link($elementlink);
          $output .= '<div class="cq-morecaptionv2 cq-morecaptionv2-avatar-'.$avatarpos.' cq-morecaptionv2-more-'.$popuppos.' cq-morecaptionv2-by'.$captionby.' cq-morecaptionv2-shape-'.$elementshape.' '.$extraclass.'" data-elementheight="'.$elementheight.'" style="height:'.$elementheight.'" data-captionby="'.$captionby.'" data-autodelay="'.$autodelay.'">';
          $output .= '<div class="cq-morecaptionv2-container cq-morecaptionv2-'.$popupsize.'">';

          if($elementlink["url"]!=""){
              $output .= '<a href="'.$elementlink["url"].'" title="'.$elementlink["title"].'" target="'.$elementlink["target"].'" rel="'.$elementlink["rel"].'" class="cq-morecaptionv2-link">';
          }

          $output .= '<div class="cq-morecaptionv2-cover" style="background-image: url(&quot;'.$resizedimage.'&quot;);background-color:'.$bgcolor.';">';

          $output .= '<div class="cq-morecaptionv2-less" style="padding:'.$titlepadding.';">';
          if($title != ""){
              $output .= '<h3 class="cq-morecaptionv2-title" style="color:'.$titlecolor.';font-size:'.$titlesize.';background-color:'.$titlebgcolor.';">'.$title.'</h3>';
          }
          if($subtitle != ""){
              $output .= '<h4 class="cq-morecaptionv2-subtitle" style="color:'.$subtitlecolor.';font-size:'.$subtitlesize.';background-color:'.$subtitlebgcolor.';">'.$subtitle.'</h4>';
          }
          $output .= '</div>';


          $output .= '<div class="cq-morecaptionv2-avatar" style="background-image: url(&quot;'.$avatarimage_url.'&quot;);background-color:'.$avatarbg.';width:'.$avatarwidth.'px;height:'.$avatarwidth.'px;">';
          $output .= '<i class="cq-morecaptionv2-icon '.esc_attr(${'icon_' . $captionicon}).'" style="color:'.$iconcolor.';font-size:'.$iconsize.';line-height:'.$avatarwidth.'px;"></i>';
          $output .= '</div>';

          $output .= '</div>';
          if($elementlink["url"]!=""){
              $output .= '</a>';
          }

          $output .= '<div class="cq-morecaptionv2-content" style="background-color:'.$bgcolor.';">';
          $output .= $content;
          if($buttontext!=""){
              $output .= do_shortcode('[vc_btn title="'.$buttontext.'" color="'.$buttoncolor.'" style="'.$buttonstyle.'" shape="'.$buttonshape.'" link="'.$buttonlink.'" align="'.$align.'" size="'.$buttonsize.'"]');
          }
          $output .= '<div class="cq-morecaptionv2-close"><a class="cq-morecaptionv2-closebtn" href="javascript:void(0)">';
          $output .= '<i class="cq-morecaptionv2-closeicon entypo-icon entypo-icon-cancel" style="color:'.$closecolor.';"></i>';
          $output .= '</a></div>';
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';
          return $output;

        }

  }

}

?>
