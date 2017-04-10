<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    /**
     *
     */
    class Widget extends DAO
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
            $this->setTableName('t_widget');
            $this->setPrimaryKey('pk_i_id');
            $this->setFields( array('pk_i_id','s_description','s_location','e_kind','s_content') );
        }

        /**
         *
         * @access public
         * @since unknown
         * @param string $location
         * @return array
         */
        function findByLocation($location)
        {
            $this->dao->select('*');
            $this->dao->from($this->getTableName());
            $this->dao->where('s_location', $location);
            $result = $this->dao->get();

            if( $result == false ) {
                return array();
            }

            return $result->result();
        }

        /**
         *
         * @access public
         * @since 3.3.3+
         * @param string $description
         * @return array
         */
        function findByDescription($description)
        {
            $this->dao->select('*');
            $this->dao->from($this->getTableName());
            $this->dao->where('s_description', $description);
            $result = $this->dao->get();

            if( $result == false ) {
                return array();
            }

            return $result->result();
        }
    }

    /* file end: ./oc-includes/osclass/model/Widget.php */
?>
