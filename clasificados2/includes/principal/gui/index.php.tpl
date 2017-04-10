<?php
    



    function bender_theme_info() {
        return array(
             'name'        => 'bender'
            ,'version'     => '<%- pkg.version %>'
            ,'description' => '<%- pkg.description %>'
            ,'author_name' => '<%- pkg.author %>'
            ,'author_url'  => 'http://osclass.org'
            ,'locations'   => array()
        );
    }

?>