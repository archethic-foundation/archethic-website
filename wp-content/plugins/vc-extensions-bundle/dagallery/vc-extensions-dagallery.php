<?php
if (!class_exists('VC_Extensions_DAGallery')) {
    class VC_Extensions_DAGallery {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("DA Gallery", 'vc_dagallery_cq'),
            "base" => "cq_vc_dagallery",
            "class" => "wpb_cq_vc_extension_dagallery",
            "controls" => "full",
            "icon" => "cq_allinone_dagallery",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__( 'Direction-aware gallery', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Images", "vc_dagallery_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_dagallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Gallery width", "vc_dagallery_cq"),
                "param_name" => "gallerywidth",
                "value" => esc_attr__("80%", 'vc_dagallery_cq'),
                "description" => esc_attr__("Set the gallery width here, a percent value(responsive) or a fixed width like 800px", "vc_dagallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail width", "vc_dagallery_cq"),
                "param_name" => "width",
                "value" => esc_attr__("240", 'vc_dagallery_cq'),
                "description" => esc_attr__("", "vc_dagallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail height", "vc_dagallery_cq"),
                "param_name" => "height",
                "value" => esc_attr__("180", 'vc_dagallery_cq'),
                "description" => esc_attr__("", "vc_dagallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail magin", "vc_dagallery_cq"),
                "param_name" => "margin",
                "value" => "5px",
                "description" => esc_attr__("Each thumbnail margin, default is 5px", "vc_dagallery_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_dagallery_cq",
                "heading" => esc_attr__("Thumbnail title", 'vc_dagallery_cq'),
                "param_name" => "thumbtitle",
                "value" => esc_attr__("Thumbnail title", 'vc_dagallery_cq'),
                "description" => esc_attr__("Enter title for each thumbnail here. Divide each with linebreaks (Enter).", 'vc_dagallery_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_dagallery_cq",
                "heading" => esc_attr__("Thumbnail description", 'vc_dagallery_cq'),
                "param_name" => "thumbdesc",
                "value" => esc_attr__("Thumbnail description", 'vc_dagallery_cq'),
                "description" => esc_attr__("Enter description for each thumbnail here. Divide each with linebreaks (Enter).", 'vc_dagallery_cq')
              ),
              array(
                "type" => "colorpicker",
                "heading" => esc_attr__("Caption text color", "vc_dagallery_cq"),
                "param_name" => "color",
                "value" => "#FFFFFF",
                "description" => esc_attr__("Select color for the caption", "vc_dagallery_cq")
              ),
              array(
                "type" => "colorpicker",
                "heading" => esc_attr__("Caption background color", "vc_dagallery_cq"),
                "param_name" => "background",
                "value" => "#00BFFF",
                "description" => esc_attr__("Select color for the caption background", "vc_dagallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Caption background opacity", "vc_dagallery_cq"),
                "param_name" => "opacity",
                "value" => "0.8",
                "description" => esc_attr__("", "vc_dagallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Caption padding", "vc_dagallery_cq"),
                "param_name" => "padding",
                "value" => "20px",
                "description" => esc_attr__("Caption padding, default is 20px", "vc_dagallery_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_dagallery_cq",
                "heading" => esc_attr__("On click", "vc_dagallery_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("open large image (lightbox)", "vc_dagallery_cq") => "link_image", esc_attr__("Open custom link", "vc_dagallery_cq") => "custom_link", esc_attr__("Do nothing", "vc_dagallery_cq") => "link_no"),
                "description" => esc_attr__("Define action for onclick event if needed.", "vc_dagallery_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("Custom links", "vc_dagallery_cq"),
                "param_name" => "custom_links",
                "description" => esc_attr__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'vc_dagallery_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Custom link target", "vc_dagallery_cq"),
                "param_name" => "custom_links_target",
                "description" => esc_attr__('Select where to open  custom links.', 'vc_dagallery_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
                'value' => array(esc_attr__("Same window", "vc_dagallery_cq") => "_self", esc_attr__("New window", "vc_dagallery_cq") => "_blank")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_dagallery_cq",
                "heading" => esc_attr__("Make the thumbnails retina?", 'vc_dagallery_cq'),
                "param_name" => "retina",
                "value" => array(esc_attr__("Yes", "vc_dagallery_cq") => 'on'),
                "description" => esc_attr__("For example a 640x480 thumbnail will display as 320x240 in retina mode.", 'vc_dagallery_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the thumbnail", "vc_dagallery_cq"),
                "param_name" => "thumb_class",
                "description" => esc_attr__("You can append extra class to the thumbnail (li tag here).", "vc_dagallery_cq")
              )
            )

        ));

        vc_map( array(
            "name" => esc_attr__("Fluidbox", 'vc_fluidbox_cq'),
            "base" => "cq_vc_fluidbox",
            "class" => "wpb_cq_vc_extension_fluidbox",
            "controls" => "full",
            "icon" => "cq_allinone_fluidbox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Image with smooth lightbox', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__('Background Image', 'vc_fluidbox_cq'),
                "param_name" => "fluidimage",
                "description" => esc_attr__("Select an image", "vc_fluidbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail width", "vc_fluidbox_cq"),
                "param_name" => "thumbwidth",
                "value" => esc_attr__("240", 'vc_fluidbox_cq'),
                "description" => esc_attr__("", "vc_fluidbox_cq")
              ),
              array(
                  "type" => "dropdown",
                  "heading" => esc_attr__("Image float:", "vc_fluidbox_cq"),
                  "param_name" => "float",
                  "description" => esc_attr__('', 'vc_fluidbox_cq'),
                  "value" => array(esc_attr__("none", "vc_fluidbox_cq") => 'none', esc_attr__("left", "vc_fluidbox_cq") => 'left', esc_attr__("right", "vc_fluidbox_cq") => 'right')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Margin", "vc_fluidbox_cq"),
                "param_name" => "margin",
                "value" => esc_attr__("0 12px 0 12px", 'vc_fluidbox_cq'),
                "description" => esc_attr__("The CSS margin value of the image, use it to control the image's position related to float.", "vc_fluidbox_cq")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_fluidbox_cq",
                "heading" => esc_attr__("Make the thumbnails retina?", 'vc_fluidbox_cq'),
                "param_name" => "retina",
                "value" => array(esc_attr__("Yes", "vc_fluidbox_cq") => 'on'),
                "description" => esc_attr__("For example a 640x480 thumbnail will display as 320x240 in retina mode.", 'vc_fluidbox_cq')
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Text", "vc_fluidbox_cq"),
                "param_name" => "content",
                "value" => esc_attr__("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "vc_fluidbox_cq")
              )
            )
        ));

          add_shortcode('cq_vc_dagallery', array($this,'cq_vc_dagallery_func'));
          add_shortcode('cq_vc_fluidbox', array($this,'cq_vc_fluidbox_func'));
      }

      function cq_vc_dagallery_func($atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'images' => '',
            'thumbtitle' => '',
            'thumbdesc' => '',
            'gallerywidth' => '80%',
            'width' => '240',
            'height' => '168',
            'color' => '#FFFFFF',
            'background' => '#00BFFF',
            'opacity' => '0.8',
            'padding' => '20px',
            'margin' => '5px',
            'thumb_class' => '',
            'retina' => 'off',
            'onclick' => 'link_image',
            'custom_links' => '',
            'custom_links_target' => '_self'
          ), $atts ) );

          wp_register_style( 'dagallery_style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'dagallery_style' );


          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');
          $custom_links = explode( ',', $custom_links);

          wp_register_script('dagallery', plugins_url('js/jquery.gallery.min.js', __FILE__), array('jquery', 'fs.boxer'));
          wp_enqueue_script('dagallery');

          $imagesarr = explode(',', $images);
          $thumbtitles = explode( ',', $thumbtitle);
          $thumbdescs = explode( ',', $thumbdesc);



          global $post;
          $gallery_id = $post->ID.rand(0, 100);


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $link_start = '';
          $output = '';
          $output .= '<div class="cq-dagallery-container" style="width:'.$gallerywidth.';margin:0 auto;">';
          $output .= '<ul class="cq-dagallery" data-gallerywidth="'.$gallerywidth.'" data-width="'.$width.'" data-height="'.$height.'" data-color="'.$color.'" data-background="'.$background.'" data-opacity="'.$opacity.'">';
          $i = -1;
          foreach ($imagesarr as $key => $value) {
              $i++;
              if($i<count($thumbtitles)){
                $thumb_title = $thumbtitles[$i];
              }else{
                $thumb_title = '';
              }
              if($i<count($thumbdescs)){
                $thumb_desc = $thumbdescs[$i];
              }else{
                $thumb_desc = '';
              }

              if(wp_get_attachment_image_src(trim($value), 'full')){
                $attachment = get_post($value);
                $return_img_arr = wp_get_attachment_image_src(trim($value), 'full');
                $img = $thumbnail = "";

                $fullimage = $return_img_arr[0];
                $thumbnail = $fullimage;
                if($width!=""){
                    if(function_exists('wpb_resize')){
                        $img = wpb_resize($value, null, $retina=="on"?$width*2:$width, $retina=="on"?$height*2:$height);
                        $thumbnail = $img['url'];
                        if($thumbnail=="") $thumbnail = $fullimage;
                    }
                }

                $output .= '<li class="'.$thumb_class.'" data-width="'.$width.'" data-height="'.$height.'" data-margin="'.$margin.'" style="margin:'.$margin.'">';
                if($onclick=='link_image'){
                  $output .= '<a class="normal" href="'.$return_img_arr[0].'" rel="'.$gallery_id.'">';
                }else if($onclick=='custom_link'){
                  if($i<count($custom_links)){
                    $output .= "<a href='".$custom_links[$i]."' target='".$custom_links_target."'>";
                  }
                }else{
                  $link_start .= "<a href='#'>";
                }

                $output .= "<img src='".$thumbnail."' width='".$width."' height='".$height."' alt='".get_post_meta($attachment->ID, "_wp_attachment_image_alt", true )."' />";
                $output .= '</a>';
                $output .= '<div class="dagallery-info" style="padding:'.$padding.';color:'.$color.';background-color:'.$background.'">';
                if($thumb_title!="") $output .= "<h3>".$thumb_title."</h3>";
                if($thumb_desc!="") $output .= "<p>".$thumb_desc."</p>";
                $output .= '';
                $output .= '';
                $output .= '</div>';
                $output .= '</li>';
              }
          }

          $output .= '</ul>';
          $output .= '</div>';
          return $output;

        }

        function cq_vc_fluidbox_func($atts, $content=null) {
          extract( shortcode_atts( array(
            'fluidimage' => '',
            'thumbwidth' => '240',
            'float' => 'none',
            'retina' => 'off',
            'margin' => '0 12px 0 12px'
          ), $atts ) );

          wp_register_script('fluidbox', plugins_url('../mediumgallery/js/jquery.fluidbox.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fluidbox');
          wp_enqueue_script('fluidbox_init', plugins_url('js/fluidbox_init.js', __FILE__), array('jquery'));
          wp_register_style( 'fluidbox', plugins_url('../mediumgallery/css/fluidbox.min.css', __FILE__) );
          wp_enqueue_style( 'fluidbox' );

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = "";
          $image_alt = "";
          $fluid_image_attachment = get_post($fluidimage);
          $image_alt = get_post_meta($fluid_image_attachment->ID, '_wp_attachment_image_alt', true );
          $fluid_image = wp_get_attachment_image_src($fluidimage, 'full');
          $img = $thumbnail = "";

          $fullimage = $fluid_image[0];
          $thumbnail = $fullimage;
          if($thumbwidth!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($fluidimage, null, $retina=="on"?$thumbwidth*2:$thumbwidth, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage;
              }
          }

          if($fluidimage==""){
            $output .= '<a href="'.plugins_url('img/blank_image.jpg', __FILE__).'" class="fluidbox-image" data-margin="'.$margin.'" data-float="'.$float.'">';
            $output .= '<img src="'.plugins_url('img/blank_image.jpg', __FILE__).'" style="float:'.$float.';margin:'.$margin.'" width="'.$thumbwidth.'" alt="'.$image_alt.'" />';
          }else{
            $output .= '<a href="'.$fluid_image[0].'" class="fluidbox-image" data-margin="'.$margin.'" data-float="'.$float.'">';
            $output .= '<img src="'.$thumbnail.'" width="'.$thumbwidth.'" style="float:'.$float.';margin:'.$margin.'" alt="'.$image_alt.'" />';
          }
          $output .= '</a>';
          $output .= $content;
          return $output;

        }



  }



}

?>
