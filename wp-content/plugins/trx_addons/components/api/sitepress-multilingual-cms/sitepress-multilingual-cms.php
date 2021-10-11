<?php
/**
 * Plugin support: WPML
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_wpml' ) ) {
	function trx_addons_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}
*/

// Return default language
if ( !function_exists( 'trx_addons_wpml_get_default_language' ) ) {
    function trx_addons_wpml_get_default_language() {
        return trx_addons_exists_wpml() ? apply_filters( 'wpml_default_language', null ) : '';
    }
}

// Return current language
if ( !function_exists( 'trx_addons_wpml_get_current_language' ) ) {
    function trx_addons_wpml_get_current_language() {
        return trx_addons_exists_wpml() ? apply_filters( 'wpml_current_language', null ) : '';
    }
}


// Create option with current language
if (!function_exists('trx_addons_wpml_add_current_language_option')) {
    add_filter('trx_addons_filter_options', 'trx_addons_wpml_add_current_language_option');
    function trx_addons_wpml_add_current_language_option($options) {
        if (trx_addons_exists_wpml()) {
            $options['wpml_current_language'] = array(
                "title" => '',
                "desc" => '',
                "std" => trx_addons_wpml_get_current_language(),
                "type" => "hidden"
            );
        }
        return $options;
    }
}

// Create translated option's values
if (!function_exists('trx_addons_wpml_replace_translated_options')) {
    add_filter('trx_addons_filter_load_options', 'trx_addons_wpml_replace_translated_options');
    function trx_addons_wpml_replace_translated_options($values) {
        if (trx_addons_exists_wpml()) {
            global $TRX_ADDONS_STORAGE;
            if (is_array($values) && isset($TRX_ADDONS_STORAGE['options']) && is_array($TRX_ADDONS_STORAGE['options'])) {
                $translated = apply_filters('trx_addons_filter_load_options_translated', get_option('trx_addons_options_translated'));
                if (empty($translated)) $translated = array();
                $lang = trx_addons_wpml_get_current_language();
                foreach ($TRX_ADDONS_STORAGE['options'] as $k=>$v) {
                    if (empty($v['translate'])) continue;
                    $param_name = sprintf('%1$s_lang_%2$s', $k, $lang);
                    if (isset($translated[$param_name]))
                        $values[$k] = $translated[$param_name];
                }
                // Disable menu cache if WPML is active
                if (!empty($values['menu_cache'])) $values['menu_cache'] = 0;
            }
        }
        return $values;
    }
}

// Disable menu cache if WPML is active
if (!function_exists('trx_addons_wpml_disable_menu_cache')) {
    add_filter('trx_addons_filter_options_save', 'trx_addons_wpml_disable_menu_cache');
    function trx_addons_wpml_disable_menu_cache($values) {
        if (trx_addons_exists_wpml()) {
            if (!empty($values['menu_cache'])) $values['menu_cache'] = 0;
        }
        return $values;
    }
}


