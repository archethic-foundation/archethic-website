<?php
/**
 * File system manipulations
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


/* Enqueue scripts and styles
------------------------------------------------------------------------------------- */

//  Enqueue slider scripts and styles
if ( !function_exists( 'trx_addons_enqueue_slider' ) ) {
	function trx_addons_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			wp_enqueue_style(  'swiperslider', trx_addons_get_file_url('js/swiper/swiper.min.css'), array(), null );
			wp_enqueue_script( 'swiperslider', trx_addons_get_file_url('js/swiper/swiper.jquery.min.js'), array('jquery'), null, true );
		} else if ($engine=='all' || $engine=='elastistack') {
			wp_enqueue_script( 'modernizr', trx_addons_get_file_url('js/elastistack/modernizr.custom.js'), array(), null, true );
			wp_enqueue_script( 'draggabilly', trx_addons_get_file_url('js/elastistack/draggabilly.pkgd.min.js'), array(), null, true );
			wp_enqueue_script( 'elastistack', trx_addons_get_file_url('js/elastistack/elastistack.js'), array(), null, true );
		}
	}
}

// Enqueue popup scripts and styles
// Link must have attribute: data-rel="popupEngine" or data-rel="popupEngine[gallery]"
if ( !function_exists( 'trx_addons_enqueue_popup' ) ) {
	function trx_addons_enqueue_popup($engine='') {
		if ($engine=='pretty') {
			wp_enqueue_style(  'prettyphoto',	trx_addons_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			wp_enqueue_script( 'prettyphoto',	trx_addons_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else {
			wp_enqueue_style(  'magnific-popup',trx_addons_get_file_url('js/magnific/magnific-popup.min.css'), array(), null );
			wp_enqueue_script( 'magnific-popup',trx_addons_get_file_url('js/magnific/jquery.magnific-popup.min.js'), array('jquery'), null, true );
		}
	}
}

//  Enqueue WP colorpicker in front-end
if ( !function_exists( 'trx_addons_enqueue_wp_color_picker' ) ) {
	function trx_addons_enqueue_wp_color_picker() {
	    wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), null, true);
		wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), null, true);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', array(
			'clear' => __( 'Clear', 'trx_addons' ),
			'defaultString' => __( 'Default', 'trx_addons' ),
			'pick' => __( 'Select Color', 'trx_addons' ),
			'current' => __( 'Current Color', 'trx_addons' ),
		)); 
	
	}
}

//  Enqueue Google map script
if ( !function_exists( 'trx_addons_enqueue_googlemap' ) ) {
	function trx_addons_enqueue_googlemap() {
		if (trx_addons_is_on(trx_addons_get_option('api_google_load'))) {
			$api_key = trx_addons_get_option('api_google');
			wp_enqueue_script( 'google-maps', trx_addons_get_protocol().'://maps.googleapis.com/maps/api/js'.($api_key ? '?key='.$api_key : ''), array(), null, true );
		}
	}
}

//  Enqueue Select2 scripts and styles
if ( !function_exists( 'trx_addons_enqueue_select2' ) ) {
	function trx_addons_enqueue_select2() {
		wp_enqueue_style(  'select2', trx_addons_get_file_url('js/select2/select2.min.css'), array(), null );
		wp_enqueue_script( 'select2', trx_addons_get_file_url('js/select2/select2.min.js'), array('jquery'), null, true );
	}
}


/* Merge scripts and styles
------------------------------------------------------------------------------------- */

// Merge all separate styles and scripts to the single file to increase page upload speed
if ( !function_exists( 'trx_addons_merge_files' ) ) {
	function trx_addons_merge_files($to, $list) {
		$s = '';
		foreach ($list as $f) {
			$s .= trx_addons_fgc(trx_addons_get_file_dir($f));
		}
		if ( $s != '') {
			trx_addons_fpc( trx_addons_get_file_dir($to), 
				'/* ' 
				. strip_tags( __("ATTENTION! This file was generated automatically! Don't change it!!!", 'trx_addons') ) 
				. "\n----------------------------------------------------------------------- */\n"
				. strpos($to, '.js')!==false 
						? trx_addons_minify_js( $s ) 
						: trx_addons_minify_css( $s )
				);
		}
	}
}


