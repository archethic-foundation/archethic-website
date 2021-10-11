<?php
if (!class_exists('VC_Extensions_StackBlock')) {
    class VC_Extensions_StackBlock{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Stack Block", 'vc_stackblock_cq'),
            "base" => "cq_vc_stackblock",
            "class" => "wpb_cq_vc_extension_stackblock",
            "icon" => "cq_allinone_stackblock",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Place any content inside it', 'js_composer'),
            "params" => array(
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Stack content", "vc_stackblock_cq"),
                "param_name" => "content",
                "value" => esc_attr__("", "vc_stackblock_cq"), "description" => esc_attr__("", "vc_stackblock_cq") ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_stackblock_cq",
                "heading" => esc_attr__("Stack background", "vc_stackblock_cq"),
                "param_name" => "panelbackground",
                "value" => array("White" => "white", "Gray" => "gray", "Orange" => "orange", "Red" => "red", "Green" => "green", "Mint" => "mint", "Aqua" => "aqua", "Blue" => "blue", "Lavender" => "lavender", "Pink" => "pink", "Yellow" => "yellow"),
                'std' => 'white',
                "description" => esc_attr__("", "vc_stackblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_stackblock_cq",
                "heading" => esc_attr__("Text align", "vc_stackblock_cq"),
                "param_name" => "textalign",
                "value" => array("left", "center", "right"),
                "description" => esc_attr__("", "vc_stackblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the whole stack (optional)", "vc_stackblock_cq"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("", "vc_stackblock_cq")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__("Link for the whole stack (optional)", "vc_stackblock_cq"),
                "param_name" => "link",
                "value" => "",
                "description" => esc_attr__("", "vc_stackblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("height of whole stack", "vc_stackblock_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("The height is auto by default, you can specify a value for it here, the content will align center vertically.", "vc_stackblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Text content width", "vc_stackblock_cq"),
                "param_name" => "contentwidth",
                "value" => "",
                "description" => esc_attr__("Default is 100%. You can specify other value here, like 80%, and it'll align center automatically.", "vc_stackblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_stackblock_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_stackblock_cq")
              )

           )
        ));

        add_shortcode('cq_vc_stackblock', array($this,'cq_vc_stackblock_func'));

      }

      function cq_vc_stackblock_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            "panelbackground" => "gray",
            "textalign" => "left",
            "elementheight" => "",
            "contentwidth" => "",
            "tooltip" => "",
            "link" => "",
            "extraclass" => ""
          ), $atts));



          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          $link = vc_build_link($link);

          wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');
          wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');

          wp_register_style( 'vc-extensions-stackblock-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-stackblock-style' );
          wp_enqueue_script('vc-extensions-stackblock-script');
          wp_register_script('vc-extensions-stackblock-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
          wp_enqueue_script('vc-extensions-stackblock-script');

          $i = -1;
          $output = '';
          $output .= '<div class="cq-stackblock" data-elementheight="'.$elementheight.'" data-contentwidth="'.$contentwidth.'" data-textalign="'.$textalign.'" data-tooltip="'.$tooltip.'">';
          if($link["url"]!=="") $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="cq-stackblock-link">';
          $output .= '<div class="cq-stackblock-card card-'.$panelbackground.'">';
          $output .= '<div class="cq-stackblock-content">';
          $output .= $content;
          $output .= '</div>';
          $output .= '</div>';
          if($link["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          return $output;

        }

  }

}

?>
