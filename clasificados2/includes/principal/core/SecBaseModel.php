<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    /**
     * Description of BaseModel
     *
     * @author danielo
     */
    class SecBaseModel extends BaseModel
    {
        function __construct()
        {
            parent::__construct ();

            //Checking granting...
            if (!$this->isLogged()) {
                //If we are not logged or we do not have permissions -> go to the login page
                $this->logout();
                $this->showAuthFailPage();
            }
        }

        //granting methods
        function setGranting($grant)
        {
            $this->grant = $grant;
        }

        //destroying current session
        function logout()
        {
            //destroying session
            Session::newInstance()->session_destroy();
        }

        function doModel() {}

        function doView($file) {}
    }

    /* file end: ./oc-includes/osclass/core/SecBaseModel.php */
?>