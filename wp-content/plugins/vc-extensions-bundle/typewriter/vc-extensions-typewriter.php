<?php
if (!class_exists('VC_Extensions_TypeWriter')) {
    class VC_Extensions_TypeWriter{
        function __construct() {
          vc_map(array(
            "name" => esc_attr__("Type Writer", 'vc_typewriter_cq'),
            "base" => "cq_vc_typewriter",
            "class" => "wpb_cq_vc_extension_typewriter",
            "icon" => "cq_allinone_typewriter",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Type text effect', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_typewriter_cq",
                "heading" => esc_attr__("Display the background with:", "vc_typewriter_cq"),
                "param_name" => "backgroundtype",
                "value" => array("Solid background color" => "solid", "Gradient background color" => "gradient", "Image" => "image"),
                "description" => esc_attr__("", "vc_typewriter_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_typewriter_cq",
                "heading" => esc_attr__("Choose a built-in solid color:", "vc_typewriter_cq"),
                "param_name" => "builtsolidcolor",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "or customized color below:" => "customized"),
                'std' => 'mediumgray',
                "dependency" => Array('element' => "backgroundtype", 'value' => array('solid')),
                "description" => esc_attr__("", "vc_typewriter_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customized solid background color:", 'vc_typewriter_cq'),
                "param_name" => "solidcolor",
                "value" => '#CCD1D9',
                "dependency" => Array('element' => "builtsolidcolor", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_typewriter_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Main color for the gradient background:", 'vc_typewriter_cq'),
                "param_name" => "gradientcolor",
                "value" => '#ED5565',
                "dependency" => Array('element' => "backgroundtype", 'value' => array('gradient')),
                "description" => esc_attr__("", 'vc_typewriter_cq')
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image:", "vc_typewriter_cq"),
                "param_name" => "backgroundimage",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => esc_attr__("Select image from media library.", "vc_typewriter_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width:", "vc_typewriter_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => esc_attr__("Default we'll use the original image, you can specify a smaller value (like 480) here, then image will be resized to 480.", "vc_typewriter_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_typewriter_cq",
                "heading" => esc_attr__("Background image repeat:", "vc_typewriter_cq"),
                "param_name" => "imagerepeat",
                "value" => array("no-repeat" => "no-repeat", "repeat" => "repeat"),
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => esc_attr__("", "vc_typewriter_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_typewriter_cq",
                "heading" => esc_attr__("Apply parallax to the image?", "vc_typewriter_cq"),
                "param_name" => "isparallax",
                "value" => array("no" => "no", "yes" => "yes"),
                "dependency" => Array('element' => "imagerepeat", 'value' => array('no-repeat')),
                "description" => esc_attr__("", "vc_typewriter_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tolerance x for the parallax:", "vc_typewriter_cq"),
                "param_name" => "parallaxx",
                "value" => "",
                "dependency" => Array('element' => "isparallax", 'value' => array('yes')),
                "description" => esc_attr__("Larger value will move x position smaller in parallax. Make sure it will not too small, otherwise image will exceed the container. Default is 800.", "vc_typewriter_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tolerance y for the parallax:", "vc_typewriter_cq"),
                "param_name" => "parallaxy",
                "value" => "",
                "dependency" => Array('element' => "isparallax", 'value' => array('yes')),
                "description" => esc_attr__("Larger value will move y position smaller in parallax. Make sure it will not too small, otherwise image will exceed the container. Default is 500.", "vc_typewriter_cq")
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Type text:", "vc_typewriter_cq"),
                "param_name" => "content",
                "value" => "
                [textitem]
                Here is the first sentence.
                [/textitem]
                [textitem]
                 Hello Mac 
                [/textitem]
                [textitem]
                Type like a human, yet another word.
                [/textitem]
                ",
                "description" => esc_attr__("", "vc_typewriter_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color of the type text:", 'vc_typewriter_cq'),
                "param_name" => "fontcolor",
                "value" => '',
                "description" => esc_attr__("Default is white, customize it with other color here.", 'vc_typewriter_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the type text:", "vc_typewriter_cq"),
                "param_name" => "fontsize",
                "value" => "",
                "description" => esc_attr__("Default is 1.8em, you can specify other value here.", "vc_typewriter_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_typewriter_cq",
                "heading" => esc_attr__("Background shape:", "vc_typewriter_cq"),
                "param_name" => "backgroundshape",
                "value" => array("square" => "0", "rounded" => "4px", "circle (the element width and height must be in same size)" => "50%"),
                "description" => esc_attr__("", "vc_typewriter_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the type text)', 'vc_typewriter_cq' ),
                'param_name' => 'textlink',
                'description' => esc_attr__( '', 'vc_typewriter_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_typewriter_cq",
                "heading" => esc_attr__("Each sentence exist for (in second):", "vc_typewriter_cq"),
                "param_name" => "delaytime",
                'value' => array(0.5, 1, 2, 3, 4, 5, 7, 10),
                'std' => 3,
                "description" => esc_attr__("Choose how long a sentence exist and start to display next one.", "vc_typewriter_cq")
              ),
              array(
                "type" => "checkbox",
                "heading" => esc_attr__("Do not loop the typing?", "vc_typewriter_cq"),
                "param_name" => "looptype",
                "value" => array(esc_attr__("Yes, stop typing at the end sentence.", "vc_typewriter_cq") => 'no'),
                "description" => esc_attr__("Default we will loop the typing. Check this if you don't want it.", "vc_typewriter_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the whole element:", "vc_typewriter_cq"),
                "param_name" => "elementwidth",
                "value" => "",
                "description" => esc_attr__("Default is 100%. You can specify other value here.", "vc_typewriter_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole element:", "vc_typewriter_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is 200px. You can specify other value here.", "vc_typewriter_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_typewriter_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default is margin: 12px auto 0 auto. You can specify other value here.", "vc_typewriter_cq")
              )

           )
        ));

        add_shortcode('cq_vc_typewriter', array($this,'cq_vc_typewriter_func'));

      }

      function cq_vc_typewriter_func($atts, $content=null) {
          extract(shortcode_atts(array(
            "builtsolidcolor" => "mediumgray",
            "solidcolor" => "#CCD1D9",
            "backgroundtype" => "solid",
            "gradientcolor" => "#CCD1D9",
            "imagerepeat" => "no-repeat",
            "fontcolor" => "",
            "fontsize" => "",
            "backgroundshape" => "0",
            "imagewidth" => "",
            "textlink" => "",
            "delaytime" => "3",
            "isparallax" => "",
            "parallaxx" => "800",
            "parallaxy" => "500",
            "elementwidth" => "",
            "elementheight" => "",
            "elementmargin" => "",
            "looptype" => "",
            "backgroundimage" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          wp_register_style( 'vc-extensions-typewriter-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-typewriter-style' );

          wp_register_script('theater', plugins_url('js/theater.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('theater');
          wp_register_script('vc-extensions-typewriter-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "theater"));
          wp_enqueue_script('vc-extensions-typewriter-script');

          $textlink = vc_build_link($textlink);

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$solidcolor", "$solidcolor") );

          $content = str_replace('[/textitem]', '', trim($content));
          $contentarr = explode('[textitem]', trim($content));
          array_shift($contentarr);
          $solidcolor_arr = $color_style_arr[$builtsolidcolor];
          $attachment = get_post($backgroundimage);
          $backgroundimage_full = wp_get_attachment_image_src($backgroundimage, 'full');
          $image_temp = $thumbnail = "";
          $thumbnail = $backgroundimage_full[0];
          if($imagewidth!=""){
              if(function_exists('wpb_resize')){
                  $image_temp = wpb_resize($backgroundimage, null, $imagewidth, null, true);
                  $thumbnail = $image_temp['url'];
                  if($thumbnail=="") $thumbnail = $backgroundimage_full[0];
              }
          }

          $output = '';
          if($backgroundtype=="image"){
              if($imagerepeat=="repeat") {
                  $output .= '<div class="cq-typewriter-container" style="background-color:'.$solidcolor_arr[1].';background-image:url('.$thumbnail.');background-repeat:repeat;">';
              }else{
                  if($isparallax=="yes"){
                    $output .= '<div class="cq-typewriter-container" data-isparallax="'.$isparallax.'" data-parallaxx="'.$parallaxx.'" data-parallaxy="'.$parallaxy.'">';
                  }else{
                    $output .= '<div class="cq-typewriter-container" style="background-image:url('.$thumbnail.');background-size:cover;">';
                  }
              }
          }else if($backgroundtype=="solid"){
              $output .= '<div class="cq-typewriter-container" style="background-color:'.$solidcolor_arr[1].';">';
          }else{
              $output .= '<div class="cq-typewriter-container" data-gradientcolor="'.$gradientcolor.'" data-backgroundtype="'.$backgroundtype.'" style="">';
          }
          $output .= '<div class="cq-typewriter" data-fontsize="'.$fontsize.'" data-fontcolor="'.$fontcolor.'" data-delaytime="'.$delaytime.'" data-elementmargin="'.$elementmargin.'" data-elementwidth="'.$elementwidth.'" data-elementheight="'.$elementheight.'" data-imagerepeat="'.$imagerepeat.'" data-backgroundshape="'.$backgroundshape.'" data-looptype="'.$looptype.'">';
          if($textlink["url"]!=="") $output .= '<a href="'.$textlink["url"].'" title="'.$textlink["title"].'" target="'.$textlink["target"].'" class="typewriter-link">';
          $output .= '<span class="cq-typewriter-text"></span>';
          $i = -1;
          foreach ($contentarr as $key => $thecontent) {
              $i++;
              $thecontent = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $thecontent);
              $thecontent = preg_replace('/^(<br \/>)*/', "", $thecontent);
              $thecontent = preg_replace('/^(<\/p>)*/', "", $thecontent);
              if($thecontent!="") $output .= '<span class="cq-typewriter-hiddentext">'.$thecontent.'</span>';
          }
          if($textlink["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          if($backgroundimage_full[0]!=""&&$imagerepeat=="no-repeat"&&$isparallax=="yes"){

            if($imagewidth==""){
              $output .= '<img src="'.$backgroundimage_full[0].'" class="cq-typewriter-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
            }else{
              $output .= '<img src="'.$thumbnail.'" width="'.$imagewidth.'" class="cq-typewriter-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
            }
          }
          $output .= '</div>';
          return $output;

        }


  }

}

?>
