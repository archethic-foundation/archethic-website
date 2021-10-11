<?php
if (!class_exists('VC_Extensions_MediumGallery')) {

    class VC_Extensions_MediumGallery {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Medium Gallery", 'vc_mediumgallery_cq'),
            "base" => "cq_vc_mediumgallery",
            "class" => "wpb_cq_vc_extension_mediumgallery",
            "controls" => "full",
            "icon" => "cq_allinone_mediumgallery",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Smooth lightbox', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Gallery Images:", "vc_mediumgallery_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Layout numbers", "vc_mediumgallery_cq"),
                "param_name" => "layoutno",
                "value" => "21343522341234232233",
                "description" => esc_attr__("Manually set a string of numbers to specify the number of images each row contains (max is 5 in a row). For example, 213 stand for there are 2, 1 and 3 images in each row. Default is a long string with a lot of numbers which suppose you'll add a lot of images, you can customize each number here.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Gutter of each image", "vc_mediumgallery_cq"),
                "param_name" => "gutter",
                "value" => "10px",
                "description" => esc_attr__("The space between the rows / columns. Default is 10px.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Gallery width", "vc_mediumgallery_cq"),
                "param_name" => "gallerywidth",
                "value" => "",
                "description" => esc_attr__("Default is 100%.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width in the thumbnail (except the container is larger than the minimal width):", "vc_mediumgallery_cq"),
                "param_name" => "thumbwidth",
                "value" => "",
                "description" => esc_attr__("Default is displaying the original image. Specify the value only, for example 640.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Minimal width of the thumbnail:", "vc_mediumgallery_cq"),
                "param_name" => "lowreswidth",
                "value" => "",
                "description" => esc_attr__("Threshold for the low resolution image, if container is larger, swap the high resolution image. Default is 500.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_mediumgallery_cq",
                "heading" => esc_attr__("Title for each image", 'vc_mediumgallery_cq'),
                "param_name" => "titles",
                "value" => esc_attr__("", 'vc_mediumgallery_cq'),
                "description" => esc_attr__("Enter title for each image here. Divide each with linebreaks (Enter), leave it to blank if you do not want it.", 'vc_mediumgallery_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_mediumgallery_cq",
                "heading" => esc_attr__("Alt for each image", 'vc_mediumgallery_cq'),
                "param_name" => "alts",
                "value" => esc_attr__("", 'vc_mediumgallery_cq'),
                "description" => esc_attr__("Enter alt for each image here. Divide each with linebreaks (Enter), leave it to blank if you do not want it.", 'vc_mediumgallery_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the thumbnail", "vc_mediumgallery_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("You can append extra class to the container.", "vc_mediumgallery_cq")
              )

            )
        ));

        add_shortcode('cq_vc_mediumgallery', array($this,'cq_vc_mediumgallery_func'));

      }

      function cq_vc_mediumgallery_func($atts, $content=null, $tag) {
          $background = "";
          extract( shortcode_atts( array(
            'images' => '',
            'gallerywidth' => '',
            'thumbwidth' => '',
            'lowreswidth' => '',
            'background' => '',
            'gutter' => 'gutter',
            'extra_class' => '',
            'titles' => '',
            'alts' => '',
            'layoutno' => '21343522341234232233'
            ), $atts ) );

          wp_register_style( 'vc_mediumgallery_cq_style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc_mediumgallery_cq_style' );

          wp_register_script('photosetgrid', plugins_url('js/jquery.photosetgrid.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('photosetgrid');

          wp_register_script('fluidbox', plugins_url('js/jquery.fluidbox.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fluidbox');
          wp_register_style( 'fluidbox', plugins_url('css/fluidbox.min.css', __FILE__) );
          wp_enqueue_style( 'fluidbox' );

          wp_register_script('photosetgrid_init', plugins_url('js/init.min.js', __FILE__), array("jquery", "photosetgrid", "fluidbox"));
          wp_enqueue_script('photosetgrid_init');

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $imagesarr = explode(',', $images);
          $titlearr = explode(',', $titles);
          $altarr = explode(',', $alts);
          $i = -1;
          $output = '';
          $output .= '<div class="cq-medium-gallery" data-gallerywidth="'.$gallerywidth.'" data-background="'.$background.'" data-layoutno="'.$layoutno.'" data-lowreswidth="'.$lowreswidth.'" data-gutter="'.$gutter.'" style="margin:0 auto;">';
              foreach ($imagesarr as $key => $image) {
                $i++;
                if(!isset($titlearr[$i])) $titlearr[$i] = '';
                if(!isset($altarr[$i])) $altarr[$i] = '';
                if(wp_get_attachment_image_src(trim($image), 'full')){
                    $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');

                    $img = $thumbnail = "";
                    $fullimage = $return_img_arr[0];
                    $thumbnail = $fullimage;
                    if($thumbwidth!=""){
                        if(function_exists('wpb_resize')){
                            $img = wpb_resize($image, null, $thumbwidth, null);
                            $thumbnail = $img['url'];
                            if($thumbnail=="") $thumbnail = $fullimage;
                        }
                    }

                    $output .= '<img src="'.$thumbnail.'" data-highres="'.$return_img_arr[0].'" class="mediumgallery-img '.$extra_class.'" title="'.$titlearr[$i].'" alt="'.$altarr[$i].'" />';

                }
              }
          $output .= '</div>';

          return $output;

        }


  }

}

?>
