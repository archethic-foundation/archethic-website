<?php
if (!class_exists('VC_Extensions_SkewBox')){
    class VC_Extensions_SkewBox{
        private $covernum = 1;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Skew Box", 'cq_allinone_vc'),
            "base" => "cq_vc_skewbox",
            "class" => "cq_vc_skewbox",
            "icon" => "cq_vc_skewbox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_skewbox_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('2 box side by side', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("The height of the whole element (in pixel), default is 320px. You can customize it with other value here.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Background shape for the title and label.", "cq_allinone_vc"),
                 "param_name" => "bgshape",
                 "value" => array("Rounded small" => "roundsmall", "Rounded large" => "roundlarge", "Square" => "square"),
                 "std" => "square",
                 "description" => esc_attr__("", "cq_allinone_vc")
                ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of the title", "cq_allinone_vc"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 1.5em.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of the label (under the title)", "cq_allinone_vc"),
                "param_name" => "labelsize",
                "value" => "",
                "description" => esc_attr__("Default is 1em.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Auto delay slideshow", "cq_allinone_vc"),
                 "param_name" => "autoslide",
                 "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                 "std" => "no",
                 "description" => esc_attr__("In seconds, default is no, which is disabled.", "cq_allinone_vc")
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
                "description" => esc_attr__("It's recommended to use this to customize the background only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Box Content","cq_allinone_vc"),
             "base" => "cq_vc_skewbox_item",
             "class" => "cq_vc_skewbox_item",
             "icon" => "cq_vc_skewbox_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_skewbox'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "",
                  "heading" => esc_attr__("Background color of the left box:", "cq_allinone_vc"),
                  "param_name" => "bgstyle1",
                  "value" => array("Grape Fruit (light)" => "light-grapefruit", "Grape Fruit (dark)" => "dark-grapefruit", "Bitter Sweet (light)" => "light-bittersweet", "Bitter Sweet (dark)" => "dark-bittersweet", "Sunflower (light)" => "light-sunflower", "Sunflower (dark)" => "dark-sunflower", "Grass (light)" => "light-grass", "Grass (dark)" => "dark-grass", "Mint (light)" => "light-mint", "Mint (dark)" => "dark-mint", "Aqua (light)" => "light-aqua", "Aqua (dark)" => "dark-aqua", "Blue Jeans (light)" => "light-bluejeans", "Blue Jeans (dark)" => "dark-bluejeans", "Lavender (light)" => "light-lavender", "Lavender (dark)" => "dark-lavender", "Pink Rose (light)" => "light-pinkrose", "Pink Rose (dark)" => "dark-pinkrose", "White" => "white", "Gray (light)" => "light-gray", "Gray (medium)" => "medium-gray", "Gray (dark)" => "dark-gray", "Transparent" => "transparent", "Customized color:" => "customized"),
                  'std' => 'transparent',
                  'group' => 'Left Box',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => esc_attr__("Custom background color", 'cq_allinone_vc'),
                  "param_name" => "bgcolor1",
                  "value" => "",
                  "dependency" => Array('element' => "bgstyle1", 'value' => array('customized')),
                  "group" => "Left Box",
                  "description" => esc_attr__("", 'cq_allinone_vc')
                ),
                array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Box image (optional):", "cq_allinone_vc"),
                  "param_name" => "skewimage1",
                  "value" => "",
                  "group" => "Left Box",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
                ),
                array(
                  'type' => 'vc_link',
                  'heading' => esc_attr__( 'URL (link for the current whole box)', 'cq_allinone_vc' ),
                  'param_name' => 'coverlink1',
                  'group' => 'Left Box',
                  'description' => esc_attr__( '', 'cq_allinone_vc' )
                ),
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "",
                  "heading" => esc_attr__("Background color of the left Box:", "cq_allinone_vc"),
                  "param_name" => "bgstyle2",
                  "value" => array("Grape Fruit (light)" => "light-grapefruit", "Grape Fruit (dark)" => "dark-grapefruit", "Bitter Sweet (light)" => "light-bittersweet", "Bitter Sweet (dark)" => "dark-bittersweet", "Sunflower (light)" => "light-sunflower", "Sunflower (dark)" => "dark-sunflower", "Grass (light)" => "light-grass", "Grass (dark)" => "dark-grass", "Mint (light)" => "light-mint", "Mint (dark)" => "dark-mint", "Aqua (light)" => "light-aqua", "Aqua (dark)" => "dark-aqua", "Blue Jeans (light)" => "light-bluejeans", "Blue Jeans (dark)" => "dark-bluejeans", "Lavender (light)" => "light-lavender", "Lavender (dark)" => "dark-lavender", "Pink Rose (light)" => "light-pinkrose", "Pink Rose (dark)" => "dark-pinkrose", "White" => "white", "Gray (light)" => "light-gray", "Gray (medium)" => "medium-gray", "Gray (dark)" => "dark-gray", "Transparent" => "transparent", "Customized color:" => "customized"),
                  'std' => 'transparent',
                  'group' => 'Right Box',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => esc_attr__("Custom background color", 'cq_allinone_vc'),
                  "param_name" => "bgcolor2",
                  "value" => "",
                  "dependency" => Array('element' => "bgstyle2", 'value' => array('customized')),
                  "group" => "Right Box",
                  "description" => esc_attr__("", 'cq_allinone_vc')
                ),
                array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Box image (optional):", "cq_allinone_vc"),
                  "param_name" => "skewimage2",
                  "value" => "",
                  "group" => "Right Box",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
                ),
                array(
                  'type' => 'vc_link',
                  'heading' => esc_attr__( 'URL (link for the current whole box)', 'cq_allinone_vc' ),
                  'param_name' => 'coverlink2',
                  'group' => 'Right Box',
                  'description' => esc_attr__( '', 'cq_allinone_vc' )
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Title (optional)", "cq_allinone_vc"),
                  "param_name" => "title1",
                  "value" => "",
                  "group" => "Left Box",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Title color", 'cq_allinone_vc'),
                  "param_name" => "title1color",
                  "value" => "",
                  "group" => "Left Box",
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Title background color", 'cq_allinone_vc'),
                  "param_name" => "title1bg",
                  "value" => "",
                  "std" => "rgba(0, 0, 0, 0.6)",
                  "group" => "Left Box",
                  "description" => esc_attr__("Default is transparent.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Title (optional)", "cq_allinone_vc"),
                  "param_name" => "title2",
                  "value" => "",
                  "group" => "Right Box",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Title color", 'cq_allinone_vc'),
                  "param_name" => "title2color",
                  "value" => "",
                  "group" => "Right Box",
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Title background color", 'cq_allinone_vc'),
                  "param_name" => "title2bg",
                  "value" => "",
                  "std" => "rgba(0, 0, 0, 0.6)",
                  "group" => "Right Box",
                  "description" => esc_attr__("Default is transparent.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Label under the title (optional)", "cq_allinone_vc"),
                  "param_name" => "label1",
                  "value" => "",
                  "group" => "Left Box",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Label color", 'cq_allinone_vc'),
                  "param_name" => "label1color",
                  "value" => "",
                  "group" => "Left Box",
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Label background color", 'cq_allinone_vc'),
                  "param_name" => "label1bg",
                  "value" => "",
                  "group" => "Left Box",
                  "description" => esc_attr__("Default is transparent.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Label under the title (optional)", "cq_allinone_vc"),
                  "param_name" => "label2",
                  "value" => "",
                  "group" => "Right Box",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Label color", 'cq_allinone_vc'),
                  "param_name" => "label2color",
                  "value" => "",
                  "group" => "Right Box",
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Label background color", 'cq_allinone_vc'),
                  "param_name" => "label2bg",
                  "value" => "",
                  "group" => "Right Box",
                  "description" => esc_attr__("Default is transparent.", 'cq_allinone_vc')
                ),
                array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Resize the box image?", "cq_allinone_vc"),
                 "param_name" => "isresize",
                 "value" => array("no", "yes"),
                 "std" => "no",
                 "description" => esc_attr__("We will use the original image by default, you can resize the image if the original image is too large.", "cq_allinone_vc")
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                  "param_name" => "skewimagesize",
                  "value" => "",
                  "std" => "400",
                  "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                  "description" => esc_attr__('The image then will be resized to 400 (in pixels) by default. Change it to other value as you need.', "cq_allinone_vc")
                )

              ),
            )
        );

        add_shortcode('cq_vc_skewbox', array($this,'cq_vc_skewbox_func'));
        add_shortcode('cq_vc_skewbox_item', array($this,'cq_vc_skewbox_item_func'));

      }

      function cq_vc_skewbox_func($atts, $content=null) {
        $titlesize = $labelsize = $elementheight = $autoslide = $css_class = $css = $extraclass = '';
        $covernum = 0;
        extract(shortcode_atts(array(
          "titlesize" => "",
          "labelsize" => "",
          "elementheight" => "",
          "autoslide" => "no",
          "bgshape" => "square",
          "gridnumber" => "3",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_skewbox', $atts);
        wp_register_style( 'vc-extensions-skewbox-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-skewbox-style' );


        wp_register_script('vc-extensions-skewbox-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('vc-extensions-skewbox-script');

        $this -> covernum = $covernum;
        $output = "";
        $output .= '<div class="cq-skewbox '.$bgshape.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'" data-elementheight="'.$elementheight.'" data-titlesize="'.$titlesize.'" data-labelsize="'.$labelsize.'">';
        $output .= do_shortcode($content);
        $output .= '<div class="cq-skewbox-upnav">';
        $output .= '<i class="cq-skewbox-icon entypo-icon entypo-icon-up-open-big"></i>';
        $output .= '</div>';
        $output .= '<div class="cq-skewbox-downnav">';
        $output .= '<i class="cq-skewbox-icon entypo-icon entypo-icon-down-open-big"></i>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_skewbox_item_func($atts, $content=null, $tag) {
          $output =  $videowidth = $isresize =  $css = $bgstyle =  $namelabel = $contentcolor = $labelcolor = $coverlink1 = $coverlink2 = "";
          $title1 = $title2 = $label1 = $label2 = $title1color = $title1bg = $title2color = $title2bg = "";
          $bgstyle1 = $bgstyle2 = $bgcolo1 = $bgcolor2 = $skewimage1 = $skewimage2 = "";
            extract(shortcode_atts(array(
              "skewimage1" => "",
              "skewimage2" => "",
              "isresize" => "no",
              "skewimage" => "",
              "avatartype" => "icon",
              "skewimagesize" => "400",
              "bgstyle" => "white",
              "title1" => "",
              "title2" => "",
              "label1" => "",
              "label2" => "",
              "title1color" => "",
              "title1bg" => "",
              "title2color" => "",
              "title2bg" => "",
              "label1color" => "",
              "label1bg" => "",
              "label2color" => "",
              "label2bg" => "",
              "bgstyle1" => "",
              "bgstyle2" => "",
              "bgcolor1" => "",
              "bgcolor2" => "",
              "labelcolor" => "",
              "coverlink1" => "",
              "coverlink2" => "",
              "css" => ""
            ), $atts));

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img1 = $thumb_skewimage1 = "";

          $full_skewimage1 = wp_get_attachment_image_src($skewimage1, 'full');
          $thumb_skewimage1 = $full_skewimage1[0];
          if($isresize=="yes"&&$skewimagesize!=""){
              if(function_exists('wpb_resize')){
                  $img1 = wpb_resize($skewimage1, null, $skewimagesize, null);
                  $thumb_skewimage1 = $img1['url'];
                  if($thumb_skewimage1=="") $thumb_skewimage1 = $full_skewimage1[0];
              }
          }

          $img2 = $thumb_skewimage2 = "";
          $full_skewimage2 = wp_get_attachment_image_src($skewimage2, 'full');
          $thumb_skewimage2 = $full_skewimage2[0];
          if($isresize=="yes"&&$skewimagesize!=""){
              if(function_exists('wpb_resize')){
                  $img2 = wpb_resize($skewimage2, null, $skewimagesize, null);
                  $thumb_skewimage2 = $img2['url'];
                  if($thumb_skewimage2=="") $thumb_skewimage2 = $full_skewimage2[0];
              }
          }



          $output = '';
          $attachment = get_post($skewimage);
          $avatar_str = $content_str = $arrow_str = "";

          $coverlink1 = vc_build_link($coverlink1);
          $coverlink2 = vc_build_link($coverlink2);
          $covernum = $this -> covernum;
          $covernum++;
          $this -> covernum = $covernum;
          if($this->covernum==1){
              $output .= '<div class="cq-skewbox-item cq-skewbox-item-'.$this->covernum.' active">';
          }else{
              $output .= '<div class="cq-skewbox-item cq-skewbox-item-'.$this->covernum.'">';
          }
          $output .= '<div class="cq-skewbox-cover cq-skewbox-cover-left">';
          $output .= '<div class="cq-skewbox-skewed">';
          if($coverlink1["url"]!=="") $output .= '<a href="'.$coverlink1["url"].'" title="'.$coverlink1["title"].'" rel="'.$coverlink1["rel"].'" target="'.$coverlink1["target"].'">';
          $output .= '<div class="cq-skewbox-content '.$bgstyle1.'" style="background-image:url('.$thumb_skewimage1.')" data-bgstyle="'.$bgstyle1.'" data-bgcolor="'.$bgcolor1.'">';
          if($title1!=""){
              $output .= '<h3 class="cq-skewbox-title" style="color:'.$title1color.';background-color:'.$title1bg.';">'.$title1.'</h3>';
          }
          if($label1!=""){
              $output .= '<p class="cq-skewbox-label" style="color:'.$label1color.';background-color:'.$label1bg.';">'.$label1.'</p>';
          }
          $output .= '</div>';
          if($coverlink1["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          $output .= '</div>';
          $output .= '<div class="cq-skewbox-cover cq-skewbox-cover-right">';
          $output .= '<div class="cq-skewbox-skewed">';
          if($coverlink2["url"]!=="") $output .= '<a href="'.$coverlink2["url"].'" title="'.$coverlink2["title"].'" rel="'.$coverlink2["rel"].'" target="'.$coverlink2["target"].'">';
          $output .= '<div class="cq-skewbox-content '.$bgstyle2.'" style="background-image:url('.$thumb_skewimage2.')" data-bgstyle="'.$bgstyle2.'" data-bgcolor="'.$bgcolor2.'">';
          if($title2!=""){
              $output .= '<h3 class="cq-skewbox-title" style="color:'.$title2color.';background-color:'.$title2bg.';">'.$title2.'</h3>';
          }
          if($label2!=""){
              $output .= '<p class="cq-skewbox-label" style="color:'.$label2color.';background-color:'.$label2bg.';">'.$label2.'</p>';
          }

          $output .= '</div>';
          if($coverlink2["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';

          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_skewbox')) {
    class WPBakeryShortCode_cq_vc_skewbox extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_skewbox_item')) {
    class WPBakeryShortCode_cq_vc_skewbox_item extends WPBakeryShortCode {
    }
}

?>
