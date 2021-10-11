<?php
if (!class_exists('VC_Extensions_Parallax')) {

    class VC_Extensions_Parallax {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Parallax", 'vc_parallax_cq'),
            "base" => "cq_vc_parallax",
            "class" => "wpb_cq_vc_extension_parallax",
            "controls" => "full",
            "icon" => "cq_allinone_parallax",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Parallax image and text', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Parallax Images:", "vc_parallax_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_parallax_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Parallax content text, divide each one with [parallaxitem][/parallaxitem], please try to edit in Text mode:", "vc_parallax_cq"),
                "param_name" => "content",
                "value" => "[parallaxitem]You have to wrap each text block inside <strong>parallaxitem</strong>.
                You can customize the text color, background, container width etc in the backend.
                The parallax is disable in mobile, and keep all the image and text readable.
                <a href='http://codecanyon.net/user/sike?ref=sike'>Visit my profile</a> for more works. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.[/parallaxitem]
                [parallaxitem]
                <h4>Text block 2</h4>
                Ecepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. [/parallaxitem]
                [parallaxitem]
                <h4>Text block 3</h4>
                qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. [/parallaxitem]",
                "description" => esc_attr__("", "vc_parallax_cq") ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text color", 'vc_parallax_cq'),
                "param_name" => "textcolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_parallax_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text background color", 'vc_parallax_cq'),
                "param_name" => "textbackground",
                "value" => '',
                "description" => esc_attr__("", 'vc_parallax_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Padding of the content:", "vc_parallax_cq"),
                "param_name" => "padding",
                "value" => "2% 5%",
                "description" => esc_attr__("The CSS padding for the text content, default is 2% 5%.", "vc_parallax_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_parallax_cq",
                "heading" => esc_attr__("Image on click", "vc_parallax_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("Do nothing", "vc_parallax_cq") => "link_no", esc_attr__("Open custom link", "vc_parallax_cq") => "custom_link"),
                "description" => esc_attr__("Define action for onclick event if needed.", "vc_parallax_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("Custom link for each image", "vc_parallax_cq"),
                "param_name" => "custom_links",
                "description" => esc_attr__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'vc_parallax_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("How to open the custom link", "vc_parallax_cq"),
                "param_name" => "custom_links_target",
                "description" => esc_attr__('Select how to open custom links.', 'vc_parallax_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
                'value' => array(esc_attr__("Same window", "vc_parallax_cq") => "_self", esc_attr__("New window", "vc_parallax_cq") => "_blank")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_parallax_cq",
                "heading" => esc_attr__("Display text content first?", 'vc_parallax_cq'),
                "param_name" => "textfirst",
                "value" => array(esc_attr__("Yes", "vc_parallax_cq") => 'on'),
                "description" => esc_attr__("You can check this if you want to display the text content in the beginning, otherwise the image will be displayed first.", 'vc_parallax_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("The speed of the parallax effect.", "vc_parallax_cq"),
                "param_name" => "speed",
                "value" => "",
                "description" => esc_attr__("A floating number between 0 and 1, where a higher number will move the images faster upwards. Default is 0.2", "vc_parallax_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Cover ratio", "vc_parallax_cq"),
                "param_name" => "coverratio",
                "value" => "",
                "description" => esc_attr__("How many percent of the screen each image should cover
, default is 0.75, stand for 75% of the browser.", "vc_parallax_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("minimal height of the image", "vc_parallax_cq"),
                "param_name" => "holderminheight",
                "value" => "",
                "description" => esc_attr__("The minimal height of the image in pixels. Default is 200.", "vc_parallax_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("maximum height of the image", "vc_parallax_cq"),
                "param_name" => "holdermaxheight",
                "value" => "",
                "description" => esc_attr__("The maximum height of the image in pixels. Default is not set, you can use this value or the cover ratio to control the height of the image.", "vc_parallax_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra height of the image", "vc_parallax_cq"),
                "param_name" => "extraheight",
                "value" => "",
                "description" => esc_attr__("Extra height added to the image. Can be useful if you want to show more of the top image. Default is 0.", "vc_parallax_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize images to this width in mobile view:", "vc_parallax_cq"),
                "param_name" => "mobilewidth",
                "value" => "640",
                "description" => esc_attr__("In mobile view, the parallax is disabled, and we will embed the images in this width. Default is 640, leave it to blank if you want to use the original image.", "vc_parallax_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_parallax_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_parallax_cq")
              )

            )
        ));

        add_shortcode('cq_vc_parallax', array($this,'cq_vc_parallax_func'));

      }

      function cq_vc_parallax_func($atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'images' => '',
            'imagewidth' => '',
            'padding' => '2% 5%',
            'textfirst' => '',
            'textcolor' => '#333',
            'textbackground' => '#FFF',
            'mobilewidth' => '640',
            'onclick' => 'link_no',
            'speed' => '',
            'coverratio' => '',
            'holderminheight' => '',
            'holdermaxheight' => '',
            'extraheight' => '',
            'custom_links' => '',
            'custom_links_target' => '',
            'extra_class' => ''
          ), $atts ) );


          wp_register_style( 'vc_parallax_cq_style', plugins_url('css/style.css', __FILE__));
          wp_enqueue_style( 'vc_parallax_cq_style' );

          wp_register_script('modernizr', plugins_url('js/modernizr.js', __FILE__));
          wp_enqueue_script('modernizr');
          wp_register_script('imagescroll', plugins_url('js/jquery.imagescroll.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('imagescroll');
          wp_register_script('vc_parallax_cq_script', plugins_url('js/init.min.js', __FILE__), array('jquery', 'modernizr', 'imagescroll'));
          wp_enqueue_script('vc_parallax_cq_script');


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          if(strpos($content, '[/parallaxitem]')===false){
              $content = str_replace('</div>', '', trim($content));
              $contentarr = explode('<div class="parallax-content">', trim($content));
          }else{
              $content = str_replace('[/parallaxitem]', '', trim($content));
              $contentarr = explode('[parallaxitem]', trim($content));
          }

          $imagesarr = explode(',', $images);
          $customlinkarr  = explode(',', $custom_links);
          $output = '';
          $output .= '<div class="cq-parallaxcontainer '.$extra_class.'"  data-speed="'.$speed.'" data-coverratio="'.$coverratio.'" data-holderminheight="'.$holderminheight.'" data-holdermaxheight="'.$holdermaxheight.'" data-extraheight="'.$extraheight.'" data-target="'.$custom_links_target.'">';
          $i = -1;
          $imagewidth = null;
          foreach ($imagesarr as $key => $image) {
              $i++;
              if(!isset($contentarr[$i+1])) $contentarr[$i+1] = '';
              if(!isset($customlinkarr[$i])) $customlinkarr[$i] = '';
              if(wp_get_attachment_image_src(trim($image), 'full')){
                  $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');
                  $img = $thumbnail = "";

                  $fullimage = $return_img_arr[0];
                  $thumbnail = $fullimage;
                  if($mobilewidth!=""){
                      if(function_exists('wpb_resize')){
                          $img = wpb_resize($image, null, $mobilewidth, null);
                          $thumbnail = $img['url'];
                          if($thumbnail=="") $thumbnail = $fullimage;
                      }
                  }


                  if($textfirst=="on"){
                      if($contentarr[$i+1]!=""){
                          $output .= '<section class="cq-parallaxsection" style="color:'.$textcolor.';background:'.$textbackground.';padding:'.$padding.';">';
                          $output .= $contentarr[$i+1];
                          $output .= '</section>';
                      }
                      $output .= '<div class="cq-parallaximage" data-image="'.$return_img_arr[0].'" data-width="'.$return_img_arr[1].'" data-height="'.$return_img_arr[2].'" data-image-mobile="'.$thumbnail.'" data-link="'.$customlinkarr[$i].'"></div>';
                  }else{
                      $output .= '<div class="cq-parallaximage" data-image="'.$return_img_arr[0].'" data-width="'.$return_img_arr[1].'" data-height="'.$return_img_arr[2].'" data-image-mobile="'.$thumbnail.'" data-link="'.$customlinkarr[$i].'"></div>';
                      if($contentarr[$i+1]!=""){
                          $output .= '<section class="cq-parallaxsection" style="color:'.$textcolor.';background:'.$textbackground.';padding:'.$padding.';">';
                          $output .= $contentarr[$i+1];
                          $output .= '</section>';
                      }
                  }

              }
          }
          $output .= '</div>';
          return $output;

        }


  }


}

?>