// Duplicate translatable options for each language
if (!function_exists('trx_addons_wpml_duplicate_options')) {
    add_filter('trx_addons_filter_options_save', 'trx_addons_wpml_duplicate_options');
    function trx_addons_wpml_duplicate_options($values) {
        if (trx_addons_exists_wpml()) {
            // Detect current language
            if (isset($values['wpml_current_language'])) {
                $tmp = explode('!', $values['wpml_current_language']);
                $lang = $tmp[0];
                unset($values['wpml_current_language']);
            } else {
                $lang = trx_addons_wpml_get_current_language();
            }

            // Duplicate options to the language-specific options and remove original
            if (is_array($values)) {
                $translated = apply_filters('trx_addons_filter_load_options_translated', get_option('trx_addons_options_translated'));
                if (empty($translated)) $translated = array();
                global $TRX_ADDONS_STORAGE;
                if (is_array($values) && isset($TRX_ADDONS_STORAGE['options']) && is_array($TRX_ADDONS_STORAGE['options'])) {
                    $changed = false;
                    foreach ($TRX_ADDONS_STORAGE['options'] as $k => $v) {
                        if (!empty($v['translate']) && isset($values[$k])) {
                            $param_name = sprintf('%1$s_lang_%2$s', $k, $lang);
                            $translated[$param_name] = $values[$k];
                            $changed = true;
                        }
                    }
                    if ($changed) {
                        update_option('trx_addons_options_translated', $translated);
                    }
                }
            }
        }
        return $values;
    }
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_wpml_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_wpml_importer_required_plugins', 10, 2 );
    function trx_addons_wpml_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'sitepress-multilingual-cms')!==false && !trx_addons_exists_wpml() )
            $not_installed .= '<br>' . esc_html__('WPML - Sitepress Multilingual CMS', 'trx_addons');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_wpml_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_wpml_importer_set_options' );
    function trx_addons_wpml_importer_set_options($options=array()) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $options['required_plugins']) ) {
            $options['additional_options'][] = 'icl_sitepress_settings';
        }
        if (is_array($options['files']) && count($options['files']) > 0) {
            foreach ($options['files'] as $k => $v) {
                $options['files'][$k]['file_with_sitepress-multilingual-cms'] = str_replace('name.ext', 'sitepress-multilingual-cms.txt', $v['file_with_']);
            }
        }
        return $options;
    }
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_wpml_importer_check_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_import_theme_options',	'trx_addons_wpml_importer_check_options', 10, 4 );
	function trx_addons_wpml_importer_check_options($allow, $k, $v, $options) {
		if ($allow && $k == 'icl_sitepress_settings') {
			$allow = trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $options['required_plugins']);
		}
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_wpml_importer_show_params' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_wpml_importer_show_params', 10, 1 );
    function trx_addons_wpml_importer_show_params($importer) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $importer->options['required_plugins']) ) {
            $importer->show_importer_params(array(
                'slug' => 'sitepress-multilingual-cms',
                'title' => esc_html__('Import Sitepress Multilingual CMS (WPML)', 'trx_addons'),
                'part' => 0
            ));
        }
    }
}

// Create tables
if ( !function_exists( 'trx_addons_wpml_importer_create_tables' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_clear_tables',	'trx_addons_wpml_importer_create_tables', 10, 2 );
    function trx_addons_wpml_importer_create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $icl_mo_files_domains = $wpdb->prefix.'icl_mo_files_domains';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb -> prefix}icl_mo_files_domains` (
			`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`file_path` varchar(250) NOT NULL,
			`file_path_md5` varchar(32) NOT NULL,
			`domain` varchar(45) NOT NULL,
			`status` varchar(20) NOT NULL,
			`num_of_strings` int(11) NOT NULL,
			`last_modified` int(11) NOT NULL,
			`component_type` enum('plugin','theme','other') NOT NULL,
			`component_id` varchar(100) DEFAULT NULL,
			UNIQUE KEY `file_path_md5_UNIQUE` (`file_path_md5`)
	 	) $charset_collate;";

        dbDelta($sql);

        $icl_string_pages = $wpdb->prefix.'icl_string_pages';
        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb -> prefix}icl_string_pages` (
		  	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		  	`string_id` bigint(20) NOT NULL,
		  	`url_id` bigint(20) NOT NULL,
		  	PRIMARY KEY (`id`),
		  	KEY `string_to_url_id` (`url_id`)
	 	) $charset_collate;";

        dbDelta($sql);

        $icl_string_urls = $wpdb->prefix.'icl_string_urls';
        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb -> prefix}icl_string_urls` (
		  	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		  	`language` varchar(7) NOT NULL,
		  	`url` varchar(255) NOT NULL,
		  	PRIMARY KEY (`id`)
	 	) $charset_collate;";

        dbDelta($sql);
    }
}

