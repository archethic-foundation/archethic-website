<?php
if (!class_exists('VC_Extensions_Tabs')) {

    class VC_Extensions_Tabs {
        private $tabsstyle, $titlebg, $titlecolor, $titlehoverbg, $contentbg, $contentcolor,  $content_str;
        private $menu_str = '';
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Tabs", 'vc_tabs_cq'),
            "base" => "cq_vc_tabs",
            "class" => "wpb_cq_vc_extension_tab",
            "controls" => "full",
            "icon" => "cq_allinone_tab",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_tab_item'),
            "js_view" => 'VcColumnView',
            'description' => esc_attr__( 'Tabbed content', 'js_composer' ),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_tabs_cq",
                "heading" => esc_attr__("Select tabs style", "vc_tabs_cq"),
                "param_name" => "tabsstyle",
                "value" => array(esc_attr__("style 1", "vc_tabs_cq") => "style1", esc_attr__("style 2", "vc_tabs_cq") => "style2", esc_attr__("style 3", "vc_tabs_cq") => "style3"),
                "description" => esc_attr__("", "vc_tabs_cq")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content font color", 'vc_tabs_cq'),
                "param_name" => "contentcolor1",
                "value" => '',
                "dependency" => Array('element' => "tabsstyle", 'value' => array('style1', 'style3')),
                "description" => esc_attr__("The color of tabs content.", 'vc_tabs_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content font color", 'vc_tabs_cq'),
                "param_name" => "contentcolor2",
                "value" => '',
                "dependency" => Array('element' => "tabsstyle", 'value' => array('style2')),
                "description" => esc_attr__("The color of tabs content.", 'vc_tabs_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content background color", 'vc_tabs_cq'),
                "param_name" => "contentbg1",
                "dependency" => Array('element' => "tabsstyle", 'value' => array('style1','style3')),
                "value" => '',
                "description" => esc_attr__("The background color of tabs content.", 'vc_tabs_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content background color", 'vc_tabs_cq'),
                "param_name" => "contentbg2",
                "dependency" => Array('element' => "tabsstyle", 'value' => array('style2')),
                "value" => '',
                "description" => esc_attr__("The background color of tabs content.", 'vc_tabs_cq')
              ),

              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Tab menu color", 'vc_tabs_cq'),
                "param_name" => "titlecolor",
                "value" => '',
                "description" => esc_attr__("The font color of tab in normal mode.", 'vc_tabs_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Tab menu background color", 'vc_tabs_cq'),
                "param_name" => "titlebg",
                "value" => '',
                "description" => esc_attr__("The background color of tab in normal mode.", 'vc_tabs_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Tab menu hover font color", 'vc_tabs_cq'),
                "param_name" => "titlehovercolor",
                "value" => '',
                "description" => esc_attr__("The font color of tab when user hover or in current mode.", 'vc_tabs_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Tab menu background hover color", 'vc_tabs_cq'),
                "param_name" => "titlehoverbg",
                "value" => '',
                "description" => esc_attr__("The background color of tab when user hover or in current mode.", 'vc_tabs_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_tabs_cq",
                "heading" => esc_attr__("Auto rotate tabs", "vc_tabs_cq"),
                "param_name" => "rotatetabs",
                'value' => array( 3, 5, 10, 15, esc_attr__( 'Disable', 'vc_tabs_cq' ) => 0 ),
                'std' => 0,
                "description" => esc_attr__("Auto rotate tabs each X seconds.", "vc_tabs_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Container width", "vc_tabs_cq"),
                "param_name" => "contaienrwidth",
                "value" => "",
                "description" => esc_attr__("The width of the whole contaienr, default is 100%. You can specify it with a smaller value, like 80%, and it will align center automatically.", "vc_tabs_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_tabs_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_tabs_cq")
              )

            )
        ));


        vc_map(
          array(
             "name" => esc_attr__("Tab Item","cq_allinone_vc"),
             "base" => "cq_vc_tab_item",
             "class" => "cq_vc_tab_item",
             "icon" => "cq_allinone_tab_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add the title and content","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_tabs'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  'type' => 'dropdown',
                  'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                  'value' => array(
                    esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                    esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                    esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                    esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                    esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                    esc_attr__( 'Material', 'js_composer' ) => 'material',
                  ),
                  'admin_label' => true,
                  'param_name' => 'tabicon',
                  'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
                ),
                array(
                  'type' => 'iconpicker',
                  'heading' => esc_attr__( 'Icon', 'js_composer' ),
                  'param_name' => 'icon_fontawesome',
                  'value' => '', // default value to backend editor admin_label
                  'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'fontawesome',
                    'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                  ),
                  'dependency' => array(
                    'element' => 'tabicon',
                    'value' => 'fontawesome',
                  ),
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
                    'element' => 'tabicon',
                    'value' => 'openiconic',
                  ),
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
                    'element' => 'tabicon',
                    'value' => 'typicons',
                  ),
                  'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
                ),
                array(
                  'type' => 'iconpicker',
                  'heading' => esc_attr__( 'Icon', 'js_composer' ),
                  'param_name' => 'icon_entypo',
                  'value' => 'entypo-icon entypo-icon-user', // default value to backend editor admin_label
                  'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'entypo',
                    'iconsPerPage' => 100, // default 100, how many icons per/page to display
                  ),
                  'dependency' => array(
                    'element' => 'tabicon',
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
                    'element' => 'tabicon',
                    'value' => 'linecons',
                  ),
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
                    'element' => 'tabicon',
                    'value' => 'material',
                  ),
                  'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
                ),
                array(
                  "type" => "textfield",
                  "holder" => "",
                  "class" => "vc_tab_cq",
                  "heading" => esc_attr__("Tab title", 'vc_tab_cq'),
                  "param_name" => "tabtitle",
                  "value" => esc_attr__("", 'vc_tab_cq'),
                  "description" => esc_attr__("", 'vc_tab_cq')
                ),
                array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Tab content", "vc_tab_cq"),
                "param_name" => "content",
                "value" => esc_attr__("", "vc_tab_cq"), "description" => esc_attr__("", "vc_tab_cq") )


              ),
            )
        );
        add_shortcode('cq_vc_tabs', array($this,'cq_vc_tabs_func'));
        add_shortcode('cq_vc_tab_item', array($this,'cq_vc_tab_item_func'));
      }

      function cq_vc_tabs_func($atts, $content=null, $tag) {
          $tabsstyle = $titlebg = $titlecolor = $titlehoverbg = $contentbg = $contentcolor = "";
          extract( shortcode_atts( array(
            'tabsstyle' => 'style1',
            'titlecolor' => '',
            'titlebg' => '',
            'titlehoverbg' => '',
            'titlehovercolor' => '',
            'tabstitlesize2' => '',
            'contentcolor1' => '',
            'contentbg1' => '',
            'contentcolor2' => '',
            'contentbg2' => '',
            'contaienrwidth' => '',
            'rotatetabs' => '0',
            'iconsupport' => 'yes',
            'extra_class' => ''
          ), $atts ) );


          if($tabsstyle=="style2"){
            $contentcolor = $contentcolor2;
            $contentbg = $contentbg2;
          }else{
            $contentcolor = $contentcolor1;
            $contentbg = $contentbg1;
          }


          $this -> tabsstyle = $tabsstyle;
          $this -> titlebg = $titlebg;
          $this -> titlecolor = $titlecolor;
          $this -> titlehoverbg = $titlehoverbg;
          $this -> contentbg = $contentbg;
          $this -> contentcolor = $contentcolor;
          $this -> menu_str = '';

          if($iconsupport=="yes"){
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }

          wp_register_style( 'vc_tabs_cq_style', plugins_url('css/style.css', __FILE__));
          wp_enqueue_style( 'vc_tabs_cq_style' );

          wp_register_script('vc_tabs_cq_script', plugins_url('js/script.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc_tabs_cq_script');


          $i = -1;


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

          $output = '';
          $all_start = $all_end = '';
          $menu_start = $menu_content = $menu_end = '';
          $container_start = $container_content = $container_end = '';

          $output .= '<div class="cq-tabs '.$extra_class.'" style="width:'.$contaienrwidth.'" data-tabsstyle="'.$tabsstyle.'" data-titlebg="'.$titlebg.'" data-titlecolor="'.$titlecolor.'" data-titlehoverbg="'.$titlehoverbg.'" data-titlehovercolor="'.$titlehovercolor.'" data-rotatetabs="'.$rotatetabs.'">';


          if($tabsstyle=="style1"){
              $output .= '<ul class="cq-tabmenu '.$tabsstyle.'" style="background-color:'.$titlebg.';border-bottom-color:'.$titlehoverbg.';">';
          }else if($tabsstyle=="style2"){
              $output .= '<ul class="cq-tabmenu '.$tabsstyle.'">';
          }else{
              $output .= '<ul class="cq-tabmenu '.$tabsstyle.'">';
          }
          $output .= $this -> menu_str;
          $output .= '</ul>';

          $output .= '<div class="cq-tabcontent '.$tabsstyle.'" style="background:'.$contentbg.';">';
          $output .= do_shortcode($content);
          $output .= '</div>';
          $output .= '</div>';

          return $output;

        }
        function cq_vc_tab_item_func($atts, $content=null, $tag) {
          $tabicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = $icon_monosocial = "";
          extract(shortcode_atts(array(
              "tabicon" => "fontawesome",
              "icon_fontawesome" => "",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => 'vc-material vc-material-cake',
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "tabtitle" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($tabicon);

          $output = '';

          $menu_str = $this -> menu_str;

          if(!isset($tabtitle) || $tabtitle == "") $tabtitle = 'Tab';
          if($this->tabsstyle=="style3"){
              $menu_str .= '<li style="background-color:'.$this->titlebg.';">';
              $menu_str .= '<a href="#" style="color:'.$this->titlecolor.';">';
              $menu_str .= '<span>';
              if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $tabicon})&&esc_attr(${'icon_' . $tabicon})!=""){
                  $menu_str .= '<i class="cq-tab-icon '.esc_attr(${'icon_' . $tabicon}).'"></i> ';
              }
              $menu_str .= $tabtitle;
              $menu_str .= '</span>';
              $menu_str .= '</a>';
              $menu_str .= '</li>';
          }else if($this->tabsstyle=="style2"){
              $menu_str .= '<li>';
              $menu_str .= '<a href="#" style="background-color:'.$this->titlebg.';color:'.$this->titlecolor.';">';
              if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $tabicon})&&esc_attr(${'icon_' . $tabicon})!=""){
                  $menu_str .= '<i class="cq-tab-icon '.esc_attr(${'icon_' . $tabicon}).'"></i> ';
              }
              $menu_str .= $tabtitle;
              $menu_str .= '</a>';
              $menu_str .= '</li>';
          }else{
              $menu_str .= '<li style="background-color:'.$this->titlebg.';">';
              $menu_str .= '<a href="#" style="color:'.$this->titlecolor.';">';
              if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $tabicon})&&esc_attr(${'icon_' . $tabicon})!=""){
                  $menu_str .= '<i class="cq-tab-icon '.esc_attr(${'icon_' . $tabicon}).'"></i> ';
              }
              $menu_str .= $tabtitle;
              $menu_str .= '</a>';
              $menu_str .= '</li>';

          }
          $this -> menu_str = $menu_str;



          $output .= '<div class="cq-tabitem" style="color:'.$this->contentcolor.';">';
          $output .= $content;
          $output .= '</div>';

          return $output;

        }


  }

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_tabs')) {
    class WPBakeryShortCode_cq_vc_tabs extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_tab_item')) {
    class WPBakeryShortCode_cq_vc_tab_item extends WPBakeryShortCode {
    }
}


?>
