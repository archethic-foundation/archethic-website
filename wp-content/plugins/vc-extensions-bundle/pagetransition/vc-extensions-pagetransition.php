<?php
if (!class_exists('VC_Extensions_PageTransition')) {
    class VC_Extensions_PageTransition{
        function __construct() {
          vc_map(array(
            "name" => esc_attr__("Page Transition", 'vc_pagetransition_cq'),
            "base" => "cq_vc_pagetransition",
            "class" => "wpb_cq_vc_extension_pagetransition",
            "icon" => "cq_allinone_pagetransition",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Loading page with animation', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_pagetransition_cq",
                "heading" => esc_attr__("Display the animation in:", "vc_pagetransition_cq"),
                "param_name" => "animationmode",
                "value" => array(esc_attr__("normal mode (animate the page only)", "vc_pagetransition_cq") => "normal", esc_attr__("overlay mode (animate a solid background overlay of the page)", "vc_pagetransition_cq") => "overlay"),
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Overlay color", 'vc_pagetransition_cq'),
                "param_name" => "overlaycolor",
                "value" => '',
                "dependency" => Array('element' => "animationmode", 'value' => array('overlay')),
                "description" => esc_attr__("", 'vc_pagetransition_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_pagetransition_cq",
                "heading" => esc_attr__("Page in animation:", "vc_pagetransition_cq"),
                "param_name" => "pagein",
                "value" => array("fade-in", "fade-in-up-sm", "fade-in-up", "fade-in-up-lg", "fade-in-down-sm", "fade-in-down", "fade-in-down-lg", "fade-in-left-sm", "fade-in-left", "fade-in-left-lg", "fade-in-right-sm", "fade-in-right", "fade-in-right-lg", "rotate-in-sm", "rotate-in", "rotate-in-lg", "flip-in-x-fr", "flip-in-x", "flip-in-x-nr", "flip-in-y-fr", "flip-in-y", "flip-in-y-nr", "zoom-in-sm", "zoom-in", "zoom-in-lg"),
                "dependency" => Array('element' => "animationmode", 'value' => array('normal')),
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_pagetransition_cq",
                "heading" => esc_attr__("Page out animation:", "vc_pagetransition_cq"),
                "param_name" => "pageout",
                "value" => array("fade-out", "fade-out-up-sm", "fade-out-up", "fade-out-up-lg", "fade-out-down-sm", "fade-out-down", "fade-out-down-lg", "fade-out-left-sm", "fade-out-left", "fade-out-left-lg", "fade-out-right-sm", "fade-out-right", "fade-out-right-lg", "rotate-out-sm", "rotate-out", "rotate-out-lg", "flip-out-x-fr", "flip-out-x", "flip-out-x-nr", "flip-out-y-fr", "flip-out-y", "flip-out-y-nr", "zoom-out-sm", "zoom-out", "zoom-out-lg"),
                "dependency" => Array('element' => "animationmode", 'value' => array('normal')),
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_pagetransition_cq",
                "heading" => esc_attr__("Page in animation:", "vc_pagetransition_cq"),
                "param_name" => "overlayin",
                "value" => array("overlay-slide-in-top", "overlay-slide-in-bottom", "overlay-slide-in-left", "overlay-slide-in-right"),
                "dependency" => Array('element' => "animationmode", 'value' => array('overlay')),
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_pagetransition_cq",
                "heading" => esc_attr__("Page out animation:", "vc_pagetransition_cq"),
                "param_name" => "overlayout",
                "value" => array("overlay-slide-out-top", "overlay-slide-out-bottom", "overlay-slide-out-left", "overlay-slide-out-right"),
                "dependency" => Array('element' => "animationmode", 'value' => array('overlay')),
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Page in speed:", "vc_pagetransition_cq"),
                "param_name" => "pageinspeed",
                "value" => "1500",
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Page out speed:", "vc_pagetransition_cq"),
                "param_name" => "pageoutspeed",
                "value" => "800",
                "description" => esc_attr__("", "vc_pagetransition_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Specify the div class of the site wrapper:", "vc_pagetransition_cq"),
                "param_name" => "sitewrapper",
                "value" => "",
                "description" => esc_attr__("Defautl we will consider first div of the page as site wrapper and hide it. But you can specify it here too.", "vc_pagetransition_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Apply page out animation to these links:", "vc_pagetransition_cq"),
                "param_name" => "linkelement",
                "value" => "",
                "description" => esc_attr__("The jQuery selector of the links, you can use tool like FireBug to inspect the element. Default is all links except the new window link and anchor link in current page. For example, li.menu-item > a will enable the page out animation only with the link in menu-item, a:not(.fluidbox):not(.lightbox-link) will will disable the page out animation in the lightbox image link.", "vc_pagetransition_cq")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_pagetransition_cq",
                "heading" => esc_attr__("Do not display the page transition temporarily?", 'vc_pagetransition_cq'),
                "param_name" => "isdisplay",
                "value" => array(esc_attr__("Yes, hide the transition", "vc_pagetransition_cq") => 'no'),
                "description" => esc_attr__("The page transition is available by default, you can check this to disable it temporarily.", 'vc_pagetransition_cq')
              )

           )
        ));

        add_shortcode('cq_vc_pagetransition', array($this,'cq_vc_pagetransition_func'));
      }

      function cq_vc_pagetransition_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            'animationmode' => 'normal',
            'pagein' => 'fade-in',
            'pageout' => 'fade-out',
            'overlayin' => 'overlay-slide-in-top',
            'overlayout' => 'overlay-slide-out-top',
            'pageinspeed' => '1500',
            'pageoutspeed' => '800',
            'linkelement' => '',
            'isdisplay' => 'yes',
            'sitewrapper' => '',
            'overlaycolor' => ''
          ), $atts));

          $i = -1;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';
          if($isdisplay!="no"){
              wp_register_style( 'animsition', plugins_url('css/animsition.min.css', __FILE__) );
              wp_enqueue_style( 'animsition' );
              wp_register_script('animsition', plugins_url('js/jquery.animsition.min.js', __FILE__), array("jquery"));
              wp_enqueue_script('animsition');

              wp_register_script('vc-extensions-pagetransition-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
              wp_enqueue_script('vc-extensions-pagetransition-script');
              $output .= '<div class="cq-animsition" data-animationmode="'.$animationmode.'" data-pagein="'.$pagein.'" data-pageout="'.$pageout.'" data-overlayin="'.$overlayin.'" data-overlayout="'.$overlayout.'" data-pageinspeed="'.$pageinspeed.'" data-pageoutspeed="'.$pageoutspeed.'" data-linkelement="'.$linkelement.'" data-overlaycolor="'.$overlaycolor.'" data-sitewrapper="'.$sitewrapper.'">';
              $output .= '</div>';
          }
          return $output;

        }


  }

}

?>
