<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class WebSecBaseModel extends SecBaseModel
    {
        function __construct()
        {
            parent::__construct();
        }

        function isLogged()
        {
            return osc_is_web_user_logged_in();
        }

        //destroying current session
        function logout()
        {
            //destroying session
            $locale = Session::newInstance()->_get('userLocale');
            Session::newInstance()->session_destroy();
            Session::newInstance()->_drop('userId');
            Session::newInstance()->_drop('userName');
            Session::newInstance()->_drop('userEmail');
            Session::newInstance()->_drop('userPhone');
            Session::newInstance()->session_start();
            Session::newinstance()->_set('userLocale', $locale);

            Cookie::newInstance()->pop('oc_userId');
            Cookie::newInstance()->pop('oc_userSecret');
            Cookie::newInstance()->set();
        }

        function showAuthFailPage()
        {
            if(Params::getParam('page')=='ajax') {
                echo json_encode(array('error' => 1, 'msg' => __('Session timed out')));
                exit;
            } else {
                $this->redirectTo( osc_user_login_url() );
                exit;
            }
        }
    }

    /* file end: ./oc-includes/osclass/core/WebSecBaseModel.php */
?>