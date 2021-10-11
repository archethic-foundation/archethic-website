<?php
/**
 * PHP utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



/* Arrays manipulations
----------------------------------------------------------------------------------------------------- */

// Return first key (by default) or value from associative array
if (!function_exists('trx_addons_array_get_first')) {
	function trx_addons_array_get_first(&$arr, $key=true) {
		$rez = false;
		foreach ($arr as $k=>$v) {
			$rez = $key ? $k : $v;
			break;
		}
		return $rez;
	}
}

// Convert list to associative array (use values as keys)
if (!function_exists('trx_addons_array_from_list')) {
	function trx_addons_array_from_list($arr) {
		$new = array();
		foreach ($arr as $v) $new[$v] = $v;
		return $new;
	}
}

// Merge arrays and lists (preserve number indexes)
// $a = array("one", "k2"=>"two", "three");
// $b = array("four", "k1"=>"five", "k2"=>"six", "seven");
// $c = array_merge($a, $b);			["one", "k2"=>"six", "three", "four", "k1"=>"five", "seven");
// $d = trx_addons_array_merge($a, $b);	["four", "k2"=>"six", "seven", "k1"=>"five");
if (!function_exists('trx_addons_array_merge')) {
	function trx_addons_array_merge($a1, $a2) {
		for ($i = 1; $i < func_num_args(); $i++){
			$arg = func_get_arg($i);
			if (is_array($arg) && count($arg)>0) {
				foreach($arg as $k=>$v) {
					$a1[$k] = $v;
				}
			}
		}
		return $a1;
	}
}

// Inserts any number of scalars or arrays at the point
// in the haystack immediately after the search key ($needle) was found,
// or at the end if the needle is not found or not supplied.
// Modifies $haystack in place.
// @param array &$haystack the associative array to search. This will be modified by the function
// @param string $needle the key to search for
// @param mixed $stuff one or more arrays or scalars to be inserted into $haystack
// @return int the index at which $needle was found
if (!function_exists('trx_addons_array_insert')) {
	function trx_addons_array_insert_after(&$haystack, $needle, $stuff){
		if (! is_array($haystack) ) return -1;

		$new_array = array();
		for ($i = 2; $i < func_num_args(); ++$i){
			$arg = func_get_arg($i);
			if (is_array($arg)) {
				if ($i==2)
					$new_array = $arg;
				else
					$new_array = trx_addons_array_merge($new_array, $arg);
			} else 
				$new_array[] = $arg;
		}

		$i = 0;
		if (is_array($haystack) && count($haystack) > 0) {
			foreach($haystack as $key => $value){
				$i++;
				if ($key == $needle) break;
			}
		}

		$haystack = trx_addons_array_merge(array_slice($haystack, 0, $i, true), $new_array, array_slice($haystack, $i, null, true));

		return $i;
    }
}

// Inserts any number of scalars or arrays at the point
// in the haystack immediately before the search key ($needle) was found,
// or at the end if the needle is not found or not supplied.
// Modifies $haystack in place.
// @param array &$haystack the associative array to search. This will be modified by the function
// @param string $needle the key to search for
// @param mixed $stuff one or more arrays or scalars to be inserted into $haystack
// @return int the index at which $needle was found
if (!function_exists('trx_addons_array_insert_before')) {
	function trx_addons_array_insert_before(&$haystack, $needle, $stuff){
		if (! is_array($haystack) ) return -1;

		$new_array = array();
		for ($i = 2; $i < func_num_args(); ++$i){
			$arg = func_get_arg($i);
			if (is_array($arg)) {
				if ($i==2)
					$new_array = $arg;
				else
					$new_array = trx_addons_array_merge($new_array, $arg);
			} else 
				$new_array[] = $arg;
		}

		$i = 0;
		if (is_array($haystack) && count($haystack) > 0) {
			foreach($haystack as $key => $value){
				if ($key == $needle) break;
				$i++;
			}
		}

		$haystack = trx_addons_array_merge(array_slice($haystack, 0, $i, true), $new_array, array_slice($haystack, $i, null, true));

		return $i;
    }
}


/* Colors manipulations
----------------------------------------------------------------------------------------------------- */

if (!function_exists('trx_addons_hex2rgb')) {
	function trx_addons_hex2rgb($hex) {
		$dec = hexdec(substr($hex, 0, 1)== '#' ? substr($hex, 1) : $hex);
		return array('r'=> $dec >> 16, 'g'=> ($dec & 0x00FF00) >> 8, 'b'=> $dec & 0x0000FF);
	}
}