// Merge styles to the SASS file
if ( !function_exists( 'trx_addons_merge_sass' ) ) {
	function trx_addons_merge_sass($to, $list, $need_responsive=false, $root='../') {
		global $TRX_ADDONS_STORAGE;
		$responsive = $TRX_ADDONS_STORAGE['responsive'];
		if ($need_responsive) $responsive = apply_filters('trx_addons_filter_sass_responsive', $responsive);
		$sass = array(
			'import' => '',
			'sizes'  => array()
			);
		$save = false;
		foreach ($list as $f) {
			$add = false;
			if (($fdir = trx_addons_get_file_dir($f)) != '') {
				if ($need_responsive) {
					$css = trx_addons_fgc($fdir);
					if (strpos($css, '@required')!==false) $add = true;
					foreach ($responsive as $k=>$v) {
//						if (preg_match("/([\d\w\-_]+--{$k})\(/", $css, $matches)) {
                        if (preg_match("/([\d\w\-_]+--{$k})\(/", $css, $matches)){
							$sass['sizes'][$k] = (!empty($sass['sizes'][$k]) ? $sass['sizes'][$k] : '') . "\t@include {$matches[1]}();\n";
							$add = true;
						}
					}
				} else
					$add = true;
			}
			if ($add) {
				$sass['import'] .= apply_filters('trx_addons_filter_sass_import', "@import \"{$root}{$f}\";\n", $f);
				$save = true;
			}
		}
		if ($save) {
			$output = '/* ' 
					. strip_tags( __("ATTENTION! This file was generated automatically! Don't change it!!!", 'trx_addons') ) 
					. "\n----------------------------------------------------------------------- */\n"
					. $sass['import'];
			if ($need_responsive) {
				foreach ($responsive as $k => $v) {
					if (!empty($sass['sizes'][$k])) {
						$output .= "\n\n"
								. strip_tags( sprintf( __("/* SASS Suffix: --%s */", 'trx_addons'), $k) )
								. "\n"
								. "@media " . (!empty($v['min']) ? "(min-width: {$v['min']}px)" : '')
											. (!empty($v['min']) && !empty($v['max']) ? ' and ' : '')
											. (!empty($v['max']) ? "(max-width: {$v['max']}px)" : '')
											. " {\n"
												. $sass['sizes'][$k]
											. "}\n";
					}
				}
			}
			trx_addons_fpc( trx_addons_get_file_dir($to), apply_filters('trx_addons_filter_sass_output', $output, $to) );
		}
	}
}



/* Check if file/folder present in the child theme and return path (url) to it. 
   Else - path (url) to file in the main theme dir
------------------------------------------------------------------------------------- */
if (!function_exists('trx_addons_get_file_dir')) {	
	function trx_addons_get_file_dir($file, $return_url=false) {
		if ($file[0]=='/') $file = substr($file, 1);
		$theme_dir = get_template_directory().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$theme_url = get_template_directory_uri().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$child_dir = get_stylesheet_directory().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$child_url = get_stylesheet_directory_uri().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$dir = '';
		if (file_exists(($child_dir).($file)))
			$dir = ($return_url ? $child_url : $child_dir) . trx_addons_check_min_file($file, $child_dir);
		else if (file_exists(($theme_dir).($file)))
			$dir = ($return_url ? $theme_url : $theme_dir) . trx_addons_check_min_file($file, $theme_dir);
		else if (file_exists(TRX_ADDONS_PLUGIN_DIR . ($file)))
			$dir = ($return_url ? TRX_ADDONS_PLUGIN_URL : TRX_ADDONS_PLUGIN_DIR) . trx_addons_check_min_file($file, TRX_ADDONS_PLUGIN_DIR);
		return apply_filters( $return_url ? 'trx_addons_get_file_url' : 'trx_addons_get_file_dir', $dir, $file );
	}
}

if (!function_exists('trx_addons_get_file_url')) {	
	function trx_addons_get_file_url($file) {
		return trx_addons_get_file_dir($file, true);
	}
}

