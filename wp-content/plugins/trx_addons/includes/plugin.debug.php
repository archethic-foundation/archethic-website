<?php
/**
 * Debug utilities (for internal use only!)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Short analogs for debug functions
if (!function_exists('dcl')) {	function dcl($msg) {			if (!function_exists('is_user_logged_in') || is_user_logged_in()) echo '<br><pre>' . esc_html($msg) . '</pre><br>'; } }	// Console log - output any message on the screen
if (!function_exists('dco')) {	function dco(&$var, $lvl=-1) {	if (!function_exists('is_user_logged_in') || is_user_logged_in()) trx_addons_debug_dump_screen($var, $lvl); } }	// Console obj - output object struct. on the screen
if (!function_exists('dcs')) {	function dcs($lvl=-1) {			if (!function_exists('is_user_logged_in') || is_user_logged_in()) trx_addons_debug_calls_stack_screen($lvl); } }	// Console stack - output calls stack on the screen
if (!function_exists('dcw')) {	function dcw($q=null) {			if (!function_exists('is_user_logged_in') || is_user_logged_in()) trx_addons_debug_dump_wp($q); } }				// Console WP - output WP is_... states on the screen
if (!function_exists('ddo')) {	function ddo(&$var, $lvl=-1) {	trx_addons_debug_dump_var($var, $lvl); } }	// Return obj - return object structure
if (!function_exists('dfl')) {	function dfl($var) {			trx_addons_debug_trace_message($var); } }	// File log - output any message into file debug.log
if (!function_exists('dfo')) {	function dfo(&$var, $lvl=-1) {	trx_addons_debug_dump_file($var, $lvl); } }	// File obj - output object structure into file debug.log
if (!function_exists('dfs')) {	function dfs($lvl=-1) { 		trx_addons_debug_calls_stack_file($lvl); } }// File stack - output calls stack into file debug.log

// Save msg into file debug.log in the stylesheet directory
if (!function_exists('trx_addons_debug_trace_message')) {
	function trx_addons_debug_trace_message($msg) {
		trx_addons_fpc(get_stylesheet_directory().'/debug.log', date('d.m.Y H:i:s')." $msg\n", FILE_APPEND);
	}
}

// Output call stack into the current page
if (!function_exists('trx_addons_debug_calls_stack_screen')) {
	function trx_addons_debug_calls_stack_screen($level=-1) {
		$s = debug_backtrace();
		array_shift($s);
		trx_addons_debug_dump_screen($s, $level);
	}
}

// Output call stack into the debug.log
if (!function_exists('trx_addons_debug_calls_stack_file')) {
	function trx_addons_debug_calls_stack_file($level=-1) {
		$s = debug_backtrace();
		array_shift($s);
		trx_addons_debug_dump_file($s, $level);
	}
}

// Output var's dump into the current page
if (!function_exists('trx_addons_debug_dump_screen')) {
	function trx_addons_debug_dump_screen(&$var, $level=-1) {
		if ((is_array($var) || is_object($var)) && count($var))
			echo "<pre>\n".nl2br(esc_html(trx_addons_debug_dump_var($var, 0, $level)))."</pre>\n";
		else
			echo "<tt>".nl2br(esc_html(trx_addons_debug_dump_var($var, 0, $level)))."</tt>\n";
	}
}

// Output var's dump into the debug.log
if (!function_exists('trx_addons_debug_dump_file')) {
	function trx_addons_debug_dump_file(&$var, $level=-1) {
		trx_addons_debug_trace_message("\n\n".trx_addons_debug_dump_var($var, 0, $level));
	}
}

// Return var's dump as string
if (!function_exists('trx_addons_debug_dump_var')) {
	function trx_addons_debug_dump_var(&$var, $level=0, $max_level=-1)  {
		if (is_array($var)) $type="Array[".count($var)."]";
		else if (is_object($var)) $type="Object";
		else $type="";
		if ($type) {
			$rez = "$type\n";
			if ($max_level<0 || $level < $max_level) {
				for (Reset($var), $level++; list($k, $v)=each($var); ) {
					if (is_array($v) && $k==="GLOBALS") continue;
					for ($i=0; $i<$level*3; $i++) $rez .= " ";
					$rez .= $k.' => '. trx_addons_debug_dump_var($v, $level, $max_level);
				}
			}
		} else if (is_bool($var))
			$rez = ($var ? 'true' : 'false')."\n";
		else if (is_long($var) || is_float($var) || intval($var) != 0)
			$rez = $var."\n";
		else
			$rez = '"'.$var."\"\n";
		return $rez;
	}
}

// Output WP is_...() state into the current page
if (!function_exists('trx_addons_debug_dump_wp')) {
	function trx_addons_debug_dump_wp($query=null) {
		global $wp_query;
		if (!$query && !empty($wp_query)) $query = $wp_query;
		echo "<tt>"
			."<br>admin=".is_admin()
			."<br>mobile=".wp_is_mobile()
			.($query ? "<br>main_query=".is_main_query()."  query=".esc_html($query->is_main_query()) : '')
			."<br>query->is_posts_page=".esc_html($query->is_posts_page)
			."<br>home=".is_home().($query ? "  query=".esc_html($query->is_home()) : '')
			."<br>fp=".is_front_page().($query ? "  query=".esc_html($query->is_front_page()) : '')
			."<br>search=".is_search().($query ? "  query=".esc_html($query->is_search()) : '')
			."<br>category=".is_category().($query ? "  query=".esc_html($query->is_category()) : '')
			."<br>tag=".is_tag().($query ? "  query=".esc_html($query->is_tag()) : '')
			."<br>archive=".is_archive().($query ? "  query=".esc_html($query->is_archive()) : '')
			."<br>day=".is_day().($query ? "  query=".esc_html($query->is_day()) : '')
			."<br>month=".is_month().($query ? "  query=".esc_html($query->is_month()) : '')
			."<br>year=".is_year().($query ? "  query=".esc_html($query->is_year()) : '')
			."<br>author=".is_author().($query ? "  query=".esc_html($query->is_author()) : '')
			."<br>page=".is_page().($query ? "  query=".esc_html($query->is_page()) : '')
			."<br>single=".is_single().($query ? "  query=".esc_html($query->is_single()) : '')
			."<br>singular=".is_singular().($query ? "  query=".esc_html($query->is_singular()) : '')
			."<br>attachment=".is_attachment().($query ? "  query=".esc_html($query->is_attachment()) : '')
			."<br><br />"
			."</tt>";
	}
}


/* Load debug script and styles
---------------------------------------------------------- */

// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_debug_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_debug_merge_styles');
	function trx_addons_debug_merge_styles($list) {
		$list[] = 'css/trx_addons.debug.css';
		return $list;
	}
}

// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_debug_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_debug_merge_scripts');
	function trx_addons_debug_merge_scripts($list) {
		$list[] = 'js/trx_addons.debug.js';
		return $list;
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'trx_addons_debug_load_scripts_admin' ) ) {
	add_action("trx_addons_action_load_scripts_admin", 'trx_addons_debug_load_scripts_admin');
	function trx_addons_debug_load_scripts_admin($all=false) {
		wp_enqueue_style( 'trx_addons-debug', trx_addons_get_file_url('css/trx_addons.debug.css'), array(), null );
		wp_enqueue_script( 'trx_addons-debug', trx_addons_get_file_url('js/trx_addons.debug.js'), array('jquery'), null, true );
	}
}

	
// Load required styles and scripts for admin mode
if ( !function_exists( 'trx_addons_debug_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_debug_load_scripts_front');
	function trx_addons_debug_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-debug', trx_addons_get_file_url('css/trx_addons.debug.css'), array(), null );
			wp_enqueue_script( 'trx_addons-debug', trx_addons_get_file_url('js/trx_addons.debug.js'), array('jquery'), null, true );
		}
	}
}


/* Profiler functions
---------------------------------------------------------- */

// Add hooks on theme setup action
if ( !function_exists( 'trx_addons_profiler_theme_init' ) ) {
	add_action( 'after_setup_theme', 'trx_addons_profiler_theme_init', 1 );
	add_action( 'after_setup_theme', 'trx_addons_profiler_theme_init', 9999 );
	function trx_addons_profiler_theme_init() {
		static $cnt = 0;
		trx_addons_profiler_add_point( $cnt++ == 0 ? esc_html__('THEME INIT START', 'trx_addons') : esc_html__('THEME INIT END', 'trx_addons'), $cnt>1);
	}
}
// Add hooks on plugins init action
if ( !function_exists( 'trx_addons_profiler_plugins_init' ) ) {
	add_action( 'init', 'trx_addons_profiler_plugins_init', 1 );
	add_action( 'init', 'trx_addons_profiler_plugins_init', 9999 );
	function trx_addons_profiler_plugins_init() {
		static $cnt = 0;
		trx_addons_profiler_add_point( $cnt++ == 0 ? esc_html__('PLUGINS INIT START', 'trx_addons') : esc_html__('PLUGINS INIT END', 'trx_addons'), false);
	}
}
// Add hooks on WP setup is done action
if ( !function_exists( 'trx_addons_profiler_wp_init' ) ) {
	add_action( 'wp', 'trx_addons_profiler_wp_init', 9999 );
	function trx_addons_profiler_wp_init() {
		trx_addons_profiler_add_point( esc_html__('WP PAGE OUTPUT START', 'trx_addons'), false);
	}
}