if (!function_exists('trx_addons_hex2rgba')) {
	function trx_addons_hex2rgba($hex, $alpha) {
		$rgb = trx_addons_hex2rgb($hex);
		return 'rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].','.$alpha.')';
	}
}

if (!function_exists('trx_addons_hex2hsb')) {
	function trx_addons_hex2hsb ($hex, $h=0, $s=0, $b=0) {
		$hsb = trx_addons_rgb2hsb(trx_addons_hex2rgb($hex));
		$hsb['h'] = min(359, $hsb['h'] + $h);
		$hsb['s'] = min(100, $hsb['s'] + $s);
		$hsb['b'] = min(100, $hsb['b'] + $b);
		return $hsb;
	}
}

if (!function_exists('trx_addons_rgb2hsb')) {
	function trx_addons_rgb2hsb ($rgb) {
		$hsb = array();
		$hsb['b'] = max(max($rgb['r'], $rgb['g']), $rgb['b']);
		$hsb['s'] = ($hsb['b'] <= 0) ? 0 : round(100*($hsb['b'] - min(min($rgb['r'], $rgb['g']), $rgb['b'])) / $hsb['b']);
		$hsb['b'] = round(($hsb['b'] /255)*100);
		if (($rgb['r']==$rgb['g']) && ($rgb['g']==$rgb['b'])) $hsb['h'] = 0;
		else if($rgb['r']>=$rgb['g'] && $rgb['g']>=$rgb['b']) $hsb['h'] = 60*($rgb['g']-$rgb['b'])/($rgb['r']-$rgb['b']);
		else if($rgb['g']>=$rgb['r'] && $rgb['r']>=$rgb['b']) $hsb['h'] = 60  + 60*($rgb['g']-$rgb['r'])/($rgb['g']-$rgb['b']);
		else if($rgb['g']>=$rgb['b'] && $rgb['b']>=$rgb['r']) $hsb['h'] = 120 + 60*($rgb['b']-$rgb['r'])/($rgb['g']-$rgb['r']);
		else if($rgb['b']>=$rgb['g'] && $rgb['g']>=$rgb['r']) $hsb['h'] = 180 + 60*($rgb['b']-$rgb['g'])/($rgb['b']-$rgb['r']);
		else if($rgb['b']>=$rgb['r'] && $rgb['r']>=$rgb['g']) $hsb['h'] = 240 + 60*($rgb['r']-$rgb['g'])/($rgb['b']-$rgb['g']);
		else if($rgb['r']>=$rgb['b'] && $rgb['b']>=$rgb['g']) $hsb['h'] = 300 + 60*($rgb['r']-$rgb['b'])/($rgb['r']-$rgb['g']);
		else $hsb['h'] = 0;
		$hsb['h'] = round($hsb['h']);
		return $hsb;
	}
}

if (!function_exists('trx_addons_hsb2rgb')) {
	function trx_addons_hsb2rgb($hsb) {
		$rgb = array();
		$h = round($hsb['h']);
		$s = round($hsb['s']*255/100);
		$v = round($hsb['b']*255/100);
		if ($s == 0) {
			$rgb['r'] = $rgb['g'] = $rgb['b'] = $v;
		} else {
			$t1 = $v;
			$t2 = (255-$s)*$v/255;
			$t3 = ($t1-$t2)*($h%60)/60;
			if ($h==360) $h = 0;
			if ($h<60) { 		$rgb['r']=$t1; $rgb['b']=$t2; $rgb['g']=$t2+$t3; }
			else if ($h<120) {	$rgb['g']=$t1; $rgb['b']=$t2; $rgb['r']=$t1-$t3; }
			else if ($h<180) {	$rgb['g']=$t1; $rgb['r']=$t2; $rgb['b']=$t2+$t3; }
			else if ($h<240) {	$rgb['b']=$t1; $rgb['r']=$t2; $rgb['g']=$t1-$t3; }
			else if ($h<300) {	$rgb['b']=$t1; $rgb['g']=$t2; $rgb['r']=$t2+$t3; }
			else if ($h<360) {	$rgb['r']=$t1; $rgb['g']=$t2; $rgb['b']=$t1-$t3; }
			else {				$rgb['r']=0;   $rgb['g']=0;   $rgb['b']=0; }
		}
		return array('r'=>round($rgb['r']), 'g'=>round($rgb['g']), 'b'=>round($rgb['b']));
	}
}

