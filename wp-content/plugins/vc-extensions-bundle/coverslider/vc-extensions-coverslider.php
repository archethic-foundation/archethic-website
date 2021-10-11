<?php
if (!class_exists('VC_Extensions_CoverSlider')) {
    class VC_Extensions_CoverSlider{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Cover Slider", 'vc_coverslider_cq'),
            "base" => "cq_vc_coverslider",
            "class" => "wpb_cq_vc_extension_coverslider",
            "icon" => "cq_allinone_coverslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('With caption and navigation button', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Cover images:", "vc_coverslider_cq"),
                "param_name" => "images",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("Select image(s) from media library, support multiple images.", "vc_coverslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Image on click", "vc_coverslider_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("Open lightbox", "vc_coverslider_cq") => "lightbox", esc_attr__("Do nothing", "vc_coverslider_cq") => "none", esc_attr__("Open custom link", "vc_coverslider_cq") => "customlink"),
                "std" => "none",
                "group" => "Image",
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Custom link for each image", 'vc_coverslider_cq'),
                "param_name" => "customlinks",
                "value" => esc_attr__("", 'vc_coverslider_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Image",
                "description" => esc_attr__("Divide with linebreak (Enter), available with open custom link option.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Custom link target", "vc_coverslider_cq"),
                "param_name" => "customlinktarget",
                "description" => esc_attr__('Select how to open custom link.', 'vc_coverslider_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Image",
                'value' => array(esc_attr__("Same window", "vc_coverslider_cq") => "_self", esc_attr__("New window", "vc_coverslider_cq") => "_blank")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the avatar image?", "vc_coverslider_cq"),
                "param_name" => "isresize",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "group" => "Image",
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_coverslider_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Image",
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "vc_coverslider_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Caption content, divide each one with [captionitem][/captionitem], please try to edit in text mode:", "vc_coverslider_cq"),
                "param_name" => "content",
                "group" => "Caption",
                "value" => esc_attr__("", "vc_coverslider_cq"), "description" => esc_attr__("", "vc_coverslider_cq"),
                "std" => '[captionitem]item caption 1[/captionitem]
[captionitem]item caption 2[/captionitem]
[captionitem]item caption 3[/captionitem]'
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Display the image on the:", "vc_coverslider_cq"),
                "param_name" => "imageposition",
                "value" => array("top", "bottom"),
                'std' => 'top',
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Select the auto delay time", "vc_coverslider_cq"),
                "param_name" => "delaytime",
                "value" => array("No slideshow" => "no", "2", "3", "4", "5", "6", "7", "8", "10"),
                'std' => 'no',
                "description" => esc_attr__("Choose to display the slider with auto delay slideshow or not, the number is in second.", "vc_coverslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("The navigation and content style", "vc_coverslider_cq"),
                "param_name" => "navstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Or you can customized color below:" => "customized"),
                'std' => 'lavender',
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color the content", 'vc_coverslider_cq'),
                "param_name" => "contentcolor",
                "value" => "",
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customize content background color", 'vc_coverslider_cq'),
                "param_name" => "contentbackground",
                "value" => '',
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "description" => esc_attr__("Both 2 buttons in same background color.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Navigation arrow background color", 'vc_coverslider_cq'),
                "param_name" => "buttonbackground",
                "value" => '',
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "description" => esc_attr__("Both 2 buttons will be in same background color in customiz mode.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Navigation arrow color", 'vc_coverslider_cq'),
                "param_name" => "arrowcolor",
                "value" => '',
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Navigation arrow hover color", 'vc_coverslider_cq'),
                "param_name" => "arrowhovercolor",
                "value" => '',
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Navigation arrow hover background color", 'vc_coverslider_cq'),
                "param_name" => "buttonhoverbackground",
                "value" => '#222F46',
                'dependency' => array('element' => 'navstyle', 'value' => 'customized'),
                "description" => esc_attr__("Default is dark gray.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Navigation button size", "vc_coverslider_cq"),
                "param_name" => "buttonsize",
                "value" => array("Small"=>"btn-small", "Medium"=>"btn-medium", "Large"=>"btn-large"),
                'std' => 'btn-medium',
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Display the navigation arrow on the:", "vc_coverslider_cq"),
                "param_name" => "navposition",
                "value" => array("left (float)" => "float-left", "right (float)" => "float-right", "left (overlay)" => "overlay-left", "right (overlay)" => "overlay-right"),
                'std' => 'float-left',
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Display image and caption with shadow?", "vc_coverslider_cq"),
                "param_name" => "isshadow",
                "value" => array("Yes (tiny shadow)" => "tinyshadow", "Yes (long shadow)" => "longshadow", "No" => ""),
                "std" => "tinyshadow",
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "heading" => esc_attr__("Content bottom shape", "vc_coverslider_cq"),
                "param_name" => "bottomshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square" => "square"),
                "std" => "square",
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_coverslider_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_coverslider_cq")
              )

           )
        ));

        add_shortcode('cq_vc_coverslider', array($this,'cq_vc_coverslider_func'));
      }

      function cq_vc_coverslider_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            "images" => "",
            "imagewidth" => "",
            "isresize" => "no",
            "contentcolor" => "",
            "delaytime" => "no",
            "isshadow" => "tinyshadow",
            "onclick" => "none",
            "customlinks" => "",
            "customlinktarget" => "",
            "contentstyle" => "",
            "contentbackground" => "",
            "imageposition" => "top",
            "bottomshape" => "square",
            "dialogstyle" => "style1",
            "navstyle" => "lavender",
            "buttonbackground" => "",
            "arrowcolor" => "",
            "arrowhovercolor" => "",
            "buttonhoverbackground" => "#222F46",
            "arrowposition" => "bottom|center",
            "arrowoffset1" => "center",
            "arrowoffset2" => "middle",
            "navposition" => "float-left",
            "buttonsize" => "btn-large",
            "extraclass" => ""
          ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue('entypo');
          }else{
          }



          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$buttonbackground", "$buttonbackground") );


          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');

          wp_register_style( 'vc-extensions-coverslider-style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-coverslider-style' );
          wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
          wp_enqueue_style('slick');

          wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('slick');
          wp_register_script('vc-extensions-coverslider-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "slick", "fs.boxer"));

          wp_enqueue_script('vc-extensions-coverslider-script');

          $content = str_replace('[/captionitem]', '', trim($content));
          $contentarr = explode('[captionitem]', trim($content));
          array_shift($contentarr);
          $imagesArr = explode(',', $images);

          $i = -1;
          $output = "";

          $customlinks = explode( ',', $customlinks);

          $navigation_str = '';
          $image_str = '';
          $content_str = '';
          $area_str = '';
          $isfloat = '';
          $uniqueID = uniqid();
          if($navposition=="float-left" || $navposition=="float-right"){
              $isfloat = 'navigation-isfloat';
          }

          $output .= '<div class="cq-coverslider '.$extraclass.' navigation-'.$navposition.' '.$isshadow.' '.$navstyle.' '.$isfloat.'" data-imagemaxheight="300" data-buttonbackground="'.$buttonbackground.'" data-buttonhoverbackground="'.$buttonhoverbackground.'" data-contentbackground="'.$contentbackground.'" data-contentcolor="'.$contentcolor.'" data-arrowcolor="'.$arrowcolor.'" data-arrowhovercolor="'.$arrowhovercolor.'" data-delaytime="'.$delaytime.'">';

            $navigation_str .= '<div class="cq-coverslider-navigation '.$buttonsize.'">';
            $navigation_str .= '<div class="coverslider-navigation-prev">';
            $navigation_str .= '<i class="cq-coverslider-icon entypo-icon entypo-icon-left-open-big"></i>';
            $navigation_str .= '</div>';
            $navigation_str .= '<div class="coverslider-navigation-next">';
            $navigation_str .= '<i class="cq-coverslider-icon entypo-icon entypo-icon-right-open-big"></i>';
            $navigation_str .= '</div>';
            $navigation_str .= '</div>';


          $image_str .= '<div class="cq-coverslider-cover">';
          $image_str .= '<div class="cq-coverslider-itemcontainer">';
          $content_str .= '<div class="cq-coverslider-content">';


          foreach ($contentarr as $key => $thecontent) {
              if(!isset($thecontent)) $thecontent = "";
              $thecontent = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $thecontent);
              $thecontent = preg_replace('/^(<br \/>)*/', "", $thecontent);
              $thecontent = preg_replace('/^(<\/p>)*/', "", $thecontent);
              $content_str .= '<div class="cq-coverslider-contentitem">';
              $content_str .= wpb_js_remove_wpautop($thecontent);
              $content_str .= '</div>';
          }

          foreach ($imagesArr as $key => $theimage) {
              $i++;
              if(!isset($customlinks[$i])) $customlinks[$i] = '';
              if(!isset($contentarr[$i])){
                  $content_str .= '<div class="cq-coverslider-contentitem">';
                  $content_str .= '</div>';
              }

              $imageLocation = wp_get_attachment_image_src($theimage, 'full');
              $attachment = get_post($theimage);
              $image_str .= '<div class="cq-coverslider-imageitem">';
              if($onclick=="customlink"){
                if($customlinks[$i]!="") $image_str .= '<a href="'.$customlinks[$i].'" target="'.$customlinktarget.'" class="cq-coverslider-link">';
              }else if($onclick=="lightbox"){
                if($imageLocation[0]!="") $image_str .= '<a href="'.$imageLocation[0].'" class="cq-coverslider-link cq-coverslider-lightbox">';
              }

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

              if($imageLocation[0]!="") $image_str .= '<img src="'.$thumbnail.'" class="cq-coverslider-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'">';
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

          $area_str .= '<div class="cq-coverslider-area '.$buttonsize.' '.$bottomshape.'">';
          if($imageposition=="bottom"){
              $area_str .= $content_str.$image_str;
          }else{
              $area_str .= $image_str.$content_str;
          }
          $area_str .= '</div>';

          if($navposition=="float-left"){
              $output .= $navigation_str.$area_str;
          }else{
              $output .= $area_str.$navigation_str;
          }


          $output .= '</div>';

          return $output;

        }



  }

}

?>
