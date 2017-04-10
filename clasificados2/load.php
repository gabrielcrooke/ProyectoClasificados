<?php



define('principal_VERSION', '3.7.1');

if( !defined('ABS_PATH') ) {
    define( 'ABS_PATH', str_replace('\\', '/', dirname(__FILE__) . '/' ));
}

define('LIB_PATH', ABS_PATH . 'includes/');
define('CONTENT_PATH', ABS_PATH . 'contenido/');
define('THEMES_PATH', CONTENT_PATH . 'themes/');
define('PLUGINS_PATH', CONTENT_PATH . 'plugins/');
define('TRANSLATIONS_PATH', CONTENT_PATH . 'languages/');

if( !file_exists(ABS_PATH . 'config.php') ) {
    require_once LIB_PATH . 'principal/helpers/hErrors.php';

    $title   = 'principal &raquo; Error';
    $message = 'There doesn\'t seem to be a <code>config.php</code> file. principal isn\'t installed. <a href="http://forums.principal.org/">Need more help?</a></p>';
    $message .= '<p><a class="button" href="' . osc_get_absolute_url() .'oc-includes/principal/install.php">Install</a></p>';
    osc_die($title, $message);
}

// load database configuration
require_once ABS_PATH . 'config.php';
require_once LIB_PATH . 'principal/default-constants.php';

// Sets PHP error handling
if( OSC_DEBUG ) {
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL | E_STRICT );

    if( OSC_DEBUG_LOG ) {
        ini_set( 'display_errors', 0 );
        ini_set( 'log_errors', 1 );
        ini_set( 'error_log', CONTENT_PATH . 'debug.log' );
    }
} else {
    error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
}

require_once LIB_PATH . 'principal/db.php';
require_once LIB_PATH . 'principal/Logger/LogDatabase.php';
require_once LIB_PATH . 'principal/classes/database/DBConnectionClass.php';
require_once LIB_PATH . 'principal/classes/database/DBCommandClass.php';
require_once LIB_PATH . 'principal/classes/database/DBRecordsetClass.php';
require_once LIB_PATH . 'principal/classes/database/DAO.php';
require_once LIB_PATH . 'principal/model/SiteInfo.php';
require_once LIB_PATH . 'principal/helpers/hDatabaseInfo.php';
require_once LIB_PATH . 'principal/model/Preference.php';
require_once LIB_PATH . 'principal/helpers/hPreference.php';

// check if principal is installed
if( !getBoolPreference('principal_installed') && MULTISITE ) {
    header('Location: ' . WEB_PATH); die;
} else if( !getBoolPreference('principal_installed') ) {
    require_once LIB_PATH . 'principal/helpers/hErrors.php';

    $title    = 'principal &raquo; Error';
    $message  = 'principal isn\'t installed. <a href="http://forums.principal.org/">Need more help?</a></p>';
    $message .= '<p><a class="button" href="' . osc_get_absolute_url() .'oc-includes/principal/install.php">Install</a></p>';

    osc_die($title, $message);
}

require_once LIB_PATH . 'principal/helpers/hDefines.php';
require_once LIB_PATH . 'principal/helpers/hLocale.php';
require_once LIB_PATH . 'principal/helpers/hMessages.php';
require_once LIB_PATH . 'principal/helpers/hUsers.php';
require_once LIB_PATH . 'principal/helpers/hItems.php';
require_once LIB_PATH . 'principal/helpers/hSearch.php';
require_once LIB_PATH . 'principal/helpers/hUtils.php';

require_once LIB_PATH . 'principal/helpers/hCategories.php';
require_once LIB_PATH . 'principal/helpers/hTranslations.php';
require_once LIB_PATH . 'principal/helpers/hSecurity.php';
require_once LIB_PATH . 'principal/helpers/hSanitize.php';
require_once LIB_PATH . 'principal/helpers/hValidate.php';
require_once LIB_PATH . 'principal/helpers/hPage.php';
require_once LIB_PATH . 'principal/helpers/hPagination.php';
require_once LIB_PATH . 'principal/helpers/hPremium.php';
require_once LIB_PATH . 'principal/helpers/hTheme.php';
require_once LIB_PATH . 'principal/helpers/hLocation.php';
require_once LIB_PATH . 'principal/core/Params.php';
require_once LIB_PATH . 'principal/core/Cookie.php';
require_once LIB_PATH . 'principal/core/Session.php';
require_once LIB_PATH . 'principal/core/View.php';
require_once LIB_PATH . 'principal/core/BaseModel.php';
require_once LIB_PATH . 'principal/core/AdminBaseModel.php';
require_once LIB_PATH . 'principal/core/SecBaseModel.php';
require_once LIB_PATH . 'principal/core/WebSecBaseModel.php';
require_once LIB_PATH . 'principal/core/AdminSecBaseModel.php';
require_once LIB_PATH . 'principal/core/Translation.php';

