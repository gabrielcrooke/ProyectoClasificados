<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class AlertForm extends Form {

        static public function user_id_hidden() {
            parent::generic_input_hidden('alert_userId', osc_logged_user_id() );
            return true;
        }

        static public function email_hidden() {
            parent::generic_input_hidden('alert_email', osc_logged_user_email() );
            return true;
        }

        static public function default_email_text() {
            return __('Enter your e-mail');
        }

        static public function email_text() {
            $value = "";
            if( osc_logged_user_email() == '' ){
                $value = self::default_email_text();
            }
            parent::generic_input_text('alert_email', $value );
            return true;
        }

        static public function page_hidden() {
            parent::generic_input_hidden('page', 'search');
            return true;
        }

        static public function alert_hidden() {
            parent::generic_input_hidden('alert', osc_search_alert() );
            return true;
        }
    }

?>