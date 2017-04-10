<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    /**
     *
     */
    class UserEmailTmp extends DAO
    {
        /**
         *
         * @var type
         */
        private static $instance;

        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         *
         */
        function __construct()
        {
            parent::__construct();
            $this->setTableName('t_user_email_tmp');
            $this->setPrimaryKey('fk_i_user_id');
            $this->setFields( array('fk_i_user_id','s_new_email','dt_date') );
        }

        /**
         *
         * @access public
         * @since unknown
         * @param type $userEmailTmp
         * @return array
         */
        public function insertOrUpdate($userEmailTmp) {

            $status = $this->dao->insert($this->getTableName(), array('fk_i_user_id' => $userEmailTmp['fk_i_user_id'], 's_new_email' => $userEmailTmp['s_new_email'], 'dt_date' => date('Y-m-d H:i:s')));
            if (!$status) {
                return $this->dao->update($this->getTableName(), array('s_new_email' => $userEmailTmp['s_new_email'], 'dt_date' => date('Y-m-d H:i:s')), array('fk_i_user_id' => $userEmailTmp['fk_i_user_id']));
            }
            return false;
        }
    }

    /* file end: ./oc-includes/osclass/model/UserEmailTmp.php */
?>