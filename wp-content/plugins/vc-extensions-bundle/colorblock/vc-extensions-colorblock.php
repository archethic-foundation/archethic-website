<?php
if (!class_exists('VC_Extensions_ColorBlock')) {
    class VC_Extensions_ColorBlock{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Color Block", 'vc_colorblock_cq'),
            "base" => "cq_vc_colorblock",
            "class" => "wpb_cq_vc_extension_colorblock",
            "icon" => "cq_allinone_colorblock",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Image next to color block content', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image:", "vc_colorblock_cq"),
                "param_name" => "image",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("Select image from media library.", "vc_colorblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_colorblock_cq",
                "heading" => esc_attr__("Display image on the", "vc_colorblock_cq"),
                "param_name" => "imageposition",
                "value" => array("left", "right"),
                "std" => "left",
                "group" => "Image",
                "description" => esc_attr__("", "vc_colorblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the image?", "vc_colorblock_cq"),
                "param_name" => "isresize",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "group" => "Image",
                "description" => esc_attr__("", "vc_colorblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_colorblock_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Image",
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 1000 will resize the image to width 1000. ", "vc_colorblock_cq")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__("URL (Optional link for the image)", "vc_colorblock_cq"),
                "param_name" => "imagelink",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("", "vc_colorblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title in the color block (optional)", "vc_colorblock_cq"),
                "param_name" => "thetitle",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "vc_colorblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Font size for the title (optional)", "vc_colorblock_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is 2em You can customize with other value here.", "vc_colorblock_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("", "vc_colorblock_cq"),
                "param_name" => "content",
                "group" => "Text",
                "value" => esc_attr__("", "vc_colorblock_cq"), "description" => esc_attr__("", "vc_colorblock_cq"),
                "std" => ''
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color the content", 'vc_colorblock_cq'),
                "param_name" => "contentcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'vc_colorblock_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_colorblock_cq",
                "heading" => esc_attr__("The text block background", "vc_colorblock_cq"),
                "param_name" => "textblockbg",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Or you can customized color below:" => "customized"),
                'std' => 'lavender',
                "description" => esc_attr__("", "vc_colorblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customize background color of block", 'vc_colorblock_cq'),
                "param_name" => "custombgcolor",
                "value" => "",
                'dependency' => array('element' => 'textblockbg', 'value' => 'customized'),
                "description" => esc_attr__("", 'vc_colorblock_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_colorblock_cq",
                "heading" => esc_attr__("Element shape", "vc_colorblock_cq"),
                "param_name" => "elementshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square" => "square"),
                "std" => "square",
                "description" => esc_attr__("", "vc_colorblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_colorblock_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_colorblock_cq")
              )

           )
        ));

        add_shortcode('cq_vc_colorblock', array($this,'cq_vc_colorblock_func'));

      }
      function cq_vc_colorblock_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            "image" => "",
            "imagewidth" => "",
            "imageposition" => "left",
            "textblockbg" => "lavender",
            "contentcolor" => "",
            "custombgcolor" => "",
            "isresize" => "no",
            "thetitle" => "",
            "titlesize" => "",
            "imagelink" => "",
            "imagelinktarget" => "",
            "elementshape" => "square",
            "extraclass" => ""
          ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue('entypo');
          }else{
          }


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $attachment = get_post($image);
          $realimage = wp_get_attachment_image_src($image, 'full');

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"));


          $imagelink = vc_build_link($imagelink);

          wp_register_style( 'vc-extensions-colorblock-style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-colorblock-style' );

          wp_enqueue_script('vc-extensions-colorblock-script');
          wp_register_script('vc-extensions-colorblock-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-colorblock-script');


          $output = '';
          $image_output = '';
          $text_output = '';

          $output .= '<div class="cq-colorblock '.$textblockbg.' '.$elementshape.' '.$extraclass.'" data-titlesize="'.$titlesize.'" data-image="'.$realimage[0].'" data-contentcolor="'.$contentcolor.'" data-textblockbg="'.$textblockbg.'" data-custombgcolor="'.$custombgcolor.'">';

          $image_output .= '<div class="cq-colorblock-imagecontainer">';
          if($imagelink["url"]!=="") $image_output .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" class="cq-colorblock-imagelink">';


          $img = $thumbnail = "";

          $fullimage = $realimage[0];
          $thumbnail = $fullimage;
          if($isresize=="yes"&&$imagewidth!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagewidth, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage;
              }
          }

              if($image[0]!="") $image_output .= '<img src="'.$thumbnail.'" class="cq-coverslider-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'">';
          if($imagelink!="") $image_output .= '</a> ';

          $image_output .= '</div>';

          $text_output .= '<div class="cq-colorblock-textcontainer">';
          $text_output .= '<div class="cq-colorblock-content">';
          if($thetitle!=""){
            $text_output .= '<h4 class="cq-colorblock-title">';
            $text_output .= $thetitle;
            $text_output .= '</h4>';
          }
          $text_output .= '<div class="cq-colorblock-caption">';
          $text_output .= $content;
          $text_output .= '</div>';
          $text_output .= '</div>';
          $text_output .= '</div>';


          if($imageposition=="left"){
              $output .= $image_output.$text_output;
          }else{
              $output .= $text_output.$image_output;
          }

          $output .= '</div>';

          return $output;

        }

  }

}

?>