// Return file extension from full name/path
if (!function_exists('trx_addons_get_file_ext')) {	
	function trx_addons_get_file_ext($file) {
		$parts = pathinfo($file);
		return $parts['extension'];
	}
}

// Return file name from full name/path
if (!function_exists('trx_addons_get_file_name')) {	
	function trx_addons_get_file_name($file, $without_ext=true) {
		$parts = pathinfo($file);
		return !empty($parts['filename']) && $without_ext ? $parts['filename'] : $parts['basename'];
	}
}

// Detect folder location (in the child theme or in the main theme)
if (!function_exists('trx_addons_get_folder_dir')) {	
	function trx_addons_get_folder_dir($folder, $return_url=false) {
		if ($folder[0]=='/') $folder = substr($folder, 1);
		$theme_dir = get_template_directory().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$theme_url = get_template_directory_uri().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$child_dir = get_stylesheet_directory().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$child_url = get_stylesheet_directory_uri().'/'.TRX_ADDONS_PLUGIN_BASE.'/';
		$dir = '';
		if (is_dir(($child_dir).($folder)))
			$dir = ($return_url ? $child_url : $child_dir).($folder);
		else if (is_dir(($theme_dir).($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).($folder);
		else if (is_dir((TRX_ADDONS_PLUGIN_DIR).($folder)))
			$dir = ($return_url ? TRX_ADDONS_PLUGIN_URL : TRX_ADDONS_PLUGIN_DIR).($folder);
		return $dir;
	}
}

if (!function_exists('trx_addons_get_folder_url')) {	
	function trx_addons_get_folder_url($folder) {
		return trx_addons_get_folder_dir($folder, true);
	}
}

// Get domain part from URL
if (!function_exists('trx_addons_get_domain_from_url')) {
	function trx_addons_get_domain_from_url($url) {
		if (($pos=strpos($url, '://'))!==false) $url = substr($url, $pos+3);
		if (($pos=strpos($url, '/'))!==false) $url = substr($url, 0, $pos);
		return $url;
	}
}


// Return .min version (if exists and filetime .min > filetime original) instead original
if (!function_exists('trx_addons_check_min_file')) {	
	function trx_addons_check_min_file($file, $dir) {
		if (substr($file, -3)=='.js') {
			if (substr($file, -7)!='.min.js' && trx_addons_is_off(trx_addons_get_option('debug_mode', false, false))) {
				$dir = trailingslashit($dir);
				$file_min = substr($file, 0, strlen($file)-3).'.min.js';
				if (file_exists($dir . $file_min) && filemtime($dir . $file) <= filemtime($dir . $file_min)) $file = $file_min;
			}
		} else if (substr($file, -4)=='.css') {
			if (substr($file, -8)!='.min.css'  && trx_addons_is_off(trx_addons_get_option('debug_mode', false, false))) {
				$dir = trailingslashit($dir);
				$file_min = substr($file, 0, strlen($file)-4).'.min.css';
				if (file_exists($dir . $file_min) && filemtime($dir . $file) <= filemtime($dir . $file_min)) $file = $file_min;
			}
		}
		return $file;
	}
}



/* Init WP Filesystem before the plugins and theme init
------------------------------------------------------------------- */
if (!function_exists('trx_addons_init_filesystem')) {
	add_action( 'after_setup_theme', 'trx_addons_init_filesystem', 0);
	function trx_addons_init_filesystem() {
        if( !function_exists('WP_Filesystem') ) {
            require_once trailingslashit(ABSPATH) . 'wp-admin/includes/file.php';
        }
		if (is_admin()) {
			$url = admin_url();
			$creds = false;
			// First attempt to get credentials.
			if ( function_exists('request_filesystem_credentials') && false === ( $creds = request_filesystem_credentials( $url, '', false, false, array() ) ) ) {
				// If we comes here - we don't have credentials
				// so the request for them is displaying no need for further processing
				return false;
			}
	
			// Now we got some credentials - try to use them.
			if ( !WP_Filesystem( $creds ) ) {
				// Incorrect connection data - ask for credentials again, now with error message.
				if ( function_exists('request_filesystem_credentials') ) request_filesystem_credentials( $url, '', true, false );
				return false;
			}
			
			return true; // Filesystem object successfully initiated.
		} else {
            WP_Filesystem();
		}
		return true;
	}
}


// Put data into specified file
if (!function_exists('trx_addons_fpc')) {	
	function trx_addons_fpc($file, $data, $flag=0) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				// Attention! WP_Filesystem can't append the content to the file!
				if ($flag==FILE_APPEND && $wp_filesystem->exists($file) && strpos($file, '//')===false) {
					// If it is a existing local file (not contain '//' in the path) and we need to append data -
					// use native PHP function to prevent large consumption of memory
					return file_put_contents($file, $data, $flag);
				} else {
					// In other case (not a local file or not need to append data or file not exists)
					// That's why we have to read the contents of the file into a string,
					// add new content to this string and re-write it to the file if parameter $flag == FILE_APPEND!
					return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND && $wp_filesystem->exists($file) ? $wp_filesystem->get_contents($file) : '') . $data, false);
				}
			} else {
				if (trx_addons_is_on(trx_addons_get_option('debug_mode', false, false)))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'trx_addons'), $file));
			}
		}
		return false;
	}
}

