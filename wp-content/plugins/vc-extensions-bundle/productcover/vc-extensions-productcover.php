<?php
if (!class_exists('VC_Extensions_ProductCover')) {

    class VC_Extensions_ProductCover {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Product Cover", 'vc_productcover_cq'),
            "base" => "cq_vc_productcover",
            "class" => "wpb_cq_vc_extension_productcover",
            "controls" => "full",
            "icon" => "cq_allinone_productcover",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Gallery with thumbnails under it', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Cover Image:", "vc_productcover_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_productcover_cq")
              ),
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Thumbnails when user hover:", "vc_productcover_cq"),
                "param_name" => "thumbs",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_productcover_cq")
              ),

              array(
                "type" => "textfield",
                "heading" => esc_attr__("Label on the cover", "vc_productcover_cq"),
                "param_name" => "label",
                "value" => "Cover Label",
                "description" => esc_attr__("", "vc_productcover_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Label color", 'vc_productcover_cq'),
                "param_name" => "labelcolor",
                "value" => '#FFF',
                "description" => esc_attr__("", 'vc_productcover_cq')
              ),
              array(
                  "type" => "textarea_raw_html",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Optinal caption when user hover", 'vc_productcover_cq'),
                  "param_name" => "hovercaption",
                  "value" => esc_attr__("JTNDc3BhbiUyMGNsYXNzJTNEJTIydGhpbiUyMiUzRUklMjdtJTIwdGhpbiUyMCUyRiUyMCUzQyUyRnNwYW4lM0UlMjBIb3ZlciUyMExhYmVs", 'vc_productcover_cq'),
                  "description" => esc_attr__("Display this caption when user hover the image. Leave it to blank if you do not want it.", 'vc_productcover_cq')
                ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Hover caption color", 'vc_productcover_cq'),
                "param_name" => "hovercpcolor",
                "value" => '#FFF',
                "description" => esc_attr__("", 'vc_productcover_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Hover caption background color", 'vc_productcover_cq'),
                "param_name" => "hovercpbackground",
                "value" => 'rgba(0,0,0,0.4)',
                "description" => esc_attr__("", 'vc_productcover_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_productcover_cq",
                "heading" => esc_attr__("Label for each thumbnail", 'vc_productcover_cq'),
                "param_name" => "thumblabels",
                "value" => esc_attr__("thumbnail 1,thumbnail 2,another label", 'vc_productcover_cq'),
                "description" => esc_attr__("Enter label for each thumbnail here. Divide each with linebreaks (Enter), leave it to blank if you do not want it.", 'vc_productcover_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Top of thumbnails", "vc_productcover_cq"),
                "param_name" => "thumbtop",
                "value" => "75%",
                "description" => esc_attr__("The CSS top of the thumbnails. You can use it to control the position of the thumbnails, default is 75%.", "vc_productcover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize thumbnails to this width:", "vc_productcover_cq"),
                "param_name" => "thumbwidth",
                "value" => "",
                "description" => esc_attr__("Default will keep the original width of the image, you can specify a width then thumbnails will all resized to this size.", "vc_productcover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Top of caption when user hover", "vc_productcover_cq"),
                "param_name" => "captiontop",
                "value" => "40%",
                "description" => esc_attr__("The CSS top of the caption when user hover, default is 40%.", "vc_productcover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_productcover_cq",
                "heading" => esc_attr__("Thumbnail on click", "vc_productcover_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("replace large image with current thumbnail", "vc_productcover_cq") => "link_image_current", esc_attr__("open large image in lightbox", "vc_productcover_cq") => "link_image", esc_attr__("Do nothing", "vc_productcover_cq") => "link_no", esc_attr__("Open custom link", "vc_productcover_cq") => "custom_link"),
                "std" => "link_image_current",
                "description" => esc_attr__("Define action for onclick event if needed.", "vc_productcover_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("Custom links", "vc_productcover_cq"),
                "param_name" => "custom_links",
                "description" => esc_attr__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'vc_productcover_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Custom link target", "vc_productcover_cq"),
                "param_name" => "custom_links_target",
                "description" => esc_attr__('Select where to open  custom links.', 'vc_productcover_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
                'value' => array(esc_attr__("Same window", "vc_productcover_cq") => "_self", esc_attr__("New window", "vc_productcover_cq") => "_blank")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_productcover_cq",
                "heading" => esc_attr__("Do not display hover label in thumbnail in small screen.", 'vc_productcover_cq'),
                "param_name" => "nothumblabel",
                "value" => array(esc_attr__("Yes", "vc_productcover_cq") => 'on'),
                "description" => esc_attr__("You may have to check this if you have a lot of thumbnails, otherwise the label may overlay the thumbnial.", 'vc_productcover_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize cover image to this width:", "vc_productcover_cq"),
                "param_name" => "coverwidth",
                "value" => "",
                "description" => esc_attr__("You can specify a width for the cover image, default is the original image.", "vc_productcover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the container", "vc_productcover_cq"),
                "param_name" => "containerwidth",
                "value" => "100%",
                "description" => esc_attr__("The width of the whole container, default is 100%. You can specify it with a small value, like 80%, and it will be align center.", "vc_productcover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_productcover_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("You can append extra class to the container.", "vc_productcover_cq")
              )

            )
        ));

        add_shortcode('cq_vc_productcover', array($this,'cq_vc_productcover_func'));
      }

      function cq_vc_productcover_func($atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'image' => '',
            'thumbs' => '',
            'label' => '',
            'labelcolor' => '#FFF',
            'thumblabels' => '',
            'thumbtop' => '',
            'captiontop' => '',
            'hovercpcolor' => '#FFF',
            'hovercpbackground' => 'rgba(0,0,0,0.4)',
            'hovercaption' => 'JTNDc3BhbiUyMGNsYXNzJTNEJTIydGhpbiUyMiUzRUklMjdtJTIwdGhpbiUyMCUyRiUyMCUzQyUyRnNwYW4lM0UlMjBIb3ZlciUyMExhYmVs',
            'thumbmargin' => '',
            'thumbwidth' => '',
            'onclick' => 'link_image_current',
            'custom_links' => '',
            'custom_links_target' => '',
            'nothumblabel' => '',
            'containerwidth' => '100%',
            'coverwidth' => '',
            'extra_class' => ''
          ), $atts ) );


          wp_register_style( 'vc_productcover_cq_style', plugins_url('css/style.css', __FILE__));
          wp_enqueue_style( 'vc_productcover_cq_style' );

          wp_register_script('vc_productcover_cq_script', plugins_url('js/jquery.productcover.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('vc_productcover_cq_script');


          if($onclick=="link_image"){
              wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
              wp_enqueue_script('fs.boxer');
              wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
              wp_enqueue_style('fs.boxer');
          }

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $thumbsarr = explode(',', $thumbs);
          $thumblabelarr = explode(',', $thumblabels);
          $customlinkarr  = explode(',', $custom_links);
          $output = '';
          $output .= '<div class="productcover-content '.$extra_class.'" data-captiontop="'.$captiontop.'" data-thumbtop="'.$thumbtop.'" data-onclick="'.$onclick.'" data-nothumblabel="'.$nothumblabel.'" style="width:'.$containerwidth.';margin:0 auto;">';
          $output .= '<div class="productcover-box">';
          $output .= '<div class="productcover-cat">';
          $imagearr = wp_get_attachment_image_src(trim($image), 'full');

          $cover_image_temp = $coverimage = "";
          $fullimage = $imagearr[0];
          $coverimage = $fullimage;
          $cover_attachment = get_post($image);
          if($coverwidth!=""){
              if(function_exists('wpb_resize')){
                  $cover_image_temp = wpb_resize($image, null, $coverwidth, null);
                  $coverimage = $cover_image_temp['url'];
                  if($coverimage=="") $coverimage = $fullimage;
              }
          }

          $output .= '<img src="'.$coverimage.'" class="cover-image" alt="'.get_post_meta($cover_attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          $output .= '<h3 style="color:'.$labelcolor.'">'.$label.'<span class="entypo-down-open-big arrdown"></span></h3>';
          $output .= '<span class="productcover-caption"><h4 style="color:'.$hovercpcolor.';background:'.$hovercpbackground.'">';
          $output .= do_shortcode(urldecode(base64_decode($hovercaption)));
          $output .= '</h4></span>';
          $link_start = '';
          $link_end = '';
          $output .= '<ul>';
          $i = -1;
          foreach ($thumbsarr as $key => $thumb) {
            $i++;
            $link_start = '';
            $link_end = '';
            if(!isset($thumblabelarr[$i])) $thumblabelarr[$i] = '';
            if(!isset($customlinkarr[$i])) $customlinkarr[$i] = '';
            if(wp_get_attachment_image_src(trim($thumb), 'full')){
              $return_thumb_arr = wp_get_attachment_image_src(trim($thumb), 'full');
              $output .= '<li class="productcover-thumb">';
              if($onclick=="custom_link"){
                if($customlinkarr[$i]!=""){
                   $link_start = '<a href="'.$customlinkarr[$i].'" target="'.$custom_links_target.'">';
                   $link_end = '</a>';
                }
              }else if($onclick=="link_image"){
                 $link_start .= '<a href="'.$return_thumb_arr[0].'" class="productcover-link">';
                 $link_end = '</a>';
              }
              $output .= $link_start;

              $thumb_attachment = get_post($thumb);
              $thumb_image_temp = $thumbimage = "";
              $fullimage = $return_thumb_arr[0];
              $thumbimage = $fullimage;
              if($thumbwidth!=""){
                  if(function_exists('wpb_resize')){
                      $thumb_image_temp = wpb_resize($thumb, null, $thumbwidth, null);
                      $thumbimage = $thumb_image_temp['url'];
                      if($thumbimage=="") $thumbimage = $fullimage;
                  }
              }


              $output .= '<img src="'.$thumbimage.'" data-largeimage="'.$return_thumb_arr[0].'" alt="'.get_post_meta($thumb_attachment->ID, '_wp_attachment_image_alt', true ).'" />';
              $output .= $link_end;
              if($thumblabelarr[$i]!='')$output .= '<span class="thumb-caption">'.$thumblabelarr[$i].'</span>';
              $output .= '</li>';
            }
          }
          $output .= '</ul>';
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';
          return $output;

        }

  }

}

?>
