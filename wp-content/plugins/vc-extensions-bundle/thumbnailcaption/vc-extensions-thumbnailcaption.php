<?php
if (!class_exists('VC_Extensions_CQThumbnailCaption')) {

    class VC_Extensions_CQThumbnailCaption {
        function __construct() {
          vc_map(array(
            "name" => esc_attr__("Thumbnail with Caption", 'vc_thumbnailcaption_cq'),
            "base" => "cq_vc_thumbnailcaption",
            "class" => "wpb_cq_vc_extension_thumbcaption",
            "controls" => "full",
            "icon" => "cq_allinone_thumbcaption",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('image, caption and button', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Thumbnail(s):", "vc_thumbnailcaption_cq"),
                "param_name" => "images",
                "value" => "",
                "group" => "Thumbnail(s)",
                "description" => esc_attr__("Select images from media library. You can specify a width for them under the General tab.", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail height", "vc_thumbnailcaption_cq"),
                "param_name" => "minheight",
                "value" => "150",
                "group" => "Thumbnail(s)",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail height in small screen device (like iPhone)", "vc_thumbnailcaption_cq"),
                "param_name" => "smallheight",
                "value" => "100",
                "group" => "Thumbnail(s)",
                "description" => esc_attr__("The thumbnail maybe too high in small screen view, we need a height for the small screen here to trigger the responsive feature.", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_thumbnailcaption_cq",
                "heading" => esc_attr__("Thumbnail position:", "vc_thumbnailcaption_cq"),
                "param_name" => "imageposition",
                "value" => array(esc_attr__("left", "vc_thumbnailcaption_cq") => "left", esc_attr__("right", "vc_thumbnailcaption_cq") => "right", esc_attr__("top", "vc_thumbnailcaption_cq") => "top", esc_attr__("bottom", "vc_thumbnailcaption_cq") => "bottom"),
                "group" => "Thumbnail(s)",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_thumbnailcaption_cq",
                "heading" => esc_attr__("Thumbnail on click", "vc_thumbnailcaption_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("Open lightbox", "vc_thumbnailcaption_cq") => "lightbox", esc_attr__("Do nothing", "vc_thumbnailcaption_cq") => "", esc_attr__("Open custom link", "vc_thumbnailcaption_cq") => "customlink"),
                "group" => "Thumbnail(s)",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__("Custom link for the image:", "vc_thumbnailcaption_cq"),
                "param_name" => "thumbnaillink",
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Thumbnail(s)",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optional caption title", "vc_thumbnailcaption_cq"),
                "param_name" => "captiontitle",
                "group" => "Caption",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title font size", "vc_thumbnailcaption_cq"),
                "param_name" => "titlesize",
                "group" => "Caption",
                "description" => esc_attr__("CSS font-size for the title, default is 1.2em.", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Optional caption content", "vc_thumbnailcaption_cq"),
                "param_name" => "caption",
                "group" => "Caption",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Optional font color for the caption:", 'vc_thumbnailcaption_cq'),
                "param_name" => "captioncolor",
                "value" => '',
                "group" => "Caption",
                "description" => esc_attr__("", 'vc_thumbnailcaption_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Optional background for the caption:", 'vc_thumbnailcaption_cq'),
                "param_name" => "backgroundcolor",
                "value" => '#efefef',
                "group" => "Caption",
                "description" => esc_attr__("Default is gray #efefef.", 'vc_thumbnailcaption_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optional button under caption", "vc_thumbnailcaption_cq"),
                "param_name" => "captionbutton",
                "group" => "Caption",
                "description" => esc_attr__("", "vc_thumbnailcaption_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'Button link', 'vc_thumbnailcaption_cq' ),
                'param_name' => 'buttonlink',
                "group" => "Caption",
                'description' => esc_attr__( 'Link for the button under caption.', 'vc_thumbnailcaption_cq' )
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Optional background color for the button:", 'vc_thumbnailcaption_cq'),
                "param_name" => "buttonbg",
                "value" => '',
                "group" => "Caption",
                "description" => esc_attr__("", 'vc_thumbnailcaption_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Optional hover background color for the button:", 'vc_thumbnailcaption_cq'),
                "param_name" => "buttonhoverbg",
                "value" => '',
                "group" => "Caption",
                "description" => esc_attr__("", 'vc_thumbnailcaption_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Auto play speed of the thumbnail carousel.", "vc_thumbnailcaption_cq"),
                "param_name" => "autoplayspeed",
                "value" => "4000",
                "description" => esc_attr__("The speed of the auto play slideshow of the thumbnails, default is 4000, stands for 4 seconds.", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize the original image to this width for the thumbnail:", "vc_thumbnailcaption_cq"),
                "param_name" => "imagewidth",
                "value" => "480",
                "description" => esc_attr__("You can specify a larger value (for example, your container is 320, then 640 width here) to get retina view.", "vc_thumbnailcaption_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_thumbnailcaption_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it is in your css file.", "vc_thumbnailcaption_cq")
              )

           )
        ));

        add_shortcode('cq_vc_thumbnailcaption', array($this,'cq_vc_thumbnailcaption_func'));
      }

      function cq_vc_thumbnailcaption_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            'images' => '',
            'imageposition' => 'left',
            'captiontitle' => '',
            'caption' => '',
            'captionbutton' => '',
            'buttonlink' => '',
            'minheight' => '150',
            'imagewidth' => '480',
            'buttonbg' => '',
            'buttonhoverbg' => '',
            'thumbnaillink' => '',
            'smallheight' => '100',
            'backgroundcolor' => '#efefef',
            'captioncolor' => '',
            'autoplayspeed' => '4000',
            'onclick' => 'lightbox',
            'titlesize' => '',
            'extra_class' => ''
          ), $atts));


          wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
          wp_enqueue_style('slick');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');

          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('slick');

          wp_register_style('vc-extensions-thumbnailcaption-style', plugins_url('css/style.css', __FILE__), array('fs.boxer'));
          wp_enqueue_style('vc-extensions-thumbnailcaption-style');

          wp_register_script('vc-extensions-thumbnailcaption-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-thumbnailcaption-script');


          $i = -1;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          $imagesarr = explode(',', $images);
          $buttonlink = vc_build_link($buttonlink);
          $thumbnaillink = vc_build_link($thumbnaillink);
          $container_start = $container_end = '';
          $link_start = $link_end = '';
          $image_content = $caption_content =  '';
          $output = '';
          $container_start .= '<div class="cq-cards-container '.$imageposition.'" data-imageposition="'.$imageposition.'" data-minheight="'.$minheight.'" data-smallheight="'.$smallheight.'" data-backgroundcolor="'.$backgroundcolor.'" data-captioncolor="'.$captioncolor.'" data-autoplayspeed="'.$autoplayspeed.'" data-buttonbg="'.$buttonbg.'" data-buttonhoverbg="'.$buttonhoverbg.'" data-titlesize="'.$titlesize.'">';
          $image_content .= '<div class="card-image-container '.$imageposition.'">';
          $image_content .= '<div class="card-image">';
            foreach ($imagesarr as $key => $image) {
                $attachment = get_post($image);
                $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');
                $img = $thumbnail = "";
                $fullimage = $return_img_arr[0];
                $thumbnail = $fullimage;
                if($imagewidth!=""){
                    if(function_exists('wpb_resize')){
                        $img = wpb_resize($image, null, $imagewidth, null, true);
                        $thumbnail = $img['url'];
                        if($thumbnail=="") $thumbnail = $fullimage;
                    }
                }

                $image_content .= '<div>';
                if($onclick=="lightbox"){
                  $image_content .= '<a href="'.$return_img_arr[0].'" class="cq-thumb-lightbox">';
                  $image_content .= '<img src="'.$thumbnail.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                  $image_content .= '</a>';
                }else if($onclick=="customlink"){
                  $image_content .= '<a href="'.$thumbnaillink['url'].'" title="'.$thumbnaillink['title'].'" target="'.$thumbnaillink['target'].'">';
                  $image_content .= '<img src="'.$thumbnail.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                  $image_content .= '</a>';
                }else{
                  $image_content .= '<img src="'.$thumbnail.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                }
                $image_content .= '</div>';
            }

          $image_content .= '</div>';
          $image_content .= '</div>';
          $caption_content .= '<div class="card-caption-container '.$imageposition.'">';
          $caption_content .= '<div class="caption-content">';
          if($captiontitle!="") $caption_content .= '<h3>'.$captiontitle.'</h3>';
          if($caption!="") $caption_content .= '<p class="caption">'.$caption.'</p>';
          if($captionbutton!="") {
            $caption_content .= '<a href="'.$buttonlink['url'].'" title="'.$buttonlink['title'].'" target="'.$buttonlink['target'].'">';
            $caption_content .= '<span class="cq-button">'.$captionbutton.'</span>';
            $caption_content .= '</a>';

          }
          $caption_content .= '</div>'; // end of caption-content
          $caption_content .= '</div>'; // end of card-caption-container
          $container_end .= '</div>';
          $output .= $container_start.$link_start;
          if($imageposition=="left" || $imageposition=="top"){
            $output .= $image_content.$caption_content;
          }else if($imageposition=="right" || $imageposition=="bottom"){
            $output .= $caption_content.$image_content;
          }
          $output .= $link_end.$container_end;

          return $output;

        }



  }

}

?>
