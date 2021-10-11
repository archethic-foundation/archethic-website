<?php
if (!class_exists('VC_Extensions_VideoCard')){
    class VC_Extensions_VideoCard{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Video Card", 'cq_allinone_vc'),
            "base" => "cq_vc_videocard",
            "class" => "cq_vc_videocard",
            "controls" => "full",
            "icon" => "cq_vc_videocard",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "show_settings_on_create" => true,
            'description' => esc_attr__('YouTube background with caption overlay', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Video URL", "cq_allinone_vc"),
                "param_name" => "videoid",
                "value" => "",
                "group" => "Video",
                "description" => esc_attr__("The URL of the YouTube video, copy from the browser's address bar, something like: https://www.youtube.com/watch?v=nrJtHemSPW4", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Auto play the video by default?", "cq_allinone_vc"),
                "param_name" => "autoplay",
                "value" => "no",
                "group" => "Video",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Mute the video by default?", "cq_allinone_vc"),
                "param_name" => "ismute",
                "value" => "false",
                "group" => "Video",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),

              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Show the control bar?", "cq_allinone_vc"),
                "param_name" => "showbar",
                "value" => "true",
                "group" => "Video",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Loop the video?", "cq_allinone_vc"),
                "param_name" => "isloop",
                "value" => "no",
                "group" => "Video",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Video quality", "cq_allinone_vc"),
                "param_name" => "videoquality",
                "value" => array("default", "small", "medium", "large", "hd720", "hd1080", "highres"),
                "group" => "Video",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Video opacity", "cq_allinone_vc"),
                "param_name" => "videoopacity",
                "value" => "",
                "group" => "Video",
                "description" => esc_attr__("0 to 1 (number) define the opacity of the video. Default is 1", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Video volume level", "cq_allinone_vc"),
                "param_name" => "videovolume",
                "value" => "",
                "group" => "Video",
                "description" => esc_attr__("1 to 100 (number) set the volume level of the video. Default is 50", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Video start at", "cq_allinone_vc"),
                "param_name" => "videostart",
                "value" => "",
                "group" => "Video",
                "description" => esc_attr__("Set the seconds the video should start at, default is 0.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Video stop at", "cq_allinone_vc"),
                "param_name" => "videostop",
                "value" => "",
                "group" => "Video",
                "description" => esc_attr__("Set the seconds the video should stop at. Default is ignored, play to the end.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Display the avatar with", "cq_allinone_vc"),
                "param_name" => "avatartype",
                "value" => array("image", "icon", "none"),
                "std" => "none",
                "group" => "Avatar",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Header avatar image (will be displayed in circle)", "cq_allinone_vc"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "description" => esc_attr__("Select image from media library.", "cq_allinone_vc")
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
                "group" => "Avatar",
                'param_name' => 'avataricon',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
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
                  'element' => 'type',
                  'value' => 'material',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the Avatar (image or icon):", "vc_flipbox_cq"),
                "param_name" => "avatarsize",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is 60(px). You can specify other value here (without the px). Note, font-size will half of it.", "vc_flipbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-3 vc_column",
                "heading" => esc_attr__("Icon color", "cq_allinone_vc"),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is dark gray.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-3 vc_column",
                "heading" => esc_attr__("Icon background color", "cq_allinone_vc"),
                "param_name" => "iconbgcolor",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is white.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Avatar name (optional).", "cq_allinone_vc"),
                "param_name" => "avatarname",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Name font-size", "cq_allinone_vc"),
                "param_name" => "namesize",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is 20px (leave it to be blank)", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Name color", "cq_allinone_vc"),
                "param_name" => "namecolor",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is white.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Avatar label (optional).", "cq_allinone_vc"),
                "param_name" => "avatarlabel",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Label font-size", "cq_allinone_vc"),
                "param_name" => "labelsize",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is 14px, support other value like 1.2em etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Label color", "cq_allinone_vc"),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Default is white.", "cq_allinone_vc")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Text content", "cq_allinone_vc"),
                "param_name" => "content",
                "group" => "Text",
                "value" => esc_attr__("", "cq_allinone_vc"), "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra info under the text", "cq_allinone_vc"),
                "param_name" => "extrainfo",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra info font-size", "cq_allinone_vc"),
                "param_name" => "extrainfosize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is 13px (leave it to be blank)", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra info color", "cq_allinone_vc"),
                "param_name" => "extrainfocolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", "cq_allinone_vc")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'Link for the whole element (optional)', 'cq_allinone_vc' ),
                'param_name' => 'custom_url',
                'group' => 'Link',
                'description' => esc_attr__( '', 'cq_allinone_vc' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("How to display the avatar and text overlay?", "cq_allinone_vc"),
                "param_name" => "textmode",
                "value" => array("Display by default, hidden when user hover" => "bydefault", "Hidden by default, display when user hover" => "byhover"),
                "std" => "none",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("The height of the whole element (in pixel), default depends on the text (leave it to be blank). min-height is 200px.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the background only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));


        add_shortcode('cq_vc_videocard', array($this,'cq_vc_videocard_func'));

      }

      function cq_vc_videocard_func($atts, $content=null) {
        $avatartype = $avatarsize = $avatarimage = $avataricon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = $labelsize = $elementheight = $avatarname = $avatarlabel = $namesize = $namecolor = $labelsize = $labelcolor = $tolerance = $css_class = $css = $linktype = $lightboxmode = $custom_url = $lightboxmargin = $lightbox_url = $videowidth = $bordertype = $borderanimation = $bordercolor = $hidetitleborder = $videoid = $ismute = $isloop = $islogo = $showbar = $autoplay = $videoquality = $videoratio = $videostart = $videostop = $videovolume = $iconcolor = $iconbgcolor = $extrainfosize = $extrainfocolor = $extrainfo = $textmode = $extraclass = '';
        extract(shortcode_atts(array(
          "avatarsize" => "",
          "avatartype" => "none",
          "avataricon" => "fontawesome",
          "avatarimage" => "",
          "icon_fontawesome" => 'fa fa-adjust',
          "icon_openiconic" => 'vc-oi vc-oi-dial',
          "icon_typicons" => 'typcn typcn-adjust-brightness',
          "icon_entypo" => 'entypo-icon entypo-icon-note',
          "icon_linecons" => 'vc_li vc_li-heart',
          "icon_material" => 'vc-material vc-material-cake',
          "avatarname" => "",
          "avatarlabel" => "",
          "namesize" => "",
          "namecolor" => "",
          "labelsize" => "",
          "labelcolor" => "",
          "elementheight" => "",
          "tolerance" => "14",
          "link" => "",
          "css" => "",
          "linktype" => "none",
          "lightboxmargin" => "",
          "lightboxmode" => "boxer",
          "lightbox_url" => "",
          "videowidth" => "640",
          "custom_url" => "",
          "bordertype" => "solid",
          "borderanimation" => "crosshand1",
          "overlaycolor" => "",
          "bordercolor" => "",
          "hidetitleborder" => "",
          "videoid" => "",
          "ismute" => "false",
          "isloop" => "false",
          "autoplay" => "false",
          "showbar" => "",
          "videoratio" => "auto",
          "videoquality" => "default",
          "videoopacity" => "",
          "videostart" => "0",
          "videostop" => "",
          "videovolume" => "50",
          "iconcolor" => "",
          "iconbgcolor" => "",
          "extrainfo" => "",
          "extrainfocolor" => "",
          "extrainfosize" => "",
          "textmode" => "bydefault",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_videocard', $atts);
        wp_register_style( 'vc-extensions-videocard-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-videocard-style' );

        wp_register_style('YTPlayer', plugins_url('css/jquery.mb.YTPlayer.min.css', __FILE__));
        wp_enqueue_style('YTPlayer');


        wp_register_script('YTPlayer', plugins_url('js/jquery.mb.YTPlayer.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('YTPlayer');


        wp_register_script('vc-extensions-videocard-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "YTPlayer"));
        wp_enqueue_script('vc-extensions-videocard-script');


        if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
          vc_icon_element_fonts_enqueue($avataricon);
        }

        $avatarimage_full = wp_get_attachment_image_src($avatarimage, 'full');
        $avatar_temp = $avatarthumb = "";
        $fullimage = $avatarimage_full[0];
        $avatarthumb = $fullimage;
        if($avatarsize!=""){
            if(function_exists('wpb_resize')){
                $avatar_temp = wpb_resize($avatarimage, null, $avatarsize*2, $avatarsize*2, true);
                $avatarthumb = $avatar_temp['url'];
                if($avatarthumb=="") $avatarthumb = $fullimage;
            }
        }


        $custom_url = vc_build_link($custom_url);
        $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

        $output = "";
      	$output .= '<div class="cq-videocard cq-bordertype-'.$bordertype.' cq-videocard-hidetext'.$textmode.' '.$extraclass.' '.$css_class.'" data-tolerance="'.$tolerance.'" data-elementheight="'.$elementheight.'"  data-labelsize="'.$labelsize.'" data-labelcolor="'.$labelcolor.'" data-namecolor="'.$namecolor.'" data-namesize="'.$namesize.'" data-overlaycolor="'.$overlaycolor.'" data-lightboxmargin="'.$lightboxmargin.'" data-bordercolor="'.$bordercolor.'" data-videourl="'.$videoid.'" data-autoplay="'.$autoplay.'" data-showbar="'.$showbar.'" data-mute="'.$ismute.'"  data-isloop="'.$isloop.'" data-startat="'.$videostart.'" data-stopat="'.$videostop.'" data-videoquality=
        "'.$videoquality.'" data-opacity="'.$videoopacity.'" data-videovolume="'.$videovolume.'" data-avatarsize="'.$avatarsize.'" data-iconcolor="'.$iconcolor.'" data-iconbgcolor="'.$iconbgcolor.'" data-extrainfosize="'.$extrainfosize.'" data-extrainfocolor="'.$extrainfocolor.'">';
        if($custom_url["url"]!=""){
            $output .= '<a href="'.$custom_url["url"].'" title="'.$custom_url["title"].'" target="'.$custom_url["target"].'" rel="'.$custom_url["rel"].'">';
        }
        $output .= '<div class="cq-videocard-card">';
        $output .= '<div class="cq-videocard-video" class="player"></div>';
        $output .= '<div class="cq-videocard-content">';
        $output .= '<div class="cq-videocard-header">';
        if($avatartype=="image"){
            $output .= '<div class="cq-videocard-avatar" style="background-image:url('.$avatarthumb.')"></div>';
        }else if($avatartype=="icon"){
            if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $avataricon})){
                $output .= '<div class="cq-videocard-avatar">';
                $output .= '<i class="cq-videocard-icon '.esc_attr(${'icon_' . $avataricon}).'"></i>';
                $output .= '</div>';
            }

        }
        $output .= '<div class="cq-videocard-avatartext">';
        if($avatarname!="")$output .= '<div class="cq-videocard-avatarname">'.$avatarname.'</div>';
        if($avatarlabel!="")$output .= '<div class="cq-videocard-avatarlabel">'.$avatarlabel.'</div>';
        $output .= '</div>';
        $output .= '</div>';
        if($content!=""){
            $output .= '<div class="cq-videocard-text">';
            $output .= $content;
            $output .= '</div>';
        }
        if($extrainfo!="")$output .= '<div class="cq-videocard-extra">'.$extrainfo.'</div>';
        $output .= '</div>';
        $output .= '</div>';

        if($custom_url["url"]!=""){
            $output .= '</a>';
        }
        $output .= '</div>';
        return $output;

      }



  }
}
?>
