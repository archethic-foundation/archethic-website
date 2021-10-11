<?php
if (!class_exists('VC_Extensions_CQCarousel')) {

    class VC_Extensions_CQCarousel {
        function __construct() {
          vc_map(array(
            "name" => esc_attr__("Carousel & Gallery", 'vc_cqcarousel_cq'),
            "base" => "cq_vc_cqcarousel",
            "class" => "wpb_cq_vc_extension_carouselgallery",
            "controls" => "full",
            "icon" => "cq_allinone_carouselgallery",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('with slideshow', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Display the image as", "vc_cqcarousel_cq"),
                "param_name" => "displaystyle",
                "value" => array(esc_attr__("Carousel (you can choose lightbox below)", "vc_cqcarousel_cq") => "carousel", esc_attr__("Gallery (large image on the top, small thumbnail on the bottom)", "vc_cqcarousel_cq") => "gallery"),
                "description" => esc_attr__("You can how to display the images.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Images:", "vc_cqcarousel_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Display how many thumbnails in the row:", "vc_cqcarousel_cq"),
                "param_name" => "slidestoshow",
                "value" => "5",
                "dependency" => Array('element' => "displaystyle", 'value' => array('carousel')),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Display how many thumbnails in the row:", "vc_cqcarousel_cq"),
                "param_name" => "thumbstoshow",
                "value" => "7",
                "dependency" => Array('element' => "displaystyle", 'value' => array('gallery')),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Resize the image?", "vc_cqcarousel_cq"),
                "param_name" => "isresize1",
                "value" => array(esc_attr__("Yes (customize the size below)", "vc_cqcarousel_cq") => "yes", esc_attr__("No", "vc_cqcarousel_cq") => "no"),
                "std" => "no",
                "dependency" => Array('element' => "displaystyle", 'value' => array('carousel')),
                "description" => esc_attr__("Note, the resize function may not compatible with some server, it will save resized image to the server.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width in thumbnail", "vc_cqcarousel_cq"),
                "param_name" => "thumbwidth1",
                "value" => "320",
                "dependency" => Array('element' => "isresize1", 'value' => array('yes')),
                "description" => esc_attr__("The thumbnail size depends on how many thumbnails will be display in above setting, you can specify the size with larger value to get retina thumbnail.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this height in thumbnail", "vc_cqcarousel_cq"),
                "param_name" => "thumbheight1",
                "value" => "200",
                "dependency" => Array('element' => "isresize1", 'value' => array('yes')),
                "description" => esc_attr__("The thumbnail size depends on how many thumbnails will be display in above setting, you can specify the size with larger value to get retina thumbnail.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Resize the image?", "vc_cqcarousel_cq"),
                "param_name" => "isresize2",
                "value" => array(esc_attr__("Yes (customize the size below)", "vc_cqcarousel_cq") => "yes", esc_attr__("No", "vc_cqcarousel_cq") => "no"),
                "std" => "no",
                "dependency" => Array('element' => "displaystyle", 'value' => array('gallery')),
                "description" => esc_attr__("Note, the resize function may not compatible with some server, it will save resized image to the server.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width in thumbnail", "vc_cqcarousel_cq"),
                "param_name" => "thumbwidth2",
                "value" => "120",
                "dependency" => Array('element' => "isresize2", 'value' => array('yes')),
                "description" => esc_attr__("The thumbnail size depends on how many thumbnails will be display in above setting, you can specify the size with larger value to get retina thumbnail.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this height in thumbnail", "vc_cqcarousel_cq"),
                "param_name" => "thumbheight2",
                "value" => "80",
                "dependency" => Array('element' => "isresize2", 'value' => array('yes')),
                "description" => esc_attr__("The thumbnail size depends on how many thumbnails will be display in above setting, you can specify the size with larger value to get retina thumbnail.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Optional tooltip for each thumbnail", 'vc_cqcarousel_cq'),
                "param_name" => "tooltips",
                "value" => esc_attr__("", 'vc_cqcarousel_cq'),
                "description" => esc_attr__("Optional tooltip for each thumbnail, divide with linebreak (Enter). Leave it to be blank if you do not want it.", 'vc_cqcarousel_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Thumbnail on click", "vc_cqcarousel_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("Open lightbox", "vc_cqcarousel_cq") => "lightbox", esc_attr__("Do nothing", "vc_cqcarousel_cq") => "", esc_attr__("Open custom link", "vc_cqcarousel_cq") => "customlink"),
                "std" => "lightbox",
                "dependency" => Array('element' => "displaystyle", 'value' => array('carousel')),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Select lightbox mode", "vc_cqcarousel_cq"),
                "param_name" => "lightboxmode",
                "value" => array(esc_attr__("prettyPhoto", "vc_cqcarousel_cq") => "prettyphoto", esc_attr__("boxer", "vc_cqcarousel_cq") => "boxer"),
                "std" => "prettyphoto",
                "dependency" => Array('element' => "onclick", 'value' => array('lightbox')),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Custom link for each thumbnail", 'vc_cqcarousel_cq'),
                "param_name" => "customlinks",
                "value" => esc_attr__("", 'vc_cqcarousel_cq'),
                "dependency" => Array('element' => "displaystyle", 'value' => array('carousel')),
                "description" => esc_attr__("Divide with linebreak (Enter), available with open custom link option.", 'vc_cqcarousel_cq')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Custom link target", "vc_cqcarousel_cq"),
                "param_name" => "customlinktarget",
                "description" => esc_attr__('Select how to open custom link.', 'vc_cqcarousel_cq'),
                "dependency" => Array('element' => "displaystyle", 'value' => array('carousel')),
                'value' => array(esc_attr__("Same window", "vc_cqcarousel_cq") => "_self", esc_attr__("New window", "vc_cqcarousel_cq") => "_blank")
              ),

              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Display dot navigation under thumbnails?", "vc_cqcarousel_cq"),
                "param_name" => "dots",
                "value" => array(esc_attr__("yes", "vc_cqcarousel_cq") => "yes", esc_attr__("no", "vc_cqcarousel_cq") => "no"),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Display arrow navigation for the thumbnails?", "vc_cqcarousel_cq"),
                "param_name" => "arrows",
                "value" => array(esc_attr__("yes", "vc_cqcarousel_cq") => "yes", esc_attr__("no", "vc_cqcarousel_cq") => "no"),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Display arrow navigation for the large image in gallery mode?", "vc_cqcarousel_cq"),
                "param_name" => "largeimagearrows",
                "value" => array(esc_attr__("yes", "vc_cqcarousel_cq") => "yes", esc_attr__("no", "vc_cqcarousel_cq") => "no"),
                "dependency" => Array('element' => "displaystyle", 'value' => array('gallery')),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),

              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cqcarousel_cq",
                "heading" => esc_attr__("Auto delay slideshow?", "vc_cqcarousel_cq"),
                "param_name" => "autoplay",
                "value" => array(esc_attr__("no", "vc_cqcarousel_cq") => "no", esc_attr__("yes", "vc_cqcarousel_cq") => "yes"),
                "description" => esc_attr__("", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Autoplay speed in milliseconds", "vc_cqcarousel_cq"),
                "param_name" => "autoplayspeed",
                "value" => "4000",
                "dependency" => Array('element' => "autoplay", 'value' => array('yes')),
                "description" => esc_attr__("The speed of the auto delay slideshow, default is 4000, which stand for 4 seconds.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the container:", "vc_cqcarousel_cq"),
                "param_name" => "containerwidth",
                "value" => "",
                "description" => esc_attr__("The width of the whole container, defautl is 100%. You can specify a smaller value like 80%. It will be align center automatically.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("max-width of the container:", "vc_cqcarousel_cq"),
                "param_name" => "containermaxwidth",
                "value" => "",
                "description" => esc_attr__("The max-width of the whole container, defautl is 960px.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS bottom of the dot navigation", "vc_cqcarousel_cq"),
                "param_name" => "dotbottom",
                "value" => "",
                "description" => esc_attr__("The CSS bottom value of the dot navigation, default is a value like -48px in VC4.3+, you can specify a different value to control it's position in some themes, otherwise leave it to be blank.", "vc_cqcarousel_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_cqcarousel_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_cqcarousel_cq")
             )

           )
       ));

       add_shortcode('cq_vc_cqcarousel', array($this,'cq_vc_cqcarousel_func'));
      }

      function cq_vc_cqcarousel_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            'images' => '',
            'displaystyle' => 'carousel',
            'isresize1' => 'no',
            'isresize2' => 'no',
            'thumbwidth1' => '320',
            'thumbheight1' => '200',
            'thumbwidth2' => '80',
            'thumbheight2' => '80',
            'onclick' => 'lightbox',
            'imagewidth' => '',
            'slidestoshow' => '5',
            'thumbstoshow' => '7',
            'dots' => '',
            'arrows' => 'yes',
            'largeimagearrows' => 'yes',
            'customlinks' => '',
            'customlinktarget' => '',
            'autoplay' => '',
            'autoplayspeed' => '4000',
            'containerwidth' => '',
            'containermaxwidth' => '',
            'tooltips' => '',
            'dotbottom' => '',
            'lightboxmode' => 'prettyphoto',
            'extra_class' => ''
          ), $atts));

          $bottom_byversion = '';
          if (version_compare(WPB_VC_VERSION,  "4.3") == -1) {
              $bottom_byversion = "-24px";
          }

          wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
          wp_enqueue_style('slick');

          wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('slick');
          wp_register_style('vc-extensions-cqcarousel-style', plugins_url('css/style.css', __FILE__), array("slick"));
          wp_enqueue_style('vc-extensions-cqcarousel-style');

          wp_register_style('tooltipster', plugins_url('../profilecard/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');

          wp_register_style('prettyphoto', vc_asset_url( 'lib/prettyphoto/css/prettyPhoto.min.css' ), array(), WPB_VC_VERSION );
          wp_enqueue_style('prettyphoto');

          wp_register_script('tooltipster', plugins_url('../profilecard/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');
          wp_register_script('prettyphoto', vc_asset_url( 'lib/prettyphoto/js/prettyPhoto.min.js' ), array(), WPB_VC_VERSION );
          wp_enqueue_script('prettyphoto');

          wp_register_script('vc-extensions-cqcarousel-init', plugins_url('js/init.min.js', __FILE__), array("jquery", "slick", "prettyphoto"));
          wp_enqueue_script('vc-extensions-cqcarousel-init');


          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');


          $customlinks = explode( ',', $customlinks);


          $i = -1;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $imagesarr = explode(',', $images);
          $tooltips = explode(',', $tooltips);
          $thumbwidth = '';
          $thumbheight = '';
          if($displaystyle=="carousel"){
              $thumbwidth = $thumbwidth1;
              $thumbheight = $thumbheight1;
          }else{
              $thumbwidth = $thumbwidth2;
              $thumbheight = $thumbheight2;
          }

          $is_gallery = $displaystyle == "gallery" ? "is-gallery" : "";
          $output = '';

          $output .= '<div class="cqcarousel-container '.$extra_class.'" data-slidestoshow="'.$slidestoshow.'" data-thumbstoshow="'.$thumbstoshow.'" data-dots="'.$dots.'" data-arrows="'.$arrows.'" data-isgallery="'.$is_gallery.'" data-largeimagearrows="'.$largeimagearrows.'" data-autoplay="'.$autoplay.'" data-autoplayspeed="'.$autoplayspeed.'" data-containerwidth="'.$containerwidth.'" data-containermaxwidth="'.$containermaxwidth.'" data-imgnum="'.count($imagesarr).'" data-bottomversion="'.$bottom_byversion.'" data-dotbottom="'.$dotbottom.'" data-lightboxmode="'.$lightboxmode.'">';
          if($displaystyle=="gallery"){
            $output .= '<div class="carousel-gallery">';
            foreach ($imagesarr as $key => $image) {
                $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');
                $attachment = get_post($image);
                if($return_img_arr[0]){
                      $output .= '<div>';
                      $output .= '<img src="'.$return_img_arr[0].'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                      $output .= '</div>';
                }
            }

            $output .= '</div>';
          }
          $output .= '<div class="carousel-thumb '.$is_gallery.'">';
          $thumbtext = '';
          $gallery_rand_id = "prettyPhoto[rel-". get_the_ID() . '-' . rand() . "]";
          foreach ($imagesarr as $key => $image) {
              $i++;
              if(!isset($customlinks[$i])) $customlinks[$i] = '';
              if(!isset($tooltips[$i])) $tooltips[$i] = '';
              $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');
              $img = $thumbnail = "";

              $fullimage = $return_img_arr[0];
              $thumbnail = $fullimage;
              if($thumbwidth!=""){
                  if(function_exists('wpb_resize')){
                      $img = wpb_resize($image, null, $thumbwidth, $thumbheight);
                      $thumbnail = $img['url'];
                      if($thumbnail=="") $thumbnail = $fullimage;
                  }
              }

              $attachment = get_post($image);
              if($return_img_arr[0]){
                    if($onclick=="lightbox"){
                        if($displaystyle=="carousel"){
                            $thumbtext .= '<div title="'.$tooltips[$i].'">';
                            if($lightboxmode=="prettyphoto"){
                                $thumbtext .= '<a href="'.$return_img_arr[0].'" class="cqcarousel-item" data-rel="'.$gallery_rand_id.'" rel="'.$gallery_rand_id.'">';
                            }else{
                                $thumbtext .= '<a href="'.$return_img_arr[0].'" class="cqcarousel-item">';
                            }
                            if($isresize1=="yes"){
                                $thumbtext .= '<img src="'.$thumbnail.'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" title="'.get_the_title($attachment->ID).'" />';
                            }else{
                                $thumbtext .= '<img src="'.$return_img_arr[0].'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" title="'.get_the_title($attachment->ID).'" />';
                            }
                            $thumbtext .= '</a>';
                            $thumbtext .= '</div>';
                        }else{
                            $thumbtext .= '<div title="'.$tooltips[$i].'">';
                            if($isresize2=="yes"){
                                $thumbtext .= '<img src="'.$thumbnail.'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                            }else{
                                $thumbtext .= '<img src="'.$return_img_arr[0].'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                            }
                            $thumbtext .= '</div>';
                        }
                    }else if($onclick=="customlink"){
                        $thumbtext .= '<div title="'.$tooltips[$i].'">';
                        if($customlinks[$i]!="") $thumbtext .= '<a href="'.$customlinks[$i].'" target="'.$customlinktarget.'">';
                        if($isresize1=="yes"){
                            $thumbtext .= '<img src="'.$thumbnail.'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                        }else{
                            $thumbtext .= '<img src="'.$return_img_arr[0].'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                        }
                        if($customlinks[$i]!="") $thumbtext .= '</a>';
                        $thumbtext .= '</div>';

                    }else{
                        $thumbtext .= '<div title="'.$tooltips[$i].'">';
                        if($isresize1=="yes"){
                            $thumbtext .= '<img src="'.$thumbnail.'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                        }else{
                            $thumbtext .= '<img src="'.$return_img_arr[0].'" alt="'.get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                        }

                        $thumbtext .= '</div>';
                    }

              }
          }
          $output .= $thumbtext;
          $output .= '</div>';
          $output .= '</div>';
          return $output;

        }


  }


}

?>
