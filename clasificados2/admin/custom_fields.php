<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class CAdminCFields extends AdminSecBaseModel
    {
        //specific for this class
        private $fieldManager;

        function __construct()
        {
            parent::__construct();

            //specific things for this class
            $this->fieldManager = Field::newInstance();
        }

        //Business Layer...
        function doModel()
        {
            parent::doModel();

            //specific things for this class
            switch( $this->action ) {
                default:
                    $categories = Category::newInstance()->toTreeAll();
                    $selected   = array();
                    foreach($categories as $c) {
                        $selected[] = $c['pk_i_id'];
                        foreach($c['categories'] as $cc) {
                            $selected[] = $cc['pk_i_id'];
                        }
                    }
                    $this->_exportVariableToView('categories', $categories);
                    $this->_exportVariableToView('default_selected', $selected);
                    $this->_exportVariableToView('fields', $this->fieldManager->listAll());
                    $this->doView("fields/index.php");
                break;
            }
        }

        //hopefully generic...
        function doView($file)
        {
            osc_run_hook("before_admin_html");
            osc_current_admin_theme_path($file);
            Session::newInstance()->_clearVariables();
            osc_run_hook("after_admin_html");
        }
    }

    /* file end: ./oc-admin/custom_fields.php */
?>