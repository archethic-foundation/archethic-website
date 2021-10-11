<?php
if (!class_exists('VC_Extensions_ImageOverlay')) {
    class VC_Extensions_ImageOverlay{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Image Overlay", 'vc_imageoverlay_cq'),
            "base" => "cq_vc_imageoverlay",
            "class" => "wpb_cq_vc_extension_imageoverlay",
            "icon" => "cq_allinone_imageoverlay",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Caption in a shape', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay_cq",
                "heading" => esc_attr__("Select a shape overlay the image:", "vc_imageoverlay_cq"),
                "param_name" => "overlayshape",
                "value" => array("circle" => "circle", "rounded" => "rounded", "square" => "square", "drop (arrow on bottom)" => "drop-bottom", "drop (arrow on top)" => "drop-top", "drop (arrow on left)" => "drop-left", "drop (arrow on right)" => "drop-right", "diamond square" => "diamond-square", "diamond rounded" => "diamond-rounded", "tv" => "tvshape", "heart (limited, no alpha background and fixed size)" => "heart"),
                "description" => esc_attr__("", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Header image", "vc_imageoverlay_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width:", "vc_imageoverlay_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "description" => esc_attr__("Default we will use the original image, you can specify a with to resize it when your original image is too large. For example, 720 will resize the image to 720.", "vc_imageoverlay_cq")
              ),
              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'overlayicon',
                'std' => 'fontawesome',
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional, displayed in the title)', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-camera', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'overlayicon',
                  'value' => 'fontawesome',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional, displayed in the title)', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'overlayicon',
                  'value' => 'openiconic',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional, displayed in the title)', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'overlayicon',
                  'value' => 'typicons',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional, displayed in the title)', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'overlayicon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional, displayed in the title)', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'overlayicon',
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
                  'element' => 'overlayicon',
                  'value' => 'material',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (optional)", "vc_imageoverlay_cq"),
                "param_name" => "overlaytitle",
                "value" => "",
                "description" => esc_attr__("", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content (optional)", "vc_imageoverlay_cq"),
                "param_name" => "overlaycontent",
                "value" => "",
                "description" => esc_attr__("", "vc_imageoverlay_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the text)', 'vc_imageoverlay_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_imageoverlay_cq' )
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay background color:", 'vc_imageoverlay_cq'),
                "param_name" => "overlaycolor",
                "value" => 'rgba(0,0,0,0.6)',
                "description" => esc_attr__("", 'vc_imageoverlay_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay content color (the text and icon):", 'vc_imageoverlay_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'vc_imageoverlay_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the overlay:", "vc_imageoverlay_cq"),
                "param_name" => "overlaysize",
                "value" => "",
                "description" => esc_attr__("Default is 150.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (and icon) size:", "vc_imageoverlay_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 2em.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content size:", "vc_imageoverlay_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "description" => esc_attr__("Default is 1em.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the overlay:", "vc_imageoverlay_cq"),
                "param_name" => "overlaymargin",
                "value" => "",
                "description" => esc_attr__("Default is 0. You can specify other value to control it's position. For example -12px 0 0 0 will move it 12px upper.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_imageoverlay_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default is 0. For example 12px 0 0 0 stand for margin-top 12px.", "vc_imageoverlay_cq")
              )

           )
        ));


        }else{
          vc_map(array(
            "name" => esc_attr__("Image Overlay", 'vc_imageoverlay_cq'),
            "base" => "cq_vc_imageoverlay",
            "class" => "wpb_cq_vc_extension_imageoverlay",
            "icon" => "cq_allinone_imageoverlay",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Caption in a shape', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay_cq",
                "heading" => esc_attr__("Select a shape overlay the image:", "vc_imageoverlay_cq"),
                "param_name" => "overlayshape",
                "value" => array("circle" => "circle", "rounded" => "rounded", "drop (arrow on bottom)" => "drop-bottom", "drop (arrow on top)" => "drop-top", "drop (arrow on left)" => "drop-left", "drop (arrow on right)" => "drop-right", "diamond square" => "diamond-square", "diamond rounded" => "diamond-rounded", "heart (no alpha background support)" => "heart"),
                "description" => esc_attr__("", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Header image", "vc_imageoverlay_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width:", "vc_imageoverlay_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "description" => esc_attr__("Default we will use the original image, you can specify a with to resize it when your original image is too large. For example, 720 will resize the image to 720.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Icon for the overlay title (optional)", "vc_imageoverlay_cq"),
                "param_name" => "overlayicon",
                "value" => "",
                "description" => esc_attr__("For example fa-twitter will insert a Twitter icon. See all the available <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>Font Awesome icon</a>.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (optional)", "vc_imageoverlay_cq"),
                "param_name" => "overlaytitle",
                "value" => "",
                "description" => esc_attr__("", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content (optional)", "vc_imageoverlay_cq"),
                "param_name" => "overlaycontent",
                "value" => "",
                "description" => esc_attr__("", "vc_imageoverlay_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the text)', 'vc_imageoverlay_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_imageoverlay_cq' )
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay background color:", 'vc_imageoverlay_cq'),
                "param_name" => "overlaycolor",
                "value" => 'rgba(0,0,0,0.6)',
                "description" => esc_attr__("", 'vc_imageoverlay_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay content color (the text and icon):", 'vc_imageoverlay_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'vc_imageoverlay_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the overlay:", "vc_imageoverlay_cq"),
                "param_name" => "overlaysize",
                "value" => "",
                "description" => esc_attr__("Default is 150.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (and icon) size:", "vc_imageoverlay_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 2em.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content size:", "vc_imageoverlay_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "description" => esc_attr__("Default is 1em.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the overlay:", "vc_imageoverlay_cq"),
                "param_name" => "overlaymargin",
                "value" => "",
                "description" => esc_attr__("Default is 0. You can specify other value to control it's position. For example -12px 0 0 0 will move it 12px upper.", "vc_imageoverlay_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_imageoverlay_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default is 0. For example 12px 0 0 0 stand for margin-top 12px.", "vc_imageoverlay_cq")
              )

           )
        ));


        }

        add_shortcode('cq_vc_imageoverlay', array($this,'cq_vc_imageoverlay_func'));

      }


      function cq_vc_imageoverlay_func($atts, $content=null, $tag) {
          $overlayicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => 'fa fa-camera',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "displaymode" => "image",
            "overlaytitle" => "",
            "overlaycontent" => "",
            "overlayicon" => "fontawesome",
            "overlaycolor" => "",
            "contentcolor" => "",
            "overlayshape" => "circle",
            "displaymode" => "image",
            "link" => "",
            "overlaysize" => "",
            "titlesize" => "",
            "contentsize" => "",
            "overlaymargin" => "",
            "imagewidth" => "",
            "elementmargin" => "",
            "image" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          vc_icon_element_fonts_enqueue($overlayicon);

          wp_register_style( 'vc-extensions-imageoverlay-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-imageoverlay-style' );
          wp_register_script('vc-extensions-imageoverlay-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-imageoverlay-script');
          $link = vc_build_link($link);
          $attachment = get_post($image);
          $image_full = wp_get_attachment_image_src($image, 'full');
          // $cardstyle_arr = $color_style_arr[$cardstyle];

          $output = '';
          $output .= '<div class="cq-imageoverlay" data-overlaycolor="'.$overlaycolor.'" data-overlaysize="'.$overlaysize.'" data-titlesize="'.$titlesize.'" data-contentsize="'.$contentsize.'" data-overlayshape="'.$overlayshape.'" data-overlaymargin="'.$overlaymargin.'" data-contentcolor="'.$contentcolor.'" data-elementmargin="'.$elementmargin.'">';
          $output .= '<div class="cq-imageoverlay-overlay cq-'.$overlayshape.'">';
          if($overlayshape=="heart"){
            $output .= '<div class="cq-heart-before">';
            $output .= '</div>';
          }
          $output .= '<div class="cq-imageoverlay-paragraph">';
          if($link['url']!=""){
            $output .= '<a href="'.$link['url'].'" title="'.$link['title'].'" target="'.$link['target'].'" class="cq-imageoverlay-link">';
          }
          if($overlaytitle!=""||$overlayicon!=""){
              $output .= '<h4 class="cq-imageoverlay-title">';
              if(isset(${'icon_' . $overlayicon})){
                  $output .= '<i class="cq-imageoverlay-icon '.esc_attr(${'icon_' . $overlayicon}).'"></i> ';
              }
              if($overlaytitle!="") $output .= $overlaytitle;
              $output .= '</h4>';
          }
          if($overlaycontent!=""){
              $output .= '<span class="cq-imageoverlay-content">';
              $output .= $overlaycontent;
              $output .= '</span>';
          }
          if($link['url']!=""){
            $output .= '</a>';
          }
          $output .= '</div>';
          if($overlayshape=="heart"){
            $output .= '<div class="cq-heart-after">';
            $output .= '</div>';
          }
          $output .= '</div>';

          if($imagewidth!=""){

              $img = $thumbnail = "";
              $fullimage = $image_full[0];
              $thumbnail = $fullimage;
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagewidth, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage;
              }

              $output .= '<img src="'.$thumbnail.'" class="cq-imageoverlay-img" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          }else{

              $output .= '<img src="'.$image_full[0].'" class="cq-imageoverlay-img" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          }
          $output .= '</div>';
          return $output;

        }


  }

}

?>
