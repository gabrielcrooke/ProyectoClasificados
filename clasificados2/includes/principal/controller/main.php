<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class CWebMain extends BaseModel
    {
        function __construct()
        {
            parent::__construct();
            osc_run_hook( 'init_main' );
        }

        //Business Layer...
        function doModel()
        {
            switch($this->action) {
                case('logout'):         // unset only the required parameters in Session
                                        osc_run_hook("logout");

                                        Session::newInstance()->_drop('userId');
                                        Session::newInstance()->_drop('userName');
                                        Session::newInstance()->_drop('userEmail');
                                        Session::newInstance()->_drop('userPhone');

                                        Cookie::newInstance()->pop('oc_userId');
                                        Cookie::newInstance()->pop('oc_userSecret');
                                        Cookie::newInstance()->set();

                                        $this->redirectTo( osc_base_url() );
                break;
                default:                $this->doView('main.php');
            }
        }

        //hopefully generic...
        function doView($file)
        {
            osc_run_hook("before_html");
            osc_current_web_theme_path($file);
            Session::newInstance()->_clearVariables();
            osc_run_hook("after_html");
        }
    }

    /* file end: ./main.php */
?>