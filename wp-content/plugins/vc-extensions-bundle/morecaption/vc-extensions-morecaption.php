<?php
if (!class_exists('VC_Extensions_MoreCaption')) {
    class VC_Extensions_MoreCaption{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("More Caption", 'cq_allinone_vc'),
            "base" => "cq_vc_morecaption",
            "class" => "wpb_cq_vc_extension_morecaption",
            "icon" => "cq_vc_morecaption",
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
                'std' => 'hover',
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
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is auto, depends on the image, you can customize it with other value (like 320px etc).", "cq_allinone_vc")
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
                "heading" => esc_attr__("Caption color", 'cq_allinone_vc'),
                "param_name" => "titlecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
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
                "heading" => esc_attr__("font size for the sub title", "cq_allinone_vc"),
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
                "group" => "Text",
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
                "group" => "Text",
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
                "group" => "Text",
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
                "group" => "Text",
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
                "group" => "Text",
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
                "group" => "Text",
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
                "group" => "Text",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),

            array(
                "type" => "textfield",
                "heading" => esc_attr__("Label (optional)", "cq_allinone_vc"),
                "param_name" => "label",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
             array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size for the label and icon", "cq_allinone_vc"),
                "param_name" => "labelsize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
             array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("label and icon color", 'cq_allinone_vc'),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", 'cq_allinone_vc')
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
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              )

           )
        ));

        add_shortcode('cq_vc_morecaption', array($this,'cq_vc_morecaption_func'));

      }

      function cq_vc_morecaption_func($atts, $content=null, $tag) {
          $image = $imagewidth = $align = $title = $subtitle = $label = $isdisplay = $titlecolor = $titlesize = $elementlink = $elementshape = $elementheight = $autodelay = $captionby = $captionicon = $subtitlesize = $subtitlecolor = $labelsize = $labelcolor = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = '';
          extract(shortcode_atts(array(
            "image" => "",
            "bgcolor" => "",
            "labelsize" => "",
            "labelcolor" => "",
            "subtitlesize" => "",
            "subtitlecolor" => "",
            "captionby" => "hover",
            "imagewidth" => "",
            "align" => "center",
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



          wp_register_style( 'vc-extensions-morecaption-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-morecaption-style' );


          wp_register_script('vc-extensions-morecaption-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-morecaption-script');

          $output = "";
          $text_str = "";
          $image_str = "";
          $style_str = "";

          vc_icon_element_fonts_enqueue($captionicon);

          $elementlink = vc_build_link($elementlink);
          $output .= '<div class="cq-morecaption cq-morecaption-by'.$captionby.' cq-morecaption-'.$captionby.' cq-morecaption-shape-'.$elementshape.' '.$extraclass.'" data-elementheight="'.$elementheight.'" style="height:'.$elementheight.'" data-captionby="'.$captionby.'">';
          if($elementlink["url"]!=""){
              $output .= '<a href="'.$elementlink["url"].'" title="'.$elementlink["title"].'" target="'.$elementlink["target"].'" rel="'.$elementlink["rel"].'" class="cq-morecaption-link">';
          }
          $output .= '<div class="cq-morecaption-container cq-visible">';
          $output .= '<div class="cq-morecaption-content">';
          $output .= '<div class="cq-morecaption-less">';
          if($title != ""){
              $output .= '<h3 class="cq-morecaption-title" style="color:'.$titlecolor.';font-size:'.$titlesize.';">'.$title.'</h3>';
          }
          if($subtitle != ""){
              $output .= '<h4 class="cq-morecaption-subtitle" style="color:'.$subtitlecolor.';font-size:'.$subtitlesize.';">'.$subtitle.'</h4>';
          }
          $output .= '</div>';
          if($content != ""){
              $output .= '<div class="cq-morecaption-more">';
              $output .= '<p class="cq-morecaption-text">'.$content.'</p>';
              $output .= '</div>';
          }

          $output .= '</div>';
          $output .= '<div class="cq-morecaption-btn"></div>';
          if($label != ""){
              $output .= '<div class="cq-morecaption-label">';
              $output .= '<i class="cq-morecaption-icon '.esc_attr(${'icon_' . $captionicon}).'" style="color:'.$labelcolor.';font-size:'.$labelsize.';"></i>';
              $output .= '<p class="cq-morecaption-labeltext" style="color:'.$labelcolor.';font-size:'.$labelsize.';">'.$label.'</p>';
              $output .= '</div>';
          }
          $output .= '<div class="cq-morecaption-image">';
          $output .= '<div class="cq-morecaption-cover" style="background-color:'.$bgcolor.';"></div>';
          $output .= '<img src="'.$resizedimage.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          $output .= '</div>';

          $output .= '</div>';
          if($elementlink["url"]!=""){
            $output .= '</a>';
          }
          $output .= '</div>';
          return $output;

        }

  }

}

?>
