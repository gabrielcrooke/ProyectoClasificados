<?php
   
?>
<div class="actions">
  <a href="#" data-bclass-toggle="display-filters" class="resp-toogle show-filters-btn"><?php _e('Menú de visualización','bender'); ?></a>
</div>
<div id="sidebar">
    <?php echo osc_private_user_menu( get_user_menu() ); ?>
</div>
<div id="dialog-delete-account" title="<?php echo osc_esc_html(__('Borrar cuenta', 'bender')); ?>">
<?php _e('¿Seguro que quieres eliminar tu cuenta?', 'bender'); ?>
</div>