if ( !function_exists( 'trx_addons_wpml_importer_clear_tables' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_clear_tables',	'trx_addons_wpml_importer_clear_tables', 10, 2 );
    function trx_addons_wpml_importer_clear_tables($importer, $clear_tables) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $importer->options['required_plugins']) ) {
            trx_addons_wpml_importer_create_tables();

            global $wpdb;
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_content_status");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_core_status");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_flags");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_languages");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_languages_translations");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_locale_map");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_message_status");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_mo_files_domains");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_node");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_reminders");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_strings");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_string_packages");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_string_pages");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_string_positions");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_string_status");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_string_translations");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_string_urls");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_translate");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_translate_job");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_translations");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_translation_batches");
            $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "icl_translation_status");

        }
    }
}

// Import posts
if ( !function_exists( 'trx_addons_wpml_importer_import' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_wpml_importer_import', 10, 2 );
    function trx_addons_wpml_importer_import($importer, $action) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $importer->options['required_plugins']) ) {
            if ( $action == 'import_sitepress-multilingual-cms' ) {

                $importer->response['start_from_id'] = 0;
                $importer->import_dump('sitepress-multilingual-cms', esc_html__('Sitepress Multilingual CMS (WPML) data', 'trx_addons'));
            }
        }
    }
}

// Display import progress
if ( !function_exists( 'trx_addons_wpml_importer_import_fields' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_wpml_importer_import_fields', 10, 1 );
    function trx_addons_wpml_importer_import_fields($importer) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $importer->options['required_plugins']) ) {
            $importer->show_importer_fields(array(
                    'slug'=>'sitepress-multilingual-cms',
                    'title' => esc_html__('Sitepress Multilingual CMS (WPML) data', 'trx_addons')
                )
            );
        }
    }
}

// Export posts
if ( !function_exists( 'trx_addons_wpml_importer_export' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_wpml_importer_export', 10, 1 );
    function trx_addons_wpml_importer_export($importer) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $importer->options['required_plugins']) ) {
            trx_addons_fpc($importer->export_file_dir('sitepress-multilingual-cms.txt'), serialize( array(
                    "icl_content_status"			=> $importer->export_dump("icl_content_status"),
                    "icl_core_status"				=> $importer->export_dump("icl_core_status"),
                    "icl_flags"						=> $importer->export_dump("icl_flags"),
                    "icl_languages"					=> $importer->export_dump("icl_languages"),
                    "icl_languages_translations"	=> $importer->export_dump("icl_languages_translations"),
                    "icl_locale_map"				=> $importer->export_dump("icl_locale_map"),
                    "icl_message_status"			=> $importer->export_dump("icl_message_status"),
                    "icl_mo_files_domains"			=> $importer->export_dump("icl_mo_files_domains"),
                    "icl_node"						=> $importer->export_dump("icl_node"),
                    "icl_reminders"					=> $importer->export_dump("icl_reminders"),
                    "icl_strings"					=> $importer->export_dump("icl_strings"),
                    "icl_string_packages"			=> $importer->export_dump("icl_string_packages"),
                    "icl_string_pages"				=> $importer->export_dump("icl_string_pages"),
                    "icl_string_positions"			=> $importer->export_dump("icl_string_positions"),
                    "icl_string_status"				=> $importer->export_dump("icl_string_status"),
                    "icl_string_translations"		=> $importer->export_dump("icl_string_translations"),
                    "icl_string_urls"				=> $importer->export_dump("icl_string_urls"),
                    "icl_translate"					=> $importer->export_dump("icl_translate"),
                    "icl_translate_job"				=> $importer->export_dump("icl_translate_job"),
                    "icl_translations"				=> $importer->export_dump("icl_translations"),
                    "icl_translation_batches"		=> $importer->export_dump("icl_translation_batches"),
                    "icl_translation_status"		=> $importer->export_dump("icl_translation_status"),
                ) )
            );
        }
    }
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_wpml_importer_export_fields' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_wpml_importer_export_fields', 10, 1 );
    function trx_addons_wpml_importer_export_fields($importer) {
        if ( trx_addons_exists_wpml() && in_array('sitepress-multilingual-cms', $importer->options['required_plugins']) ) {
            $importer->show_exporter_fields(array(
                    'slug'	=> 'sitepress-multilingual-cms',
                    'title' => esc_html__('Sitepress Multilingual CMS (WPML) data', 'trx_addons')
                )
            );
        }
    }
}

?>