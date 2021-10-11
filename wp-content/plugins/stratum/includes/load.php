<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


require_once dirname( __FILE__ ) . '/functions.php';
require_once dirname( __FILE__ ) . '/excerpt-helper.php';
require_once dirname( __FILE__ ) . '/main.php';
require_once dirname( __FILE__ ) . '/translation.php';
require_once dirname( __FILE__ ) . '/settings.php';
require_once dirname( __FILE__ ) . '/scripts-manager.php';
require_once dirname( __FILE__ ) . '/widgets-manager.php';
require_once dirname( __FILE__ ) . '/ajax-manager.php';
require_once dirname( __FILE__ ) . '/controls-manager.php';
require_once dirname( __FILE__ ) . '/token-manager.php';
require_once dirname( __FILE__ ) . '/rest-api.php';
require_once dirname( __FILE__ ) . '/version-control.php';
require_once dirname( __FILE__ ) . '/admin-page.php';
require_once dirname( __FILE__ ) . '/stratum-sections.php';
require_once dirname( __FILE__ ) . '/libraries/class.settings-api.php';

//premium
require_once dirname( __FILE__ ) . '/premium.php';

//license
//require_once dirname( __FILE__ ) . '/license/load.php';