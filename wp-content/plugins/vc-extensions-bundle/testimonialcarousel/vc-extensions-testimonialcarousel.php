<?php
if (!class_exists('VC_Extensions_TestimonialCarousel')) {

    class VC_Extensions_TestimonialCarousel {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Testimonial Carousel", 'vc_testimonialcarousel_cq'),
            "base" => "cq_vc_testimonialcarousel",
            "class" => "wpb_cq_vc_extension_testimonial",
            "controls" => "full",
            "icon" => "cq_allinone_testimonial",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('List user comment got easily', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Testimonial Avatar", "vc_testimonialcarousel_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => esc_attr__("Select images from media library.", "vc_testimonialcarousel_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Testimonial text", "vc_testimonialcarousel_cq"),
                "param_name" => "content",
                "value" => esc_attr__("I am Testimonial text 1. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. \n\n Text block 2, lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, earum, impedit, veniam quam eaque deserunt tempore praesentium possimus rerum non neque cumque? \n\n Text block 3 lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam, expedita.", "vc_testimonialcarousel_cq"),
                "description" => esc_attr__("Enter content for each testimonial here. Divide each with linebreaks (Enter).", "vc_testimonialcarousel_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Name for each Testimonial", 'vc_testimonialcarousel_cq'),
                "param_name" => "names",
                "value" => esc_attr__("Janet Gibson,Isabel Corona,Madalena Sousa", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Enter name for each testimonial here. Divide each with linebreaks (Enter).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textarea_raw_html",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Sub title for each Testimonial", 'vc_testimonialcarousel_cq'),
                "param_name" => "subtitles",
                "value" => esc_attr__("PGEgaHJlZj0iaHR0cDovL3R3aXR0ZXIuY29tL2VudmF0byI+PGkgY2xhc3M9ImZhIGZhLXR3aXR0
ZXIgcHVsbC1sZWZ0IHR3aXR0ZXIiIHRpdGxlPSJGb2xsb3cgbXkgdHdpdHRlciI+PC9pPjwvYT4g
PGEgaHJlZj0iaHR0cDovL2ZhY2Vib29rLmNvbS9lbnZhdG8iPjxpIGNsYXNzPSJmYSBmYS1mYWNl
Ym9vay1zcXVhcmUgcHVsbC1sZWZ0IGZhY2Vib29rIiB0aXRsZT0iRm9sbG93IG15IGZhY2Vib29r
Ij48L2k+PC9hPiA8YSBocmVmPSJodHRwOi8vZHJpYmJibGUuY29tL2VudmF0byI+PGkgY2xhc3M9
ImZhIGZhLWRyaWJiYmxlIHB1bGwtbGVmdCBkcmliYmJsZSIgdGl0bGU9IlZpZXcgbW9yZSB3b3Jr
cyI+PC9pPjwvYT4NCjxhIGhyZWY9Imh0dHA6Ly9wbHVzLmdvb2dsZS5jb20vK2VudmF0byI+PGkg
Y2xhc3M9ImZhIGZhLWdvb2dsZS1wbHVzLXNxdWFyZSBwdWxsLWxlZnQgZ29vZ2xlLXBsdXMiIHRp
dGxlPSJNeSBHb29nbGUgUGx1cyI+PC9pPjwvYT4gPGEgaHJlZj0iaHR0cDovL2RyaWJiYmxlLmNv
bS9lbnZhdG8iPjxpIGNsYXNzPSJmYSBmYS1kcmliYmJsZSBwdWxsLWxlZnQgZHJpYmJibGUiIHRp
dGxlPSJWaWV3IG1vcmUgd29ya3MiPjwvaT48L2E+DQpXZWIgRGV2ZWxvcGVyLCA8YSBocmVmPSJo
dHRwOi8vY29kZWNhbnlvbi5uZXQvdXNlci9zaWtlIj5MaW5rPC9hPg0KUHJvZHVjdCBNYW5hZ2Vy", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Sub title under name, enter name for each testimonial here. Divide each with linebreaks (Enter).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Defaut Testimonial background color", 'vc_extend'),
                "param_name" => "tbackgroundcolor",
                "value" => '#54ACD2',
                "description" => esc_attr__("", 'vc_extend')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Defaut Testimonial text color", 'vc_extend'),
                "param_name" => "ttextcolor",
                "value" => '#FFFFFF',
                "description" => esc_attr__("", 'vc_extend')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Background color for each Testimonial", 'vc_testimonialcarousel_cq'),
                "param_name" => "backgrounds",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Enter background color for each testimonial here. Divide each with linebreaks (Enter, default is #54ACD2).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Text color for each Testimonial", 'vc_testimonialcarousel_cq'),
                "param_name" => "colors",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Enter color for each testimonial here. Divide each with linebreaks (Enter, default is #FFFFFF).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Link for each avatar (optional)", 'vc_testimonialcarousel_cq'),
                "param_name" => "avatarlink",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Enter link for each testimonial here. Divide each with linebreaks (Enter, default is empty).", 'vc_testimonialcarousel_cq')
              ),
              array(
                  "type" => "dropdown",
                  "heading" => esc_attr__("Avatar link target", "vc_testimonialcarousel_cq"),
                  "param_name" => "avatar_link_target",
                  "description" => esc_attr__('Select where to open avatar link.', 'vc_testimonialcarousel_cq'),
                  'value' => array(esc_attr__("Same window", "vc_testimonialcarousel_cq") => "_self", esc_attr__("New window", "vc_testimonialcarousel_cq") => "_blank")
                ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Avatar width", 'vc_testimonialcarousel_cq'),
                "param_name" => "avatarwidth",
                "value" => esc_attr__("60", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Avatar height", 'vc_testimonialcarousel_cq'),
                "param_name" => "avatarheight",
                "value" => esc_attr__("60", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Display how many Testimonials by default?", 'vc_testimonialcarousel_cq'),
                "param_name" => "tnumber",
                "value" => esc_attr__("3", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Testimonial width", 'vc_testimonialcarousel_cq'),
                "param_name" => "twidth",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("The width of the Testimonial content, default is 90% (leave it to be blank).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Testimonial content margin", 'vc_testimonialcarousel_cq'),
                "param_name" => "tmargin",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("The CSS margin of the Testimonial content, leave it to blank if you don't now how it work, default is 0 auto.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Testimonial content padding", 'vc_testimonialcarousel_cq'),
                "param_name" => "tpadding",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("The CSS padding of the Testimonial content, leave it to blank if you don't now how it work, default is 12px.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("CSS margin-left of the arrow", 'vc_testimonialcarousel_cq'),
                "param_name" => "arrowmarginleft",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("The margin-left of the down arrow, default is 42px (leave it to be blank).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("CSS margin-left of the avatar", 'vc_testimonialcarousel_cq'),
                "param_name" => "avatarmarginleft",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("The margin-left of the avatar, default is 24px (leave it to be blank).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("CSS margin of the name", 'vc_testimonialcarousel_cq'),
                "param_name" => "namemargin",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("The margin the name, default is 12px 0 0 20px (leave it to be blank).", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Auto play the Testimonial?", 'vc_testimonialcarousel_cq'),
                "param_name" => "autoplay",
                "value" => array(esc_attr__("Yes", "vc_testimonialcarousel_cq") => 'on'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Autoplay Speed in milliseconds", 'vc_testimonialcarousel_cq'),
                "param_name" => "autoplayspeed",
                "value" => esc_attr__("3000", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Make the avatar retina?", 'vc_testimonialcarousel_cq'),
                "param_name" => "retina",
                "value" => array(esc_attr__("Yes", "vc_testimonialcarousel_cq") => 'on'),
                "description" => esc_attr__("For example a 200x200 avatar will display as 100x100 in retina mode.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("font-family for the Testimonial content", 'vc_testimonialcarousel_cq'),
                "param_name" => "font",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Specify the font-family for the Testimonial content.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Display the Testimonial in italic?", 'vc_testimonialcarousel_cq'),
                "param_name" => "italic",
                "value" => array(esc_attr__("Yes", "vc_testimonialcarousel_cq") => 'on'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Do not display the tooltip for the icon in the sub title?", 'vc_testimonialcarousel_cq'),
                "param_name" => "notooltip",
                "value" => array(esc_attr__("Yes, do not display the tooltip", "vc_testimonialcarousel_cq") => 'on'),
                "description" => esc_attr__("Default the title attribute of the Font Awesome icon will display as tooltip, check this if you do not want it.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("Do not infinite loop sliding?", 'vc_testimonialcarousel_cq'),
                "param_name" => "noloop",
                "value" => array(esc_attr__("Yes, no loop for the sliding", "vc_testimonialcarousel_cq") => 'on'),
                "description" => esc_attr__("", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("font-size for the Testimonial content", 'vc_testimonialcarousel_cq'),
                "param_name" => "fontsize",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Specify the font-size for the Testimonial content, default is 18px.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("font-size for the Name", 'vc_testimonialcarousel_cq'),
                "param_name" => "namesize",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Specify the font-size for the Name, default is 14px.", 'vc_testimonialcarousel_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_testimonialcarousel_cq",
                "heading" => esc_attr__("font-size for the Sub title under the Name", 'vc_testimonialcarousel_cq'),
                "param_name" => "subtitlesize",
                "value" => esc_attr__("", 'vc_testimonialcarousel_cq'),
                "description" => esc_attr__("Specify the font-size for the Sub title, default is 12px.", 'vc_testimonialcarousel_cq')
              )


            )
        ));
        add_shortcode('cq_vc_testimonialcarousel', array($this,'cq_vc_testimonialcarousel_func'));

      }

      function cq_vc_testimonialcarousel_func($atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'images' => '',
            'colors' => '',
            'backgrounds' => '',
            'tbackgroundcolor' => '#54ACD2',
            'ttextcolor' => '#FFF',
            'names' => 'Default Name',
            'subtitles' => 'default sub title',
            'tnumber' => '3',
            'twidth' => '',
            'avatarlink' => '',
            'avatar_link_target' => '_self',
            'avatarwidth' => '60',
            'avatarheight' => '60',
            'tmargin' => '',
            'tpadding' => '',
            'arrowmarginleft' => '',
            'avatarmarginleft' => '',
            'namemargin' => '',
            'htmltag' => 'h4',
            'retina' => 'off',
            'italic' => 'off',
            'font' => '',
            'notooltip' => 'off',
            'autoplay' => 'off',
            'noloop' => 'off',
            'autoplayspeed' => '3000',
            'fontsize' => '',
            'namesize' => '',
            'subtitlesize' => ''
          ), $atts ) );

          wp_register_style( 'slick', plugins_url('slick/slick.css', __FILE__) );
          wp_enqueue_style( 'slick' );
          wp_register_style( 'vc_testimonialcarousel_cq_style', plugins_url('slick/style.css', __FILE__) );
          wp_enqueue_style( 'vc_testimonialcarousel_cq_style' );

          wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
          wp_enqueue_style( 'font-awesome' );

          wp_register_script('slick', plugins_url('slick/slick.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('slick');
          wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');
          wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_register_script('vc_testimonialcarousel_cq_script', plugins_url('js/tc_init.js', __FILE__), array("jquery", "slick", "tooltipster"));
          wp_enqueue_script('vc_testimonialcarousel_cq_script');
          wp_enqueue_script('tooltipster');

          $imagesarr = explode(',', $images);
          $colorarr = explode(',', $colors);
          $backgroundarr = explode(',', $backgrounds);
          $avatarlinkarr = explode(',', $avatarlink);
          $namearr = explode(',', $names);
          $subtitlearr = preg_split("/\r\n|\n|\r/", urldecode(base64_decode($subtitles)));
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $testimonialcontentarr = preg_split("/\r\n|\n|\r/", $content);

          $output = '';

          $output .= '<div class="cq-testimonialcarousel" data-avatarwidth="'.$avatarwidth.'" data-avatarheight="'.$avatarheight.'" data-italic="'.$italic.'" data-font="'.$font.'" data-tnumber="'.$tnumber.'" data-twidth="'.$twidth.'" data-tmargin="'.$tmargin.'" data-tpadding="'.$tpadding.'" data-arrowmarginleft="'.$arrowmarginleft.'" data-namemargin="'.$namemargin.'" data-avatarmarginleft="'.$avatarmarginleft.'" data-tbackgroundcolor="'.$tbackgroundcolor.'" data-ttextcolor="'.$ttextcolor.'" data-autoplay="'.$autoplay.'" data-autoplayspeed="'.$autoplayspeed.'" data-noloop="'.$noloop.'" data-fontsize="'.$fontsize.'" data-namesize="'.$namesize.'" data-subtitlesize="'.$subtitlesize.'" data-notooltip="'.$notooltip.'">';
          $i = -1;
          foreach ($testimonialcontentarr as $key => $value) {
              $i++;
              if(!isset($testimonialcontentarr[$i])) {
                $testimonialcontent = '';
              }else{
                $testimonialcontent = $testimonialcontentarr[$i];
              }
              if(!isset($colorarr[$i])) $colorarr[$i] = '';
              if(!isset($backgroundarr[$i])) $backgroundarr[$i] = '';
              if(!isset($avatarlinkarr[$i])) $avatarlinkarr[$i] = '';
              if(!isset($namearr[$i])) $namearr[$i] = '';
              if(!isset($subtitlearr[$i])) $subtitlearr[$i] = '';
              if(!isset($imagesarr[$i])) $imagesarr[$i] = '';

                  $return_img_arr = wp_get_attachment_image_src(trim($imagesarr[$i]), 'full');
                  $attachment = get_post($imagesarr[$i]);
                  $testimonial_image_temp = $testimonialimage = "";
                  $fullimage = $return_img_arr[0];
                  $testimonialimage = $fullimage;
                  if($avatarwidth!=""){
                      if(function_exists('wpb_resize')){
                          $testimonial_image_temp = wpb_resize($imagesarr[$i], null, $retina=="on"?$avatarwidth*2:$avatarwidth, $retina=="on"?$avatarheight*2:$avatarheight, true);
                          $testimonialimage = $testimonial_image_temp['url'];
                          if($testimonialimage=="") $testimonialimage = $fullimage;
                      }
                  }


                  $output .= '<div class="testimonial-wrap">';
                  $output .= '<div class="testimonial" data-color="'.$colorarr[$i].'" data-background="'.$backgroundarr[$i].'">';
                  $output .= $testimonialcontent;
                  $output .= '</div>';
                  $output .= '<div class="arrow-down"></div>';
                  if($return_img_arr[0]!=""){
                    $output .= '<div class="headshot">';
                    if($avatarlinkarr[$i]!=""){
                      $output .= '<a href="'.$avatarlinkarr[$i].'" target="'.$avatar_link_target.'">';
                    }
                    $output .= '<img src="'.$testimonialimage.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" width="'.$avatarwidth.'" />';
                    if($avatarlinkarr[$i]!=""){
                      $output .= '</a>';
                    }
                    $output .= '</div>';
                  }

                  $output .= '<div class="testimonial-info">';
                  $output .= '<h4>'.$namearr[$i].'</h4>';
                  $output .= '<p>'.$subtitlearr[$i].'</p>';
                  $output .= '</div>';

                  $output .= '</div>';

          }
          $output .= '</div>';
          return $output;

        }


  }


}

?>
