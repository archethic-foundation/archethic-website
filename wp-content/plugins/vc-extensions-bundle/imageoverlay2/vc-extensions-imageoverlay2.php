<?php
if (!class_exists('VC_Extensions_ImageOverlay2')) {
    class VC_Extensions_ImageOverlay2{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Image Overlay 2", 'vc_imageoverlay2_cq'),
            "base" => "cq_vc_imageoverlay2",
            "class" => "wpb_cq_vc_extension_imageoverlay2",
            "icon" => "cq_allinone_imageoverlay2",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Caption with transition', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_imageoverlay2_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay2_cq",
                "heading" => esc_attr__("Select the transition direction:", "vc_imageoverlay2_cq"),
                "param_name" => "transitiondirection",
                "value" => array("default (45 degree, top left to bottom right)" => "", "45 degree, top right to bottom left" => "topright_bottomleft", "45 degree, bottom left to top right" => "bottomleft_topright", "45 degree, bottom right to top left" => "bottomright_topleft"),
                "std" => "",
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "vc_imageoverlay2_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is 480, you may have to make it smaller if your image is landscape, or make it larger if your image is portrait. The height depends on the container width too.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay2_cq",
                "heading" => esc_attr__("Resize the image?", "vc_imageoverlay2_cq"),
                "param_name" => "isresize",
                "value" => array("no (we will use the original image)", "yes (customize resized width below)" => "yes"),
                "std" => "no",
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_imageoverlay2_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__("Specify a width here. For example, 600 will resize the image to width 600.", "vc_imageoverlay2_cq")
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
                'group' => 'Text',
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional, displayed in the title)', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa ', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'overlayicon',
                  'value' => 'fontawesome',
                ),
                'group' => 'Text',
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
                'group' => 'Text',
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
                'group' => 'Text',
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
                'group' => 'Text',
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
                'group' => 'Text',
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
                "group" => "Text",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (optional)", "vc_imageoverlay2_cq"),
                "param_name" => "overlaytitle",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content (optional)", "vc_imageoverlay2_cq"),
                "param_name" => "overlaycontent",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the whole element)', 'vc_imageoverlay2_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_imageoverlay2_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay2_cq",
                "heading" => esc_attr__("Overlay background style:", "vc_imageoverlay2_cq"),
                "param_name" => "overlaystyle",
                "value" => array("Orange" => "", "Grape Fruit" => "grapefruit", "Grass" => "grass", "Aqua" => "aqua", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Dark Gray" => "darkgray", "Customize below:" => "customized"),
                'std' => 'darkgray',
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay background color:", 'vc_imageoverlay2_cq'),
                "param_name" => "overlaycolor",
                "dependency" => Array('element' => "overlaystyle", 'value' => array('customized')),
                "value" => '',
                "description" => esc_attr__("", 'vc_imageoverlay2_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (and icon) size:", "vc_imageoverlay2_cq"),
                "param_name" => "titlesize",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("Default is 2em.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content size:", "vc_imageoverlay2_cq"),
                "param_name" => "contentsize",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("Default is 1em.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay text color (the title, content and icon):", 'vc_imageoverlay2_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                'group' => 'Text',
                "description" => esc_attr__("Default is white.", 'vc_imageoverlay2_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_imageoverlay2_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default is 0, you can specify other value here. For example 0 0 12px 0 will stand for margin-bottom 12px.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_imageoverlay2_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_imageoverlay2_cq")
              )


           )
        ));


        }else{


          vc_map(array(
            "name" => esc_attr__("Image Overlay 2", 'vc_imageoverlay2_cq'),
            "base" => "cq_vc_imageoverlay2",
            "class" => "wpb_cq_vc_extension_imageoverlay2",
            "icon" => "cq_allinone_imageoverlay2",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Caption with transition', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_imageoverlay2_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay2_cq",
                "heading" => esc_attr__("Select the transition direction:", "vc_imageoverlay2_cq"),
                "param_name" => "transitiondirection",
                "value" => array("default (45 degree, top left to bottom right)" => "", "45 degree, top right to bottom left" => "topright_bottomleft", "45 degree, bottom left to top right" => "bottomleft_topright", "45 degree, bottom right to top left" => "bottomright_topleft"),
                "std" => "",
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "vc_imageoverlay2_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is 480, you may have to make it smaller if your image is landscape, or make it larger if your image is portrait. The height depends on the container width too.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay2_cq",
                "heading" => esc_attr__("Resize the image?", "vc_imageoverlay2_cq"),
                "param_name" => "isresize",
                "value" => array("no (we will use the original image)", "yes (customize resized width below)" => "yes"),
                "std" => "no",
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_imageoverlay2_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__("Specify a width here. For example, 600 will resize the image to width 600.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Icon for the overlay title (optional)", "vc_imageoverlay2_cq"),
                "param_name" => "overlayicon",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("For example fa-twitter will insert a Twitter icon. See all the available Font Awesome icon.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (optional)", "vc_imageoverlay2_cq"),
                "param_name" => "overlaytitle",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content (optional)", "vc_imageoverlay2_cq"),
                "param_name" => "overlaycontent",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the whole element)', 'vc_imageoverlay2_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_imageoverlay2_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_imageoverlay2_cq",
                "heading" => esc_attr__("Overlay background style:", "vc_imageoverlay2_cq"),
                "param_name" => "overlaystyle",
                "value" => array("Orange" => "", "Grape Fruit" => "grapefruit", "Grass" => "grass", "Aqua" => "aqua", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Dark Gray" => "darkgray", "Customize below:" => "customized"),
                'std' => 'darkgray',
                "description" => esc_attr__("", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay background color:", 'vc_imageoverlay2_cq'),
                "param_name" => "overlaycolor",
                "dependency" => Array('element' => "overlaystyle", 'value' => array('customized')),
                "value" => '',
                "description" => esc_attr__("", 'vc_imageoverlay2_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay title (and icon) size:", "vc_imageoverlay2_cq"),
                "param_name" => "titlesize",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("Default is 2em.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Overlay content size:", "vc_imageoverlay2_cq"),
                "param_name" => "contentsize",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("Default is 1em.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay text color (the title, content and icon):", 'vc_imageoverlay2_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                'group' => 'Text',
                "description" => esc_attr__("Default is white.", 'vc_imageoverlay2_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_imageoverlay2_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default is 0, you can specify other value here. For example 0 0 12px 0 will stand for margin-bottom 12px.", "vc_imageoverlay2_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_imageoverlay2_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_imageoverlay2_cq")
              )


           )
        ));

        }

        add_shortcode('cq_vc_imageoverlay2', array($this,'cq_vc_imageoverlay2_func'));
      }

      function cq_vc_imageoverlay2_func($atts, $content=null, $tag) {
          $overlayicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => 'fa ',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "overlaystyle" => "darkgray",
            "overlaytitle" => "",
            "overlaycontent" => "",
            "overlayicon" => "fontawesome",
            "overlaycolor" => "",
            "contentcolor" => "",
            "link" => "",
            "overlaysize" => "",
            "titlesize" => "",
            "contentsize" => "",
            "imagewidth" => "",
            "elementheight" => "",
            "elementmargin" => "",
            "transitiondirection" => "",
            "extraclass" => "",
            "isresize" => "no",
            "image" => ""
          ), $atts));

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$overlaycolor", "$overlaycolor") );
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($overlayicon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }

          wp_register_style( 'vc-extensions-imageoverlay2-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-imageoverlay2-style' );
          wp_register_script('vc-extensions-imageoverlay2-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-imageoverlay2-script');
          $link = vc_build_link($link);
          $attachment = get_post($image);
          $image_full = wp_get_attachment_image_src($image, 'full');
          if(isset($color_style_arr[$overlaystyle])){
            $cardstyle_arr = $color_style_arr[$overlaystyle];
          }else{
            $cardstyle_arr = array("#656D78", "#434A54");
          }

          $output = '';
          $output .= '<div class="cq-imageoverlay2-container '.$extraclass.' '.$transitiondirection.'" data-elementheight="'.$elementheight.'" data-overlaycolor="'.$cardstyle_arr[1].'"  data-image="'.$image[0].'" data-titlesize="'.$titlesize.'" data-contentsize="'.$contentsize.'" data-contentcolor="'.$contentcolor.'" data-overlaystyle="'.$overlaystyle.'" data-elementmargin="'.$elementmargin.'">';
          if($link["url"]!=="") $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="cq-imageoverlay2-link">';
          $output .= '<div class="cq-imageoverlay2">';

          $img = $thumbnail = "";

          $fullimage = $image_full[0];
          $thumbnail = $fullimage;
          if($isresize&&$imagewidth!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagewidth, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage;
              }
          }

          if($isresize=="yes"&&$imagewidth!=""){
              $output .= '<img src="'.$thumbnail.'" class="cq-imageoverlay2-img" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          }else{

              $output .= '<img src="'.$image_full[0].'" class="cq-imageoverlay2-img" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          }
          $output .= '<div class="text-container">';
          if(version_compare(WPB_VC_VERSION,  "4.4")>=0){
            if($overlaytitle!=""||(isset(${'icon_' . $overlayicon})&&esc_attr(${'icon_' . $overlayicon})!="")){
                $output .= '<h3 class="cq-imageoverlay2-title">';
                if((isset(${'icon_' . $overlayicon})&&esc_attr(${'icon_' . $overlayicon})!="")){
                    $output .= '<i class="cq-imageoverlay2-icon '.esc_attr(${'icon_' . $overlayicon}).'"></i> ';
                }
                if($overlaytitle!="")$output .= $overlaytitle;
                $output .= '</h3>';
            }

          }else{
                $output .= '<h3 class="cq-imageoverlay2-title">';
                if($overlayicon!=""){
                    $output .= '<i class="fa cq-imageoverlay2-icon '.$overlayicon.'"></i> ';
                }
                if($overlaytitle!="")$output .= $overlaytitle;
                $output .= '</h3>';

          }
          if($overlaycontent!=""){
              $output .= '<p class="cq-imageoverlay2-content">';
              $output .= $overlaycontent;
              $output .= '</p>';
          }
          $output .= '</div>';
          $output .= '<div class="cq-imageoverlay2-background">';
          $output .= '</div>';
          $output .= '</div>';
          if($link["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          return $output;

        }


  }

}

?>
