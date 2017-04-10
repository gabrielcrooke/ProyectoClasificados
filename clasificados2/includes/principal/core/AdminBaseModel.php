<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');


    class AdminBaseModel extends BaseModel
    {
        function __construct()
        {
            parent::__construct();
            // @deprecated: to be removed
            osc_run_hook( 'init_admin' );
            osc_run_hook( 'init_admin_insecure' );
        }

        function doModel() {}
        function doView($file) {}
    }

    /* file end: ./oc-includes/osclass/core/AdminBaseModel.php */
?>