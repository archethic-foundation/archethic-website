<?php
if (!class_exists('VC_Extensions_ChatBubble')){
    class VC_Extensions_ChatBubble{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Chat Bubble", 'cq_allinone_vc'),
            "base" => "cq_vc_chatbubble",
            "class" => "cq_vc_chatbubble",
            "icon" => "cq_vc_chatbubble",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_chatbubble_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Responsive chat list', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Avatar image size", "cq_allinone_vc"),
                 "param_name" => "avatarsize",
                 "value" => array("60", "80", "100"),
                 "std" => "60",
                 "description" => esc_attr__("Select the built in avatar image size (in pixels).", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
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
             "name" => esc_attr__("Bubble Content","cq_allinone_vc"),
             "base" => "cq_vc_chatbubble_item",
             "class" => "cq_vc_chatbubble_item",
             "icon" => "cq_vc_chatbubble_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, icon and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_chatbubble'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "heading" => esc_attr__("Display the avatar on the", "cq_allinone_vc"),
                  "param_name" => "avatarposition",
                  "value" => array("left", "right"),
                  "group" => "Avatar",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "heading" => esc_attr__("Display the avatar with", "cq_allinone_vc"),
                  "param_name" => "avatartype",
                  "value" => array("None (no avatar)"=>"none", "Image" => "image", "Icon" => "icon"),
                  "std" => "icon",
                  "group" => "Avatar",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'faceicon',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
                  'value' => 'material',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "heading" => esc_attr__("Icon font size", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is 2em (leave to blank), support value like 20px or 1.5em", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),

              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Avatar image:", "cq_allinone_vc"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),

              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "avatarimagesize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "std" => "400",
                "group" => "Avatar",
                "description" => esc_attr__('The image then will be resized to 400 (in pixels) by default. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-9 cqadmin-col-offset",
                "heading" => esc_attr__("Label for the avatar (optional, under the avatar image or icon)", "cq_allinone_vc"),
                "param_name" => "namelabel",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Useful for display the name, for example, Jon Snow", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-3 cqadmin-col-offset",
                "class" => "",
                "heading" => esc_attr__("Label color", 'cq_allinone_vc'),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-9 cqadmin-col-offset",
                "heading" => esc_attr__("Extra info (optional, under the dialog)", "cq_allinone_vc"),
                "param_name" => "extrainfo",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Useful for display extra information, like date or message read receipt.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-3 cqadmin-col-offset",
                "class" => "",
                "heading" => esc_attr__("Extro info color", 'cq_allinone_vc'),
                "param_name" => "infocolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),

              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("The slide in content.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_attr__("Text color", 'cq_allinone_vc'),
                "param_name" => "contentcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Background color of the grid item:", "cq_allinone_vc"),
                "param_name" => "bgstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "White" => "white", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent" => "transparent", "Customized color:" => "customized"),
                'std' => 'white',
                'group' => 'Background',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background color of the grid item", 'cq_allinone_vc'),
                "param_name" => "backgroundcolor",
                "value" => "",
                'group' => 'Background',
                "dependency" => Array('element' => "bgstyle", 'value' => array('customized')),
                "description" => esc_attr__("Default is medium gray. Note, the content only support white background with customized gird item background.", 'cq_allinone_vc')
              )

              ),
            )
        );

        add_shortcode('cq_vc_chatbubble', array($this,'cq_vc_chatbubble_func'));
        add_shortcode('cq_vc_chatbubble_item', array($this,'cq_vc_chatbubble_item_func'));

      }

      function cq_vc_chatbubble_func($atts, $content=null) {
        $css_class = $css =  $gridnumber = $avatarsize = $extraclass = '';
        extract(shortcode_atts(array(
          "gridnumber" => "3",
          "avatarsize" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_chatbubble', $atts);
        wp_register_style( 'vc-extensions-chatbubble-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-chatbubble-style' );


        wp_register_script('vc-extensions-chatbubble-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('vc-extensions-chatbubble-script');

        $output = "";
        $output .= '<div class="cq-chatbubble cq-chatbubble-avatar-'.$avatarsize.' '.$extraclass.' '.$css_class.'">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;

      }


      function cq_vc_chatbubble_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $videowidth = $isresize = $tooltip =  $backgroundcolor = $backgroundhovercolor = $itembgcolor = $iconcolor = $iconsize =  $css = $bgstyle =  $namelabel = $contentcolor = $labelcolor = $extrainfo = $infocolor = $avatarposition = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_monosocial = $icon_material = "";

            extract(shortcode_atts(array(
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "isresize" => "no",
              "avatarimage" => "",
              "avatartype" => "icon",
              "avatarimagesize" => "400",
              "avatarresize" => "no",
              "iscaption" => "",
              "tooltip" => "",
              "bgstyle" => "white",
              "backgroundcolor" => "",
              "backgroundhovercolor" => "",
              "itembgcolor" => "",
              "icon_fontawesome" => "fa fa-user",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => "vc-material vc-material-cake",
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "iconcolor" => "",
              "iconsize" => "",
              "namelabel" => "",
              "labelcolor" => "",
              "extrainfo" => "",
              "infocolor" => "",
              "contentcolor" => "",
              "avatarposition" => "left",
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img = $thumbnail = "";

          $fullimage = wp_get_attachment_image_src($image, 'full');
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
          if($avatarimagesize!=""){
              if(function_exists('wpb_resize')){
                  $avatarimg = wpb_resize($avatarimage, null, $avatarimagesize, $avatarimagesize,  true);
                  $avatarthumbnail = $avatarimg['url'];
                  if($avatarthumbnail=="") $avatarthumbnail = $avatarfullimage[0];
              }
          }


          $no_name_class = "";
          if($namelabel=="") $no_name_class = "cq-chatbubble-noname";
          $output = '';
          $attachment = get_post($avatarimage);
          $avatar_str = $content_str = $arrow_str = "";
          $output .= "<div class='cq-chatbubble-container ".$no_name_class." ".$bgstyle." cq-chatbubble-".$avatarposition."' data-bgstyle='".$bgstyle."' data-backgroundcolor='".$backgroundcolor."' data-contentcolor='".$contentcolor."' data-iconcolor='".$iconcolor."' data-iconsize='".$iconsize."' data-labelcolor='".$labelcolor."' data-infocolor='".$infocolor."'>";
          $avatar_str .= "<div class='cq-chatbubble-avatarcontainer'>";
          $avatar_str .= "<div class='cq-chatbubble-avatar'>";
          if($avatartype=="image"){
            if($avatarthumbnail!=""){
                $avatar_str .= "<img class='cq-chatbubble-img' src='".$avatarthumbnail."' alt='".get_post_meta($attachment->ID, '_wp_attachment_image_alt', true )."' />";
            }
          }else if($avatartype=="icon"){
            if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $faceicon})&&esc_attr(${'icon_' . $faceicon})!=""&&$avatartype=="icon"){
              $avatar_str .= '<i class="cq-chatbubble-icon '.esc_attr(${'icon_' . $faceicon}).'"></i>';
            }
          }
          $avatar_str .= "</div>";
          if($namelabel!="")$avatar_str .= "<span class='cq-chatbubble-label'>".$namelabel."</span>";
          $avatar_str .= "</div>";

          if($content!=""){
            $content_str .= "<div class='cq-chatbubble-wrapper'>";
                if($avatarposition=="left")$content_str .= "<div class='cq-chatbubble-arrow cq-chatbubble-arrowleft'></div>";
                $content_str .= "<div class='cq-chatbubble-message'>";
                  $content_str .= "<div class='cq-chatbubble-content'>";
                      $content_str .= do_shortcode($content);
                  $content_str .= "</div>";
                  if($extrainfo!=""){
                    $content_str .= "<div class='cq-chatbubble-detail'>";
                      $content_str .= "<span class=''>".$extrainfo."</span>";
                    $content_str .= "</div>";
                  }
                $content_str .= "</div>";
                if($avatarposition=="right")$content_str .= "<div class='cq-chatbubble-arrow cq-chatbubble-arrowright'></div>";
            $content_str .= "</div>";
          }

          if($avatarposition=="left"){
            $output .= $avatar_str.$content_str;
          }else{
            $output .= $content_str.$avatar_str;
          }


          $output .= '</div>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_chatbubble')) {
    class WPBakeryShortCode_cq_vc_chatbubble extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_chatbubble_item')) {
    class WPBakeryShortCode_cq_vc_chatbubble_item extends WPBakeryShortCode {
    }
}

?>
