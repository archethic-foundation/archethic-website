<?php
if (!class_exists('VC_Extensions_HoverCard')) {
    class VC_Extensions_HoverCard{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Hover Card", 'vc_hovercard_cq'),
            "base" => "cq_vc_hovercard",
            "class" => "wpb_cq_vc_extension_hovercard",
            "icon" => "cq_allinone_hovercard",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Animate caption with lightbox', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Display the background as:", "vc_hovercard_cq"),
                "param_name" => "bgtype",
                "value" => array("image", "solid color"=>"solidcolor", "radial gradient color"=>"radialgradient", "linear gradient color"=>"lineargradient"),
                "std" => "image",
                "group" => "Background",
                "description" => esc_attr__("", "vc_hovercard_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Cover image:", "vc_hovercard_cq"),
                "param_name" => "image",
                "value" => "",
                "group" => "Background",
                "dependency" => Array('element' => "bgtype", 'value' => array('image')),
                "description" => esc_attr__("Select image(s) from media library, support multiple images.", "vc_hovercard_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the image?", "vc_hovercard_cq"),
                "param_name" => "isresize",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "group" => "Background",
                "dependency" => Array('element' => "bgtype", 'value' => array('image')),
                "description" => esc_attr__("Select image(s) from media library, support multiple images.", "vc_hovercard_cq"),
                "description" => esc_attr__("", "vc_hovercard_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_hovercard_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Background",
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "vc_hovercard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background color", 'vc_hovercard_cq'),
                "param_name" => "bgcolor",
                "value" => "#E6E9ED",
                "dependency" => Array('element' => "bgtype", 'value' => array('solidcolor')),
                "group" => "Background",
                "description" => esc_attr__("Default is light gray.", 'vc_hovercard_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background gradient color start with", 'vc_hovercard_cq'),
                "param_name" => "startcolor",
                "value" => "#499FCD",
                "dependency" => Array('element' => "bgtype", 'value' => array('radialgradient')),
                "group" => "Background",
                "description" => esc_attr__("Default is #499FCD", 'vc_hovercard_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background gradient color end with", 'vc_hovercard_cq'),
                "param_name" => "endcolor",
                "value" => "#1A69AA",
                "dependency" => Array('element' => "bgtype", 'value' => array('radialgradient')),
                "group" => "Background",
                "description" => esc_attr__("Default is #1A69AA", 'vc_hovercard_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background gradient color start with", 'vc_hovercard_cq'),
                "param_name" => "linearcolor1",
                "value" => "#499FCD",
                "dependency" => Array('element' => "bgtype", 'value' => array('lineargradient')),
                "group" => "Background",
                "description" => esc_attr__("Default is #499FCD", 'vc_hovercard_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background gradient color end with", 'vc_hovercard_cq'),
                "param_name" => "linearcolor2",
                "value" => "#1A69AA",
                "dependency" => Array('element' => "bgtype", 'value' => array('lineargradient')),
                "group" => "Background",
                "description" => esc_attr__("Default is #1A69AA", 'vc_hovercard_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hovercard_cq",
                "heading" => esc_attr__("Open the card as", "vc_hovercard_cq"),
                "param_name" => "linktype",
                "value" => array(esc_attr__("Open lightbox (same image in large size)", "vc_hovercard_cq") => "lightbox", esc_attr__("Open lightbox (custom URL, e.g. different image or YouTube/Vimeo video, specify URL below)", "vc_hovercard_cq") => "lightbox_custom",  esc_attr__("Do nothing", "vc_hovercard_cq") => "none", esc_attr__("Open custom link", "vc_hovercard_cq") => "customlink"),
                "std" => "none",
                "group" => "Link",
                "description" => esc_attr__("", "vc_hovercard_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the whole card)', 'vc_hovercard_cq' ),
                'param_name' => 'cardlink',
                "dependency" => Array('element' => "linktype", 'value' => array('customlink')),
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_hovercard_cq' )
              ),
              array(
                'type' => 'textfield',
                'heading' => esc_attr__( 'lightbox URL, support image or YouTube/Vimeo video', 'vc_hovercard_cq' ),
                'param_name' => 'lightbox_url',
                "dependency" => Array('element' => "linktype", 'value' => array('lightbox_custom')),
                'group' => 'Link',
                'description' => esc_attr__( 'Just copy and paste the page URL of the YouTube or Vimeo video, something like https://www.youtube.com/watch?v=pNSKQ9Qp36M&autoplay=1 or https://vimeo.com/127081676?autoplay=1. Add the autoplay=1 in the URL to auto play the video. Also support custom image link.', 'vc_hovercard_cq' )
              ),
              array(
                'type' => 'textfield',
                'heading' => esc_attr__( 'video width, default is 640', 'vc_hovercard_cq' ),
                'param_name' => 'videowidth',
                "dependency" => Array('element' => "linktype", 'value' => array('lightbox_custom')),
                'value' => '640',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_hovercard_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hovercard_cq",
                "heading" => esc_attr__("How to display the caption", "vc_hovercard_cq"),
                "param_name" => "captiontype",
                "value" => array(esc_attr__("Display the title and subtitle, hide the icon (visible when user hover)", "vc_hovercard_cq") => "hideicon", esc_attr__("Hide them all (visible when user hover)", "vc_hovercard_cq") => "hideall", esc_attr__("Display all without hover effect", "vc_hovercard_cq") => "showall"),
                "std" => "hideicon",
                "group" => "Caption",
                "description" => esc_attr__("", "vc_hovercard_cq")
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_hovercard_cq",
                "heading" => esc_attr__("Title (optional)", 'vc_hovercard_cq'),
                "param_name" => "title",
                "value" => esc_attr__("", 'vc_hovercard_cq'),
                "group" => "Caption",
                "description" => esc_attr__("", 'vc_hovercard_cq')
              ),
              array(
                "type" => "textfield",
                "holder" => "",
                "class" => "vc_hovercard_cq",
                "heading" => esc_attr__("Sub title (optional)", 'vc_hovercard_cq'),
                "param_name" => "subtitle",
                "value" => esc_attr__("", 'vc_hovercard_cq'),
                "group" => "Caption",
                "description" => esc_attr__("", 'vc_hovercard_cq')
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
                'param_name' => 'captionicon',
                "group" => "Caption",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-share', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'captionicon',
                  'value' => 'fontawesome',
                ),
                "group" => "Caption",
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
                  'element' => 'captionicon',
                  'value' => 'openiconic',
                ),
                "group" => "Caption",
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
                  'element' => 'captionicon',
                  'value' => 'typicons',
                ),
                "group" => "Caption",
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
                "group" => "Caption",
                'dependency' => array(
                  'element' => 'captionicon',
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
                  'element' => 'captionicon',
                  'value' => 'linecons',
                ),
                "group" => "Caption",
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
                  'element' => 'captionicon',
                  'value' => 'material',
                ),
                "group" => "Caption",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Icon animation", "vc_hovercard_cq"),
                "param_name" => "iconanimation",
                "value" => array("rotate", "rotateY", "rotateX"),
                "std" => "rotateY",
                "group" => "Caption",
                "description" => esc_attr__("", "vc_hovercard_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text color of the caption", 'vc_hovercard_cq'),
                "param_name" => "contentcolor",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Default is white.", 'vc_hovercard_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon color of the caption", 'vc_hovercard_cq'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Default is white.", 'vc_hovercard_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Caption offset", "vc_hovercard_cq"),
                "param_name" => "captionoffset",
                "value" => "",
                "group" => "Caption",
                "description" => esc_attr__("Default the caption is align middle (50%), you can specify other value to move it upper(e.g. 30%) or lower(e.g. 70%)", "vc_hovercard_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "vc_hovercard_cq"),
                "param_name" => "bgheight",
                "value" => "240",
                "description" => esc_attr__("The height of whole element, only available with color background, default is 240 (in pixel).", "vc_hovercard_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("margin of the lightbox margin", "vc_hovercard_cq"),
                "param_name" => "lightboxmargin",
                "value" => "",
                "description" => esc_attr__("The margin of the lightbox image, default is 20 (in pixel).", "vc_hovercard_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_hovercard_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_hovercard_cq")
              )

           )
        ));

        add_shortcode('cq_vc_hovercard', array($this,'cq_vc_hovercard_func'));

      }

      function cq_vc_hovercard_func($atts, $content=null, $tag) {
          $captionicon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "image" => "",
            "imagewidth" => "",
            "bgtype" => "image",
            "iconanimation" => "rotateY",
            "startcolor" => "#499FCD",
            "endcolor" => "#1A69AA",
            "linearcolor1" => "#499FCD",
            "linearcolor2" => "#1A69AA",
            "captionicon" => "fontawesome",
            "icon_fontawesome" => 'fa fa-share',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "isresize" => "no",
            "bgcolor" => "#E6E9ED",
            "bgheight" => "240",
            "title" => "",
            "subtitle" => "",
            "contentcolor" => "",
            "iconcolor" => "",
            "captionoffset" => "",
            "captiontype" => "hideicon",
            "lightboxmargin" => "",
            "linktype" => "",
            "lightbox_url" => "",
            "videowidth" => "640",
            "cardlink" => "",
            "extraclass" => ""
          ), $atts));


          vc_icon_element_fonts_enqueue('linecons');
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
              vc_icon_element_fonts_enqueue($captionicon);
          }else{
          }



          wp_register_style('formstone-lightbox', plugins_url('../videocover/css/lightbox.css', __FILE__));
          wp_enqueue_style('formstone-lightbox');
          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');

          wp_register_style( 'vc-extensions-hovercard-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-hovercard-style' );

          wp_register_script('formstone-lightbox', plugins_url('../videocover/js/lightbox.js', __FILE__));
          wp_enqueue_script('formstone-lightbox');

          wp_register_script('vc-extensions-hovercard-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "fs.boxer", "formstone-lightbox"));
          wp_enqueue_script('vc-extensions-hovercard-script');

          $attachment = get_post($image);
          $image_full = wp_get_attachment_image_src($image, 'full');
          $cardlink = vc_build_link($cardlink);
          $content = str_replace('[/captionitem]', '', trim($content));
          $contentarr = explode('[captionitem]', trim($content));
          array_shift($contentarr);

          $i = -1;
          $output = "";
          if($bgtype=="solidcolor"){
              $output .= '<div class="cq-hovercard cq-'.$iconanimation.' '.$extraclass.' cq-hovercard-'.$captiontype.'" data-contentcolor="'.$contentcolor.'" data-iconcolor="'.$iconcolor.'" data-bgheight="'.$bgheight.'" data-captionoffset="'.$captionoffset.'" data-videowidth="'.$videowidth.'" data-linktype="'.$linktype.'" style="background:'.$bgcolor.';height:'.$bgheight.'px" data-bgtype="'.$bgtype.'" data-lightboxmargin="'.$lightboxmargin.'">';
          }else if($bgtype=="radialgradient"){
              $output .= '<div class="cq-hovercard cq-'.$iconanimation.' '.$extraclass.' cq-hovercard-'.$captiontype.'" data-contentcolor="'.$contentcolor.'" data-iconcolor="'.$iconcolor.'" data-bgheight="'.$bgheight.'" data-captionoffset="'.$captionoffset.'" data-videowidth="'.$videowidth.'" data-linktype="'.$linktype.'" style="background:'.$startcolor.';background:-ms-radial-gradient(center, ellipse cover, '.$startcolor.' 0%, '.$endcolor.' 100%);background:-moz-radial-gradient(center, ellipse cover, '.$startcolor.' 0%, '.$endcolor.' 100%);background:-webkit-radial-gradient(center, ellipse cover, '.$startcolor.' 0%, '.$endcolor.' 100%);background:radial-gradient(center, ellipse cover, '.$startcolor.' 0%, '.$endcolor.' 100%);height:'.$bgheight.'px" data-bgtype="'.$bgtype.'" data-lightboxmargin="'.$lightboxmargin.'">';
          }else if($bgtype=="lineargradient"){
              $output .= '<div class="cq-hovercard cq-'.$iconanimation.' '.$extraclass.' cq-hovercard-'.$captiontype.'" data-contentcolor="'.$contentcolor.'" data-iconcolor="'.$iconcolor.'" data-bgheight="'.$bgheight.'" data-captionoffset="'.$captionoffset.'" data-videowidth="'.$videowidth.'" data-linktype="'.$linktype.'" style="background:'.$startcolor.';background-image: linear-gradient( '.$linearcolor1.', '.$linearcolor2.');height:'.$bgheight.'px" data-bgtype="'.$bgtype.'" data-lightboxmargin="'.$lightboxmargin.'">';
          }else{
              $output .= '<div class="cq-hovercard cq-'.$iconanimation.' '.$extraclass.' cq-hovercard-'.$captiontype.'" data-contentcolor="'.$contentcolor.'" data-iconcolor="'.$iconcolor.'" data-bgheight="'.$bgheight.'" data-captionoffset="'.$captionoffset.'" data-videowidth="'.$videowidth.'" data-linktype="'.$linktype.'" data-bgtype="'.$bgtype.'" data-lightboxmargin="'.$lightboxmargin.'">';
          }
          if($linktype=="lightbox"){
              $output .= '<a href="'.$image_full[0].'" class="cq-hovercard-lightbox">';
          }else if($linktype=="lightbox_custom"){
              $output .= '<a href="'.$lightbox_url.'" class="cq-hovercard-lightbox" title="">';
          }else if($linktype=="customlink"){
            if($cardlink["url"]!=="") $output .= '<a href="'.$cardlink["url"].'" title="'.$cardlink["title"].'" target="'.$cardlink["target"].'" class="cq-hovercard-customlink">';
          }

          $image_temp = $imagethumb = "";
          $fullimage = $image_full[0];
          $imagethumb = $fullimage;
          if($imagewidth!=""&&$isresize=="yes"){
              if(function_exists('wpb_resize')){
                  $image_temp = wpb_resize($image, null, $imagewidth, null);
                  $imagethumb = $image_temp['url'];
                  if($imagethumb=="") $imagethumb = $fullimage;
              }
          }

          if($image_full[0]!=""){
              $output .= '<img src="'.$imagethumb.'" class="cq-hovercard-background" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';

          }
          $output .= '<div class="cq-hovercard-textcontainer">';
          if($title!=""){
              $output .= '<div class="cq-hovercard-title">';
              $output .= $title;
              $output .= '</div>';
          }
          if($subtitle!=""){
              $output .= '<div class="cq-hovercard-content">';
              $output .= $subtitle;
              $output .= '</div>';
          }
          if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $captionicon})){
              $output .= '<i class="cq-hovercard-icon '.esc_attr(${'icon_' . $captionicon}).'"></i>';
          }
          $output .= '</div>';


          if($linktype=="lightbox" || $linktype=="lightbox_custom" || $linktype=="customlink"){
              $output .= '</a>';
          }
          $output .= '</div>';
          return $output;

        }

  }

}

?>
