<?php

if (!class_exists('VC_Extensions_HotSpot')) {

    class VC_Extensions_HotSpot {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("HotSpot", 'vc_hotspot_cq'),
            "base" => "cq_vc_hotspot",
            "class" => "wpb_cq_vc_extension_hotspot",
            "controls" => "full",
            "icon" => "cq_allinone_hotspot",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__( 'Image hotspot with tooltip', 'js_composer' ),
            'front_enqueue_js' => plugins_url('js/hotspot_frontend.min.js', __FILE__),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_hotspot_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "vc_hotspot_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_hotspot_cq"),
                "param_name" => "width",
                "value" => esc_attr__("", 'vc_hotspot_cq'),
                "description" => esc_attr__("You can resize image to this width, or keep it to blank to use the original image.", "vc_hotspot_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Tooltip content, divide each one with [hotspotitem][/hotspotitem], please edit in text mode:", "vc_hotspot_cq"),
                "param_name" => "content",
                "value" => esc_attr__("[hotspotitem]
                  You have to wrap each tooltip block in hotspotitem.
                [/hotspotitem]
                [hotspotitem]
                  Hello tooltip 2, you can customize the icon color, link, arrow position, tooltip content etc in the backend.
                [/hotspotitem]
                [hotspotitem]
                  Hello tooltip 3
                [/hotspotitem]
                [hotspotitem]
                You can customize the icon position in the frontend editor of Visual Composer.
                <a href='http://codecanyon.net/user/sike?ref=sike'>Visit my profile</a> for more works.
                [/hotspotitem]", "vc_hotspot_cq"), "description" => esc_attr__("Enter content for each block here. Divide each with [hotspotitem].", "vc_hotspot_cq") ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Display which tooltip by default?", "vc_hotspot_cq"),
                "param_name" => "isdisplayall",
                'value' => array(esc_attr__("Display all of them when loaded", "vc_hotspot_cq") => "on", esc_attr__("Display a specified one (customize it below:)", "vc_hotspot_cq") => "specify", esc_attr__("Hide them all when loaded", "vc_hotspot_cq") => "off"),
                'std' => 'off',
                "description" => esc_attr__('Default all the tooltips are hidden. Though you can choose to open all of them or a single one when page is loaded.', 'vc_hotspot_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Display this tooltip when page loaded:", "vc_hotspot_cq"),
                "param_name" => "displayednum",
                "value" => "1",
                "dependency" => Array('element' => "isdisplayall", 'value' => array('specify')),
                "description" => esc_attr__("You can specify to display which tooltip in current image. Default is 1, which stand for the number 1 tooltip will be opened when page is loaded.", "vc_hotspot_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Display the hotspot with?", "vc_hotspot_cq"),
                "param_name" => "icontype",
                "value" => array(esc_attr__("single dot", "vc_hotspot_cq") => "dot", esc_attr__("number", "vc_hotspot_cq") => "number", esc_attr__("Font Awesome icon", "vc_hotspot_cq") => "icon"),
                "description" => esc_attr__("", "vc_hotspot_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Numbers start from", "vc_hotspot_cq"),
                "param_name" => "startnumber",
                "value" => "1",
                "dependency" => Array('element' => "icontype", 'value' => array('number')),
                "description" => esc_attr__("Default is start from 1, you can specify other value here, like 4.", "vc_hotspot_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Font Awesome icon for each hotspot:", 'vc_hotspot_cq'),
                "param_name" => "fonticon",
                "value" => esc_attr__("fa-hand-o-right,fa-image,fa-coffee,fa-comment", 'vc_hotspot_cq'),
                "dependency" => Array('element' => "icontype", 'value' => array('icon')),
                "description" => esc_attr__("Put the <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>Font Awesome icon</a> here, divide with linebreak (Enter).", 'vc_hotspot_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Link for each hotspot icon", 'vc_hotspot_cq'),
                "param_name" => "links",
                "value" => esc_attr__("", 'vc_hotspot_cq'),
                "description" => esc_attr__("Specify link for each icon, divide each with linebreaks (Enter).", 'vc_hotspot_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Open the link as lightbox?", "vc_hotspot_cq"),
                "param_name" => "islightbox",
                "value" => array(esc_attr__("no", "vc_hotspot_cq") => "no", esc_attr__("yes", "vc_hotspot_cq") => "yes"),
                "description" => esc_attr__("Support YouTube, Vimeo video, image, or Google Map etc.", "vc_hotspot_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Global hotspot icon color", 'vc_hotspot_cq'),
                "param_name" => "iconbackground",
                "value" => 'rgba(0,0,0,0.8)',
                "description" => esc_attr__("Global color for the hotspot icon. Or you can specify different color for each icon below.", 'vc_hotspot_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Hotspot circle dot (or Font Awesome icon) color", 'vc_hotspot_cq'),
                "param_name" => "circlecolor",
                "value" => '#FFFFFF',
                "description" => esc_attr__("Color for the hotspot circle dot. Default is white.", 'vc_hotspot_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Each hotspot icon's color", 'vc_hotspot_cq'),
                "param_name" => "color",
                "value" => esc_attr__("", 'vc_hotspot_cq'),
                "description" => esc_attr__("Color for each icon, you can use the value like #663399 or the name of the color like blue here. Divide each with linebreaks (Enter).", 'vc_hotspot_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Display pulse animation for the hotspot icon?", "vc_hotspot_cq"),
                "param_name" => "ispulse",
                "value" => array(esc_attr__("no", "vc_hotspot_cq") => "no", esc_attr__("yes", "vc_hotspot_cq") => "yes"),
                "description" => esc_attr__("", "vc_hotspot_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Select pulse border color", "vc_hotspot_cq"),
                "param_name" => "pulsecolor",
                "value" => array(esc_attr__("Default", "vc_hotspot_cq") => "pulse-white", esc_attr__("gray", "vc_hotspot_cq") => "pulse-gray", esc_attr__("red", "vc_hotspot_cq") => "pulse-red", esc_attr__("green", "vc_hotspot_cq") => "pulse-green", esc_attr__("yellow", "vc_hotspot_cq") => "pulse-yellow", esc_attr__("blue", "vc_hotspot_cq") => "pulse-blue", esc_attr__("purple", "vc_hotspot_cq") => "pulse-purple"),
                "dependency" => Array('element' => "ispulse", 'value' => array('yes')),
                "std" => "pulse-white",
                "description" => esc_attr__("You can select the pulse border color here, default is white.", "vc_hotspot_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Tooltip arrow position for each hotspot", 'vc_hotspot_cq'),
                "param_name" => "arrowposition",
                "value" => esc_attr__("", 'vc_hotspot_cq'),
                "description" => esc_attr__("The arrow position for each tooltip, default is top. The available options are: top, right, bottom, left, top-right, top-left, bottom-right, bottom-left. Divide each with linebreaks (Enter)", 'vc_hotspot_cq')
              ),

              array(
                "type" => "textfield",
                "heading" => esc_attr__("Hotspot icon opacity", "vc_hotspot_cq"),
                "param_name" => "opacity",
                "value" => "1",
                "description" => esc_attr__("The opacity of each icon, default is 1", "vc_hotspot_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Tooltip style", "vc_hotspot_cq"),
                "param_name" => "tooltipstyle",
                "value" => array(esc_attr__("shadow", "vc_hotspot_cq") => "shadow", esc_attr__("light", "vc_hotspot_cq") => "light", esc_attr__("noir", "vc_hotspot_cq") => "noir", esc_attr__("punk", "vc_hotspot_cq") => "punk"),
                "description" => esc_attr__("", "vc_hotspot_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Tooltip trigger when user", "vc_hotspot_cq"),
                "param_name" => "trigger",
                "value" => array(esc_attr__("hover", "vc_hotspot_cq") => "hover", esc_attr__("click", "vc_hotspot_cq") => "click"),
                "description" => esc_attr__("Select how to trigger the tooltip.", "vc_hotspot_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Tooltip animation", "vc_hotspot_cq"),
                "param_name" => "tooltipanimation",
                "value" => array(esc_attr__("grow", "vc_hotspot_cq") => "grow", esc_attr__("fade", "vc_hotspot_cq") => "fade", esc_attr__("swing", "vc_hotspot_cq") => "swing", esc_attr__("slide", "vc_hotspot_cq") => "slide", esc_attr__("fall", "vc_hotspot_cq") => "fall"),
                "description" => esc_attr__("Choose the animation for the tooltip.", "vc_hotspot_cq")
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("How to open the link for the icon?", "vc_hotspot_cq"),
                "param_name" => "custom_links_target",
                "description" => esc_attr__('Select how to open the links', 'vc_hotspot_cq'),
                'value' => array(esc_attr__("Same window", "vc_hotspot_cq") => "_self", esc_attr__("New window", "vc_hotspot_cq") => "_blank")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("maxWidth of the tooltip", "vc_hotspot_cq"),
                "param_name" => "maxwidth",
                "value" => "240",
                "description" => esc_attr__("maxWidth for the tooltip, 0 is auto width, you can specify a value here, default is 240.", "vc_hotspot_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Container width", "vc_hotspot_cq"),
                "param_name" => "containerwidth",
                "value" => "",
                "description" => esc_attr__("You can specify the container width here, default is 100%. You can try other value like 80%, it will be align center automatically.", "vc_hotspot_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Margin offset", "vc_hotspot_cq"),
                "param_name" => "marginoffset",
                "value" => "",
                "description" => esc_attr__("The margin offset for the hotspot icon in small screen. For example -6px 0 0 -6px will move the icons upper left for 6px offset in small screen. Leave here to be blank if you do not want it.", "vc_hotspot_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_hotspot_cq",
                "heading" => esc_attr__("Each hotspot icon's position", 'vc_hotspot_cq'),
                "param_name" => "position",
                "value" => esc_attr__("25%|30%,35%|20%,45%|60%,75%|20%", 'vc_hotspot_cq'),
                "description" => esc_attr__("Position of each icon in top|left format. Please update via dragging the hotspot icon in the Visual Composer Frontend editor. See a <a href='http://youtu.be/9j1XhIQw9JE' target='_blank'>Youtube video demo</a>.", 'vc_hotspot_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_hotspot_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_hotspot_cq")
              )

            )
        ));

        add_shortcode('cq_vc_hotspot', array($this,'cq_vc_hotspot_func'));
      }

      function cq_vc_hotspot_func($atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'image' => '',
            'width' => '',
            'color' => '',
            'islightbox' => 'no',
            'ispulse' => 'no',
            'pulsecolor' => 'pulse-white',
            'icon' => '',
            'iconsize' => '',
            'tooltipstyle' => 'shadow',
            'iconbackground' => 'rgba(0,0,0,0.8)',
            'tooltipanimation' => 'grow',
            'circlecolor' => '#FFFFFF',
            'opacity' => '1',
            'arrowposition' => '',
            'trigger' => '',
            'links' => '',
            'maxwidth' => '240',
            'custom_links_target' => '',
            'position' => '25%|30%,35%|20%,45%|60%,75%|20%',
            'containerwidth' => '',
            'marginoffset' => '',
            'icontype' => 'dot',
            'fonticon' => '',
            'isdisplayall' => 'off',
            'displayednum' => '1',
            'startnumber' => '1',
            'extra_class' => ''
          ), $atts ) );

          if($icontype=="icon"){
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }
          wp_register_style( 'vc_hotspot_cq_style', plugins_url('css/style.min.css', __FILE__));
          wp_enqueue_style( 'vc_hotspot_cq_style' );
          wp_register_style('tooltipster', plugins_url('../profilecard/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');

          if($islightbox == "yes"){
              wp_register_style('lity', plugins_url('css/lity.min.css', __FILE__));
              wp_enqueue_style('lity');
              wp_register_script('lity', plugins_url('js/lity.min.js', __FILE__), array('jquery'));
              wp_enqueue_script('lity');

          }

          wp_register_script('tooltipster', plugins_url('../profilecard/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');

          wp_register_script('vc_hotspot_cq_script', plugins_url('js/script.min.js', __FILE__), array("jquery", "tooltipster"));
          wp_enqueue_script('vc_hotspot_cq_script');


          $image_full = wp_get_attachment_image_src($image, 'full');
          $position = explode(',', $position);
          $color = explode(',', $color);
          $arrowposition = explode(',', $arrowposition);
          $links = explode(',', $links);
          $fonticon = explode(',', $fonticon);
          $i = -1;
          $is_new_tag = false;
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          if(strpos($content, '[/hotspotitem]')===false){
              $content = str_replace('</div>', '', trim($content));
              $contentarr = explode('<div class="tooltip-content">', trim($content));
          }else{
              $content = str_replace('[/hotspotitem]', '', trim($content));
              $contentarr = explode('[hotspotitem]', trim($content));
              $is_new_tag = true;
          }
          $pulseborder = "";
          $ispulse = $ispulse == "yes" ? $pulsecolor : "";
          array_shift($contentarr);
          $output = $tooltipcontent = '';
          $output .= '<div style="width:'.$containerwidth.';" class="cqtooltip-wrapper '.$extra_class.'" data-opacity="'.$opacity.'" data-tooltipanimation="'.$tooltipanimation.'" data-tooltipstyle="'.$tooltipstyle.'" data-trigger="'.$trigger.'" data-maxwidth="'.$maxwidth.'" data-marginoffset="'.$marginoffset.'" data-isdisplayall="'.$isdisplayall.'" data-displayednum="'.$displayednum.'">';

            $image_temp = $imagethumb = "";
            $fullimage = $image_full[0];
            $imagethumb = $fullimage;
            $attachment = get_post($image);
            if($width!=""){
                if(function_exists('wpb_resize')){
                    $image_temp = wpb_resize($image, null, $width, null);
                    $imagethumb = $image_temp['url'];
                    if($imagethumb=="") $imagethumb = $fullimage;
                }
            }

          $output .= '<img src="'.$imagethumb.'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
          $output .= '<div class="cq-hotspots">';
          foreach ($contentarr as $key => $thecontent) {
             $i++;
             $tooltipcontent = '';
             if(!isset($position[$i])) $position[$i] = '25%|25%';
             if(!isset($fonticon[$i])) $fonticon[$i] = '';
             $iconposition = explode('|', trim($position[$i]));
             if(!isset($iconposition[0])) $iconposition[0] = '25%';
             if(!isset($iconposition[1])) $iconposition[1] = '25%';
             if(!isset($color[$i])) $color[$i] = '';
             if(!isset($arrowposition[$i])) $arrowposition[$i] = 'top';
             if(!isset($links[$i])) $links[$i] = '';
             if($color[$i]!="") {
               $iconcolor = $color[$i];
             }else{
               $iconcolor = $iconbackground;
             }
             $tooltipcontent = trim($thecontent);
             if($is_new_tag){
             }
             $tooltipcontent = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $tooltipcontent);
             $tooltipcontent = preg_replace('/^(<br \/>)*/', "", $tooltipcontent);
             $tooltipcontent = preg_replace('/^(<\/p>)*/', "", $tooltipcontent);
             $output .= '<div class="hotspot-item '.$ispulse.' '.$pulseborder.'" style="top:'.$iconposition[0].';left:'.$iconposition[1].';" data-top="'.$iconposition[0].'" data-left="'.$iconposition[1].'">';
             $is_lity = $islightbox == "yes" ? "data-lity" : "";
             if($links[$i]!=""){
                 $output .= '<a href="'.$links[$i].'" class="cq-tooltip" style="background-color:'.$iconcolor.';" '.$is_lity.' data-iconbg="'.$iconcolor.'" data-tooltip="'.htmlspecialchars($tooltipcontent).'" data-arrowposition="'.trim($arrowposition[$i]).'" target="'.$custom_links_target.'">';
             }else{
                 $output .= '<a href="#" class="cq-tooltip" style="background-color:'.$iconcolor.';" data-iconbg="'.$iconcolor.'" data-tooltip="'.htmlspecialchars($tooltipcontent).'" data-arrowposition="'.trim($arrowposition[$i]).'">';
             }
             if($icontype=="number"){
                if($startnumber!=1){
                  $output .= '<i>';
                  $output .= $startnumber+$i;
                  $output .= '</i>';
                }else{
                  $output .= '<i>';
                  $output .= $i+1;
                  $output .= '</i>';
                }
             }else if($icontype=="icon"){
                if($fonticon[$i]!=""){
                    $output .= '<i class="fa '.$fonticon[$i].'" style="color:'.$circlecolor.';"></i>';
                }else{
                    $output .= '<span style="background:'.$circlecolor.';">';
                    $output .= '</span>';
                }
             }else{
                $output .= '<span style="background:'.$circlecolor.';">';
                $output .= '</span>';
             }

             $output .= '</a>';
             $output .= '</div>';
          }
          $output .= '</div>';
          $output .= '</div>';

          return $output;

        }


  }

}

?>