if (!function_exists('trx_addons_rgb2hex')) {
	function trx_addons_rgb2hex($rgb) {
		$hex = array(
			dechex($rgb['r']),
			dechex($rgb['g']),
			dechex($rgb['b'])
		);
		return '#'.(strlen($hex[0])==1 ? '0' : '').($hex[0]).(strlen($hex[1])==1 ? '0' : '').($hex[1]).(strlen($hex[2])==1 ? '0' : '').($hex[2]);
	}
}

if (!function_exists('trx_addons_hsb2hex')) {
	function trx_addons_hsb2hex($hsb) {
		return trx_addons_rgb2hex(trx_addons_hsb2rgb($hsb));
	}
}






/* Date manipulations
----------------------------------------------------------------------------------------------------- */

// Convert date from Date format (dd.mm.YYYY) to MySQL format (YYYY-mm-dd)
if (!function_exists('trx_addons_date_to_sql')) {
	function trx_addons_date_to_sql($str) {
		if (trim($str)=='') return '';
		$str = strtr(trim($str),'/\.,','----');
		if (trim($str)=='00-00-0000' || trim($str)=='00-00-00') return '';
		$pos = strpos($str,'-');
		if ($pos > 3) return $str;
		$d=trim(substr($str,0,$pos));
		$str=substr($str,$pos+1);
		$pos = strpos($str,'-');
		$m=trim(substr($str,0,$pos));
		$y=trim(substr($str,$pos+1));
		$y=($y<50?$y+2000:($y<1900?$y+1900:$y));
		return ''.($y).'-'.(strlen($m)<2?'0':'').($m).'-'.(strlen($d)<2?'0':'').($d);
	}
}






/* Numbers manipulations
----------------------------------------------------------------------------------------------------- */

// Display price
if (!function_exists('trx_addons_format_price')) {
	function trx_addons_format_price($price) {
		return is_numeric($price) 
					? ($price != round($price, 0)
						? number_format(round($price, 2), 2, '.', ' ')
						: number_format($price, 0, '.', ' ')
						)
					: $price;
	}
}


// Convert number to Kilo/Mega/Giga
if (!function_exists('trx_addons_num2kilo')) {
	function trx_addons_num2kilo($num) {
		return $num > 1000000000
					? ceil(num/1000000000, 1).'G'
					: ($num > 1000000
						? ceil(num/1000000, 1).'M'
						: ($num > 1000
							? round($num/1000, 0).'K'
							: $num
							)
						);
	}
}





/* String manipulations
----------------------------------------------------------------------------------------------------- */

// Check value for "on" | "off" | "inherit" values
if (!function_exists('trx_addons_is_on')) {
	function trx_addons_is_on($prm) {
		return (is_numeric( $prm ) && $prm > 0) || in_array(strtolower($prm), array('true', 'on', 'yes', 'show'));
	}
}
if (!function_exists('trx_addons_is_off')) {
	function trx_addons_is_off($prm) {
		return empty($prm) || (is_numeric( $prm ) && $prm === 0) || in_array(strtolower($prm), array('false', 'off', 'no', 'none', 'hide'));
	}
}
if (!function_exists('trx_addons_is_inherit')) {
	function trx_addons_is_inherit($prm) {
		return in_array(strtolower($prm), array('inherit'));
	}
}

