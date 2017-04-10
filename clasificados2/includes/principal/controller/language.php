<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class CWebLanguage extends BaseModel
    {
        function __construct()
        {
            parent::__construct();
            osc_run_hook( 'init_language' );
        }

        // business layer...
        function doModel()
        {
            $locale = Params::getParam('locale');

            if(preg_match('/.{2}_.{2}/', $locale)) {
                Session::newinstance()->_set('userLocale', $locale);
            }

            $redirect_url = '';
            if(Params::getServerParam('HTTP_REFERER', false, false) != '') {
                $redirect_url = Params::getServerParam('HTTP_REFERER', false, false);
            } else {
                $redirect_url = osc_base_url(true);
            }

            $this->redirectTo($redirect_url);
        }

        // hopefully generic...
        function doView($file) { }
    }

    /* file end: ./language.php */
?>