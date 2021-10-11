<?php
if (!class_exists('VC_Extensions_FullscreenIntro')) {
    class VC_Extensions_FullscreenIntro{
        function __construct() {
          vc_map(array(
            "name" => esc_attr__("Fullscreen Intro", 'vc_fullscreenintro_cq'),
            "base" => "cq_vc_fullscreenintro",
            "class" => "wpb_cq_vc_extension_fullscreenintro",
            "icon" => "cq_allinone_fullscreenintro",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Scroll to view', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_fullscreenintro_cq",
                "heading" => esc_attr__("Display the background with:", "vc_fullscreenintro_cq"),
                "param_name" => "backgroundtype",
                "value" => array(esc_attr__("solid color", "vc_fullscreenintro_cq") => "color", esc_attr__("image", "vc_fullscreenintro_cq") => "image"),
                "description" => esc_attr__("", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background Image:", "vc_fullscreenintro_cq"),
                "param_name" => "image",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => esc_attr__("Select images from media library. You can specify a width for them under the General tab.", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Solid background color:", 'vc_fullscreenintro_cq'),
                "param_name" => "backgroundcolor",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('color')),
                "value" => '',
                "description" => esc_attr__("", 'vc_fullscreenintro_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_fullscreenintro_cq",
                "heading" => esc_attr__("Display the image in:", "vc_fullscreenintro_cq"),
                "param_name" => "imagerepeat",
                "value" => array(esc_attr__("no-repeat", "vc_fullscreenintro_cq") => "no-repeat", esc_attr__("repeat", "vc_fullscreenintro_cq") => "repeat"),
                "description" => esc_attr__("", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Intro text:", "vc_fullscreenintro_cq"),
                "param_name" => "introtext",
                "value" => "Scroll down to see more",
                "description" => esc_attr__("", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Icon under the intro text:", "vc_fullscreenintro_cq"),
                "param_name" => "texticon",
                "value" => "fa-chevron-down",
                "description" => esc_attr__("Support all the Font Awesome Icon. Default is fa-chevron-down, you can specify with other icon as you like.", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-family of the intro text:", "vc_fullscreenintro_cq"),
                "param_name" => "textfamily",
                "value" => "",
                "description" => esc_attr__("You can specify the CSS font-family of the intro text.", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the intro text:", "vc_fullscreenintro_cq"),
                "param_name" => "textsize",
                "value" => "",
                "description" => esc_attr__("The CSS font-size of the intro text and icon. Default is 2em.", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Intro text position:", "vc_fullscreenintro_cq"),
                "param_name" => "textposition",
                "value" => "",
                "description" => esc_attr__("The CSS top value of the intro text, default is 50%, stand for middle of the container.", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Intro text color", 'vc_fullscreenintro_cq'),
                "param_name" => "textcolor",
                "value" => '#ffffff',
                "description" => esc_attr__("", 'vc_fullscreenintro_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_fullscreenintro_cq",
                "heading" => esc_attr__("Scroll to an element if user click the intro text?", "vc_fullscreenintro_cq"),
                "param_name" => "textclickable",
                "value" => array(esc_attr__("no", "vc_fullscreenintro_cq") => "no", esc_attr__("yes", "vc_fullscreenintro_cq") => "yes"),
                "description" => esc_attr__("", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Scroll to this element's position after clicking:", 'vc_fullscreenintro_cq'),
                "param_name" => "scrollto",
                "value" => '',
                "dependency" => Array('element' => "textclickable", 'value' => array('yes')),
                "description" => esc_attr__("The jQuery selector of the HTML element, you can use tool like FireBug to inspect the element. For example, .cq-medium-gallery:eq(1) stand for scroll to the second Medium Gallery in the page. You can drop me a line with your page via the contact form in my profile page  if you don't know how to get the selector.", 'vc_fullscreenintro_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Scroll offset:", 'vc_fullscreenintro_cq'),
                "param_name" => "scrolloffset",
                "value" => '',
                "dependency" => Array('element' => "textclickable", 'value' => array('yes')),
                "description" => esc_attr__("Offset for the scrolling, for example, -100 stand for 100px above the element.", 'vc_fullscreenintro_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Scroll speed:", 'vc_fullscreenintro_cq'),
                "param_name" => "scrollspeed",
                "value" => '',
                "dependency" => Array('element' => "textclickable", 'value' => array('yes')),
                "description" => esc_attr__("Speed of the scrolling, default is 1000, stand for 1 second.", 'vc_fullscreenintro_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole container", "vc_fullscreenintro_cq"),
                "param_name" => "containerheight",
                "value" => "100vh",
                "description" => esc_attr__("The CSS height of the whole container, default is 100vh, stand for 100/100th of the height of the viewport. For example, 50vh stand for 50/100th of the height of the viewport.", "vc_fullscreenintro_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_fullscreenintro_cq"),
                "param_name" => "extraclass",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it is in your css file.", "vc_fullscreenintro_cq")
              )

           )
        ));

        add_shortcode('cq_vc_fullscreenintro', array($this,'cq_vc_fullscreenintro_func'));

      }


      function cq_vc_fullscreenintro_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            'backgroundtype' => '',
            'backgroundcolor' => '',
            'image' => '',
            'imagerepeat' => '',
            'introtext' => '',
            'texticon' => 'fa-chevron-down',
            'textposition' => '',
            'textcolor' => '',
            'textsize' => '',
            'textfamily' => '',
            'textclickable' => '',
            'scrollto' => '',
            'scrolloffset' => '',
            'scrollspeed' => '',
            'containerheight' => '',
            'extraclass' => ''
          ), $atts));

          wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
          wp_enqueue_style( 'font-awesome' );

          wp_register_style('vc-extensions-fullscreenintro-style', plugins_url('css/style.css', __FILE__));
          wp_enqueue_style('vc-extensions-fullscreenintro-style');
          wp_register_script('smooth-scroll', plugins_url('js/jquery.smooth-scroll.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('smooth-scroll');

          wp_register_script('vc-extensions-fullscreenintro-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "smooth-scroll"));
          wp_enqueue_script('vc-extensions-fullscreenintro-script');


          $i = -1;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $image = wp_get_attachment_image_src(trim($image), 'full');

          $output = '';
          $output .= '<div class="cq-fullscreen-intro '.$extraclass.'" data-backgroundtype="'.$backgroundtype.'" data-image="'.$image[0].'" data-textcolor="'.$textcolor.'" data-textsize="'.$textsize.'" data-textfamily="'.$textfamily.'" data-backgroundcolor="'.$backgroundcolor.'" data-textposition="'.$textposition.'" data-textclickable="'.$textclickable.'" data-imagerepeat="'.$imagerepeat.'" data-containerheight="'.$containerheight.'" data-scrollto="'.htmlspecialchars($scrollto).'" data-scrolloffset="'.$scrolloffset.'" data-scrollspeed="'.$scrollspeed.'">';
          $output .= '<span class="cq-intro-text"><span class="intro-text">'.$introtext.'</span><i class="fa '.$texticon.'"></i></span>';
          $output .= '</div>';

          return $output;

        }

  }

}

?>
