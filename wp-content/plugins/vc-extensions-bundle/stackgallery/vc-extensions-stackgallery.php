<?php
if (!class_exists('VC_Extensions_StackGallery')) {

    class VC_Extensions_StackGallery{
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Stack Gallery", 'vc_stackgallery_cq'),
            "base" => "cq_vc_stackgallery",
            "class" => "wpb_cq_vc_extension_stackgallery",
            "controls" => "full",
            "icon" => "cq_allinone_stackgallery",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Gallery in stack order', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Images", "vc_stackgallery_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_stackgallery_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Container background color", 'vc_extend'),
                "param_name" => "background",
                "value" => '',
                "description" => esc_attr__("", 'vc_extend')
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Container background image", "vc_stackgallery_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select background from media library.", "vc_stackgallery_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Background image repeat", "vc_stackgallery_cq"),
                "param_name" => "repeat",
                "value" => array(esc_attr__("repeat", "vc_stackgallery_cq") => "repeat", esc_attr__("no-repeat", "vc_stackgallery_cq") => "no-repeat", esc_attr__("repeat-x", "vc_stackgallery_cq") => "repeat-x", esc_attr__("repeat-y", "vc_stackgallery_cq") => "repeat-y"),
                "description" => esc_attr__("", "vc_stackgallery_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Tooltip for each image", 'vc_stackgallery_cq'),
                "param_name" => "tooltips",
                "value" => esc_attr__("Hello tooltip 1,Hello tooltip 2,Hello tooltip 3", 'vc_stackgallery_cq'),
                "description" => esc_attr__("Enter tooltip for each image here. Divide each with linebreaks (Enter).", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Image width", 'vc_stackgallery_cq'),
                "param_name" => "width",
                "value" => esc_attr__("320", 'vc_stackgallery_cq'),
                "description" => esc_attr__("The image will be resized to this size (x2 in retina mode).", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Image height", 'vc_stackgallery_cq'),
                "param_name" => "height",
                "value" => esc_attr__("240", 'vc_stackgallery_cq'),
                "description" => esc_attr__("The image will be resized to this size (x2 in retina mode).", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("ease in", "vc_stackgallery_cq"),
                "param_name" => "easein",
                "description" => esc_attr__('Select the ease in animation', 'vc_stackgallery_cq'),
                'value' => array(esc_attr__("easeInBack", "vc_stackgallery_cq") => "easeInBack", esc_attr__("easeInOutCubic", "vc_stackgallery_cq") => "easeInOutCubic", esc_attr__("easeInCirc", "vc_stackgallery_cq") => "easeInCirc", esc_attr__("easeInOutCirc", "vc_stackgallery_cq") => "easeInOutCirc", esc_attr__("easeInExpo", "vc_stackgallery_cq") => "easeInExpo", esc_attr__("easeInOutExpo", "vc_stackgallery_cq") => "easeInOutExpo", esc_attr__("easeInQuad", "vc_stackgallery_cq") => "easeInQuad", esc_attr__("easeInOutQuad", "vc_stackgallery_cq") => "easeInOutQuad", esc_attr__("easeInQuart", "vc_stackgallery_cq") => "easeInQuart", esc_attr__("easeInOutQuart", "vc_stackgallery_cq") => "easeInOutQuart", esc_attr__("easeInQuint", "vc_stackgallery_cq") => "easeInQuint", esc_attr__("easeInOutQuint", "vc_stackgallery_cq") => "easeInOutQuint", esc_attr__("easeInSine", "vc_stackgallery_cq") => "easeInSine", esc_attr__("easeInOutSine", "vc_stackgallery_cq") => "easeInOutSine", esc_attr__("easeInOutBack", "vc_stackgallery_cq") => "easeInOutBack"),esc_attr__("linear", "vc_stackgallery_cq") => "linear", esc_attr__("ease", "vc_stackgallery_cq") => "ease", esc_attr__("in", "vc_stackgallery_cq") => "in", esc_attr__("in-out", "vc_stackgallery_cq") => "in-out", esc_attr__("snap", "vc_stackgallery_cq") => "snap"),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("ease out", "vc_stackgallery_cq"),
                "param_name" => "easeout",
                "description" => esc_attr__('Select the ease out animation', 'vc_stackgallery_cq'),
                'value' => array(esc_attr__("easeOutCubic", "vc_stackgallery_cq") => "easeOutCubic", esc_attr__("easeInOutCubic", "vc_stackgallery_cq") => "easeInOutCubic", esc_attr__("easeOutCirc", "vc_stackgallery_cq") => "easeOutCirc", esc_attr__("easeInOutCirc", "vc_stackgallery_cq") => "easeInOutCirc", esc_attr__("easeOutExpo", "vc_stackgallery_cq") => "easeOutExpo", esc_attr__("easeInOutExpo", "vc_stackgallery_cq") => "easeInOutExpo", esc_attr__("easeOutQuad", "vc_stackgallery_cq") => "easeOutQuad", esc_attr__("easeInOutQuad", "vc_stackgallery_cq") => "easeInOutQuad", esc_attr__("easeOutQuart", "vc_stackgallery_cq") => "easeOutQuart", esc_attr__("easeInOutQuart", "vc_stackgallery_cq") => "easeInOutQuart", esc_attr__("easeOutQuint", "vc_stackgallery_cq") => "easeOutQuint", esc_attr__("easeInOutQuint", "vc_stackgallery_cq") => "easeInOutQuint", esc_attr__("easeOutSine", "vc_stackgallery_cq") => "easeOutSine", esc_attr__("easeInOutSine", "vc_stackgallery_cq") => "easeInOutSine", esc_attr__("easeOutBack", "vc_stackgallery_cq") => "easeOutBack", esc_attr__("easeInOutBack", "vc_stackgallery_cq") => "easeInOutBack"),esc_attr__("linear", "vc_stackgallery_cq") => "linear", esc_attr__("ease", "vc_stackgallery_cq") => "ease", esc_attr__("out", "vc_stackgallery_cq") => "out", esc_attr__("in-out", "vc_stackgallery_cq") => "in-out", esc_attr__("snap", "vc_stackgallery_cq") => "snap"),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Auto delay slideshow?", "vc_stackgallery_cq"),
                "param_name" => "slideshow",
                "value" => array(esc_attr__("no", "vc_stackgallery_cq") => "no", esc_attr__("yes", "vc_stackgallery_cq") => "yes"),
                "description" => esc_attr__("", "vc_stackgallery_cq")
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Sliseshow delay", 'vc_stackgallery_cq'),
                "param_name" => "slideshowdelay",
                "value" => esc_attr__("5000", 'vc_stackgallery_cq'),
                "dependency" => Array('element' => "slideshow", 'value' => array('yes')),
                "description" => esc_attr__("Delay time for the slideshow, default is 5000, stand for 5 seconds.", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Do not display tooltip for the image?", 'vc_stackgallery_cq'),
                "param_name" => "notooltip",
                "value" => array(esc_attr__("No tooltip, please", "vc_stackgallery_cq") => 'on'),
                "description" => esc_attr__("Default you can put each tooltip for image, check this if you do not want it.", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Do not display the image in retina?", 'vc_stackgallery_cq'),
                "param_name" => "noretina",
                "value" => array(esc_attr__("No retina, please", "vc_stackgallery_cq") => 'on'),
                "description" => esc_attr__("Default is retina, check this if you do not want it.", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Do not display the arrow?", 'vc_stackgallery_cq'),
                "param_name" => "noarrow",
                "value" => array(esc_attr__("No arrow, please", "vc_stackgallery_cq") => 'on'),
                "description" => esc_attr__("Default there are arrow for the next/previous, check this if you do not want it.", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Container height", 'vc_stackgallery_cq'),
                "param_name" => "containerheight",
                "value" => esc_attr__("", 'vc_stackgallery_cq'),
                "description" => esc_attr__("Specify the container height, default is image height + 80 (leave it to blank here).", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Image border", 'vc_stackgallery_cq'),
                "param_name" => "border",
                "value" => esc_attr__("", 'vc_stackgallery_cq'),
                "description" => esc_attr__("Specify the image border, default is 0.", 'vc_stackgallery_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_stackgallery_cq",
                "heading" => esc_attr__("Arrow color", "vc_stackgallery_cq"),
                "param_name" => "arrowcolor",
                "value" => array(esc_attr__("black", "vc_stackgallery_cq") => "", esc_attr__("white", "vc_stackgallery_cq") => "white"),
                "description" => esc_attr__("", "vc_stackgallery_cq")
              )

            )
        ));


        add_shortcode('cq_vc_stackgallery', array($this,'cq_vc_stackgallery_func'));

      }

      function cq_vc_stackgallery_func($atts, $content = null) {
          extract( shortcode_atts( array(
            'images' => '',
            'image' => '',
            'background' => '',
            'repeat' => '',
            'tooltips' => '',
            'width' => '320',
            'height' => '240',
            'noretina' => 'off',
            'notooltip' => 'off',
            'noarrow' => 'off',
            'slideshow' => 'off',
            'slideshowdelay' => 'off',
            'easein' => 'easeInBack',
            'easeout' => 'easeOutBack',
            'border' => '',
            'arrowcolor' => '',
            'containerheight' => ''
          ), $atts ) );



          wp_register_style( 'vc_stackgallery_cq_style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc_stackgallery_cq_style' );

          wp_register_script('transit', plugins_url('js/jquery.transit.min.js', __FILE__));
          wp_enqueue_script('transit');
          wp_register_script('vc_stackgallery_cq_script', plugins_url('js/jquery.stackgallery.min.js', __FILE__), array("jquery", "transit"));
          wp_enqueue_script('vc_stackgallery_cq_script');

          wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');
          wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');


          $imagesarr = explode(',', $images);
          $tooltiparr = explode(',', $tooltips);
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          $i = count($imagesarr);
          $backgroundimage = wp_get_attachment_image_src($image, 'full');
          $output .= '<div class="cq-stackgallery" data-width="'.$width.'" data-height="'.$height.'" data-easein="'.$easein.'" data-easeout="'.$easeout.'" data-containerheight="'.$containerheight.'" data-slideshow="'.$slideshow.'" data-slideshowdelay="'.$slideshowdelay.'" data-notooltip="'.$notooltip.'" style="background:'.$background.' url('.$backgroundimage[0].') '.$repeat.'">';
          foreach ($imagesarr as $key => $value) {
              $i--;
              if(!isset($tooltiparr[$i])) $tooltiparr[$i] = '';
              $return_img_arr = wp_get_attachment_image_src(trim($imagesarr[$i]), 'full');
              $image_temp = $stackimage = "";
              $fullimage = $return_img_arr[0];
              $stackimage = $fullimage;
              $attachment = get_post($imagesarr[$i]);
              if($width!=""){
                  if(function_exists('wpb_resize')){
                      $image_temp = wpb_resize($imagesarr[$i], null, $noretina=="off"?$width*2:$width, $noretina=="off"?$height*2:$height, true);
                      $stackimage = $image_temp['url'];
                      if($stackimage=="") $stackimage = $fullimage;
                  }
              }

              $output .= '<img class="stackgallery-item" style="border: '.$border.'px solid #FFF" src="'.$stackimage.'" width="'.$width.'" height="'.$height.'" title="'.$tooltiparr[$i].'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';

          }
          if($noarrow!="on"){
            $output .= '<div><a href="#"><span class="'.$arrowcolor.' stackgallery-prev"></span></a></div>';
            $output .= '<div><a href="#"><span class="'.$arrowcolor.' stackgallery-next"></span></a></div>';
          }
          $output .= '</div>';
          return $output;

        }

  }

}

?>
