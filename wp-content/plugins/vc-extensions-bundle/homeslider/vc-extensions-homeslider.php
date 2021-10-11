<?php
if (!class_exists('VC_Extensions_HomeSlider')) {
    class VC_Extensions_HomeSlider{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Home Slider", 'vc_homeslider_cq'),
            "base" => "cq_vc_homeslider",
            "class" => "wpb_cq_vc_extension_homeslider",
            "icon" => "cq_allinone_homeslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Full width slider for homepage', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Slide images:", "vc_homeslider_cq"),
                "param_name" => "images",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("Select image(s) from media library, support multiple images.", "vc_homeslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("Image stretch", "vc_homeslider_cq"),
                "param_name" => "imagestretch",
                "value" => array(esc_attr__("Default", "vc_homeslider_cq") => "default", esc_attr__("Stretch to full width", "vc_homeslider_cq") => "fullwidth"),
                "std" => "default",
                "group" => "Image",
                "description" => esc_attr__("", "vc_homeslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("max-height for the images", "vc_homeslider_cq"),
                "param_name" => "maxheight",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("Default is 640px", "vc_homeslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("Image on click", "vc_homeslider_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("Do nothing", "vc_homeslider_cq") => "none", esc_attr__("Open custom link", "vc_homeslider_cq") => "customlink"),
                "std" => "none",
                "group" => "Image",
                "description" => esc_attr__("", "vc_homeslider_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("Custom link for each image", 'vc_homeslider_cq'),
                "param_name" => "customlinks",
                "value" => esc_attr__("", 'vc_homeslider_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Image",
                "description" => esc_attr__("Divide with linebreak (Enter), available with open custom link option.", 'vc_homeslider_cq')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Custom link target", "vc_homeslider_cq"),
                "param_name" => "customlinktarget",
                "description" => esc_attr__('Select how to open custom link.', 'vc_homeslider_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Image",
                'value' => array(esc_attr__("Same window", "vc_homeslider_cq") => "_self", esc_attr__("New window", "vc_homeslider_cq") => "_blank")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("Optional title for each slide", "vc_homeslider_cq"),
                "param_name" => "titles",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Divide with linebreak (Enter)", "vc_homeslider_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Caption content, divide each one with [captionitem][/captionitem], please try to edit in the text mode:", "vc_homeslider_cq"),
                "param_name" => "content",
                "group" => "Caption",
                "value" => esc_attr__("", "vc_homeslider_cq"), "description" => esc_attr__("", "vc_homeslider_cq"),
                "description" => esc_attr__("Please keep the caption item number is same as the image number.", "vc_homeslider_cq"),
                "std" => '[captionitem]item caption 1[/captionitem]
[captionitem]item caption 2[/captionitem]
[captionitem]item caption 3[/captionitem]'
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("width for the caption", "vc_homeslider_cq"),
                "param_name" => "captionwidth",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Default is 360px", "vc_homeslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("min-height for the caption", "vc_homeslider_cq"),
                "param_name" => "minheight",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("You can customize the caption with a min-height to keep all caption in same height, for example 400px", "vc_homeslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("The caption style", "vc_homeslider_cq"),
                "param_name" => "navstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Or you can customized color below:" => "customized"),
                'std' => 'lavender',
                "group" => "Caption",
                "description" => esc_attr__("", "vc_homeslider_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customize caption background color", 'vc_homeslider_cq'),
                "param_name" => "contentbackground",
                "value" => '',
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "group" => "Caption",
                "description" => esc_attr__("Both 2 buttons in same background color.", 'vc_homeslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color of the caption", 'vc_homeslider_cq'),
                "param_name" => "contentcolor",
                "value" => "",
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "group" => "Caption",
                "description" => esc_attr__("Default is white.", 'vc_homeslider_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS top for the caption", "vc_homeslider_cq"),
                "param_name" => "captiontop",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Default is 0. You can specif a value like 12px or 10% here.", "vc_homeslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS left for the caption", "vc_homeslider_cq"),
                "param_name" => "captionleft",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Default is 0. You can specif a value like 12px or 10% here.", "vc_homeslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("Select the auto delay time", "vc_homeslider_cq"),
                "param_name" => "delaytime",
                "value" => array("No slideshow" => "no", "2", "3", "4", "5", "6", "7", "8", "10"),
                'std' => 'no',
                "description" => esc_attr__("Choose to display the slider with auto delay slideshow or not, the number is in second.", "vc_homeslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("Display image and caption with shadow?", "vc_homeslider_cq"),
                "param_name" => "isshadow",
                "value" => array("Yes (tiny shadow)" => "tinyshadow", "Yes (long shadow)" => "longshadow", "No" => "noshadow"),
                "std" => "tinyshadow",
                "description" => esc_attr__("", "vc_homeslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_homeslider_cq",
                "heading" => esc_attr__("Content bottom shape", "vc_homeslider_cq"),
                "param_name" => "bottomshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square" => "square"),
                "std" => "square",
                "description" => esc_attr__("", "vc_homeslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_homeslider_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_homeslider_cq")
              )

           )
        ));

        add_shortcode('cq_vc_homeslider', array($this,'cq_vc_homeslider_func'));
      }

      function cq_vc_homeslider_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            "images" => "",
            "imagewidth" => "",
            "captiontop" => "",
            "captionleft" => "",
            "minheight" => "",
            "maxheight" => "",
            "captionwidth" => "",
            "imagestretch" => "default",
            "titles" => "",
            "contentcolor" => "",
            "delaytime" => "no",
            "avatarlink" => "",
            "isshadow" => "tinyshadow",
            "onclick" => "none",
            "customlinks" => "",
            "customlinktarget" => "",
            "contentstyle" => "",
            "contentbackground" => "",
            "bottomshape" => "",
            "navstyle" => "lavender",
            "extraclass" => ""
          ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue('entypo');
          }else{
          }



          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');

          wp_register_style( 'vc-extensions-homeslider-style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-homeslider-style' );
          wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
          wp_enqueue_style('slick');

          wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('slick');
          wp_enqueue_script('vc-extensions-homeslider-script');
          wp_register_script('vc-extensions-homeslider-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "slick", "fs.boxer"));

          wp_enqueue_script('vc-extensions-homeslider-script');

          $content = str_replace('[/captionitem]', '', trim($content));
          $contentarr = explode('[captionitem]', trim($content));
          array_shift($contentarr);
          $imagesArr = explode(',', $images);
          $titles = explode(',', $titles);

          $output = "";
          $navigation_str = '';
          $image_str = '';
          $content_str = '';
          $area_str = '';

          $customlinks = explode( ',', $customlinks);

          $output .= '<div class="cq-homeslider '.$navstyle.' '.$isshadow.' '.$extraclass.'" data-captiontop="'.$captiontop.'" data-captionleft="'.$captionleft.'" data-delaytime="'.$delaytime.'" data-minheight="'.$minheight.'" data-maxheight="'.$maxheight.'" data-contentbackground="'.$contentbackground.'" data-vc-stretch-content="true" data-captionwidth="'.$captionwidth.'" data-imagestretch="'.$imagestretch.'" data-contentcolor="'.$contentcolor.'">';

          $navigation_str .= '<div class="cq-homeslider-navigation btn-medium">';
          $navigation_str .= '<div class="homeslider-navigation-prev">';
          $navigation_str .= '<i class="cq-homeslider-icon entypo-icon entypo-icon-left-open-big"></i>';
          $navigation_str .= '</div>';
          $navigation_str .= '<div class="homeslider-navigation-next">';
          $navigation_str .= '<i class="cq-homeslider-icon entypo-icon entypo-icon-right-open-big"></i>';
          $navigation_str .= '</div>';
          $navigation_str .= '</div>';


          $image_str .= '<div class="cq-homeslider-cover">';
          $image_str .= '<div class="cq-homeslider-itemcontainer">';
          $content_str .= '<div class="cq-homeslider-contentcontainer '.$bottomshape.'">';
          $content_str .= '<div class="cq-homeslider-content">';


          $i = -1;
          $j = -1;
          foreach ($contentarr as $key => $thecontent) {
              $j++;
              if(!isset($thecontent)) $thecontent = "";
              $thecontent = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $thecontent);
              $thecontent = preg_replace('/^(<br \/>)*/', "", $thecontent);
              $thecontent = preg_replace('/^(<\/p>)*/', "", $thecontent);
              $content_str .= '<div class="cq-homeslider-contentitem">';
              if(isset($titles[$j])){
                $content_str .= '<h4 class="cq-homeslider-title">';
                $content_str .= $titles[$j];
                $content_str .= '</h4>';
              }
              $content_str .= wpb_js_remove_wpautop($thecontent);
              $content_str .= '</div>';
          }

          foreach ($imagesArr as $key => $theimage) {
              $i++;
              if(!isset($customlinks[$i])) $customlinks[$i] = '';
              if(!isset($contentarr[$i])){
                  $content_str .= '<div class="cq-homeslider-contentitem">';
                  $content_str .= '</div>';
              }

              $imageLocation = wp_get_attachment_image_src($theimage, 'full');
              $attachment = get_post($theimage);
              $image_str .= '<div class="cq-homeslider-imageitem">';
              if($onclick=="customlink"){
                if($customlinks[$i]!="") $image_str .= '<a href="'.$customlinks[$i].'" target="'.$customlinktarget.'" class="cq-homeslider-link">';
              }else if($onclick=="lightbox"){
                if($imageLocation[0]!="") $image_str .= '<a href="'.$imageLocation[0].'" class="cq-homeslider-link cq-homeslider-lightbox">';
              }
              if($imageLocation[0]!=""){
                $image_str .= '<img src="'.$imageLocation[0].'" class="cq-homeslider-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'"
>';
              }
              if($onclick=="customlink"){
                if($customlinks[$i]!="") $image_str .= '</a>';
              }else if($onclick=="lightbox"){
                if($imageLocation[0]!="") $image_str .= '</a>';
              }


              $image_str .= '</div>';

          }

          $image_str .= '</div>';
          $image_str .= '</div>';

          $content_str .= '</div>';
          $content_str .= $navigation_str;
          $content_str .= '</div>';  // end of the contentcontainer

          $area_str .= '<div class="cq-homeslider-area btn-medium">';
          $area_str .= $image_str.$content_str;

          $area_str .= '</div>';

          $output .= $area_str;


          $output .= '</div>';

          return $output;

        }

  }

}

?>
