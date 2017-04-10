<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');


    /**
     * AdminMenu class
     *
     * @since 3.0
     * @package Osclass
     * @subpackage classes
     * @author Osclass
     */
    class AdminMenu
    {
        private static $instance;
        private $aMenu;

        public function __construct()
        {
            $this->aMenu = array();
        }

        public static function newInstance()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         *  Initialize menu representation.
         */
        public function init()
        {
            $this->add_menu( __('Panel de administracion'), osc_admin_base_url(), 'dash', 'moderator');

            

            $this->add_menu( __('Anuncios'), osc_admin_base_url(true).'?page=items', 'items', 'moderator');
            $this->add_submenu( 'items', __('Manage listings'), osc_admin_base_url(true).'?page=items', 'items_manage', 'moderator');
            $this->add_submenu( 'items', __('Reported listings'), osc_admin_base_url(true).'?page=items&action=items_reported', 'items_reported', 'moderator');
            $this->add_submenu( 'items', __('Manage media'), osc_admin_base_url(true).'?page=media', 'items_media', 'moderator');
            $this->add_submenu( 'items', __('Comments'), osc_admin_base_url(true).'?page=comments', 'items_comments', 'moderator');
            $this->add_submenu( 'items', __('Custom fields'), osc_admin_base_url(true).'?page=cfields', 'items_cfields', 'administrator');
            $this->add_submenu( 'items', __('Settings'), osc_admin_base_url(true).'?page=items&action=settings', 'items_settings', 'administrator');

           
            $this->add_menu( __('Estadisticas'), osc_admin_base_url(true) .'?page=stats&action=items', 'stats', 'moderator' );
            $this->add_submenu( 'stats', __('Listings'), osc_admin_base_url(true) .'?page=stats&action=items', 'stats_items', 'moderator');
            $this->add_submenu( 'stats', __('Reports'), osc_admin_base_url(true) .'?page=stats&action=reports', 'stats_reports', 'moderator');
            $this->add_submenu( 'stats', __('Users'), osc_admin_base_url(true) .'?page=stats&action=users', 'stats_users', 'moderator');
            $this->add_submenu( 'stats', __('Comments'), osc_admin_base_url(true) .'?page=stats&action=comments', 'stats_comments', 'moderator');

           

            

            $this->add_menu( __('Usuarios'), osc_admin_base_url(true) .'?page=users', 'users', 'moderator');
            $this->add_submenu( 'users', __('Users'), osc_admin_base_url(true) .'?page=users', 'users_manage', 'administrator');
            $this->add_submenu( 'users', __('User Settings'), osc_admin_base_url(true) .'?page=users&action=settings', 'users_settings', 'administrator');
            $this->add_submenu( 'users', __('Administrators'), osc_admin_base_url(true) .'?page=admins', 'users_administrators_manage', 'administrator');
            $this->add_submenu( 'users', __('Your Profile'), osc_admin_base_url(true) .'?page=admins&action=edit', 'users_administrators_profile', 'moderator');
            $this->add_submenu( 'users', __('Alerts'), osc_admin_base_url(true) .'?page=users&action=alerts', 'users_alerts', 'administrator');
            $this->add_submenu( 'users', __('Ban rules'), osc_admin_base_url(true) .'?page=users&action=ban', 'users_ban', 'administrator');

            
        }

        /**
         * Add menu entry
         *
         * @param type $menu_title
         * @param type $url
         * @param type $menu_id
         * @param type $icon_url   (unused)
         * @param type $capability (unused)
         * @param type $position   (unused)
         */
        public function add_menu($menu_title, $url, $menu_id, $capability = null ,$icon_url = null, $position = null )
        {
            $array = array(
                $menu_title,
                $url,
                $menu_id,
                $capability,
                $icon_url,
                $position
            );
            $this->aMenu[$menu_id] = $array;
        }

        /**
         * Remove menu and submenus under menu with id $id_menu
         *
         * @param type $id_menu
         */
        public function remove_menu( $menu_id )
        {
            unset( $this->aMenu[$menu_id] );
        }

        /**
         * Add submenu under menu id $menu_id
         *
         * @param type $menu_id
         * @param type $submenu_title
         * @param type $url
         * @param type $id_submenu
         * @param type $capability
         */
        public function add_submenu( $menu_id, $submenu_title, $url, $submenu_id, $capability = null)
        {
            $array = array(
                $submenu_title,
                $url,
                $submenu_id,
                $menu_id,
                $capability
            );
            $this->aMenu[$menu_id]['sub'][$submenu_id] = $array;
        }

        /**
         * Remove submenu with id $id_submenu under menu id $id_menu
         *
         * @param type $id_menu
         * @param type $id_submenu
         */
        public function remove_submenu( $menu_id, $submenu_id )
        {
            unset( $this->aMenu[$menu_id]['sub'][$submenu_id] );
        }

        /**
         * Add submenu under menu id $menu_id
         *
         * @param type $menu_id
         * @param type $submenu_title
         * @param type $id_submenu
         * @param type $capability
         * @since 3.1
         */
        public function add_submenu_divider( $menu_id, $submenu_title, $submenu_id, $capability = null)
        {
            $array = array(
                $submenu_title,
                "divider_" . $submenu_id,
                $menu_id,
                $capability
            );
            $this->aMenu[$menu_id]['sub']["divider_" . $submenu_id] = $array;
        }

        /**
         * Remove submenu with id $id_submenu under menu id $id_menu
         *
         * @param type $id_menu
         * @param type $id_submenu
         * @since 3.1
         */
        public function remove_submenu_divider( $menu_id, $submenu_id )
        {
            unset( $this->aMenu[$menu_id]['sub']["divider_" . $submenu_id] );
        }

        /**
         * Return menu as array
         *
         * @return type
         */
        public function get_array_menu()
        {
            return $this->aMenu;
        }

        // common functions
        public function add_menu_items( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('items', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_categories( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('categories', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_pages( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('pages', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_appearance( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('appearance', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_plugins( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('plugins', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_settings( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('settings', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_tools( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('tools', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_users( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('users', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        public function add_menu_stats( $submenu_title, $url, $submenu_id, $capability = null, $icon_url = null )
        {
            $this->add_submenu('stats', $submenu_title, $url, $submenu_id, $capability, $icon_url);
        }

        /*
         * Empty the menu
         */
        public function clear_menu( )
        {
            $this->aMenu = array();
        }
    }

?>