require_once LIB_PATH . 'principal/Themes.php';
require_once LIB_PATH . 'principal/AdminThemes.php';
require_once LIB_PATH . 'principal/WebThemes.php';
require_once LIB_PATH . 'principal/compatibility.php';
require_once LIB_PATH . 'principal/utils.php';
require_once LIB_PATH . 'principal/formatting.php';
require_once LIB_PATH . 'principal/locales.php';
require_once LIB_PATH . 'principal/classes/Plugins.php';
require_once LIB_PATH . 'principal/helpers/hPlugins.php';
require_once LIB_PATH . 'principal/ItemActions.php';
require_once LIB_PATH . 'principal/emails.php';
require_once LIB_PATH . 'principal/model/Admin.php';
require_once LIB_PATH . 'principal/model/Alerts.php';
require_once LIB_PATH . 'principal/model/AlertsStats.php';
require_once LIB_PATH . 'principal/model/Cron.php';
require_once LIB_PATH . 'principal/model/Category.php';
require_once LIB_PATH . 'principal/model/CategoryStats.php';
require_once LIB_PATH . 'principal/model/City.php';
require_once LIB_PATH . 'principal/model/CityArea.php';
require_once LIB_PATH . 'principal/model/Country.php';
require_once LIB_PATH . 'principal/model/Currency.php';
require_once LIB_PATH . 'principal/model/OSCLocale.php';
require_once LIB_PATH . 'principal/model/Item.php';
require_once LIB_PATH . 'principal/model/ItemComment.php';
require_once LIB_PATH . 'principal/model/ItemResource.php';
require_once LIB_PATH . 'principal/model/ItemStats.php';
require_once LIB_PATH . 'principal/model/Page.php';
require_once LIB_PATH . 'principal/model/PluginCategory.php';
require_once LIB_PATH . 'principal/model/Region.php';
require_once LIB_PATH . 'principal/model/User.php';
require_once LIB_PATH . 'principal/model/UserEmailTmp.php';
require_once LIB_PATH . 'principal/model/ItemLocation.php';
require_once LIB_PATH . 'principal/model/Widget.php';
require_once LIB_PATH . 'principal/model/Search.php';
require_once LIB_PATH . 'principal/model/LatestSearches.php';
require_once LIB_PATH . 'principal/model/Field.php';
require_once LIB_PATH . 'principal/model/Log.php';
require_once LIB_PATH . 'principal/model/CountryStats.php';
require_once LIB_PATH . 'principal/model/RegionStats.php';
require_once LIB_PATH . 'principal/model/CityStats.php';
require_once LIB_PATH . 'principal/model/BanRule.php';

require_once LIB_PATH . 'principal/model/LocationsTmp.php';

require_once LIB_PATH . 'principal/classes/Cache.php';
require_once LIB_PATH . 'principal/classes/ImageResizer.php';
require_once LIB_PATH . 'principal/classes/RSSFeed.php';
require_once LIB_PATH . 'principal/classes/Sitemap.php';
require_once LIB_PATH . 'principal/classes/Pagination.php';
require_once LIB_PATH . 'principal/classes/Rewrite.php';
require_once LIB_PATH . 'principal/classes/Stats.php';
require_once LIB_PATH . 'principal/classes/AdminMenu.php';
require_once LIB_PATH . 'principal/classes/datatables/DataTable.php';
require_once LIB_PATH . 'principal/classes/AdminToolbar.php';
require_once LIB_PATH . 'principal/classes/Breadcrumb.php';
require_once LIB_PATH . 'principal/classes/EmailVariables.php';
require_once LIB_PATH . 'principal/alerts.php';

require_once LIB_PATH . 'principal/classes/Dependencies.php';
require_once LIB_PATH . 'principal/classes/Scripts.php';
require_once LIB_PATH . 'principal/classes/Styles.php';

