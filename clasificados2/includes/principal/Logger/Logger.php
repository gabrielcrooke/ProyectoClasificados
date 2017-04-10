<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    abstract class Logger
    {
        private function __construct() {}

        /**
         * Log a message with the INFO level.
         * @param <type> $message
         */
        abstract function info($message = '', $caller = null );

        /**
         * Log a message with the WARN level.
         * @param <type> $message
         */
        abstract function warn($message = '', $caller = null );

        /**
         * Log a message with the ERROR level.
         * @param <type> $message
         */
        abstract function error($message = '', $caller = null );

        /**
         * Log a message with the DEBUG level.
         * @param <type> $message
         */
        abstract function debug($message = '', $caller = null );

        /**
         * Log a message object with the FATAL level including the caller.
         * @param <type> $message
         */
        abstract function fatal($message = '', $caller = null );
    }

    /* file end: ./oc-includes/osclass/Logger/Logger.php */
?>