<?php
if (!class_exists('VC_Extensions_ZoomImage')) {

    class VC_Extensions_ZoomImage {
        function __construct() {
          vc_map(array(
            "name" => esc_attr__("Zoom or Magnify", 'vc_zoomimage_cq'),
            "base" => "cq_vc_zoomimage",
            "class" => "wpb_cq_vc_extension_zoommagnify",
            "controls" => "full",
            "icon" => "cq_allinone_zoommagnify",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('view image details', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_zoomimage_cq",
                "heading" => esc_attr__("Choose Zoom or Magnify", "vc_zoomimage_cq"),
                "param_name" => "displaystyle",
                "value" => array(esc_attr__("Zoom (support multiple images)", "vc_zoomimage_cq") => "zoom", esc_attr__("Magnify", "vc_zoomimage_cq") => "magnify"),
                "description" => esc_attr__("", "vc_zoomimage_cq")
              ),
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Image(s):", "vc_zoomimage_cq"),
                "param_name" => "images",
                "value" => "",
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("Select images from media library.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Container width:", "vc_zoomimage_cq"),
                "param_name" => "containerwidth",
                "value" => "100%",
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Container height:", "vc_zoomimage_cq"),
                "param_name" => "containerheight",
                "value" => "480",
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("", "vc_zoomimage_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_zoomimage_cq",
                "heading" => esc_attr__("Control (zoom, next, previous buttons) position:", "vc_zoomimage_cq"),
                "param_name" => "position",
                "value" => array(esc_attr__("bottom", "vc_zoomimage_cq") => "bottom", esc_attr__("top", "vc_zoomimage_cq") => "top", esc_attr__("left", "vc_zoomimage_cq") => "left", esc_attr__("right", "vc_zoomimage_cq") => "right"),
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("", "vc_zoomimage_cq")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_zoomimage_cq",
                "heading" => esc_attr__("Fix the left control bar size problem?", 'vc_zoomimage_cq'),
                "param_name" => "smallercontrol",
                "value" => array(esc_attr__("Yes", "vc_zoomimage_cq") => 'on'),
                "dependency" => Array('element' => "position", 'value' => array('left')),
                "description" => esc_attr__("The left control bar's size is wrong in some theme. You can try to check this to fix it.", 'vc_zoomimage_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_zoomimage_cq",
                "heading" => esc_attr__("Display the image(s) in retina?", "vc_zoomimage_cq"),
                "param_name" => "retina",
                "value" => array(esc_attr__("no", "vc_zoomimage_cq") => "no", esc_attr__("yes", "vc_zoomimage_cq") => "yes"),
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("Choose to display the image(s) in retina mode or not.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Container background color:", 'vc_zoomimage_cq'),
                "param_name" => "containerbgcolor",
                "value" => '#CCC',
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("", 'vc_zoomimage_cq')
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Container background pattern (optional)", "vc_zoomimage_cq"),
                "param_name" => "background",
                "value" => "",
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("Select images from media library.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("marginMin of the container", "vc_zoomimage_cq"),
                "param_name" => "marginmin",
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("Min bounds of the image to the container, default is 20.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("marginMax of the container", "vc_zoomimage_cq"),
                "param_name" => "marginmax",
                "dependency" => Array('element' => "displaystyle", 'value' => array('zoom')),
                "description" => esc_attr__("Max bounds of the image to the container, default is 80.", "vc_zoomimage_cq")
              ),

              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image:", "vc_zoomimage_cq"),
                "param_name" => "magnifyimage",
                "value" => "",
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("Select images from media library.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_zoomimage_cq",
                "heading" => esc_attr__("Move the glass by", "vc_zoomimage_cq"),
                "param_name" => "moveby",
                "value" => array(esc_attr__("Press it", "vc_zoomimage_cq") => "press", esc_attr__("Hover it", "vc_zoomimage_cq") => "hover"),
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Glass radius:", "vc_zoomimage_cq"),
                "param_name" => "radius",
                "value" => "50",
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("The radius size of the magnify glass.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Glass border size:", "vc_zoomimage_cq"),
                "param_name" => "bordersize",
                "value" => "4",
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("The size of the magnify glass border.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Glass Border color:", 'vc_zoomimage_cq'),
                "param_name" => "bordercolor",
                "value" => '#fff',
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("The color of the magnify glass border.", 'vc_zoomimage_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_zoomimage_cq",
                "heading" => esc_attr__("Apply gray filter to the image?", 'vc_zoomimage_cq'),
                "param_name" => "filter",
                "value" => array(esc_attr__("Yes", "vc_zoomimage_cq") => 'gray'),
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("If checked Yes, the image will be grayscale while the glass part will remain colorful.", 'vc_zoomimage_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("x position of the magnify glass by default:", "vc_zoomimage_cq"),
                "param_name" => "glassx",
                "value" => "80",
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("Same as the CSS left.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("y position of the magnify glass by default:", "vc_zoomimage_cq"),
                "param_name" => "glassy",
                "value" => "80",
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("Same as the CSS top.", "vc_zoomimage_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optinal title for the image:", "vc_zoomimage_cq"),
                "param_name" => "imagetitle",
                "value" => "",
                "dependency" => Array('element' => "displaystyle", 'value' => array('magnify')),
                "description" => esc_attr__("", "vc_zoomimage_cq")
              ),

              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_zoomimage_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_zoomimage_cq")
             )

           )
        ));

        add_shortcode('cq_vc_zoomimage', array($this,'cq_vc_zoomimage_func'));

      }

      function cq_vc_zoomimage_func($atts, $content=null, $tag) {
         extract(shortcode_atts(array(
            'images' => '',
            'background' => '',
            'containerbgcolor' => '#CCC',
            'containerwidth' => '100%',
            'containerheight' => '400',
            'position' => '',
            'retina' => '',
            'marginmax' => '80',
            'marginmin' => '20',
            'smallercontrol' => '',
            'magnifyimage' => '',
            'displaystyle' => 'zoom',
            'radius' => '50',
            'bordersize' => '4',
            'bordercolor' => '#fff',
            'glassx' => '80',
            'glassy' => '80',
            'moveby' => 'press',
            'filter' => '',
            'imagetitle' => '',
            'imagealt' => '',
            'extra_class' => ''
          ), $atts));



          if($displaystyle=="magnify"){
              wp_register_style('imagemagnify', plugins_url('css/jquery.imagemagnify.min.css', __FILE__));
              wp_enqueue_style('imagemagnify');
              wp_register_script('imagemagnify', plugins_url('js/jquery.imagemagnify.min.js', __FILE__), array("jquery"));
              wp_enqueue_script('imagemagnify');
              wp_enqueue_script('touchwipe', plugins_url('js/jquery.touchwipe.min.js', __FILE__), array("jquery"));
              wp_register_script('vc-extensions-magnifyimage-init', plugins_url('js/imagemagnify_init.min.js', __FILE__), array("jquery", "imagemagnify"));
              wp_enqueue_script('vc-extensions-magnifyimage-init');
          }else{
              wp_register_style('zoomer', plugins_url('css/jquery.fs.zoomer.css', __FILE__));
              wp_enqueue_style('zoomer');
              wp_register_style('vc-extensions-zoomimage-style', plugins_url('css/style.css', __FILE__), array("zoomer"));
              wp_enqueue_style('vc-extensions-zoomimage-style');

              wp_register_script('zoomer', plugins_url('js/jquery.fs.zoomer.min.js', __FILE__), array("jquery"));
              wp_enqueue_script('zoomer');
              wp_register_script('vc-extensions-zoomimage-init', plugins_url('js/init.min.js', __FILE__), array("jquery", "zoomer",));
              wp_enqueue_script('vc-extensions-zoomimage-init');

          }

          $i = -1;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $imagesarr = explode(',', $images);
          $background = wp_get_attachment_image_src(trim($background), 'full');
          $thumbwidth = '';
          $thumbheight = '';
          $output = '';

          $smallercontrol = $smallercontrol == "on" ? "fix-controls" : "";

          if($displaystyle=="zoom"){
              $output .= '<div class="zoomimage '.$smallercontrol.' '.$extra_class.'" data-width="'.$containerwidth.'" data-height="'.$containerheight.'" data-position="'.$position.'" data-retina="'.$retina.'" data-background="'.$background[0].'" data-containerbgcolor="'.$containerbgcolor.'" data-marginmax="'.$marginmax.'" data-marginmin="'.$marginmin.'">';
              foreach ($imagesarr as $key => $image) {
                  $i++;
                  $attachment = get_post($image);
                  $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');
                  if($return_img_arr[0]){
                      $output .= '<img src="'.$return_img_arr[0].'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                  }
              }
              $output .= '</div>';
          }else{
              $magnifyimageattachment = get_post($magnifyimage);
              $magnifyimage = wp_get_attachment_image_src(trim($magnifyimage), 'full');
              $output .= '<img src="'.$magnifyimage[0].'" data-largeimage="'.$magnifyimage[0].'" class="cq-magnify-image '.$extra_class.'" data-radius="'.$radius.'" data-bordercolor="'.$bordercolor.'" data-bordersize="'.$bordersize.'" data-moveby="'.$moveby.'" data-x="'.$glassx.'" data-y="'.$glassy.'" data-filter="'.$filter.'" alt="'.get_post_meta($magnifyimageattachment->ID, '_wp_attachment_image_alt', true ).'" title="'.$imagetitle.'" data-pluginurl="'. plugins_url('', __FILE__).'"  />';
          }

          return $output;

        }


  }


}

?>
