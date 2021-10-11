<?php
if (!class_exists('VC_Extensions_TestimonialList')) {
    class VC_Extensions_TestimonialList{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Testimonial List", 'vc_testimoniallist_cq'),
            "base" => "cq_vc_testimoniallist",
            "class" => "wpb_cq_vc_extension_testimoniallist",
            "icon" => "cq_allinone_testimoniallist",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('With scroll to view slideshow', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Avatar images:", "vc_testimoniallist_cq"),
                "param_name" => "images",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Select images from media library.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the avatar image?", "vc_testimoniallist_cq"),
                "param_name" => "isresize",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "yes",
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_testimoniallist_cq"),
                "param_name" => "imagewidth",
                "value" => "160",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__("Default is 160, the avatar is in 80x80, so the avatar image will be displayed in retina. Please note the image resize function may not work with some server setup, then you have to disable it.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("User name under the avatar", "vc_testimoniallist_cq"),
                "param_name" => "username",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Optional user name under each avatar, divide with linebreak (Enter)", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("User role label (optional)", "vc_testimoniallist_cq"),
                "param_name" => "userrole",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Optional user role under each avatar, divide with linebreak (Enter)", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color the optional user name and role", 'vc_testimoniallist_cq'),
                "param_name" => "namecolor",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is dark gray.", 'vc_testimoniallist_cq')
              ),
              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library (select a global default icon for the avatar without image)', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'avataricon',
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-bullhorn', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'fontawesome',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'openiconic',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'typicons',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Avatar",
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'linecons',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'material',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background color of the avatar", 'vc_testimoniallist_cq'),
                "param_name" => "avatarbg",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is light gray.", 'vc_testimoniallist_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of the avatar icon", 'vc_testimoniallist_cq'),
                "param_name" => "avatarcolor",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is dark gray.", 'vc_testimoniallist_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("Display how many avatar by default (in large screen)", "vc_testimoniallist_cq"),
                "param_name" => "avatarnum1",
                "value" => array(3, 5, 7, 9),
                "std" => "3",
                "group" => "Avatar",
                "description" => esc_attr__("This is the default number, and display in screen large than or equal 1280. Note, this number must be less than the whole avatar number.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("Display how many avatar (in tablet screen, like iPad)", "vc_testimoniallist_cq"),
                "param_name" => "avatarnum2",
                "value" => array(3, 5, 7, 9),
                "std" => "3",
                "group" => "Avatar",
                "description" => esc_attr__("Display how many avatars in screen smaller than 800. Default is 3. Note this number must less than the whole avatar number.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("Display how many avatar (in mobile screen, like iPhone)", "vc_testimoniallist_cq"),
                "param_name" => "avatarnum3",
                "value" => array(3, 5, 7, 9),
                "std" => "3",
                "group" => "Avatar",
                "description" => esc_attr__("Display how many avatars in screen smaller than 640. Default is 3.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "heading" => esc_attr__("Optional title for each testimonial", "vc_testimoniallist_cq"),
                "param_name" => "titles",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Divide with linebreak (Enter)", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Testimonial content, divide each one with [testimonialitem][/testimonialitem], please try to edit in Text mode:", "vc_testimoniallist_cq"),
                "param_name" => "content",
                "group" => "Text",
                "value" => esc_attr__("", "vc_testimoniallist_cq"),
                "std" => '[testimonialitem]Testimonial 1[/testimonialitem]
                	[testimonialitem]Testimonial 2[/testimonialitem]
                	[testimonialitem]Testimonial 3[/testimonialitem]
                	[testimonialitem]Yet another testimonial[/testimonialitem]',
                "description" => esc_attr__("", "vc_testimoniallist_cq")
              ),

              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("Text align", "vc_testimoniallist_cq"),
                "param_name" => "textalign",
                "value" => array("left", "center", "right"),
                'std' => 'left',
                "group" => "Text",
                "description" => esc_attr__("", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding of the content", "vc_testimoniallist_cq"),
                "param_name" => "contentpadding",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("The padding of the content is 32px by default. You can specify other value here.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("The text block background", "vc_testimoniallist_cq"),
                "param_name" => "textblockbg",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                'std' => 'lavender',
                "description" => esc_attr__("", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("Auto display the testimonial in slideshow? Select the auto delay time in second below.", "vc_testimoniallist_cq"),
                "param_name" => "delaytime",
                "value" => array("no slideshow" => "no", "2", "3", "4", "5", "6", "7", "8", "9", "10"),
                'std' => 'no',
                "description" => esc_attr__("The auto slideshow is disabled by default. You can select a auto delay time if you want to enable it.", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_testimoniallist_cq",
                "heading" => esc_attr__("Element shape", "vc_testimoniallist_cq"),
                "param_name" => "elementshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square" => "square"),
                "std" => "square",
                "description" => esc_attr__("", "vc_testimoniallist_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_testimoniallist_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_testimoniallist_cq")
              )

           )
        ));

        add_shortcode('cq_vc_testimoniallist', array($this,'cq_vc_testimoniallist_func'));
      }

      function cq_vc_testimoniallist_func($atts, $content=null, $tag) {
          $avataricon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => 'fa fa-bullhorn',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "avataricon" => 'fontawesome',
            "images" => "",
            "imagewidth" => "160",
            "textblockbg" => "lavender",
            "textalign" => "left",
            "isresize" => "no",
            "username" => "",
            "userrole" => "",
            "namecolor" => "",
            "avatarbg" => "",
            "avatarcolor" => "",
            "elementshape" => "square",
            "avatarnum1" => "3",
            "avatarnum2" => "3",
            "avatarnum3" => "3",
            "delaytime" => "no",
            "titles" => "",
            "minheight" => "",
            "contentpadding" => "",
            "extraclass" => ""
          ), $atts));


          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($avataricon);
          }else{
          }



          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $content = str_replace('[/testimonialitem]', '', trim($content));
          $contentarr = explode('[testimonialitem]', trim($content));
          array_shift($contentarr);
          $imagesarr = explode(',', $images);
          $username = explode(',', $username);
          $userrole = explode(',', $userrole);
          $titles = explode(',', $titles);

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"));



          wp_register_style( 'vc-extensions-testimoniallist-style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-testimoniallist-style' );
          wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
          wp_enqueue_style('slick');

          wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('slick');

          wp_register_script('vc-extensions-testimoniallist-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "slick"));
          wp_enqueue_script('vc-extensions-testimoniallist-script');


          $output = '';
          $text_output = '';
          $image_output = '';

          $output .= '<div class="cq-testimoniallist '.$textblockbg.' '.$elementshape.' '.$extraclass.'" data-avatarbg="'.$avatarbg.'" data-avatarcolor="'.$avatarcolor.'" data-avatarnum1="'.$avatarnum1.'" data-avatarnum2="'.$avatarnum2.'" data-avatarnum3="'.$avatarnum3.'" data-delaytime="'.$delaytime.'" data-textalign="'.$textalign.'" data-namecolor="'.$namecolor.'"  data-contentpadding="'.$contentpadding.'">';

          $text_output .= '<div class="cq-testimoniallist-contentcontainer">';
          $text_output .= '<div class="cq-testimoniallist-contentsub">';


          $i = -1;
          $image_output .= '<div class="cq-testimoniallist-avatarcontainer">';
          foreach ($contentarr as $key => $thecontent) {
              $i++;
              $thecontent = trim($thecontent);
              $thecontent = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $thecontent);
              $thecontent = preg_replace('/^(<br \/>)*/', "", $thecontent);
              $thecontent = preg_replace('/^(<\/p>)*/', "", $thecontent);

              if($thecontent!=""){
                  $text_output .= '<div class="cq-testimoniallist-contentitem">';
                  $text_output .= '<div class="cq-testimoniallist-content">';
                  if(isset($titles[$i])){
                    $text_output .= '<h4 class="cq-testimoniallist-title">';
                    $text_output .= $titles[$i];
                    $text_output .= '</h4>';
                  }
                  $text_output .= $thecontent;
                  $text_output .= '</div>';
                  $text_output .= '</div>';

                  $image_output .= '<div class="cq-testimoniallist-avataritem">';
                  if(isset($imagesarr[$i])&&$imagesarr[$i]!=""){
                    $attachment = get_post($imagesarr[$i]);
                    $imageLocation = wp_get_attachment_image_src($imagesarr[$i], 'full');

                    $testimonial_image_temp = $testimonialimage = "";
                    $fullimage = $imagesarr[$i];
                    $testimonialimage = $fullimage;
                    if($imagewidth!=""){
                        if(function_exists('wpb_resize')){
                            $testimonial_image_temp = wpb_resize($imagesarr[$i], null, $imagewidth, $imagewidth, true);
                            $testimonialimage = $testimonial_image_temp['url'];
                            if($testimonialimage=="") $testimonialimage = $fullimage;
                        }
                    }


                    if($imageLocation[0]!="") $image_output .= '<img src="'.$testimonialimage.'" class="cq-testimoniallist-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'">';
                  }else{
                      $image_output .= '<span class="cq-testimoniallist-avatar">';
                      if(version_compare(WPB_VC_VERSION,  "4.4")>=0 && isset(${'icon_' . $avataricon})){
                          $image_output .= '<i class="cq-testimoniallist-icon '.esc_attr(${'icon_' . $avataricon}).'"></i>';
                      }else{
                          $image_output .= '<i class="fa cq-testimoniallist-icon '.$avataricon.'"></i>';
                      }
                      $image_output .= '</span>';
                  }
                  if(isset($username[$i])){
                      $image_output .= '<span class="cq-testimoniallist-name">';
                      $image_output .= $username[$i];
                      $image_output .= '</span>';
                  }
                  if(isset($userrole[$i])){
                      $image_output .= '<span class="cq-testimoniallist-label">';
                      $image_output .= $userrole[$i];
                      $image_output .= '</span>';
                  }

                  $image_output .= '</div>';



              }


          }

          $image_output .= '</div>';

          $text_output .= '</div>';
          $text_output .= '</div>';

          $output .= $text_output.$image_output;

          $output .= '</div>';

          return $output;

        }



  }

}

?>