require_once LIB_PATH . 'principal/frm/Form.form.class.php';
require_once LIB_PATH . 'principal/frm/Page.form.class.php';
require_once LIB_PATH . 'principal/frm/Category.form.class.php';
require_once LIB_PATH . 'principal/frm/Item.form.class.php';
require_once LIB_PATH . 'principal/frm/Contact.form.class.php';
require_once LIB_PATH . 'principal/frm/Comment.form.class.php';
require_once LIB_PATH . 'principal/frm/User.form.class.php';
require_once LIB_PATH . 'principal/frm/Language.form.class.php';
require_once LIB_PATH . 'principal/frm/SendFriend.form.class.php';
require_once LIB_PATH . 'principal/frm/Alert.form.class.php';
require_once LIB_PATH . 'principal/frm/Field.form.class.php';
require_once LIB_PATH . 'principal/frm/Admin.form.class.php';
require_once LIB_PATH . 'principal/frm/ManageItems.form.class.php';
require_once LIB_PATH . 'principal/frm/BanRule.form.class.php';

require_once LIB_PATH . 'principal/functions.php';
require_once LIB_PATH . 'principal/helpers/hAdminMenu.php';


require_once LIB_PATH . 'principal/core/iObject_Cache.php';
require_once LIB_PATH . 'principal/core/Object_Cache_Factory.php';
require_once LIB_PATH . 'principal/helpers/hCache.php';

if( !defined('OSC_CRYPT_KEY') ) {
    define('OSC_CRYPT_KEY', osc_get_preference('crypt_key'));
}

osc_cache_init();

define('__OSC_LOADED__', true);

Params::init();
Session::newInstance()->session_start();

if( osc_timezone() != '' ) {
    date_default_timezone_set(osc_timezone());
}

function osc_show_maintenance() {
    if(defined('__OSC_MAINTENANCE__')) { ?>
        <div id="maintenance" name="maintenance">
             <?php _e("The website is currently undergoing maintenance"); ?>
        </div>
        <style>
            #maintenance {
                position: static;
                top: 0px;
                right: 0px;
                background-color: #bc0202;
                width: 100%;
                height:20px;
                text-align: center;
                padding:5px 0;
                font-size:14px;
                color: #fefefe;
            }
        </style>
    <?php }
}
function osc_meta_generator() {
    echo '<meta name="generator" content="principal ' . principal_VERSION . '" />';
}
osc_add_hook('header', 'osc_show_maintenance');
osc_add_hook('header', 'osc_meta_generator');
osc_add_hook('header', 'osc_load_styles', 9);
osc_add_hook('header', 'osc_load_scripts', 10);

// register scripts
osc_register_script('jquery', osc_assets_url('js/jquery.min.js'));
osc_register_script('jquery-ui', osc_assets_url('js/jquery-ui.min.js'), 'jquery');
osc_register_script('jquery-json', osc_assets_url('js/jquery.json.js'), 'jquery');
osc_register_script('jquery-treeview', osc_assets_url('js/jquery.treeview.js'), 'jquery');
osc_register_script('jquery-nested', osc_assets_url('js/jquery.ui.nestedSortable.js'), 'jquery');
osc_register_script('jquery-validate', osc_assets_url('js/jquery.validate.min.js'), 'jquery');
osc_register_script('tabber', osc_assets_url('js/tabber-minimized.js'), 'jquery');
osc_register_script('tiny_mce', osc_assets_url('js/tinymce/tinymce.min.js'));
osc_register_script('colorpicker', osc_assets_url('js/colorpicker/js/colorpicker.js'));
osc_register_script('fancybox', osc_assets_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
osc_register_script('jquery-migrate', osc_assets_url('js/jquery-migrate.min.js'), array('jquery'));
osc_register_script('php-date', osc_assets_url('js/date.js'));
osc_register_script('jquery-fineuploader', osc_assets_url('js/fineuploader/jquery.fineuploader.min.js'), 'jquery');


Plugins::init();
Translation::init();
osc_csrfguard_start();

if( OC_ADMIN ) {
    // init admin menu
    AdminMenu::newInstance()->init();
    $functions_path = AdminThemes::newInstance()->getCurrentThemePath() . 'functions.php';
    if( file_exists($functions_path) ) {
        require_once $functions_path;
    }
} else {
    Rewrite::newInstance()->init();
}

if( !class_exists('PHPMailer') ) {
    require_once osc_lib_path() . 'phpmailer/class.phpmailer.php';
}
if( !class_exists('SMTP') ) {
    require_once osc_lib_path() . 'phpmailer/class.smtp.php';
}

/* file end: ./oc-load.php */