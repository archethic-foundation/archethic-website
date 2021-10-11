<?php
if (!class_exists('VC_Extensions_SkewCard')){
    class VC_Extensions_SkewCard{
        private $itemnum = 1;
        private $itemheight;
        private $itembg;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Skew Card", 'cq_allinone_vc'),
            "base" => "cq_vc_skewcard",
            "class" => "cq_vc_skewcard",
            "icon" => "cq_vc_skewcard",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_skewcard_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('With image and text', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Skew direction", "cq_allinone_vc"),
                 "param_name" => "skewdirection",
                 "value" => array("left", "right"),
                 "std" => "right",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Item height:", "cq_allinone_vc"),
                "param_name" => "itemheight",
                "value" => "",
                "description" => esc_attr__("The height depends on the item number and container width. Default is 160%.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Background size:", "cq_allinone_vc"),
                 "param_name" => "bgsize",
                 "value" => array("100%" => "0", "110%" => "1", "120%" => "2", "130%" => "3", "140%" => "4", "150%" => "5", "160%" => "6"),
                 "std" => "100%",
                 "description" => esc_attr__("The image size.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Background x offset:", "cq_allinone_vc"),
                 "param_name" => "bgoffset",
                 "value" => array("-5%" => "x5", "-10%" => "x10", "-20%" => "x20", "0" => "0", "%5" => "5", "10%" => "10", "20%" => "20"),
                 "std" => "10",
                 "description" => esc_attr__("The image x offset, default is 10%.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color item", 'cq_allinone_vc'),
                "param_name" => "itembg",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the padding/margin only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Card Item","cq_allinone_vc"),
             "base" => "cq_vc_skewcard_item",
             "class" => "cq_vc_skewcard_item",
             "icon" => "cq_vc_skewcard_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_skewcard'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Background image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Label for the image (optional, keep it short)", "cq_allinone_vc"),
                "param_name" => "label",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Caption for the image (optional)", "cq_allinone_vc"),
                "param_name" => "caption",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__("URL (Optional link for the item)", "cq_allinone_vc"),
                "param_name" => "imagelink",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
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
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),

              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color for the label.", 'cq_allinone_vc'),
                "param_name" => "labelbg",
                "value" => '',
                "description" => esc_attr__("Default is lavender.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color for the hover overlay.", 'cq_allinone_vc'),
                "param_name" => "overlaybg",
                "value" => '',
                "description" => esc_attr__("Default is lavender.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font color for the label", 'cq_allinone_vc'),
                "param_name" => "labelcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font color for the hover overlay", 'cq_allinone_vc'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("color for the icon", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font size for the icon.", "cq_allinone_vc"),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "iconsize",
                "value" => "",
                "description" => esc_attr__('Default is 2em. Support other value, like 1em or 14px etc.', "cq_allinone_vc")
              )


              ),
            )
        );

          add_shortcode('cq_vc_skewcard', array($this,'cq_vc_skewcard_func'));
          add_shortcode('cq_vc_skewcard_item', array($this,'cq_vc_skewcard_item_func'));

      }

      function cq_vc_skewcard_func($atts, $content=null) {
        $css_class = $css = $autoslide = $extraclass = $itemheight = $itembg = $skewdirection = $bgsize = $bgoffset = '';
        $itemnum = 0;
        $itembg = '';

        extract(shortcode_atts(array(
          "bgsize" => "0",
          "bgoffset" => "10",
          "arrowstyle" => "aqua",
          "autoslide" => "no",
          "skewdirection" => "right",
          "css" => "",
          "itemheight" => "",
          "itembg" => "",
          "extraclass" => ""
        ),$atts));


        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_skewcard', $atts);

        wp_register_style( 'vc-extensions-skewcard-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-skewcard-style' );


        $this -> itemnum = $itemnum;
        $this -> itemheight = $itemheight;
        $this -> itembg = $itembg;


        $final_item_num;

        $item_str = do_shortcode($content);

        $output .= '<div class="cq-skewcard cq-skewcard-size-'.$bgsize.' cq-skewcard-offset-'.$bgoffset.' cq-skewcard-skew-'.$skewdirection.' cq-skewcard-item-'.$this -> itemnum.' '.$css_class.' cq-skewcard-shape-'.$elementshape.' '.$extraclass.'" data-itemheight="'.$itemheight.'" data-autodelay="'.$autodelay.'">';

        $output .= '<div class="cq-skewcard-container">';

        $output .= $item_str;


        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_skewcard_item_func($atts, $content=null, $tag) {
          $output = $image = $imagesize = $videowidth = $isresize = $label = $imagelink = $labelcolor = $labelbg = $overlaybg = $contentcolor = $captionicon = $iconcolor = $iconsize = $caption = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = '';

          extract(shortcode_atts(array(
              "captionicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "isresize" => "no",
              "iscaption" => "",
              "label" => "",
              "imagelink" => "",
              "labelcolor" => "",
              "labelbg" => "",
              "overlaybg" => "",
              "iconcolor" => "",
              "iconsize" => "",
              "caption" => "",
              "captionicon" => "entypo",
              "icon_fontawesome" => 'fa fa-share',
              "icon_openiconic" => 'vc-oi vc-oi-dial',
              "icon_typicons" => 'typcn typcn-adjust-brightness',
              "icon_entypo" => 'entypo-icon entypo-icon-comment',
              "icon_linecons" => 'vc_li vc_li-heart',
              "icon_material" => 'vc-material vc-material-cake',
              "contentcolor" => "",
            ), $atts));

          vc_icon_element_fonts_enqueue($captionicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content


          $imagelink = vc_build_link($imagelink);

          $img = $thumbnail = "";

          $fullimage = wp_get_attachment_image_src($image, 'full');
          $attachment = get_post($image);
          $thumbnail = $fullimage[0];
          if($isresize=="yes"&&$imagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagesize, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage[0];
              }
          }

          $avatarimg = $avatarthumbnail = "";
          $avatarfullimage = wp_get_attachment_image_src($avatarimage, 'full');
          $avatarthumbnail = $avatarfullimage[0];
          if($avatarresize=="yes"&&$avatarimagesize!=""){
              if(function_exists('wpb_resize')){
                  $avatarimg = wpb_resize($avatarimage, null, $avatarimagesize, null);
                  $avatarthumbnail = $avatarimg['url'];
                  if($avatarthumbnail=="") $avatarthumbnail = $avatarfullimage[0];
              }
          }

          $itemnum = $this -> itemnum;


          $output = '';

          $output .= '<div class="cq-skewcard-item">';
          $output .= '<div class="cq-skewcard-itemcontent">';

          $output .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" class="cq-skewcard-link" rel="'.$imagelink["rel"].'">';

          $output .= '<div class="cq-skewcard-top" style="background-color:'.$this -> itembg.';">';

          $output .= '<div class="cq-skewcard-top-container" style="padding-top:'.$this -> itemheight.'">';
          $output .= '</div>';

          $output .= '<div class="cq-skewcard-top-inner">';
          $output .= '<div class="cq-skewcard-img" style="background-image: url(&quot;'.$thumbnail.'&quot;);">';
          $output .= '</div>';

          if($label != ""){
              $output .= '<div class="cq-skewcard-label" style="background-color:'.$labelbg.';color:'.$labelcolor.';">';
              $output .= '<span>'.$label.'</span>';
              $output .= '</div>';
          }
          $output .= '<div class="cq-skewcard-overlay">';
          $output .= '<div class="cq-skewcard-overlay-bg" style="background-color:'.$overlaybg.';">';
          $output .= '</div>';
          $output .= '<div class="cq-skewcard-overlay-inner">';
          if($caption != "" || $captionicon != ""){
              $output .= '<div class="cq-skewcard-overlay-txt" style="color:'.$contentcolor.';">';
              $output .= $caption;
              $output .= '<div class="cq-clearfix"></div>';
              $output .= '<i class="cq-skewcard-icon '.esc_attr(${'icon_' . $captionicon}).'" style="color:'.$iconcolor.';font-size:'.$iconsize.';"></i>';
              $output .= '</div>';
          }


          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';

          $output .= '</a>';
          $output .= '</div>';
          $output .= '</div>';

          $itemnum++;
          $this -> itemnum = $itemnum;

          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_skewcard')) {
    class WPBakeryShortCode_cq_vc_skewcard extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_skewcard_item')) {
    class WPBakeryShortCode_cq_vc_skewcard_item extends WPBakeryShortCode {
    }
}

?>
