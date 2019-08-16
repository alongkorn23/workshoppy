<div class="container">
    <div class="jumbotron">
        <h4><?php echo $data['l10n']->get("user account"); ?></h4>
        <hr class="my-4">
        <?php midcom_show_style('show-person-account'); ?>
    </div>
    <div class="jumbotron">
    	<?php $data['view']->display_view(); ?>
    </div>
</div>