<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');


	class Cookie
	{
		public $name;
		public $val;
		public $expires;
		
		private static $instance;

        public static function newInstance() {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        function __construct()
		{
			$this->val = array();
            $web_pat = (MULTISITE) ? osc_multisite_url() : WEB_PATH;
			$this->name = substr( md5($web_pat), 0, 5 );
			$this->expires = time() + 3600; // 1 hour by default
			if ( isset( $_COOKIE[$this->name] ) )
            {
			    list($vars, $vals) = explode("&", $_COOKIE[$this->name]);
			    $vars = explode("._.", $vars);
			    $vals = explode("._.", $vals);
			    while(list($key, $var) = each($vars))
			    {
				    $this->val["$var"] = $vals[$key];
				    $_COOKIE["$var"] = $vals[$key];
			    }
            }
		}
		
		function push($var, $value)
		{
			$this->val["$var"] = $value;
			$_COOKIE["$var"] = $value;
		}
		
		function pop($var)
		{
            unset($this->val[$var]);
			unset($_COOKIE[$var]);
		}
			
		function clear()
		{
			$this->val = array();
		}
			
		function set()
		{
			$cookie_val = "";
            if(is_array($this->val) && count($this->val) > 0)
			{
				$cookie_val = '';
				$vars = $vals = array();
				
				foreach ($this->val as $key => $curr)
				{
					if($curr !== "")
					{
						$vars[] = $key;
						$vals[] = $curr;
					}
				}
				if(count($vars) > 0 && count($vals) > 0) {
					$cookie_val = implode("._.", $vars) . "&" . implode("._.", $vals);
				}
			}
            setcookie($this->name, $cookie_val, $this->expires, REL_WEB_URL);
		}
        
        function num_vals() {
            return(count($this->val));
        }
        
        function get_value($str) {
            if (isset($this->val[$str])) return($this->val[$str]);
            return('');
        }

        //$tm: time in seconds
        function set_expires($tm) {
        	$this->expires = time() + $tm;
		}
	}
    
?>