<?php
if (!class_exists('VC_Extensions_ToDoList')) {

    class VC_Extensions_ToDoList {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("To Do List", 'cq_allinone_vc'),
            "base" => "cq_vc_todolist",
            "class" => "wpb_cq_vc_extension_todolist",
            "controls" => "full",
            "icon" => "cq_allinone_todolist",
            "as_parent" => array('only' => 'cq_vc_todolist_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('To Do List or Price Table', 'js_composer' ),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Global header text", "cq_allinone_vc"),
                "param_name" => "header",
                "value" => esc_attr__("To Do List", 'cq_allinone_vc'),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Header text color", 'cq_allinone_vc'),
                "param_name" => "headercolor",
                "value" => '#FFFFFF',
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Header text background", 'cq_allinone_vc'),
                "param_name" => "headerbackground",
                "value" => '#663399',
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Optional repeat pattern for the header", "cq_allinone_vc"),
                "param_name" => "headerpattern",
                "value" => "",
                "description" => esc_attr__("Select image pattern from media library.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Make the list interactive?", "cq_allinone_vc"),
                "param_name" => "isclickable",
                "description" => esc_attr__('Make the to do list clickable or not. Note, the interactive only work in front-end without saving data, which means everytime you reload the page the list will be reset.', 'cq_allinone_vc'),
                'value' => array(esc_attr__("yes (choose the checked icon below)", "cq_allinone_vc") => "yes", esc_attr__("no", "cq_allinone_vc") => "no"),
                'std' => "yes"
              ),
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
                  'param_name' => 'clickedicon',
                  'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
                ),
                array(
                  'type' => 'iconpicker',
                  'heading' => esc_attr__( 'Icon', 'js_composer' ),
                  'param_name' => 'icon_fontawesome',
                  'value' => 'fa fa-check-square-o', // default value to backend editor admin_label
                  'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'fontawesome',
                    'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                  ),
                  'dependency' => array(
                    'element' => 'clickedicon',
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
                    'element' => 'clickedicon',
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
                    'element' => 'clickedicon',
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
                    'element' => 'clickedicon',
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
                    'element' => 'clickedicon',
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
                  'element' => 'clickedicon',
                  'value' => 'material',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "cq_allinone_vc",
                "heading" => esc_attr__("Display sign up button below the list", "cq_allinone_vc"),
                "param_name" => "issignup",
                "value" => array(esc_attr__("no", "cq_allinone_vc") => "no", esc_attr__("yes", "cq_allinone_vc") => "yes"),
                "description" => esc_attr__("Append a button to the end of the list, you can use this as a Price Table.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Sign up button text", "cq_allinone_vc"),
                "param_name" => "signuptext",
                "value" => esc_attr__("Sign Up", 'cq_allinone_vc'),
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__("Link of the sign up button", "cq_allinone_vc"),
                "param_name" => "signuplink",
                "value" => esc_attr__("", 'cq_allinone_vc'),
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding of the sign up button", "cq_allinone_vc"),
                "param_name" => "signuppadding",
                "value" => esc_attr__("6px 8px", 'cq_allinone_vc'),
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("max-width of the sign up button", "cq_allinone_vc"),
                "param_name" => "signupmaxwidth",
                "value" => esc_attr__("120px", 'cq_allinone_vc'),
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Sign up button text color", 'cq_allinone_vc'),
                "param_name" => "signupcolor",
                "value" => '#FFFFFF',
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Sign up button background", 'cq_allinone_vc'),
                "param_name" => "signupbackground",
                "value" => '#663399',
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Sign up button hover background", 'cq_allinone_vc'),
                "param_name" => "signuphoverbackground",
                "value" => '#6495ED',
                "dependency" => Array('element' => "issignup", 'value' => array('yes')),
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Divide each item with", "cq_allinone_vc"),
                "param_name" => "itembg",
                "description" => esc_attr__('You can choose how to divide each item list, by different background or border only.', 'cq_allinone_vc'),
                'value' => array(esc_attr__("Background", "cq_allinone_vc") => "background", esc_attr__("Border", "cq_allinone_vc") => "border")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Container width", "cq_allinone_vc"),
                "param_name" => "containerwidth",
                "description" => esc_attr__("Default is 100%, you can specify it with a smaller value like 60%, and will be align center automatically.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "cq_allinone_vc"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              )

            )
        ));

        vc_map(
          array(
             "name" => esc_attr__("List item","cq_allinone_vc"),
             "base" => "cq_vc_todolist_item",
             "class" => "cq_vc_todolist_item",
             "icon" => "cq_vc_todolist_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_todolist'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  'type' => 'dropdown',
                  'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                  'value' => array(
                    esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                    esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                    esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                    esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                    esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                    esc_attr__( 'Material', 'js_composer' ) => 'material',
                  ),
                  'admin_label' => true,
                  'param_name' => 'listicon',
                  'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
                ),
                array(
                  'type' => 'iconpicker',
                  'heading' => esc_attr__( 'Icon', 'js_composer' ),
                  'param_name' => 'icon_fontawesome',
                  'value' => 'fa fa-user', // default value to backend editor admin_label
                  'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'fontawesome',
                    'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                  ),
                  'dependency' => array(
                    'element' => 'listicon',
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
                    'element' => 'listicon',
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
                    'element' => 'listicon',
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
                    'element' => 'listicon',
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
                    'element' => 'listicon',
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
                  'element' => 'listicon',
                  'value' => 'material',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
                array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => esc_attr__("Icon color", 'cq_allinone_vc'),
                  "param_name" => "iconcolor",
                  "value" => "",
                  "description" => esc_attr__("", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("List content", "cq_allinone_vc"),
                  "param_name" => "listcontent",
                  "value" => "",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Divide label under the list item (optional)", "cq_allinone_vc"),
                  "param_name" => "dividelabel",
                  "value" => "",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Optional repeat pattern for the label divider", "cq_allinone_vc"),
                  "param_name" => "labelpattern",
                  "value" => "",
                  "description" => esc_attr__("Select image pattern from media library.", "cq_allinone_vc")
                )


              ),
            )
        );

        add_shortcode('cq_vc_todolist', array($this,'cq_vc_todolist_func'));
        add_shortcode('cq_vc_todolist_item', array($this,'cq_vc_todolist_item_func'));
      }

      function cq_vc_todolist_func($atts, $content=null, $tag) {
          $clickedicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_monosocial = $icon_material = "";
          extract( shortcode_atts( array(
            'header' => 'To Do List',
            'width' => '',
            'color' => '',
            'headerbackground' => '#663399',
            'headercolor' => '#FFF',
            'signupbackground' => '#663399',
            'signuphoverbackground' => '#6495ED',
            'signupcolor' => '#FFF',
            'issignup' => '',
            'isclickable' => 'yes',
            'clickedicon' => 'fontawesome',
            'signuptext' => 'Sign Up',
            'signupmaxwidth' => '120px',
            'signuppadding' => '',
            'signuplink' => '',
            'itembg' => '',
            'headerpattern' => '',
            'maxwidth' => '',
            'containerwidth' => '',
            "icon_fontawesome" => "fa fa-check-square-o",
            "icon_openiconic" => "vc-oi vc-oi-dial",
            "icon_typicons" => "typcn typcn-adjust-brightness",
            "icon_entypo" => "entypo-icon entypo-icon-user",
            "icon_linecons" => "vc_li vc_li-heart",
            "icon_material" => 'vc-material vc-material-cake',
            "icon_pixelicons" => "",
            "icon_monosocial" => "",
            'extra_class' => ''
          ), $atts ) );


          wp_register_style( 'vc_todolist_cq_style', plugins_url('css/style.css', __FILE__));
          wp_enqueue_style( 'vc_todolist_cq_style' );

          wp_register_script('vc_todolist_cq_script', plugins_url('js/script.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc_todolist_cq_script');


          $headerpattern = wp_get_attachment_image_src($headerpattern, 'full');
          $i = -1;
          vc_icon_element_fonts_enqueue($clickedicon);
          $clickedicon_str = '';
          if(isset(${'icon_' . $clickedicon})&&esc_attr(${'icon_' . $clickedicon})!=""){
              $clickedicon_str = esc_attr(${'icon_' . $clickedicon});
          }
          $output = '';
          $output .= '<div class="cqlist-container '.$extra_class.'" data-isclickable="'.$isclickable.'" data-clickedicon="'.$clickedicon_str.'" style="width:'.$containerwidth.';">';
          $output .= '<div class="cqlist '.$itembg.'">';
          if($header!=""){
                if($headerpattern[0]!=""){
                  $output .= '<h3 style="color:'.$headercolor.';background-color:'.$headerbackground.';background-image:url('.$headerpattern[0].');">'.$header.'</h3>';
                }else{
                  $output .= '<h3 style="color:'.$headercolor.';background-color:'.$headerbackground.';">'.$header.'</h3>';
                }
          }
          $output .= '<ul>';
          $output .= do_shortcode($content);
          $output .= '</ul>';
          $output .= '</div>';
          $output .= '</div>';
          $signuplink = vc_build_link($signuplink);
          if($issignup=="yes"){
              $output .= '<div class="cqlist-signup">';
              $output .= '<a href="'.$signuplink["url"].'" target="'.$signuplink["target"].'" title="'.$signuplink["title"].'" style="padding:'.$signuppadding.';max-width:'.$signupmaxwidth.';color:'.$signupcolor.';background:'.$signupbackground.';" data-signupbackground="'.$signupbackground.'" data-signuphoverbackground="'.$signuphoverbackground.'">'.$signuptext.'</a>';
              $output .= '</div>';
          }

          return $output;

        }


        function cq_vc_todolist_item_func($atts, $content=null, $tag) {
          $dividelabel = $labelpattern = $iconcolor = $listcontent = "";
          $listicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_monosocial = $icon_material = "";
          extract(shortcode_atts(array(
            "dividelabel" => "",
            "labelpattern" => "",
            "listicon" => "entypo",
            "icon_fontawesome" => "fa fa-user",
            "icon_openiconic" => "vc-oi vc-oi-dial",
            "icon_typicons" => "typcn typcn-adjust-brightness",
            "icon_entypo" => "entypo-icon entypo-icon-user",
            "icon_linecons" => "vc_li vc_li-heart",
            "icon_material" => 'vc-material vc-material-cake',
            "icon_pixelicons" => "",
            "icon_monosocial" => "",
            "iconcolor" => "",
            "listcontent" => "",
            "css" => ""
          ), $atts));

          vc_icon_element_fonts_enqueue($listicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $labelpattern = wp_get_attachment_image_src($labelpattern, 'full');

          $output = '';
          if($dividelabel!=""){
              $output .= '<span class="cqlist-label" style="background-image:url('.$labelpattern[0].');">'.$dividelabel.'</span>';
          }
          $output .= '<li>';
          if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $listicon})&&esc_attr(${'icon_' . $listicon})!=""){
               $output .= '<a href="#" class="todolist-btn" data-icon="'.esc_attr(${'icon_' . $listicon}).'"> <i class="cq-todolist-icon '.esc_attr(${'icon_' . $listicon}).'" style="color:'.$iconcolor.';"></i> </a>';
               $output .= '<span class="todolist-content">'.$listcontent.'</span>';
          }else{

               $output .= '<span class="no-icon">'.$listcontent.'</span>';
          }

          $output .= '</li>';

          return $output;

        }


  }

}


//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_todolist')) {
    class WPBakeryShortCode_cq_vc_todolist extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_todolist_item')) {
    class WPBakeryShortCode_cq_vc_todolist_item extends WPBakeryShortCode {
    }
}


?>
