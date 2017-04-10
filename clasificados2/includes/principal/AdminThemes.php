<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class AdminThemes extends Themes
    {
        private static $instance;

        public static function newInstance()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct()
        {
            parent::__construct();
            $this->setCurrentTheme( osc_admin_theme() );
        }

        public function setCurrentThemeUrl()
        {
            if ($this->theme_exists) {
                $this->theme_url = osc_admin_base_url() . 'themes/' . $this->theme . '/';
            } else {
                $this->theme_url = osc_admin_base_url() . 'gui/';
            }
        }

        public function setCurrentThemePath()
        {
            if (file_exists(osc_admin_base_path() . 'themes/' . $this->theme . '/')) {
                $this->theme_exists = true;
                $this->theme_path = osc_admin_base_path() . 'themes/' . $this->theme . '/';
            } else {
                $this->theme_exists = false;
                $this->theme_path = osc_admin_base_path() . 'gui/';
            }
        }
    }

    /* file end: ./oc-includes/osclass/AdminThemes.php */