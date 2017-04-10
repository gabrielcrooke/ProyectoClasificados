<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    /**
     * Model database for Currency table
     *
     * @package Osclass
     * @subpackage Model
     * @since unknown
     */
    class Currency extends DAO
    {
        /**
         * It references to self object: Currency.
         * It is used as a singleton
         *
         * @access private
         * @since unknown
         * @var Currency
         */
        private static $instance;
        private static $_currencies;

        /**
         * It creates a new Currency object class ir if it has been created
         * before, it return the previous object
         *
         * @access public
         * @since unknown
         * @return Currency
         */
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         * Set data related to t_currency table
         */
        function __construct()
        {
            parent::__construct();
            $this->setTableName('t_currency');
            $this->setPrimaryKey('pk_c_code');
            $this->setFields(array('pk_c_code', 's_name', 's_description', 'b_enabled'));
        }

        function findByPrimaryKey($value)
        {
            if(isset(Currency::$_currencies[$value])) {
                return Currency::$_currencies[$value];
            }

            $this->dao->select($this->fields);
            $this->dao->from($this->getTableName());
            $this->dao->where($this->getPrimaryKey(), $value);
            $result = $this->dao->get();

            if( $result === false ) {
                return false;
            }

            if( $result->numRows() !== 1 ) {
                return false;
            }

            Currency::$_currencies[$value] = $result->row();
            return Currency::$_currencies[$value];
        }

    }

    /* file end: ./oc-includes/osclass/model/Currency.php */
?>