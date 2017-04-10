<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class CAdminItems extends AdminSecBaseModel
    {
        //specific for this class
        private $itemManager;

        function __construct()
        {
            parent::__construct();

            //specific things for this class
            $this->itemManager = Item::newInstance();
        }

        //Business Layer...
        function doModel()
        {
            parent::doModel();

            if(osc_is_moderator() && ($this->action=='settings' || $this->action=='settings_post')) {
                osc_add_flash_error_message(_m("No tienes suficientes permisos"), "admin");
                $this->redirectTo(osc_admin_base_url());
            }

            //specific things for this class
            switch ($this->action)
            {
                case 'bulk_actions':
                                        osc_csrf_check();
                                        $mItems  = new ItemActions( true );
                                        switch ( Params::getParam('bulk_actions') )
                                        {
                                            case 'enable_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->enable($_id) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d Se ha habilitado la lista', '%d Los listados se han habilitado',$numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'disable_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->disable((int)$_id) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio se ha inhabilitado', '%d Los listados han sido deshabilitados',$numSuccess),$numSuccess), 'admin');
                                                }
                                            break;
                                            case 'activate_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->activate($_id) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio ha sido activado','%d Los listados han sido activados',$numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'deactivate_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->deactivate($_id) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_m('%d La lista ha sido desactivada', '%d Los listados se han desactivado',$numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'premium_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->premium($_id) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio ha sido marcado como premium','%d Los listados han sido marcados como premium', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'depremium_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->premium($_id,false) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d Se ha realizado un cambio', '%d se han realizado cambios',$numSuccess) ,$numSuccess), 'admin');
                                                }
                                            break;
                                            case 'spam_all':
                                                $id = Params::getParam('id');
                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->spam($_id) ) {
                                                            $numSuccess++;
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio ha sido marcado como spam', '%d Los listados han sido marcados como spam',$numSuccess),$numSuccess), 'admin');
                                                }
                                            break;
                                            case 'despam_all':
                                                $id = Params::getParam('id');
                                                if ($id) {
                                                    $numSuccess = 0;
                                                    foreach ($id as $_id) {
                                                        if( $mItems->spam($_id, false) ) {
                                                            $numSuccess++;
                                                        }
                                                    }

                                                    osc_add_flash_ok_message( sprintf(_mn('%d Se ha realizado un cambio', '%d se han realizado cambios', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'delete_all':
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $item = $this->itemManager->findByPrimaryKey($i);
                                                            $success = $mItems->delete($item['s_secret'], $item['pk_i_id']);
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio ha sido eliminado', '%d Los listados han sido eliminados', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'clear_spam_all';
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $success = $this->itemManager->clearStat($i , 'spam' );
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio ha sido desmarcado como spam', '%d Los listados han sido marcados como spam', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'clear_bad_all';
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $success = $this->itemManager->clearStat($i , 'bad' );
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio ha sido marcado como mal clasificado', '%d Los listados han sido marcados como clasificados erróneos', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'clear_dupl_all';
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $success = $this->itemManager->clearStat($i , 'Duplicado' );
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d Lista ha sido desmarcada como duplicada', '%d Los listados han sido desmarcados como duplicados', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'clear_expi_all';
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $success = $this->itemManager->clearStat($i , 'Caducado' );
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d Lista ha sido desmarcada como caducada', '%d Los listados han sido desmarcados como caducados', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'clear_offe_all';
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $success = $this->itemManager->clearStat($i , 'Ofensivo' );
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d Lista ha sido desmarcada como ofensiva', '%d Los listados han sido desmarcados como ofensivos', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            case 'clear_all';
                                                $id = Params::getParam('id');
                                                $success = false;

                                                if($id) {
                                                    $numSuccess = 0;
                                                    foreach($id as $i) {
                                                        if ($i) {
                                                            $success = $this->itemManager->clearStat($i , 'Todo' );
                                                            if($success) {
                                                                $numSuccess++;
                                                            }
                                                        }
                                                    }
                                                    osc_add_flash_ok_message( sprintf(_mn('%d El anuncio no ha sido marcado', '%d Los listados no han sido marcados', $numSuccess), $numSuccess), 'admin');
                                                }
                                            break;
                                            default:
                                                if(Params::getParam("bulk_actions")!="") {
                                                    osc_run_hook("item_bulk_".Params::getParam("bulk_actions"), Params::getParam('id'));
                                                }
                                            break;
                                        }
                                        $this->redirectTo( Params::getServerParam('HTTP_REFERER', false, false) );
                break;
                case 'delete':          //delete
                                        osc_csrf_check();
                                        $id      = Params::getParam('id');
                                        $success = false;

                                        foreach( $id as $i ) {
                                            if ( $i ) {
                                                $aItem   = $this->itemManager->findByPrimaryKey( $i );
                                                $mItems  = new ItemActions( true );
                                                $success = $mItems->delete( $aItem['s_secret'], $aItem['pk_i_id'] );
                                            }
                                        }

                                        if( $success ) {
                                            osc_add_flash_ok_message( _m('Se ha eliminado el anuncio.'), 'admin');
                                        } else {
                                            osc_add_flash_error_message( _m("No se pudo eliminar la lista"), 'admin');
                                        }

                                        $this->redirectTo( Params::getServerParam('HTTP_REFERER', false, false) );
                break;
                case 'status':          //status
                                        osc_csrf_check();
                                        $id = Params::getParam('id');
                                        $value = Params::getParam('value');

                                        if (!$id)
                                            return false;

                                        $id = (int) $id;

                                        if (!is_numeric($id))
                                            return false;

                                        if (!in_array($value, array('ACTIVE', 'INACTIVE','ENABLE','DISABLE')))
                                            return false;

                                        $item = $this->itemManager->findByPrimaryKey($id);
                                        $mItems  = new ItemActions( true );

                                        switch ($value) {
                                            case 'ACTIVE':

                                                $success = $mItems->activate( $id );
                                                if( $success && $success > 0 ) {
                                                    osc_add_flash_ok_message( _m('Se ha activado el anuncio'), 'admin');
                                                } else if ( !$success ){
                                                    osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                                } else {
                                                    osc_add_flash_error_message( _m("El anuncio no se puede activar porque está bloqueado"), 'admin');
                                                }

                                                break;
                                            case 'INACTIVE':

                                                $success = $mItems->deactivate( $id );
                                                if( $success && $success > 0 ) {
                                                    osc_add_flash_ok_message( _m('El anuncio ha sido desactivado'), 'admin');
                                                } else {
                                                    osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                                }

                                                break;
                                            case 'ENABLE':

                                                $success = $mItems->enable( $id );
                                                if( $success && $success > 0 ) {
                                                    osc_add_flash_ok_message( _m('Se ha habilitado el anuncio'), 'admin');
                                                } else {
                                                    osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                                }

                                                break;
                                            case 'DISABLE':

                                                $success = $mItems->disable( $id );
                                                if( $success && $success > 0 ) {
                                                    osc_add_flash_ok_message( _m('Se ha inhabilitado el anuncio'), 'admin');
                                                } else {
                                                    osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                                }

                                                break;
                                        }

                                        $this->redirectTo( Params::getServerParam('HTTP_REFERER', false, false) );
                break;
                case 'status_premium':  //status premium
                                        osc_csrf_check();
                                        $id = Params::getParam('id');
                                        $value = Params::getParam('value');

                                        if (!$id)
                                            return false;

                                        $id = (int) $id;

                                        if (!is_numeric($id))
                                            return false;

                                        if (!in_array($value, array(0, 1)))
                                            return false;

                                        $mItems = new ItemActions(true);

                                        if ($mItems->premium($id, $value==1?true:false) ) {
                                            osc_add_flash_ok_message( _m('Se han aplicado cambios'), 'admin');
                                        } else {
                                            osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                        }

                                        $this->redirectTo( Params::getServerParam('HTTP_REFERER', false, false) );
                break;
                case 'status_spam':  //status spam
                                        osc_csrf_check();
                                        $id = Params::getParam('id');
                                        $value = Params::getParam('value');

                                        if (!$id)
                                            return false;

                                        $id = (int) $id;

                                        if (!is_numeric($id))
                                            return false;

                                        if (!in_array($value, array(0, 1)))
                                            return false;

                                        $mItems = new ItemActions(true);

                                        if( $mItems->spam($id, $value==1?true:false) ){
                                            osc_add_flash_ok_message( _m('Se han aplicado cambios'), 'admin');
                                        } else {
                                            osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                        }

                                        $this->redirectTo( Params::getServerParam('HTTP_REFERER', false, false) );
                break;
                case 'clear_stat':
                                        osc_csrf_check();
                                        $id     = Params::getParam('id');
                                        $stat   = Params::getParam('stat');

                                        if (!$id)
                                            return false;

                                        if (!$stat)
                                            return false;

                                        $id = (int) $id;

                                        if (!is_numeric($id))
                                            return false;

                                        $success = $this->itemManager->clearStat($id , $stat );

                                        if($success) {
                                            osc_add_flash_ok_message( _m('El anuncio ha sido desmarcado como')." $stat", 'admin');
                                        } else {
                                            osc_add_flash_error_message( _m("El anuncio no ha sido desmarcado como")." $stat", 'admin');
                                        }

                                        $this->redirectTo( Params::getServerParam('HTTP_REFERER', false, false) );
                break;
                case 'item_edit':       // edit item
                                        $id = Params::getParam('id');

                                        $item = Item::newInstance()->findByPrimaryKey($id);
                                        if (count($item) <= 0) {
                                            $this->redirectTo( osc_admin_base_url(true) . "?page=items" );
                                        }

                                        $csrf_token = osc_csrf_token_url();
                                        if( $item['b_active'] ) {
                                            $actions[] = '<a class="btn float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=INACTIVE">'.__('Desactivar') .'</a>';
                                        } else {
                                            $actions[] = '<a class="btn btn-red float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=ACTIVE">'.__('Activar') .'</a>';
                                        }
                                        if( $item['b_enabled'] ) {
                                            $actions[] = '<a class="btn float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=DISABLE">'.__('Bloquear') .'</a>';
                                        } else {
                                            $actions[] = '<a class="btn btn-red float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=ENABLE">'.__('Desbloquear') .'</a>';
                                        }
                                        if( $item['b_premium'] ) {
                                            $actions[] = '<a class="btn float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status_premium&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=0">'.__('Unmark as premium') .'</a>';
                                        } else {
                                            $actions[] = '<a class="btn float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status_premium&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=1">'.__('Mark as premium') .'</a>';
                                        }
                                        if( $item['b_spam'] ) {
                                            $actions[] = '<a class="btn btn-red float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status_spam&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=0">'.__('Desmarcar como spam') .'</a>';
                                        } else {
                                            $actions[] = '<a class="btn float-left" href="'.osc_admin_base_url(true).'?page=items&amp;action=status_spam&amp;id='.$item['pk_i_id'].'&amp;'.$csrf_token.'&amp;value=1">'.__('Marcar como spam') .'</a>';
                                        }

                                        $this->_exportVariableToView("actions", $actions);

                                        $form     = count(Session::newInstance()->_getForm());
                                        $keepForm = count(Session::newInstance()->_getKeepForm());

                                        if($form==0 || $form==$keepForm) {
                                            Session::newInstance()->_dropKeepForm();
                                        }

                                        // save referer if belongs to manage items
                                        // redirect only if ManageItems or ReportedListngs
                                        if( Params::existServerParam('HTTP_REFERER') ) {
                                            $referer = Params::getServerParam('HTTP_REFERER', false, false);
                                            if(preg_match('/page=items/', $referer) ) {
                                                if(preg_match("/action=([\p{L}|_|-]+)/u", $referer, $matches)) {
                                                    if( $matches[1] == 'items_reported' ) {
                                                        Session::newInstance()->_set( 'osc_admin_referer', $referer );
                                                    }
                                                } else {
                                                    // no actions - Manage Listings
                                                    Session::newInstance()->_set( 'osc_admin_referer', $referer );
                                                }
                                            }
                                        }

                                        $this->_exportVariableToView("item", $item);
                                        $this->_exportVariableToView("new_item", FALSE);

                                        osc_run_hook("before_item_edit", $item);
                                        $this->doView('items/frm.php');
                break;
                case 'item_edit_post':
                                        osc_csrf_check();
                                        $mItems = new ItemActions(true);

                                        $mItems->prepareData(false);
                                        // set all parameters into session
                                        foreach( $mItems->data as $key => $value ) {
                                            Session::newInstance()->_setForm($key,$value);
                                        }

                                        $meta = Params::getParam('meta');
                                        if(is_array($meta)) {
                                            foreach( $meta as $key => $value ) {
                                                Session::newInstance()->_setForm('meta_'.$key, $value);
                                                Session::newInstance()->_keepForm('meta_'.$key);
                                            }
                                        }

                                        $success = $mItems->edit();

                                        if($success==1){
                                            osc_add_flash_ok_message( _m('Cambios guardados correctamente'), 'admin');
                                            $url = osc_admin_base_url(true) . "?page=items";
                                            // if Referer is saved that means referer is ManageListings or ReportListings
                                            if(Session::newInstance()->_get('osc_admin_referer')!='') {
                                                $url = Session::newInstance()->_get('osc_admin_referer');
                                            }
                                            Session::newInstance()->_clearVariables();
                                            if(is_array($meta)) {
                                                foreach( $meta as $key => $value ) {
                                                    Session::newInstance()->_dropKeepForm('meta_'.$key);
                                                }
                                            }

                                            $this->redirectTo( $url );
                                        } else {
                                            osc_add_flash_error_message( $success , 'admin');
                                            $this->redirectTo( osc_admin_base_url(true) . "?page=items&action=item_edit&id=" . Params::getParam('id') );
                                        }
                break;
                case 'deleteResource':  //delete resource
                                        osc_csrf_check();
                                        $id = Params::getParam('id');
                                        $name = Params::getParam('name');
                                        $fkid = Params::getParam('fkid');

                                        // delete files
                                        osc_deleteResource($id, true);
                                        Log::newInstance()->insertLog('items', 'deleteResource', $id, $id, 'admin', osc_logged_admin_id());

                                        $result = ItemResource::newInstance()->delete(array('pk_i_id' => $id, 'fk_i_item_id' => $fkid, 's_name' => $name));
                                        if($result === false) {
                                            osc_add_flash_error_message( _m('Se ha producido un error'), 'admin');
                                        } else {
                                            osc_add_flash_ok_message( _m('Recurso eliminado'), 'admin');
                                        }
                                        $this->redirectTo( osc_admin_base_url(true) . "?page=items" );
                break;
                case 'post':            // add item
                                        $form     = count(Session::newInstance()->_getForm());
                                        $keepForm = count(Session::newInstance()->_getKeepForm());
                                        if($form == 0 || $form == $keepForm) {
                                            Session::newInstance()->_dropKeepForm();
                                        }

                                        $this->_exportVariableToView("new_item", TRUE);
                                        osc_run_hook('post_item');
                                        $this->doView('items/frm.php');
                break;
                case 'post_item':       //post item
                                        osc_csrf_check();
                                        $mItem = new ItemActions(true);

                                        $mItem->prepareData(true);
                                        // set all parameters into session
                                        foreach( $mItem->data as $key => $value ) {
                                            Session::newInstance()->_setForm($key,$value);
                                        }

                                        $meta = Params::getParam('meta');

                                        if(is_array($meta)) {
                                            foreach( $meta as $key => $value ) {
                                                Session::newInstance()->_setForm('meta_'.$key, $value);
                                                Session::newInstance()->_keepForm('meta_'.$key);
                                            }
                                        }

                                        $success = $mItem->add();

                                        if( $success==1 || $success==2 ) {
                                            $url = osc_admin_base_url(true) . "?page=items";
                                            // if Referer is saved that means referer is ManageListings or ReportListings
                                            if(Session::newInstance()->_get('osc_admin_referer')!='') {
                                                $url = Session::newInstance()->_get('osc_admin_referer');
                                                Session::newInstance()->_drop('osc_admin_referer');
                                            }
                                            Session::newInstance()->_clearVariables();
                                            if(is_array($meta)) {
                                                foreach( $meta as $key => $value ) {
                                                    Session::newInstance()->_dropKeepForm('meta_'.$key);
                                                }
                                            }
                                            osc_add_flash_ok_message( _m('Se ha añadido una nueva ficha'), 'admin');

                                            $this->redirectTo( $url );
                                        } else {
                                            osc_add_flash_error_message( $success, 'admin');
                                            $this->redirectTo( osc_admin_base_url(true) . "?page=items&action=post" );
                                        }
                break;
                case('settings'):          // calling the items settings view
                                        $this->doView('items/settings.php');
                break;
                case('settings_post'):     // update item settings
                                        osc_csrf_check();
                                        $iUpdated                   = 0;
                                        $enabledRecaptchaItems      = Params::getParam('enabled_recaptcha_items');
                                        $enabledRecaptchaItems      = (($enabledRecaptchaItems == '1') ? true : false);
                                        $moderateItems              = Params::getParam('moderate_items');
                                        $moderateItems              = (($moderateItems != '') ? true : false);
                                        $numModerateItems           = Params::getParam('num_moderate_items');
                                        $itemsWaitTime              = Params::getParam('items_wait_time');
                                        $loggedUserItemValidation   = Params::getParam('logged_user_item_validation');
                                        $loggedUserItemValidation   = (($loggedUserItemValidation != '') ? true : false);
                                        $regUserPost                = Params::getParam('reg_user_post');
                                        $regUserPost                = (($regUserPost != '') ? true : false);
                                        $notifyNewItem              = Params::getParam('notify_new_item');
                                        $notifyNewItem              = (($notifyNewItem != '') ? true : false);
                                        $notifyContactItem          = Params::getParam('notify_contact_item');
                                        $notifyContactItem          = (($notifyContactItem != '') ? true : false);
                                        $notifyContactFriends       = Params::getParam('notify_contact_friends');
                                        $notifyContactFriends       = (($notifyContactFriends != '') ? true : false);
                                        $enabledFieldPriceItems     = Params::getParam('enableField#f_price@items');
                                        $enabledFieldPriceItems     = (($enabledFieldPriceItems != '') ? true : false);
                                        $enabledFieldImagesItems    = Params::getParam('enableField#images@items');
                                        $enabledFieldImagesItems    = (($enabledFieldImagesItems != '') ? true : false);
                                        $numImagesItems             = Params::getParam('numImages@items');
                                        if($numImagesItems=='') { $numImagesItems = 0; }
                                        $regUserCanContact          = Params::getParam('reg_user_can_contact');
                                        $regUserCanContact          = (($regUserCanContact != '') ? true : false);
                                        $contactItemAttachment      = Params::getParam('item_attachment');
                                        $contactItemAttachment      = (($contactItemAttachment != '') ? true : false);
                                        $warnExpiration             = Params::getParam('warn_expiration');
                                        $warnExpiration             = (int) $warnExpiration;
                                        $titleLength				= Params::getParam('max_chars_per_title');
                                        $descriptionLength			= Params::getParam('max_chars_per_description');



                                        $msg = '';
                                        if(!osc_validate_int(Params::getParam("items_wait_time"))) {
                                            $msg .= _m("El tiempo de espera sólo debe contener caracteres numéricos")."<br/>";
                                        }
                                        if(Params::getParam("num_moderate_items")!='' && !osc_validate_int(Params::getParam("num_moderate_items"))) {
                                            $msg .= _m("El número de anuncios moderados sólo debe contener caracteres numéricos")."<br/>";
                                        }
                                        if(!osc_validate_int($numImagesItems)) {
                                            $msg .= _m("Las imágenes por anuncio sólo deben contener caracteres numéricos")."<br/>";
                                        }
                                        if(!osc_validate_int($warnExpiration)) {
                                            $msg .= _m("El número de días de caducidad tiene que ser un valor numérico")."<br/>";
                                        }
                                        if(!osc_validate_int($titleLength)) {
                                            $msg .= _m("Longitud del título tiene que ser un valor numérico")."<br/>";
                                        }
                                        if(!osc_validate_int($descriptionLength)) {
                                            $msg .= _m("Descripción Longitud tiene que ser un valor numérico")."<br/>";
                                        }
                                        if($msg!='') {
                                            osc_add_flash_error_message( $msg, 'admin');
                                            $this->redirectTo(osc_admin_base_url(true) . '?page=items&action=settings');
                                        }



                                        $iUpdated += osc_set_preference('enabled_recaptcha_items', $enabledRecaptchaItems);
                                        if($moderateItems) {
                                            $iUpdated += osc_set_preference('moderate_items', $numModerateItems);
                                        } else {
                                            $iUpdated += osc_set_preference('moderate_items', '-1');
                                        }
                                        $iUpdated += osc_set_preference('logged_user_item_validation', $loggedUserItemValidation);
                                        $iUpdated += osc_set_preference('reg_user_post', $regUserPost);
                                        $iUpdated += osc_set_preference('notify_new_item', $notifyNewItem);
                                        $iUpdated += osc_set_preference('notify_contact_item', $notifyContactItem);
                                        $iUpdated += osc_set_preference('notify_contact_friends', $notifyContactFriends);
                                        $iUpdated += osc_set_preference('enableField#f_price@items', $enabledFieldPriceItems);
                                        $iUpdated += osc_set_preference('enableField#images@items', $enabledFieldImagesItems);
                                        $iUpdated += osc_set_preference('items_wait_time', $itemsWaitTime);
                                        $iUpdated += osc_set_preference('numImages@items', $numImagesItems);
                                        $iUpdated += osc_set_preference('reg_user_can_contact', $regUserCanContact);
                                        $iUpdated += osc_set_preference('item_attachment', $contactItemAttachment);
                                        $iUpdated += osc_set_preference('warn_expiration', $warnExpiration);
                                        $iUpdated += osc_set_preference('title_character_length', $titleLength);
                                        $iUpdated += osc_set_preference('description_character_length', $descriptionLength);

                                        if($iUpdated > 0) {
                                            osc_add_flash_ok_message( _m("La configuración de los anuncios se ha actualizado"), 'admin');
                                        }
                                        $this->redirectTo(osc_admin_base_url(true) . '?page=items&action=settings');
                break;
                case('items_reported'):

                                        require_once osc_lib_path()."osclass/classes/datatables/ItemsDataTable.php";

                                        // set default iDisplayLength
                                        if( Params::getParam('iDisplayLength') != '' ) {
                                            Cookie::newInstance()->push('listing_iDisplayLength', Params::getParam('iDisplayLength'));
                                            Cookie::newInstance()->set();
                                        } else {
                                            // set a default value if it's set in the cookie
                                            if( Cookie::newInstance()->get_value('listing_iDisplayLength') != '' ) {
                                                Params::setParam('iDisplayLength', Cookie::newInstance()->get_value('listing_iDisplayLength'));
                                            } else {
                                                Params::setParam('iDisplayLength', 10 );
                                            }
                                        }
                                        $this->_exportVariableToView('iDisplayLength', Params::getParam('iDisplayLength'));

                                        // Table header order by related
                                        if( Params::getParam('sort') == '') {
                                            Params::setParam('sort', 'date');
                                        }
                                        if( Params::getParam('direction') == '') {
                                            Params::setParam('direction', 'desc');
                                        }

                                        $page  = (int)Params::getParam('iPage');
                                        if($page==0) { $page = 1; };
                                        Params::setParam('iPage', $page);

                                        $params = Params::getParamsAsArray();

                                        $itemsDataTable = new ItemsDataTable();
                                        $itemsDataTable->tableReported($params);
                                        $aData = $itemsDataTable->getData();

                                        if(count($aData['aRows']) == 0 && $page!=1) {
                                            $total = (int)$aData['iTotalDisplayRecords'];
                                            $maxPage = ceil( $total / (int)$aData['iDisplayLength'] );

                                            $url = osc_admin_base_url(true).'?'.Params::getServerParam('QUERY_STRING', false, false);

                                            if($maxPage==0) {
                                                $url = preg_replace('/&iPage=(\d)+/', '&iPage=1', $url);
                                                $this->redirectTo($url);
                                            }

                                            if($page > 1) {
                                                $url = preg_replace('/&iPage=(\d)+/', '&iPage='.$maxPage, $url);
                                                $this->redirectTo($url);
                                            }
                                        }


                                        $this->_exportVariableToView('aData', $aData);
                                        $this->_exportVariableToView('aRawRows', $itemsDataTable->rawRows());

                                        //calling the view...
                                        $this->doView('items/reported.php');
                break;
                default:                // default

                                        require_once osc_lib_path()."osclass/classes/datatables/ItemsDataTable.php";

                                        // set default iDisplayLength
                                        if( Params::getParam('iDisplayLength') != '' ) {
                                            Cookie::newInstance()->push('listing_iDisplayLength', Params::getParam('iDisplayLength'));
                                            Cookie::newInstance()->set();
                                        } else {
                                            // set a default value if it's set in the cookie
                                            if( Cookie::newInstance()->get_value('listing_iDisplayLength') != '' ) {
                                                Params::setParam('iDisplayLength', Cookie::newInstance()->get_value('listing_iDisplayLength'));
                                            } else {
                                                Params::setParam('iDisplayLength', 10 );
                                            }
                                        }
                                        $this->_exportVariableToView('iDisplayLength', Params::getParam('iDisplayLength'));

                                        // Table header order by related
                                        if( Params::getParam('sort') == '') {
                                            Params::setParam('sort', 'date');
                                        }
                                        if( Params::getParam('direction') == '') {
                                            Params::setParam('direction', 'desc');
                                        }

                                        $page  = (int)Params::getParam('iPage');
                                        if($page==0) { $page = 1; };
                                        Params::setParam('iPage', $page);

                                        $params = Params::getParamsAsArray();

                                        $itemsDataTable = new ItemsDataTable();
                                        $aData = $itemsDataTable->table($params);

                                        if(count($aData['aRows']) == 0 && $page!=1) {
                                            $total = (int)$aData['iTotalDisplayRecords'];
                                            $maxPage = ceil( $total / (int)$aData['iDisplayLength'] );

                                            $url = osc_admin_base_url(true).'?'.Params::getServerParam('QUERY_STRING', false, false);

                                            if($maxPage==0) {
                                                $url = preg_replace('/&iPage=(\d)+/', '&iPage=1', $url);
                                                $this->redirectTo($url);
                                            }

                                            if($page > 1) {
                                                $url = preg_replace('/&iPage=(\d)+/', '&iPage='.$maxPage, $url);
                                                $this->redirectTo($url);
                                            }
                                        }


                                        $this->_exportVariableToView('aData', $aData);
                                        $this->_exportVariableToView('withFilters', $itemsDataTable->withFilters());
                                        $this->_exportVariableToView('aRawRows', $itemsDataTable->rawRows());

                                        $bulk_options = array(
                                            array('value' => '', 'data-dialog-content' => '', 'label' => __('Acciones')),
                                            array('value' => 'delete_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Borrar'))), 'label' => __('Borrar')),
                                            array('value' => 'activate_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Activar'))), 'label' => __('Activar')),
                                            array('value' => 'deactivate_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Desactivar'))), 'label' => __('Desactivar')),
                                            array('value' => 'disable_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Bloquear'))), 'label' => __('Bloquear')),
                                            array('value' => 'enable_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Desbloquear'))), 'label' => __('Desbloquear')),
                                            array('value' => 'spam_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Marcar como spam'))), 'label' => __('Marcar como spam')),
                                            array('value' => 'despam_all', 'data-dialog-content' => sprintf(__('Are you sure you want to %s the selected listings?'), strtolower(__('Desmarcar como spam'))), 'label' => __('Desmarcar como spam'))
                                        );
                                        $bulk_options = osc_apply_filter("item_bulk_filter", $bulk_options);
                                        $this->_exportVariableToView('bulk_options', $bulk_options);

                                        //calling the view...
                                        $this->doView('items/index.php');
            }
        }

        //hopefully generic...
        function doView($file)
        {
            osc_run_hook("before_admin_html");
            osc_current_admin_theme_path($file);
            Session::newInstance()->_clearVariables();
            osc_run_hook("after_admin_html");
        }
    }

    /* file end: ./oc-admin/items.php */
?>
