<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    /**
     * Log DAO
     */
    class Log extends DAO
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
            $this->setTableName('t_log');
            $array_fields = array(
                'dt_date',
                's_section',
                's_action',
                'fk_i_id',
                's_data',
                's_ip',
                's_who',
                'fk_i_who_id'
            );
            $this->setFields($array_fields);
        }

        /**
         * Insert a log row.
         *
         * @access public
         * @since unknown
         * @param string $section
         * @param string $action
         * @param integer $id
         * @param string $data
         * @param string $who
         * @param integer $who_id
         * @return boolean
         */
        public function insertLog($section, $action, $id, $data, $who, $whoId)
        {
            $array_set = array(
                'dt_date'       => date('Y-m-d H:i:s'),
                's_section'     => $section,
                's_action'      => $action,
                'fk_i_id'       => $id,
                's_data'        => $data,
                's_ip'          => Params::getServerParam('REMOTE_ADDR'),
                's_who'         => $who,
                'fk_i_who_id'   => $whoId
            );
            return $this->dao->insert($this->getTableName(), $array_set);
        }
    }

    /* file end: ./oc-includes/osclass/model/Log.php */
?>