<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class BanRuleForm extends Form {

        static public function primary_input_hidden($rule) {
            parent::generic_input_hidden("id", (isset($rule["pk_i_id"]) ? $rule['pk_i_id'] : '') );
        }

        static public function name_text($rule = null) {
            parent::generic_input_text("s_name", isset($rule['s_name'])? $rule['s_name'] : '', null, false);
        }

        static public function ip_text($rule = null) {
            parent::generic_input_text("s_ip", isset($rule['s_ip'])? $rule['s_ip'] : '', null, false);
        }

        static public function email_text($rule = null) {
            parent::generic_input_text("s_email", isset($rule['s_email'])? $rule['s_email'] : '', null, false);
        }

    }

?>