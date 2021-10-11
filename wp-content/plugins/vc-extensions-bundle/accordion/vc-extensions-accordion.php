<?php
if (!class_exists('VC_Extensions_Accordion')) {

    class VC_Extensions_Accordion {
        private $accordionstyle, $arrowcolor, $titlecolor, $accordiontitlesize1, $titlepadding1, $contentbg, $contentcolor, $accordioncontentsize1, $withborder, $titlebg, $backgroundimage_url, $titlepadding2, $accordiontitlesize2, $withbordercolor, $accordioncontentsize2;
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Accordion", 'vc_accordion_cq'),
            "base" => "cq_vc_accordion",
            "class" => "wpb_cq_vc_extension_accordion",
            "controls" => "full",
            "icon" => "cq_allinone_accordion",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_accordion_item'),
            "js_view" => 'VcColumnView',
            'description' => esc_attr__( 'CSS3 accordion', 'js_composer' ),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_accordion_cq",
                "heading" => esc_attr__("Select accordion style", "vc_accordion_cq"),
                "param_name" => "accordionstyle",
                "value" => array(esc_attr__("style 1", "vc_accordion_cq") => "style1", esc_attr__("style 2", "vc_accordion_cq") => "style2"),
                "description" => esc_attr__("", "vc_accordion_cq")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Accordion content font color", 'vc_accordion_cq'),
                "param_name" => "contentcolor",
                "value" => '#333',
                "description" => esc_attr__("The color of accordion content.", 'vc_accordion_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Accordion content background color", 'vc_accordion_cq'),
                "param_name" => "contentbg",
                "value" => '',
                "description" => esc_attr__("The background color of accordion content.", 'vc_accordion_cq')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Global title", "vc_accordion_cq"),
                "param_name" => "title",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style1')),
                "description" => esc_attr__("The title of the whole element.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of global title", "vc_accordion_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style1')),
                "description" => esc_attr__("The size of the container title. Default is 1.4em.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of each accordion item title", "vc_accordion_cq"),
                "param_name" => "accordiontitlesize1",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style1')),
                "description" => esc_attr__("The font size of each accordion title. Default is 1.3em.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of each accordion item content", "vc_accordion_cq"),
                "param_name" => "accordioncontentsize1",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style1')),
                "description" => esc_attr__("The font size of each accordion content. Default is 1em.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of each accordion item title", "vc_accordion_cq"),
                "param_name" => "accordiontitlesize2",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "description" => esc_attr__("The font size of each accordion title. Default is 20px.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of each accordion item content", "vc_accordion_cq"),
                "param_name" => "accordioncontentsize2",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "description" => esc_attr__("The font size of each accordion content. Default is 1em.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding of the accordion title", "vc_accordion_cq"),
                "param_name" => "titlepadding1",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style1')),
                "description" => esc_attr__("The CSS padding of the accordion title. Default is 18px 0, which stand for padding-top and padding-bottom is 18px.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding of the accordion title", "vc_accordion_cq"),
                "param_name" => "titlepadding2",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "description" => esc_attr__("The CSS padding of the accordion title. Default is 1em.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding of the accordion content", "vc_accordion_cq"),
                "param_name" => "contentpadding",
                "value" => "",
                "description" => esc_attr__("The CSS padding of the accordion content.", "vc_accordion_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Optional repeat pattern for the accordion title", "vc_accordion_cq"),
                "param_name" => "pattern",
                "value" => "",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "description" => esc_attr__("Select image pattern from media library.", "vc_accordion_cq")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Accordion title color", 'vc_accordion_cq'),
                "param_name" => "titlecolor",
                "value" => '',
                "description" => esc_attr__("The color of each accordion title.", 'vc_accordion_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Accordion title background color", 'vc_accordion_cq'),
                "param_name" => "titlebg",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "value" => '',
                "description" => esc_attr__("", 'vc_accordion_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Accordion title hover font color", 'vc_accordion_cq'),
                "param_name" => "titlehovercolor",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "value" => '#fff',
                "description" => esc_attr__("", 'vc_accordion_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Accordion title background hover color", 'vc_accordion_cq'),
                "param_name" => "titlehoverbg",
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "value" => '#00ACED',
                "description" => esc_attr__("", 'vc_accordion_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_accordion_cq",
                "heading" => esc_attr__("Border under each accordion Accordion?", "vc_accordion_cq"),
                "param_name" => "withborder",
                "value" => array(esc_attr__("no", "vc_accordion_cq") => "", esc_attr__("yes", "vc_accordion_cq") => "withBorder"),
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "description" => esc_attr__("", "vc_accordion_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of border under each accordion title", 'vc_accordion_cq'),
                "param_name" => "withbordercolor",
                "dependency" => Array('element' => "withborder", 'value' => array('withBorder')),
                "value" => '',
                "description" => esc_attr__("", 'vc_accordion_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_accordion_cq",
                "heading" => esc_attr__("Display extra border under whole accordion?", "vc_accordion_cq"),
                "param_name" => "extraborder",
                "value" => array(esc_attr__("no", "vc_accordion_cq") => "no", esc_attr__("yes", "vc_accordion_cq") => "yes"),
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style2')),
                "description" => esc_attr__("", "vc_accordion_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Extra border color", 'vc_accordion_cq'),
                "param_name" => "extrabordercolor",
                "dependency" => Array('element' => "extraborder", 'value' => array('yes')),
                "value" => '',
                "description" => esc_attr__("", 'vc_accordion_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_accordion_cq",
                "heading" => esc_attr__("Select arrow color", "vc_accordion_cq"),
                "param_name" => "arrowcolor",
                "value" => array(esc_attr__("Default", "vc_accordion_cq") => "", esc_attr__("red", "vc_accordion_cq") => "red", esc_attr__("green", "vc_accordion_cq") => "green", esc_attr__("yellow", "vc_accordion_cq") => "yellow", esc_attr__("blue", "vc_accordion_cq") => "blue", esc_attr__("orange", "vc_accordion_cq") => "orange", esc_attr__("purple", "vc_accordion_cq") => "purple"),
                "dependency" => Array('element' => "accordionstyle", 'value' => array('style1')),
                "description" => esc_attr__("You can select the arrow color here, default is gray.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Display how many words form the content if you don't specify the title", "vc_accordion_cq"),
                "param_name" => "titlewords",
                "value" => "4",
                "description" => esc_attr__("We will fetch the words from the content if you don't specify title for the accordion. Default will fetch 4 words.", "vc_accordion_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element width", "vc_accordion_cq"),
                "param_name" => "contaienrwidth",
                "value" => "",
                "description" => esc_attr__("The width of the whole element, default is 100%. You can specify it with a smaller value, like 80%, and it will align center automatically.", "vc_accordion_cq")
              ),
              array(
                "type" => "checkbox",
                "holder" => "",
                "class" => "vc_accordion_cq",
                "heading" => esc_attr__("Display first accordion by default?", 'vc_accordion_cq'),
                "param_name" => "displayfirst",
                "value" => array(esc_attr__("Yes, display first accordion", "vc_accordion_cq") => 'on'),
                "description" => esc_attr__("", 'vc_accordion_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_accordion_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_accordion_cq")
              )

            )
        ));


        vc_map(
          array(
             "name" => esc_attr__("Accordion Item","cq_allinone_vc"),
             "base" => "cq_vc_accordion_item",
             "class" => "cq_vc_accordion_item",
             "icon" => "cq_vc_accordion_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add the title and content","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_accordion'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_accordion_cq",
                  "heading" => esc_attr__("Accordion title", 'vc_accordion_cq'),
                  "param_name" => "accordiontitle",
                  "value" => esc_attr__("", 'vc_accordion_cq'),
                  "description" => esc_attr__("", 'vc_accordion_cq')
                ),
                array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Accordion content", "vc_accordion_cq"),
                "param_name" => "content",
                "value" => esc_attr__("", "vc_accordion_cq"), "description" => esc_attr__("", "vc_accordion_cq") )


              ),
            )
        );

        add_shortcode('cq_vc_accordion', array($this,'cq_vc_accordion_func'));
        add_shortcode('cq_vc_accordion_item', array($this,'cq_vc_accordion_item_func'));

      }

      function cq_vc_accordion_func($atts, $content=null, $tag) {
            $accordionstyle = "style1";
            $arrowcolor = $titlecolor = $accordiontitlesize1 = $titlepadding1 = $contentbg = $contentcolor = $accordioncontentsize1 = $withborder = $titlebg = $pattern = $titlepadding2 = $accordiontitlesize2 = $accordioncontentsize2 = "";
            extract( shortcode_atts( array(
              'accordionstyle' => 'style1',
              'title' => '',
              'titlebg' => '',
              'pattern' => '',
              'titlehoverbg' => '',
              'titlehovercolor' => '',
              'titlesize' => '',
              'accordiontitle' => '',
              'accordiontitlesize1' => '',
              'accordiontitlesize2' => '',
              'accordioncontentsize1' => '',
              'accordioncontentsize2' => '',
              'titlecolor' => '',
              'contentcolor' => '',
              'contentbg' => '',
              'arrowcolor' => '',
              'titlepadding1' => '',
              'titlepadding2' => '',
              'titlewords' => '4',
              'extraborder' => '',
              'withborder' => '',
              'withbordercolor' => '',
              'extrabordercolor' => '',
              'contaienrwidth' => '',
              'displayfirst' => '',
              'extra_class' => ''
            ), $atts ) );

          wp_register_style( 'vc_accordion_cq_style', plugins_url('css/style.css', __FILE__));
          wp_enqueue_style( 'vc_accordion_cq_style' );

          wp_register_script('vc_accordion_cq_script', plugins_url('js/script.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc_accordion_cq_script');

          $pattern = wp_get_attachment_image_src($pattern, 'full');
          $this -> accordionstyle = $accordionstyle;
          $this -> arrowcolor = $arrowcolor;
          $this -> titlecolor = $titlecolor;
          $this -> accordiontitlesize1 = $accordiontitlesize1;
          $this -> titlepadding1 = $titlepadding1;
          $this -> contentbg = $contentbg;
          $this -> contentcolor = $contentcolor;
          $this -> accordioncontentsize1 = $accordioncontentsize1;
          $this -> withborder = $withborder;
          $this -> titlebg = $titlebg;
          $this -> titlepadding2 = $titlepadding2;
          $this -> accordiontitlesize2 = $accordiontitlesize2;
          $this -> withbordercolor = $withbordercolor;
          $this -> accordioncontentsize2 = $accordioncontentsize2;
          $this -> backgroundimage_url = $pattern[0];
          $i = -1;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          $output = '';
          if($accordionstyle=="style1"){
            $output = '<div class="cq-accordion '.$extra_class.'" style="width:'.$contaienrwidth.';" data-displayfirst="'.$displayfirst.'">';
            if($title!=""){
                $output .= '<h3 style="color:'.$titlecolor.';font-size:'.$titlesize.';">';
                $output .= $title;
                $output .= '</h3>';
              }

            $output .= '<ul>';
            $output .= do_shortcode($content);
            $output .= '</ul>';
            $output .= '</div>';
          }else{
            $output .= '<div class="cq-accordion2 '.$extra_class.'" style="width:'.$contaienrwidth.';" data-titlecolor="'.$titlecolor.'" data-titlebg="'.$titlebg.'" data-titlehoverbg="'.$titlehoverbg.'" data-titlehovercolor="'.$titlehovercolor.'" data-displayfirst="'.$displayfirst.'">';
            if($extraborder=="yes"){
                  $output .= '<div class="extraborder" style="background-color:'.$extrabordercolor.';"></div>';
              }
            $output .= '<dl>';
            $output .= do_shortcode($content);
            $output .= '</dl>';
            $output .= '</div>';

          }

          return $output;

        }

        function cq_vc_accordion_item_func($atts, $content=null) {
            extract(shortcode_atts(array(
              "accordiontitle" => ""
            ), $atts));

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          $output = "";
          if($this->accordionstyle=="style1"){
              $output .= '<li>';
              $output .= '<input type="checkbox" checked>';
              $output .= '<i class="'.$this->arrowcolor.'"></i>';
              $output .= '<h4 style="color:'.$this->titlecolor.';font-size:'.$this->accordiontitlesize1.';padding:'.$this->titlepadding1.';">'.$accordiontitle.'</h4>';
              $output .= '<div class="accordion-content" style="background-color:'.$this->contentbg.';color:'.$this->contentcolor.';font-size:'.$this->accordioncontentsize1.';">';
              $output .= do_shortcode($content);
              $output .= '</div>';
              $output .= '</li>';

          }else{
              $output .= '<dt>';
              $output .= '<a class="accordionTitle '.$this->withborder.'" style="background-color:'.$this->titlebg.';background-image:url('.$this->backgroundimage_url.');padding:'.$this->titlepadding2.';color:'.$this->titlecolor.';border-color:'.$this->withbordercolor.';" href="#">';
              $output .= '<i class="accordion-icon">+</i>';

              $output .= '<span style="font-size:'.$this->accordiontitlesize2.';">';
              $output .= $accordiontitle;
              $output .= '</span>';
              $output .= '</a>';

              $output .= '</dt>';
              $output .= '<dd class="accordionItem accordionItemCollapsed">';
              $output .= '<div class="accordion-content" style="background-color:'.$this->contentbg.';color:'.$this->contentcolor.';font-size:'.$this->accordioncontentsize2.';">';
              $output .= do_shortcode($content);
              $output .= '</div>';
              $output .= '</dd>';

          }


          return $output;

        }




  }


}

if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_accordion')) {
    class WPBakeryShortCode_cq_vc_accordion extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_accordion_item')) {
    class WPBakeryShortCode_cq_vc_accordion_item extends WPBakeryShortCode {
    }
}


?>
