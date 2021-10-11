<?php
if (!class_exists('VC_Extensions_MaterialCard')) {
    class VC_Extensions_MaterialCard{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Material Card", 'vc_materialcard_cq'),
            "base" => "cq_vc_materialcard",
            "class" => "wpb_cq_vc_extension_materialcard",
            "icon" => "cq_allinone_materialcard",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Add Google Material style card', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Card title", "vc_materialcard_cq"),
                "param_name" => "title",
                "value" => "",
                "description" => esc_attr__("", "vc_materialcard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Title color", 'vc_materialcard_cq'),
                "param_name" => "titlecolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_materialcard_cq')
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Card content:", "vc_materialcard_cq"),
                "param_name" => "content",
                "value" => "Here is the content, please edit it in the editor.",
                "description" => esc_attr__("", "vc_materialcard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content color", 'vc_materialcard_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_materialcard_cq')
              ),

              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'labelicon',
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon (optional) for the label', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa ', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'labelicon',
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
                  'element' => 'labelicon',
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
                  'element' => 'labelicon',
                  'value' => 'typicons',
                ),
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
                'dependency' => array(
                  'element' => 'labelicon',
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
                  'element' => 'labelicon',
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
                  'element' => 'labelicon',
                  'value' => 'material',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Label under the content (on the right):", "vc_materialcard_cq"),
                "param_name" => "labeltext",
                "value" => "",
                "description" => esc_attr__("Leave it to be blank if you don't need it.", "vc_materialcard_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the label)', 'vc_materialcard_cq' ),
                'param_name' => 'link',
                'description' => esc_attr__( '', 'vc_materialcard_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_materialcard_cq",
                "heading" => esc_attr__("Border and link color option:", "vc_materialcard_cq"),
                "param_name" => "colorstyle",
                "value" => array("Medium Gray" => "#AAB2BD", "Grass" => "#8CC152", "Lavender" => "#967ADC", "Grapefruit" => "#DA4453", "Sunflower" => "#F6BB42", "Blue" => "#4A89DC", "Pink" => "#D770AD", "Mint" => "#37BC9B", "Aqua" => "#3BAFDA", "Light Gray" => "#E6E9ED",  "Dark Gray" => "#434A54", "Or customize below:" => "customized"),
                "description" => esc_attr__("", "vc_materialcard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customize border and link color", 'vc_materialcard_cq'),
                "param_name" => "bordercolor",
                "value" => '',
                "dependency" => Array('element' => "colorstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_materialcard_cq')
              ),
              array(
                  "type" => "checkbox",
                  "holder" => "",
                  "class" => "vc_materialcard_cq",
                  "heading" => esc_attr__("Do not apply ripple effect to the label link.", 'vc_materialcard_cq'),
                  "param_name" => "isripple",
                  "value" => array(esc_attr__("Yes, do not show the ripple", "vc_materialcard_cq") => 'on'),
                  "description" => esc_attr__("We'll add ripple effect to the label link by default, you can check this if you don't want it.", 'vc_materialcard_cq')
                ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the title:", "vc_materialcard_cq"),
                "param_name" => "titlemargin",
                "value" => "",
                "description" => esc_attr__("Default is 0.5em 0, which stand for margin 0.5em for top and bottom. You can specify other value here.", "vc_materialcard_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the whole card:", "vc_materialcard_cq"),
                "param_name" => "cardwidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%.", "vc_materialcard_cq")
              )
           )
          ));

          }else{
            vc_map(array(
            "name" => esc_attr__("Material Card", 'vc_materialcard_cq'),
            "base" => "cq_vc_materialcard",
            "class" => "wpb_cq_vc_extension_materialcard",
            "icon" => "cq_allinone_materialcard",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Add Google Material style card', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Card title", "vc_materialcard_cq"),
                "param_name" => "title",
                "value" => "",
                "description" => esc_attr__("", "vc_materialcard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Title color", 'vc_materialcard_cq'),
                "param_name" => "titlecolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_materialcard_cq')
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Card content:", "vc_materialcard_cq"),
                "param_name" => "content",
                "value" => "Here is the content, please edit it in the editor.",
                "description" => esc_attr__("", "vc_materialcard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content color", 'vc_materialcard_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_materialcard_cq')
              ),
              array(
                "type" => "textarea_raw_html",
                "heading" => esc_attr__("Label under the content (on the right):", "vc_materialcard_cq"),
                "param_name" => "label",
                "value" => "",
                "description" => esc_attr__("Support HTML here, for example &lt;i class=&#039;fa fa-twitter&#039;&gt;&lt;/i&gt; will insert a Font Awesome icon.", "vc_materialcard_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the label)', 'vc_materialcard_cq' ),
                'param_name' => 'link',
                'description' => esc_attr__( '', 'vc_materialcard_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_materialcard_cq",
                "heading" => esc_attr__("Border and link color option:", "vc_materialcard_cq"),
                "param_name" => "colorstyle",
                "value" => array("Medium Gray" => "#AAB2BD", "Grass" => "#8CC152", "Lavender" => "#967ADC", "Grapefruit" => "#DA4453", "Sunflower" => "#F6BB42", "Blue" => "#4A89DC", "Pink" => "#D770AD", "Mint" => "#37BC9B", "Aqua" => "#3BAFDA", "Light Gray" => "#E6E9ED",  "Dark Gray" => "#434A54", "Or customize below:" => "customized"),
                "description" => esc_attr__("", "vc_materialcard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customize border and link color", 'vc_materialcard_cq'),
                "param_name" => "bordercolor",
                "value" => '',
                "dependency" => Array('element' => "colorstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_materialcard_cq')
              ),
              array(
                  "type" => "checkbox",
                  "holder" => "",
                  "class" => "vc_materialcard_cq",
                  "heading" => esc_attr__("Do not apply ripple effect to the label link.", 'vc_materialcard_cq'),
                  "param_name" => "isripple",
                  "value" => array(esc_attr__("Yes, do not show the ripple", "vc_materialcard_cq") => 'on'),
                  "description" => esc_attr__("We'll add ripple effect to the label link by default, you can check this if you don't want it.", 'vc_materialcard_cq')
                ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the title:", "vc_materialcard_cq"),
                "param_name" => "titlemargin",
                "value" => "",
                "description" => esc_attr__("Default is 0.5em 0, which stand for margin 0.5em for top and bottom. You can specify other value here.", "vc_materialcard_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the whole card:", "vc_materialcard_cq"),
                "param_name" => "cardwidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%.", "vc_materialcard_cq")
              )
           )
        ));


        }

        add_shortcode('cq_vc_materialcard', array($this,'cq_vc_materialcard_func'));
      }

      function cq_vc_materialcard_func($atts, $content=null, $tag) {
          $labelicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "labelicon" => 'fontawesome',
            "icon_fontawesome" => 'fa ',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "title" => '',
            "titlecolor" => '',
            "contentcolor" => '',
            "author" => '',
            "label" => '',
            "labeltext" => '',
            "bordercolor" => '',
            "link" => '',
            "isripple" => '',
            "colorstyle" => '#AAB2BD',
            "titlemargin" => '',
            "cardwidth" => '',
          ), $atts));

          $output = '';
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($labelicon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }
          wp_register_style( 'vc-extensions-materialcard-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-materialcard-style' );
          wp_register_script('vc-extensions-materialcard-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-materialcard-script');
          $link = vc_build_link($link);
          $output .= '<div class="cq-material-card" data-bordercolor="'.$bordercolor.'" data-colorstyle="'.$colorstyle.'" data-isripple="'.$isripple.'" data-titlecolor="'.$titlecolor.'" data-contentcolor="'.$contentcolor.'" data-cardwidth="'.$cardwidth.'" data-titlemargin="'.$titlemargin.'">';
          $output .= '<div class="material-card-content">';
          if($title!="") $output .= '<h3 class="material-card-title">'.$title.'</h3>';
          $output .= '<p class="material-card-summary">'.do_shortcode($content).'</p>';
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
              if($labeltext!=""||$labelicon!="") {
                if($link["url"]!==""){
                  $output .= '<div class="material-card-label">';
                  $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="material-card-label-link">';
                    if(isset(${'icon_' . $labelicon})&&esc_attr(${'icon_' . $labelicon})!=""){
                      $output .= '<i class="cq-material-icon '.esc_attr(${'icon_' . $labelicon}).'"></i> ';;
                    }
                  if($labeltext!="") $output .= $labeltext;
                  $output .= '</a>';
                  $output .= '</div>';
              }else{
                  if((isset(${'icon_' . $labelicon})&&esc_attr(${'icon_' . $labelicon})!=""&&esc_attr(${'icon_' . $labelicon})!="fa ")||$labeltext!=""){
                      $output .= '<div class="material-card-label">';
                      if(isset(${'icon_' . $labelicon})&&esc_attr(${'icon_' . $labelicon})!=""&&esc_attr(${'icon_' . $labelicon})!="fa "){
                        $output .= '<i class="cq-material-icon '.esc_attr(${'icon_' . $labelicon}).'"></i> ';
                      }
                      if($labeltext!="") $output .= $labeltext;
                      $output .= '</div>';

                  }

              }

            }
          }else{
            if($label!=""){
              if($link["url"]!==""){
                  $output .= '<div class="material-card-label">';
                  $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="material-card-label-link">';
                  $output .= rawurldecode(base64_decode($label));
                  $output .= '</a>';
                  $output .= '</div>';
              }else{
                  $output .= '<div class="material-card-label">';
                  $output .= rawurldecode(base64_decode($label));
                  $output .= '</div>';
              }
            }
          }

          $output .= '</div>';
          $output .= '</div>';
          $output .= '';
          return $output;

        }


  }

}

?>
