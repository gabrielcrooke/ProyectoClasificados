<?php


    /**
     * Kill Osclass with an error message
     *
     * @since 1.2
     *
     * @param string $message Error message
     * @param string $title Error title
     */
    function osc_die($title, $message) {
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en-US">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><?php echo $title; ?></title>
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo osc_get_absolute_url(); ?>oc-includes/osclass/installer/install.css" />
            </head>
            <body class="page-error">
                <h1><?php echo $title; ?></h1>
                <p><?php echo $message; ?></p>
            </body>
        </html>
        <?php die(); ?>
    <?php }

    function getErrorParam($param, $htmlencode = false, $quotes_encode = true)
    {
        if ($param == "") return '';
        if (!isset($_SERVER[$param])) return '';
        $value = $_SERVER[$param];
        if ($htmlencode) {
            if($quotes_encode) {
                return htmlspecialchars(stripslashes($value), ENT_QUOTES);
            } else {
                return htmlspecialchars(stripslashes($value), ENT_NOQUOTES);
            }
        }

        if(get_magic_quotes_gpc()) {
            $value = strip_slashes_extended_e($value);
        }

        return ($value);
    }
    function strip_slashes_extended_e($array) {
        if(is_array($array)) {
            foreach($array as $k => &$v) {
                $v = strip_slashes_extended_e($v);
            }
        } else {
            $array = stripslashes($array);
        }
        return $array;
    }
    function osc_get_absolute_url() {
        $protocol = (getErrorParam('HTTPS') == 'on'  || getErrorParam('HTTPS') == 1  || getErrorParam('HTTP_X_FORWARDED_PROTO')=='https')? 'https' : 'http';
        return $protocol . '://' . getErrorParam('HTTP_HOST') . preg_replace('/((oc-admin)|(oc-includes)|(oc-content)|([a-z]+\.php)|(\?.*)).*/i', '', getErrorParam('REQUEST_URI', false, false));
    }
