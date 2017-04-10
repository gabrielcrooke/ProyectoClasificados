<?php
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">

    <head>
        <?php osc_current_web_theme_path('common/head.php') ; ?>
    </head>
<body <?php bender_body_class(); ?>>



<div id="header">
    <!-- header ad 728x60-->
    <div class="ads_header">
    <?php echo osc_get_preference('header-728x90', 'bender'); ?>
    <!-- /header ad 728x60-->
    </div>
	
    <div class="clear"></div>
    <div class="wrapper">
        <div id="logo">
            <?php echo logo_header(); ?>
            <span id="description"><?php echo osc_page_description(); ?></span>
        </div>
        <ul class="nav">
            <?php if( osc_is_static_page() || osc_is_contact_page() ){ ?>
                <li class="search"><a class="ico-search icons" data-bclass-toggle="display-search"></a></li>
                <li class="cat"><a class="ico-menu icons" data-bclass-toggle="display-cat"></a></li>
            <?php } ?>
            <?php if( osc_users_enabled() ) { ?>
            <?php if( osc_is_web_user_logged_in() ) { ?>
                <li class="first logged">
                    <span><?php echo sprintf(__('Hi %s', 'bender'), osc_logged_user_name() . '!'); ?>  &middot;</span>
                    <strong><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('Mi cuenta', 'bender'); ?></a></strong> &middot;
                    <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Cerrar seccion', 'bender'); ?></a>
                </li>
            <?php } else { ?>
                <li><a id="login_open" href="<?php echo osc_user_login_url(); ?>"><?php _e('Iniciar sesion', 'bender') ; ?></a></li>
                <?php if(osc_user_registration_enabled()) { ?>
                    <li><a href="<?php echo osc_register_account_url() ; ?>"><?php _e('Regístrate gratis', 'bender'); ?></a></li>
					<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1822258254762733',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

&nbsp; <fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>




                <?php }; ?>
            <?php } ?>
            <?php } ?>
            <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
            <li class="publish"><a href="<?php echo osc_item_post_url_in_category() ; ?>"><?php _e("Publique su anuncio", 'bender');?></a></li>
            <?php } ?>
        </ul>

    </div>
    <?php if( osc_is_home_page() || osc_is_static_page() || osc_is_contact_page() ) { ?>
    <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
        <input type="hidden" name="page" value="search"/>
        <div class="main-search">
            <div class="cell">
                <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'bender'), 'bender')); ?>" />
            </div>
            <?php  if ( osc_count_categories() ) { ?>
                <div class="cell selector">
                    <?php osc_categories_select('sCategory', null, __('Selecciona una categoria', 'bender')) ; ?>
                </div>
                <div class="cell reset-padding">
            <?php  } else { ?>
                <div class="cell">
            <?php  } ?>
                <button class="ui-button ui-button-big js-submit"><?php _e("Buscar", 'bender');?></button>
            </div>
        </div>
        <div id="message-seach"></div>
    </form>
    <?php } ?>
</div>
<?php osc_show_widgets('header'); ?>
<div class="wrapper wrapper-flash">
    <?php
        $breadcrumb = osc_breadcrumb('&raquo;', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
        <div class="breadcrumb">
            <?php echo $breadcrumb; ?>
            <div class="clear"></div>
        </div>
    <?php
        }
    ?>
    <?php osc_show_flash_message(); ?>
</div>
<?php osc_run_hook('before-content'); ?>
<div class="wrapper" id="content">
    <?php osc_run_hook('before-main'); ?>
    <div id="main">
        <?php osc_run_hook('inside-main'); ?>
