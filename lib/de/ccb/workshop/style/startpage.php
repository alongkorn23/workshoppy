<?php
$prefix = midcom_core_context::get()->get_key(MIDCOM_CONTEXT_ANCHORPREFIX);
$url_workshop_create = $data['router']->generate('create_workshop');
$workflow = new midcom\workflow\datamanager();
$formatter = $data['l10n']->get_formatter();
/** @var midcom_services_i18n_formatter $formatter */
?>
<div class="container">

	<div class="jumbotron">
		<h4>
        <a class="btn btn-success createButton float-right" href="&(url_workshop_create);" <?php echo $workflow->render_attributes(); ?>>
        	<i class="fa fa-plus" aria-hidden="true"></i>
        	<?php echo $data['l10n']->get('create workshop') ?>
        </a>

		<?php echo $data['l10n']->get('lists of workshops');?>
		</h4>
		<hr class="my-4">
  		<div class="alert alert-info helptext<?php if (count($data['workshops']) > 0) { echo ' d-none';} ?>"><?php echo $data['l10n']->get('no workshops helptext'); ?></div>
		<ul>
			<?php
        foreach ($data['workshops'] as $workshop) {
            $workflow_delete = new midcom\workflow\delete([
                'object' => $workshop,
                'label' => sprintf($data['l10n']->get('workshop %s'), htmlentities($workshop->title)),
                'dialog_text' => sprintf($data['l10n_midcom']->get('delete %s'), htmlentities($workshop->title))
            ]);
            $workflow_edit = new midcom\workflow\datamanager();
            $url = $data['router']->generate('controller_workshop', ['guid' => $workshop->guid]);
            $edit_url = $data['router']->generate('update_workshop', ['guid' => $workshop->guid]);
            $delete_url = $data['router']->generate('delete_workshop', ['guid' => $workshop->guid]);
            ?>
            <li><a href="&(url);">&(workshop.title);</a></li>
            <a class='btn btn-primary mr-2 editButton' href="&(edit_url);"<?php echo $workflow_edit->render_attributes() ?>>
            	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </a>
            <a class='btn btn-danger deleteButton' href="&(delete_url);"<?php echo $workflow_delete->render_attributes() ?>>
            	<i class="fa fa-trash-o" aria-hidden="true"></i>
            </a>
            <?php
        }
    ?>
		</ul>
	</div>
	
	<div class="jumbotron archivedWorkshops">
		<h4><?php echo $data['l10n']->get('closed workshops');?></h4>
		<hr class="my-4">
		<div class="alert alert-info helptext<?php if (count($data['archived_workshops']) > 0) { echo ' d-none';} ?>"><?php echo $data['l10n']->get('no closed workshops helptext'); ?></div>
		<ul>
			<?php 
			foreach ($data['archived_workshops'] as $archived_workshops) {
			    $url_workshop_result = $data['router']->generate('workshop_result', ['guid' => $archived_workshops->guid]);
			?>
			 <li>
			 	<a>&(archived_workshops.title);</a>
			 	<span class="text-muted">
			 		(<?php 
			 	       echo $data['l10n']->get('closed date');
			 	       echo " ";
			 	       echo $formatter->datetime($archived_workshops->closed);
			 	     ?>)
			 	</span>
			 </li>
			 <a class="btn btn-warning result-button"  href="&(url_workshop_result);" onclick="window.open(this.href); return false;">
            	<i class="fa fa-file-text" aria-hidden="true"></i>
            	<?php echo $data['l10n']->get('show result button')?>
        	 </a>
			<?php
			}
			?>
		</ul>
	</div>
</div>
