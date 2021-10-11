<?php

namespace Stratum;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Version_Control
{
    /** @var string */
    protected $plugin_version = '';

    /** @var string */
    protected $dbVersion = '';

    /** @var bool */
    protected $needUpgrade = false;

    public function __construct(){
        $settings = Settings::get_instance();

        $this->plugin_version = $settings->getVersion();

        $this->checkVersion();
        $this->addActions();
    }

    protected function checkVersion()
    {
        $this->dbVersion = $this->getCurrentDatabaseVersion();

        if (version_compare($this->plugin_version, $this->dbVersion, '>')) {
            $this->needUpgrade = true;
        }
    }

    protected function addActions()
    {
        if ($this->needUpgrade) {
            add_action('init', [$this, 'upgrade']);
        }
    }

    public function upgrade()
    {
        // Nothing to do at the moment
        $this->afterUpgrade();
    }

    protected function afterUpgrade()
    {
        $this->setCurrentDatabaseVersion($this->plugin_version);

        if (version_compare($this->plugin_version, $this->dbVersion, '!=')) {
            $this->addVersionToHistory($this->plugin_version);
        }
    }

    protected function getCurrentDatabaseVersion()
    {
        return get_option('stratum_db_version', '0.0.0');
    }

    protected function setCurrentDatabaseVersion($version)
    {
        update_option('stratum_db_version', $version);
    }

    protected function addVersionToHistory($version)
    {
        $versionHistory = get_option('stratum_db_version_history', []);

        if (!in_array($version, $versionHistory)) {
            $versionHistory[] = $version;
            update_option('stratum_db_version_history', $versionHistory);
        }
    }
}