// Get text from specified file
if (!function_exists('trx_addons_fgc')) {	
	function trx_addons_fgc($file, $unpack=false) {
		global $wp_filesystem;
		if ( ! empty( $file ) ) {
			if ( isset( $wp_filesystem ) && is_object( $wp_filesystem ) ) {
				$file = str_replace( ABSPATH, $wp_filesystem->abspath(), $file );
				$tmp_cont = strpos( $file, '//' ) !== false //&& ! $allow_url_fopen 
								? trx_addons_remote_get( $file ) 
								: $wp_filesystem->get_contents( $file );
				if ( $unpack && trx_addons_get_file_ext( $file ) == 'zip' ) {
					$tmp_name = 'tmp-'.rand().'.zip';
					$tmp = wp_upload_bits($tmp_name, null, $tmp_cont);
					if ( $tmp['error'] ) {
						$tmp_cont = '';
					} else {
						unzip_file( $tmp['file'], dirname( $tmp['file'] ) );
						$file_name = dirname( $tmp['file'] ) . '/' . basename( $file, '.zip' ) . '.txt';
						$tmp_cont = trx_addons_fgc( $file_name );
						unlink( $tmp['file'] );
						unlink( $file_name );
					}
				}
				return $tmp_cont;
			} else {
				if ( trx_addons_is_on( trx_addons_get_option('debug_mode', false, false ) ) ) {
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get contents from the file "%s" failed', 'trx_addons'), $file));
				}
			}
		}
		return '';
	}
}

// Get text from specified file via HTTP (cURL)
if (!function_exists('trx_addons_remote_get')) {	
	function trx_addons_remote_get($file, $timeout=-1) {
		// Set timeout as half of the PHP execution time
		if ($timeout < 1) $timeout = round( 0.5 * max(30, ini_get('max_execution_time')));
		$response = wp_remote_get($file, array(
									'timeout'     => $timeout
									)
								);
		//return wp_remote_retrieve_response_code( $response ) == 200 ? wp_remote_retrieve_body( $response ) : '';
		return !is_wp_error($response) && isset($response['response']['code']) && $response['response']['code']==200 ? $response['body'] : '';
	}
}

// Get array with rows from specified file
if (!function_exists('trx_addons_fga')) {	
	function trx_addons_fga($file) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				return $wp_filesystem->get_contents_array($file);
			} else {
				if (trx_addons_is_on(trx_addons_get_option('debug_mode', false, false)))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get rows from the file "%s" failed', 'trx_addons'), $file));
			}
		}
		return array();
	}
}

// Remove unsafe characters from file/folder path
if (!function_exists('trx_addons_esc')) {	
	function trx_addons_esc($file) {
		return str_replace(array('\\', '~', '$', ':', ';', '+', '>', '<', '|', '"', "'", '`', "\xFF", "\x0A", "\x0D", '*', '?', '^'), '/', trim($file));
	}
}
?>