// Add profiler point
if (!function_exists('trx_addons_profiler_add_point')) {
	function trx_addons_profiler_add_point($name, $theme_mode=true, $data=false) {
		global $timestart, $TRX_ADDONS_STORAGE;
		if (trx_addons_is_on(trx_addons_get_option('debug_mode', true, false))) {
			if ($data===false) {
				$data = array(
					'mode' => $theme_mode,
					'time' => microtime(true)-max(0, $timestart),
					'memory' => memory_get_usage(),
					'queries' => get_num_queries()
					);
			}
			$TRX_ADDONS_STORAGE['profiler_points'][microtime(true).'|'.$name] = $data;
		}
	}
}

// Show time and memory statistic
if (!function_exists('trx_addons_profiler_show')) {
	if (is_admin())
		add_action('admin_footer',	'trx_addons_profiler_show', 9999);
	else
		add_action('wp_footer',		'trx_addons_profiler_show', 9999);
	function trx_addons_profiler_show() {
		global $timestart, $TRX_ADDONS_STORAGE;
		
		if (!trx_addons_get_setting('allow_profiler', false)
			|| trx_addons_is_off(trx_addons_get_option('debug_mode', false, false))
			|| (function_exists('is_user_logged_in') && !is_user_logged_in())
			|| in_array(trx_addons_get_value_gp('action'), array('vc_load_template_preview'))
			) return;
		
		trx_addons_profiler_add_point(esc_html__('WP PAGE OUTPUT END', 'trx_addons'), !is_admin());
		?>
		<div class="trx_addons_profiler sc_align_center">
			<h4 class="profiler_title"><?php esc_html_e('Execution time and Memory usage', 'trx_addons'); ?></h4>
			<table>
				<tr>
					<th rowspan="2"><?php esc_html_e('Point', 'trx_addons'); ?></th>
					<th colspan="2"><?php esc_html_e('Execution time (seconds)', 'trx_addons'); ?></th>
					<th colspan="2"><?php esc_html_e('Usage memory (bytes)', 'trx_addons'); ?></th>
					<th colspan="2"><?php esc_html_e('Database queries', 'trx_addons'); ?></th>
				</tr>
				<tr>
					<th><?php esc_html_e('By theme', 'trx_addons'); ?></th>
					<th><?php esc_html_e('Total (WP+Plugins+Theme)', 'trx_addons'); ?></th>
					<th><?php esc_html_e('By theme', 'trx_addons'); ?></th>
					<th><?php esc_html_e('Total (WP+Plugins+Theme)', 'trx_addons'); ?></th>
					<th><?php esc_html_e('By theme', 'trx_addons'); ?></th>
					<th><?php esc_html_e('Total (WP+Plugins+Theme)', 'trx_addons'); ?></th>
				</tr>
				<?php
				$theme_usage = $last_usage = array(
					'time' => 0,
					'memory' => 0,
					'queries' => 0
				);
				foreach ($TRX_ADDONS_STORAGE['profiler_points'] as $key => $data) {
					$point = explode('|', $key);
					$point = !empty($point[1]) ? $point[1] : $key;
					if ($data['mode']) {
						$theme_usage['time']    += $data['time'] - $last_usage['time'];
						$theme_usage['memory']  += $data['memory'] - $last_usage['memory'];
						$theme_usage['queries'] += $data['queries'] - $last_usage['queries'];
					}
					?>
					<tr>
						<td class="sc_align_left"><?php echo esc_html($point); ?></td>
						<td><?php echo esc_html($data['mode'] ? round($theme_usage['time'], 3) : '-'); ?></td>
						<td><?php echo esc_html(round($data['time'], 3)); ?></td>
						<td><?php echo esc_html($data['mode'] ? number_format($theme_usage['memory'], 0, '.', ' ') : '-'); ?></td>
						<td><?php echo esc_html(number_format($data['memory'], 0, '.', ' ')); ?></td>
						<td><?php echo esc_html($data['mode'] ? $theme_usage['queries'] : '-'); ?></td>
						<td><?php echo esc_html($data['queries']); ?></td>
					</tr>
					<?php
					$last_usage = $data;
				}
				?>
			</table>
		</div>
		<?php
	}
}
?>