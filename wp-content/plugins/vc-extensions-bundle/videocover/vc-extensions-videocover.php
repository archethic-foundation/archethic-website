<?php
if (!class_exists('VC_Extensions_VideoCover')) {
    class VC_Extensions_VideoCover{
        function __construct() {
            vc_map(array(
            "name" => __("Video Cover", 'vc_videocover_cq'),
            "base" => "cq_vc_videocover",
            "class" => "wpb_cq_vc_extension_videocover",
            "icon" => "cq_allinone_videocover",
            "category" => __('Sike Extensions', 'js_composer'),
            'description' => __('Lightbox video', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => __("Image", "vc_videocover_cq"),
                "param_name" => "videoimage",
                "value" => "",
                "group" => "Image",
                "description" => __("Select image from media library.", "vc_videocover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_videocover_cq",
                "heading" => __("Image shape", "vc_videocover_cq"),
                "param_name" => "imageshape",
                "value" => array("square" => "square", "rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "ellipse (or circle with square image)" => "ellipse"),
                "std" => "square",
                "group" => "Image",
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_videocover_cq",
                "heading" => __("Resize the image?", "vc_videocover_cq"),
                "param_name" => "resizecoverimage",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "group" => "Image",
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Resize image to this width", "vc_videocover_cq"),
                "param_name" => "coverimagewidth",
                "value" => "",
                "dependency" => Array('element' => "resizecoverimage", 'value' => array('yes')),
                "group" => "Image",
                "description" => __("Default we will use the original image, specify a width here. For example, 800 will resize the image to width 800.", "vc_videocover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_videocover_cq",
                "heading" => __("Icon (or text) button position:", "vc_videocover_cq"),
                "param_name" => "iconposition",
                "value" => array("center" => "center", "top left" => "top-left", "top center"=> "top-center", "top right" => "top-right", "left top" => "left-top", "left center" => "left-center", "left bottom" => "left-bottom", "right top" => "right-top", "right center" => "right-center", "right bottom" => "right-bottom", "bottom left" => "bottom-left", "bottom center" => "bottom-center", "bottom right" => "bottom-right"),
                "std" => "center",
                "group" => "Icon",
                "description" => __("Choose where to display the button. Default is center.", "vc_videocover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_videocover_cq",
                "heading" => __("Display button with:", "vc_videocover_cq"),
                "param_name" => "overlaytype",
                "value" => array("Icon (select the icon below)" => "icon", "Text (customize the button text below)" => "text"),
                "std" => "icon",
                "group" => "Icon",
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                'type' => 'dropdown',
                'heading' => __( 'Icon library', 'js_composer' ),
                'value' => array(
                  __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  __( 'Typicons', 'js_composer' ) => 'typicons',
                  __( 'Entypo', 'js_composer' ) => 'entypo',
                  __( 'Linecons', 'js_composer' ) => 'linecons',
                  __( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'covericon',
                'dependency' => array('element' => 'overlaytype', 'value' => 'icon',
                ),
                "group" => "Icon",
                'description' => __( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-youtube-play', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'covericon',
                  'value' => 'fontawesome',
                ),
                "group" => "Icon",
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'covericon',
                  'value' => 'openiconic',
                ),
                "group" => "Icon",
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'covericon',
                  'value' => 'typicons',
                ),
                "group" => "Icon",
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Icon",
                'dependency' => array(
                  'element' => 'covericon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'covericon',
                  'value' => 'linecons',
                ),
                "group" => "Icon",
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
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
                  'element' => 'covericon',
                  'value' => 'material',
                ),
                "group" => "Icon",
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => __("Button text", "vc_videocover_cq"),
                "param_name" => "buttonlabel",
                "value" => "PLAY",
                'dependency' => array('element' => 'overlaytype', 'value' => 'text', ),
                "group" => "Icon",
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_videocover_cq",
                "heading" => __("Icon (or text) background shape", "vc_videocover_cq"),
                "param_name" => "iconshape",
                "value" => array("circle", "rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square"),
                "std" => "circle",
                "group" => "Icon",
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Font size of the button text", "vc_videocover_cq"),
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "param_name" => "iconsize",
                "value" => "",
                "group" => "Icon",
                "description" => __("The icon default is 2em, the button text default is 1em. Specify other value as you like here.", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Size of the whole button", "vc_videocover_cq"),
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "param_name" => "iconbgsize",
                "value" => "",
                "group" => "Icon",
                "description" => __("The icon default is 64 (in pixel). Specify other value as you like here, like 80.", "vc_videocover_cq")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "holder" => "div",
                "class" => "",
                "heading" => __("Icon (or text) color", 'vc_videocover_cq'),
                "param_name" => "iconcolor",
                "value" => '',
                "group" => "Icon",
                "description" => __("Default is white.", 'vc_videocover_cq')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "holder" => "div",
                "class" => "",
                "heading" => __("Icon (or text) background color", 'vc_videocover_cq'),
                "param_name" => "iconbgcolor",
                "value" => '',
                "group" => "Icon",
                "description" => __("Default is transparent black.", 'vc_videocover_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_videocover_cq",
                "heading" => __("Clicking the image, open as", "vc_videocover_cq"),
                "param_name" => "linktype",
                "value" => array("lightbox (video, Youtube or Vimeo)" => "video", /* , "lightbox (image)" => "image", */ "link"),
                "std" => "video",
                'group' => 'Link',
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => __( 'URL (Optional link for the header)', 'vc_videocover_cq' ),
                'dependency' => array('element' => 'linktype', 'value' => 'link',
                ),
                'param_name' => 'normallink',
                'group' => 'Link',
                'description' => __( '', 'vc_videocover_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => __("Video link", "vc_videocover_cq"),
                "param_name" => "videolink",
                "value" => "",
                'dependency' => array('element' => 'linktype', 'value' => 'video', ),
                'group' => 'Link',
                "description" => __("Just copy and paste the page URL of the YouTube or Vimeo video, something like https://www.youtube.com/watch?v=pNSKQ9Qp36M&autoplay=1 or https://vimeo.com/127081676?autoplay=1. Add the autoplay=1 in the URL to auto play the video.", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Video width", "vc_videocover_cq"),
                "param_name" => "videowidth",
                "value" => "",
                'dependency' => array('element' => 'linktype', 'value' => 'video', ),
                'group' => 'Link',
                "description" => __("The width of lightbox video. Default is 800. You can specify other value here.", "vc_videocover_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => __("Optional caption under the video in the lightbox", "vc_videocover_cq"),
                "param_name" => "videocaption",
                "value" => "",
                'dependency' => array('element' => 'linktype', 'value' => 'video', ),
                'group' => 'Link',
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Display the lightbox in this gallery:", "vc_videocover_cq"),
                "param_name" => "gallery",
                "value" => "",
                'group' => 'Link',
                'dependency' => array('element' => 'linktype', 'value' => 'video', ),
                "description" => __("If you wish to open the video lightbox as a gallery, you can specify a unique gallery string for each one here. For example, video_gallery_1.", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Tooltip (optional)", "vc_videocover_cq"),
                "param_name" => "imagetooltip",
                "value" => "",
                "description" => __("", "vc_videocover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Extra class name", "vc_videocover_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_videocover_cq")
              )

           )
        ));

        add_shortcode('cq_vc_videocover', array($this,'cq_vc_videocover_func'));

      }

      function cq_vc_videocover_func($atts, $content=null, $tag) {
          $covericon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => 'fa fa-youtube-play',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "videoimage" => '',
            "coverimagewidth" => '',
            "resizecoverimage" => 'no',
            "covericon" => 'fontawesome',
            "imageshape" => 'square',
            "iconshape" => 'circle',
            "iconsize" => '',
            "iconbgsize" => '',
            "iconcolor" => '',
            "iconbgcolor" => '',
            "iconposition" => 'center',
            "videolink" => '',
            "videocaption" => '',
            "overlaytype" => 'icon',
            "buttonlabel" => '',
            "linktype" => 'video',
            "normallink" => '',
            "headerheight" => '',
            "gallery" => '',
            "videowidth" => '',
            "imagetooltip" => '',
            "extraclass" => ""
          ), $atts));


          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($covericon);
          }else{
            // wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            // wp_enqueue_style( 'font-awesome' );
          }


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          $normallink = vc_build_link($normallink);


          wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');
          wp_register_style('formstone-lightbox', plugins_url('css/lightbox.css', __FILE__));
          wp_enqueue_style('formstone-lightbox');
          wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');
          wp_register_script('formstone-lightbox', plugins_url('js/lightbox.js', __FILE__));
          wp_enqueue_script('formstone-lightbox');

          wp_register_style( 'vc-extensions-videocover-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-videocover-style' );
          wp_enqueue_script('vc-extensions-videocover-script');
          wp_register_script('vc-extensions-videocover-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster", "formstone-lightbox"));
          wp_enqueue_script('vc-extensions-videocover-script');


          $videoimage_full = wp_get_attachment_image_src($videoimage, 'full');
          $i = -1;
          $output = '';
          $link_start_str = $link_end_str = '';
          $image_start_str = $image_end_str = '';
          $icon_str = '';
          // $iconposition = "bottom-right";
          if($linktype=="video"){
              $link_start_str .= '<a href="'.$videolink.'" class="cq-videocover-lightbox" data-lightbox-gallery="'.$gallery.'" data-videowidth="'.$videowidth.'" title="'.htmlspecialchars($videocaption).'">';
          }elseif ($linktype=="image") {
          }else{
              $link_start_str .= '<a href="'.$normallink["url"].'" title="'.$normallink["title"].'" target="'.$normallink["target"].'">';
          }
          $image_start_str .= '<div class="cq-videocover '.$extraclass.'" data-iconsize="'.$iconsize.'" data-iconbgsize="'.$iconbgsize.'" data-iconcolor="'.$iconcolor.'" data-iconbgcolor="'.$iconbgcolor.'" data-tooltip="'.$imagetooltip.'" data-iconposition="'.$iconposition.'">';


          if($videoimage_full[0]!="") {
              $image_temp = $thumbnail = "";
              $thumbnail = $videoimage_full[0];
              $attachment = get_post($videoimage);
              if($resizecoverimage=="yes"&&$coverimagewidth!=""){
                  if(function_exists('wpb_resize')){
                      $image_temp = wpb_resize($videoimage, null, $coverimagewidth, null, true);
                      $thumbnail = $image_temp['url'];
                      if($thumbnail=="") $thumbnail = $videoimage_full[0];
                  }
              }

              // if($resizecoverimage=="yes"&&$coverimagewidth!=""){
                  $image_start_str .= '<img src="'.$thumbnail.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" class="cq-videocover-img '.$imageshape.'"  />';
              // }else{
                // $output .= '<img src="'.$videoimage_full[0].'" class="cq-videocover-img '.$imageshape.'"  />';
              // }
          }
          if(version_compare(WPB_VC_VERSION,  "4.4")>=0){
            if($overlaytype=="icon"){
                  if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $covericon})){
                    $icon_str .= '<div class="cq-videocover-iconcontainer '.$iconshape.' icon-'.$iconposition.'">';
                    $icon_str .= '<i class="cq-videocover-icon '.esc_attr(${'icon_' . $covericon}).'"></i>';
                    $icon_str .= '</div>';
                  }
            }else{
                  if($buttonlabel!=""){
                    $icon_str .= '<div class="cq-videocover-iconcontainer '.$iconshape.' icon-'.$iconposition.'">';
                    $icon_str .= '<span class="cq-videocover-label">'.$buttonlabel.'</span>';
                    $icon_str .= '</div>';
                  }
            }

          }else{
              if($buttonlabel!=""){
                $icon_str .= '<div class="cq-videocover-iconcontainer '.$iconshape.' icon-'.$iconposition.'">';
                $icon_str .= '<span class="cq-videocover-label">'.$buttonlabel.'</span>';
                $icon_str .= '</div>';
              }

          }




          $image_end_str .= '</div>';
          $link_end_str .= '</a>';
          if($iconposition == "center"){
            $output .= $link_start_str.$image_start_str.$icon_str.$image_end_str.$link_end_str;
          }else{
            $output .= $image_start_str.$link_start_str.$icon_str.$link_end_str.$image_end_str;
          }

          return $output;

        }


  }

}

?>
