<?php
if (!class_exists('VC_Extensions_MaterialSlider')){
    class VC_Extensions_MaterialSlider{
        private $slide_content = '';
        private $slide_dot = '';
        private $slide_num = 0;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Material Slider", 'cq_allinone_vc'),
            "base" => "cq_vc_materialslider",
            "class" => "cq_vc_materialslider",
            "icon" => "cq_vc_materialslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_materialslider_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('auto delay slider', 'js_composer'),
            "params" => array(
              array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "",
                  "heading" => esc_attr__("color of the dot navigation", "cq_allinone_vc"),
                  "param_name" => "dotstyle",
                  "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "White" => "white", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                  'std' => 'white',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
              array(
                  "type" => "dropdown",
                  "holder" => "",
                  "class" => "",
                  "heading" => esc_attr__("auto hide the dot navigation?", "cq_allinone_vc"),
                  "param_name" => "autohide",
                  "value" => array("yes", "no"),
                  'std' => 'no',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("The height of the whole element (in pixel), is equal to the image's max height by default. You can customize the value if there is no image in the slider, default is 320. ", "cq_allinone_vc")
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
                "description" => esc_attr__("It's recommended to use this to customize the margin only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Slide Content","cq_allinone_vc"),
             "base" => "cq_vc_materialslider_item",
             "class" => "cq_vc_materialslider_item",
             "icon" => "cq_vc_materialslider_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image and text, support up to 10 slide","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_materialslider'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => esc_attr__("Slide background color", 'cq_allinone_vc'),
                  "param_name" => "bgcolor",
                  "value" => "",
                  "group" => "Image",
                  "description" => esc_attr__("Default is light gray.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Slide image", "cq_allinone_vc"),
                  "param_name" => "slideimage",
                  "value" => "",
                  "group" => "Image",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Title (optional)", "cq_allinone_vc"),
                  "param_name" => "title",
                  "value" => "",
                  "group" => "Text",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Title color", 'cq_allinone_vc'),
                  "param_name" => "titlecolor",
                  "value" => "",
                  "group" => "Text",
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Label under the title (optional)", "cq_allinone_vc"),
                  "param_name" => "label",
                  "value" => "",
                  "group" => "Text",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "edit_field_class" => "vc_col-xs-6",
                  "heading" => esc_attr__("Label color", 'cq_allinone_vc'),
                  "param_name" => "labelcolor",
                  "value" => "",
                  "group" => "Text",
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Resize the slide image?", "cq_allinone_vc"),
                 "param_name" => "isresize",
                 "value" => array("no", "yes"),
                 "std" => "no",
                 "group" => "Image",
                 "description" => esc_attr__("We will use the original image by default, you can resize the image if the original image is too large.", "cq_allinone_vc")
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                  "param_name" => "slideimagesize",
                  "value" => "",
                  "std" => "400",
                  "group" => "Image",
                  "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                  "description" => esc_attr__('The image then will be resized to 400 (in pixels) by default. Change it to other value as you need.', "cq_allinone_vc")
                ),
                array(
                  'type' => 'vc_link',
                  'heading' => esc_attr__( 'URL (link for the current whole slide)', 'cq_allinone_vc' ),
                  'param_name' => 'slidelink',
                  "group" => "Link",
                  'description' => esc_attr__( '', 'cq_allinone_vc' )
                )


              ),
            )
        );

        add_shortcode('cq_vc_materialslider', array($this,'cq_vc_materialslider_func'));
        add_shortcode('cq_vc_materialslider_item', array($this,'cq_vc_materialslider_item_func'));

      }

      function cq_vc_materialslider_func($atts, $content=null) {
        $titlesize = $labelsize = $elementheight = $autoslide = $dotstyle = $autohide = $css_class = $css = $extraclass = '';
        $slide_num = 0;
        $slide_dot = $slide_content = "";
        extract(shortcode_atts(array(
          "titlesize" => "",
          "labelsize" => "",
          "dotstyle" => "",
          "elementheight" => "",
          "autoslide" => "no",
          "autohide" => "no",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_materialslider', $atts);
        wp_register_style( 'vc-extensions-materialslider-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-materialslider-style' );


        wp_register_script('vc-extensions-materialslider-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('vc-extensions-materialslider-script');

        $this -> slide_dot = $slide_dot;
        $this -> slide_content = $slide_content;
        $this -> slide_num = $slide_num;
        $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content


        $output = "";
        $output .= '<div class="cq-materialslider cq-materialslider-'.$this -> slide_num.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'" data-elementheight="'.$elementheight.'" data-titlesize="'.$titlesize.'" data-labelsize="'.$labelsize.'" data-autohide="'.$autohide.'">';
        $output .= '<div class="cq-materialslider-container" data-pos="0">';
        $output .= '<div class="cq-materialslider-slidecontainer">';
        $output .= do_shortcode($this -> slide_content);
        $output .= '</div>';
        $output .= '<div class="cq-materialslider-navigation cq-materialslider-dot-'.$dotstyle.'">';
        $output .= '<span class="cq-materialslider-bar"></span>';
        $output .= $this -> slide_dot;
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_materialslider_item_func($atts, $content=null, $tag) {
          $output =  $videowidth = $isresize =  $css =  $namelabel = $contentcolor = $labelcolor = $slidelink = "";
          $title = $label = $titlecolor = $bgcolor  = $slideimage = "";
          extract(shortcode_atts(array(
              "slideimage" => "",
              "isresize" => "no",
              "skewimage" => "",
              "avatartype" => "icon",
              "slideimagesize" => "400",
              "bgstyle" => "white",
              "title" => "",
              "label" => "",
              "titlecolor" => "",
              "labelcolor" => "",
              "bgcolor" => "",
              "labelcolor" => "",
              "slidelink" => "",
              "css" => ""
            ), $atts));

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img = $thumb_slideimage = "";

          $slidelink = vc_build_link($slidelink);
          $attachment = get_post($slideimage);
          $full_slideimage = wp_get_attachment_image_src($slideimage, 'full');
          $thumb_slideimage = $full_slideimage[0];
          if($isresize=="yes"&&$slideimagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($slideimage, null, $slideimagesize, null);
                  $thumb_slideimage = $img['url'];
                  if($thumb_slideimage=="") $thumb_slideimage = $full_slideimage[0];
              }
          }

          $slide_content = "";
          $slide_num = $this -> slide_num;

          $slide_content = $this -> slide_content;
          $slide_content .= '<div class="cq-materialslider-slide" data-titlecolor="'.$titlecolor.'" data-labelcolor="'.$labelcolor.'" data-bgcolor="'.$bgcolor.'">';
          if($slidelink["url"]!=""){
              $slide_content .= '<a class="cq-materialslider-link" href="'.$slidelink["url"].'" title="'.$slidelink["title"].'" rel="'.$slidelink["rel"].'" target="'.$slidelink["target"].'">';

          }
          $slide_content .= '<div class="cq-materialslider-content">';
          if($thumb_slideimage!=""){
              $slide_content .= '<img src="'.$thumb_slideimage.'" class="cq-materialslider-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          }
          $slide_content .= '<div class="cq-materialslider-text">';
          if($title!=""){
              $slide_content .= '<h4 class="cq-materialslider-title">';
              $slide_content .= $title;
              $slide_content .= '</h4>';
          }
          if($label!=""){
              $slide_content .= '<p class="cq-materialslider-description">';
              $slide_content .= $label;
              $slide_content .= '</p>';
          }
          $slide_content .= '</div>';
          $slide_content .= '</div>';
          if($slidelink["url"]!=""){
              $slide_content .= '</a>';
          }
          $slide_content .= '</div>';
          $this -> slide_content = $slide_content;

          $slide_dot = $this -> slide_dot;
          $slide_dot .= '<span href="#" class="cq-materialslider-dot" data-pos="'.$slide_num.'"></span>';
          $this -> slide_dot = $slide_dot;

          $slide_num++;
          $this -> slide_num = $slide_num;

          return $slide_content;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_materialslider')) {
    class WPBakeryShortCode_cq_vc_materialslider extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_materialslider_item')) {
    class WPBakeryShortCode_cq_vc_materialslider_item extends WPBakeryShortCode {
    }
}

?>
