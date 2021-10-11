<?php
if (!class_exists('VC_Extensions_CompareSlider')) {
    class VC_Extensions_CompareSlider{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Compare Slider", 'vc_compareslider_cq'),
            "base" => "cq_vc_compareslider",
            "class" => "wpb_cq_vc_extension_compareslider",
            "icon" => "cq_allinone_compareslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('With menu navigation', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Images", "vc_compareslider_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select image from media library, support multiple images.", "vc_compareslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Resize the image?", "vc_compareslider_cq"),
                "param_name" => "isresize",
                "value" => array("no", "yes"),
                "std" => "no",
                "description" => esc_attr__("", "vc_compareslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_compareslider_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__("Default we will use the original image, specify a width here. For example, 600 will resize the image to width 600.", "vc_compareslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Slide transition style", "vc_compareslider_cq"),
                "param_name" => "transitionstyle",
                "value" => array("scale up" => "fadeUp", "fade" => "normalFade", "go down" => "goDown", "back slide" => "backSlide", "normal slide" => "false"),
                "std" => "normalFade",
                "description" => esc_attr__("", "vc_compareslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Auto slide?", "vc_compareslider_cq"),
                "param_name" => "autoslide",
                'value' => array(2, 3, 4, 5, 6, 8, 10, esc_attr__( 'Disable', 'vc_compareslider_cq' ) => 0 ),
                'std' => 0,
                "description" => esc_attr__("Auto slide in each X seconds.", "vc_compareslider_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Optional caption under each image, wrap each one inside the [slidedesc][/slidedesc].", "vc_compareslider_cq"),
                "param_name" => "content",
                "value" => esc_attr__("[slidedesc][/slidedesc]
                  [slidedesc][/slidedesc]
                  [slidedesc][/slidedesc]", "vc_compareslider_cq"), "description" => esc_attr__("Please try to edit in the text mode.", "vc_compareslider_cq") ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Link (optional) for each image", 'vc_compareslider_cq'),
                "param_name" => "imagelinks",
                "value" => esc_attr__("", 'vc_compareslider_cq'),
                "description" => esc_attr__("Optional link for each image. Divide each with linebreaks (Enter)", 'vc_compareslider_cq')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("How to open the link", "vc_compareslider_cq"),
                "param_name" => "imagelinktarget",
                "description" => esc_attr__('Select how to open the image link', 'vc_compareslider_cq'),
                'value' => array(esc_attr__("Same window", "vc_compareslider_cq") => "_self", esc_attr__("New window", "vc_compareslider_cq") => "_blank")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Menu for each image", 'vc_compareslider_cq'),
                "param_name" => "menus",
                "value" => esc_attr__("", 'vc_compareslider_cq'),
                "group" => "Menus",
                "description" => esc_attr__("The menu text for each image. Divide each with linebreaks (Enter)", 'vc_compareslider_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Menu :", "vc_compareslider_cq"),
                "param_name" => "menucolorstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Customized color:" => "customized"),
                'std' => 'mediumgray',
                "group" => "Menus",
                "description" => esc_attr__("", "vc_compareslider_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Menu text color", 'vc_compareslider_cq'),
                "param_name" => "menutextcolor",
                "value" => '',
                "dependency" => Array('element' => "menucolorstyle", 'value' => array('customized')),
                "group" => "Menus",
                "description" => esc_attr__("", 'vc_compareslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Menu background (and border) color", 'vc_compareslider_cq'),
                "param_name" => "menubackgroundcolor",
                "value" => '',
                "dependency" => Array('element' => "menucolorstyle", 'value' => array('customized')),
                "group" => "Menus",
                "description" => esc_attr__("", 'vc_compareslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Menu text color when actived", 'vc_compareslider_cq'),
                "param_name" => "menuactivetextcolor",
                "value" => '',
                "dependency" => Array('element' => "menucolorstyle", 'value' => array('customized')),
                "group" => "Menus",
                "description" => esc_attr__("", 'vc_compareslider_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Menu padding", "vc_compareslider_cq"),
                "param_name" => "menupadding",
                "value" => "",
                "group" => "Menus",
                "description" => esc_attr__("Default is 8px 16px, you can specify other value here.", "vc_compareslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the menus", "vc_compareslider_cq"),
                "param_name" => "menumargin",
                "value" => "",
                "group" => "Menus",
                "description" => esc_attr__("Default is 16px 0 0 0, which stand for margin-top 16px. You can specify other value here.", "vc_compareslider_cq")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_compareslider_cq",
                "heading" => esc_attr__("Enable drag for the images?", 'vc_compareslider_cq'),
                "param_name" => "enabledrag",
                "value" => array(esc_attr__("Yes, allow user to drag", "vc_compareslider_cq") => 'on'),
                "description" => esc_attr__("Checked this to allow user to drag moving the image.", 'vc_compareslider_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_compareslider_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_compareslider_cq")
              )

           )
        ));

        add_shortcode('cq_vc_compareslider', array($this,'cq_vc_compareslider_func'));
      }

      function cq_vc_compareslider_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            "images" => '',
            "link" => '',
            "autoslide" => '0',
            "menucolorstyle" => 'mediumgray',
            "menutextcolor" => '',
            "menuactivetextcolor" => '',
            "menubackgroundcolor" => '',
            "menus" => '',
            "menupadding" => '',
            "menumargin" => '',
            "imagelinks" => '',
            "imagelinktarget" => '',
            "isresize" => 'no',
            "imagewidth" => '',
            "transitionstyle" => 'normalFade',
            "enabledrag" => '',
            "extraclass" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $content = str_replace('[/slidedesc]', '', trim($content));
          $contentarr = explode('[slidedesc]', trim($content));
          array_shift($contentarr);
          $output = '';

          wp_register_style( 'vc-extensions-compareslider-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-compareslider-style' );
          wp_register_style( 'owl.carousel', plugins_url('css/owl.carousel.css', __FILE__) );
          wp_enqueue_style( 'owl.carousel' );
          wp_register_script('jquery.easing', plugins_url('../metrocarousel/js/jquery.easing.1.3.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('jquery.easing');
          wp_enqueue_script('vc-extensions-compareslider-script');
          wp_register_script('owl.carousel', plugins_url('js/owl.carousel.min.js', __FILE__), array("jquery", "jquery.easing"));
          wp_enqueue_script('owl.carousel');
          wp_register_script('vc-extensions-compareslider-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "owl.carousel"));
          wp_enqueue_script('vc-extensions-compareslider-script');
          $imagesArr = explode(',', $images);
          $menus = explode(',', $menus);
          $imagelinks = explode(',', $imagelinks);
          $imageLen = 0;
          $output = '';
          $output .= '<div class="cq-compareslider '.$extraclass.'" data-autoslide="'.$autoslide.'" data-menubackgroundcolor="'.$menubackgroundcolor.'" data-menutextcolor="'.$menutextcolor.'" data-menucolorstyle="'.$menucolorstyle.'" data-menuactivetextcolor="'.$menuactivetextcolor.'" data-menupadding="'.$menupadding.'" data-enabledrag="'.$enabledrag.'" data-transitionstyle="'.$transitionstyle.'" data-menumargin="'.$menumargin.'">';
          $output .= '<div class="cq-compareslider-imagecontainer">';
          foreach ($imagesArr as $key => $theimage) {
              $attachment = get_post($theimage);
              $imageLocation = wp_get_attachment_image_src($theimage, 'full');
              $output .= '<div class="cq-compareslider-imageitem">';
              if(isset($imagelinks[$imageLen])&&$imagelinks[$imageLen]!="") $output .= '<a href="'.$imagelinks[$imageLen].'" target="'.$imagelinktarget.'" class="cq-compareslider-link">';

                $img = $thumbnail = "";
                $fullimage = $imageLocation[0];
                $thumbnail = $fullimage;
                if($isresize=="yes"&&$imagewidth!=""){
                    if(function_exists('wpb_resize')){
                        $img = wpb_resize($theimage, null, $imagewidth, null);
                        $thumbnail = $img['url'];
                        if($thumbnail=="") $thumbnail = $fullimage;
                    }
                }

             $output .= '<img src="'.$thumbnail.'" class="cq-compareslider-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';

              if(isset($imagelinks[$imageLen])&&$imagelinks[$imageLen]!="") $output .= '</a>';
              if(isset($contentarr[$imageLen])){
                $slidedesc = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $contentarr[$imageLen]);
                $slidedesc = preg_replace('/^(<br \/>)*/', "", $slidedesc);
                $slidedesc = preg_replace('/^(<\/p>)*/', "", $slidedesc);
                if($slidedesc!=""){
                  $output .= '<p class="cq-compareslider-desc">';
                  $output .= $contentarr[$imageLen];
                  $output .= '</p>';
                }
              }
              $output .= '</div>';
              $imageLen++;
          }
          $output .= '</div>';

          $output .= '<div class="cq-compareslider-menucontainer">';
          $output .= '<ul class="cq-compareslider-menu">';
          for ($i=0; $i < $imageLen; $i++) {
              $output .= '<li class="cq-compareslider-dot '.$menucolorstyle.'">';
              if(isset($menus[$i])){
                  if(trim($menus[$i])!="") $output .= $menus[$i];
              }
              $output .= '</li>';
          }
          $output .= '</ul>';
          $output .= '</div>';

          $output .= '</div>';
          return $output;

        }

  }

}

?>