// Return truncated string
if (!function_exists('trx_addons_strshort')) {
	function trx_addons_strshort($str, $maxlength, $add='...') {
		if ($maxlength < 0) 
			return '';
		if ($maxlength == 0)
			return '';
		if ($maxlength >= strlen($str)) 
			return strip_tags($str);
		$str = substr(strip_tags($str), 0, $maxlength - strlen($add));
		$ch = substr($str, $maxlength - strlen($add), 1);
		if ($ch != ' ') {
			for ($i = strlen($str) - 1; $i > 0; $i--)
				if (substr($str, $i, 1) == ' ') break;
			$str = trim(substr($str, 0, $i));
		}
		if (!empty($str) && strpos(',.:;-', substr($str, -1))!==false) $str = substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('trx_addons_unserialize')) {
	function trx_addons_unserialize($str) {
		if ( !empty($str) && is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			//if ($data===false) $data = @unserialize(str_replace(array("\n", "\r"), array('\\n','\\r'), $str));
			return $data;
		} else
			return $str;
	}
}

// Replace macros in the string
if (!function_exists('trx_addons_prepare_macros')) {
	function trx_addons_prepare_macros($str) {
		$str = str_replace(
			array("{{",  "}}",   "((",  "))",   "||"),
			array("<i>", "</i>", "<b>", "</b>", "<br>"),
			$str);
		$str = preg_replace('/(\^(\d+))/', '<sup>$2</sup>', $str);
		return $str;
	}
}

// Remove macros from the string
if (!function_exists('trx_addons_remove_macros')) {
	function trx_addons_remove_macros($str) {
		return str_replace(
			array("{{", "}}", "((", "))", "||", "^"),
			array("",   "",   "",   "",   " ",  ""),
			$str);
	}
}

// Prepare string to use as telephone link
if (!function_exists('trx_addons_get_phone_link')) {
	function trx_addons_get_phone_link($str) {
		return 'tel:'.str_replace(array(' ', '-', '(', ')', '.', ','), '', $str);
	}
}

// Output string with the html layout (if not empty)
// (put it between 'before' and 'after' tags)
// Attention! This string may contain layout formed in any plugin (widgets or shortcodes output) and not require escaping to prevent damage!
if ( !function_exists('trx_addons_show_layout') ) {
	function trx_addons_show_layout($str, $before='', $after='') {
		if (trim($str) != '') {
			if (!is_admin()) {
				$str = str_replace(array('{{Y}}', '{Y}'), date('Y'), $str);
			}
			printf("%s%s%s", $before, $str, $after);
		}
	}
}

// Return template part as string
if ( !function_exists( 'trx_addons_get_template_part_as_string' ) ) {
	function trx_addons_get_template_part_as_string($file, $args_name, $args=array()) {
		static $fdirs = array();
		if (!is_array($file))
			$file = array($file);
		$output = '';
		foreach ($file as $f) {
			if (!empty($fdirs[$f]) || ($fdirs[$f] = trx_addons_get_file_dir($f)) != '') { 
				if (!empty($args_name) && !empty($args))
					set_query_var($args_name, $args);
				ob_start();
				include $fdirs[$f];
				$output = ob_get_contents();
				ob_end_clean();
				break;
			}
		}
		return $output;
	}	
}

// Include part of template with specified parameters
if (!function_exists('trx_addons_get_template_part')) {	
	function trx_addons_get_template_part($file, $args_name='', $args=array()) {
		static $fdirs = array();
		if (!is_array($file))
			$file = array($file);
		foreach ($file as $f) {
			if (!empty($fdirs[$f]) || ($fdirs[$f] = trx_addons_get_file_dir($f)) != '') { 
				if (!empty($args_name) && !empty($args))
					set_query_var($args_name, $args);
				include $fdirs[$f];
				break;
			}
		}
	}
}


// Add dynamic CSS and return class for it
if (!function_exists('trx_addons_add_inline_css_class')) {
	function trx_addons_add_inline_css_class($css) {
		$class_name = sprintf('trx_addons_inline_%d', mt_rand());
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['inline_css'] = (!empty($TRX_ADDONS_STORAGE['inline_css']) ? $TRX_ADDONS_STORAGE['inline_css'] : '') . sprintf('.%s{%s}', $class_name, $css);
		return $class_name;
	}
}

// Add dynamic CSS to insert it to the footer
if ( !function_exists('trx_addons_add_inline_css') ) {
	function trx_addons_add_inline_css($css) {
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['inline_css'] = (!empty($TRX_ADDONS_STORAGE['inline_css']) ? $TRX_ADDONS_STORAGE['inline_css'] : '') . $css;
	}
}

// Return dynamic CSS to insert it to the footer
if ( !function_exists('trx_addons_get_inline_css') ) {
	function trx_addons_get_inline_css($clear=false) {
		global $TRX_ADDONS_STORAGE;
		$rez = '';
        if (!empty($TRX_ADDONS_STORAGE['inline_css'])) {
        	$rez = $TRX_ADDONS_STORAGE['inline_css'];
        	if ($clear) $TRX_ADDONS_STORAGE['inline_css'] = '';
        }
        return $rez;
	}
}

// Add dynamic HTML to insert it to the footer
if ( !function_exists('trx_addons_add_inline_html') ) {
	function trx_addons_add_inline_html($html) {
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['inline_html'] = (!empty($TRX_ADDONS_STORAGE['inline_html']) ? $TRX_ADDONS_STORAGE['inline_html'] : '') . $html;
	}
}

// Return dynamic HTML to insert it to the footer
if ( !function_exists('trx_addons_get_inline_html') ) {
	function trx_addons_get_inline_html() {
		global $TRX_ADDONS_STORAGE;
		return !empty($TRX_ADDONS_STORAGE['inline_html']) ? $TRX_ADDONS_STORAGE['inline_html'] : '';
	}
}
?>