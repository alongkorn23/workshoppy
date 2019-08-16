<?php
$workshop = $data['workshop'];
$url = $data['router']->generate('controller_workshop', ['guid' => $workshop->guid]);
$url_presentation = $data['router']->generate('presentation', ['guid' => $workshop->guid]);
$url_client = $data['router']->generate('client', ['guid' => $workshop->guid]);
$url_session_create = $data['router']->generate('create_session', ['guid' => $workshop->guid]);
$url_workshopResult = $data['router']->generate('workshop_result', ['guid' => $workshop->guid]);
$url_archived_workshops = $data['router']->generate('archived_workshops', ['guid' => $workshop->guid]);
$workflow = new midcom\workflow\datamanager(['relocate' => false]);
?>
<script>
var WS_CONFIG = {
    url: '<?php echo $data['config']->get('websocket_server'); ?>'
};

window.workshoppy.start_session_helptext = '<?php echo $data['l10n']->get('the session is running');?>';
window.workshoppy.stop_session_helptext = '<?php echo $data['l10n']->get('only available while the session is running');?>';
window.workshoppy.edit_session_helptext = '<?php echo $data['l10n']->get('while the session is running, it can not be edited');?>';
window.workshoppy.delete_session_helptext = '<?php echo $data['l10n']->get('while the session is running, it can not be deleted');?>';
window.workshoppy.no_connection_helptext = '<?php echo $data['l10n']->get('there is no connection to websockets');?>';
window.workshoppy.stop_workshop_helptext = '<?php echo $data['l10n']->get('while the session is running, this workshop can not be finished');?>';
window.workshoppy.guid = '<?php echo $workshop->guid; ?>';
window.workshoppy.save_data_prefix = '/save/sessiondata/';
window.workshoppy.sessiondata = <?php echo json_encode($data['sessiondata']); ?>;
window.workshoppy.sessioncategories = <?php echo json_encode($data['sessioncategories']); ?>;

</script>
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" id= "connection-close" role="alert" style="display:none;">
          <?php echo $data['l10n']->get('connection unreachable');?>
    </div>
    <h1>
        <?php echo sprintf($data['l10n']->get('workshop %s'), htmlentities($workshop->title));?>
    </h1>

    <ul class="nav nav-tabs" role="tablist">
  		<li class="nav-item">
    		<a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="home" aria-selected="true"><?php echo $data['l10n']->get('workshop controls');?></a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda" aria-selected="false"><?php echo $data['l10n']->get('agenda nav');?></a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" id="participants-tab" data-toggle="tab" href="#participants" role="tab" aria-controls="participants" aria-selected="false"><?php echo $data['l10n']->get('participants nav');?></a>
  		</li>
	</ul>
	<div class="jumbotron tab-content">
  		<div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
			<div class="workshopData">
        		<a class="btn btn-success onlineButton" href="&(url_client);" onclick="window.open(this.href); return false;">
            		<i class="fa fa-user-circle-o" aria-hidden="true"></i>
            		<?php echo $data['l10n']->get('client button')?>
        		</a>
        		<a class='btn btn-info' href="&(url_presentation);" id="controller-button">
            		<i class="fa fa-television" aria-hidden="true"></i>
            		<?php echo $data['l10n']->get('presentation button')?>
        		</a>
        		<button class='btn btn-warning' id="showResult-button" href="&(url_workshopResult);" title= "<?php echo $data['l10n']->get('no results available');?>">
            		<i class="fa fa-file-text" aria-hidden="true"></i>
            		<?php echo $data['l10n']->get('show result button')?>
        		</button>
        		<button class="btn btn-danger float-right stopWSButton" data-toggle="modal" data-target="#confirmModal">
            		<i class="fa fa-window-close" aria-hidden="true"></i>
            		<?php echo $data['l10n']->get('close the workshop')?>
        		</button>
  			</div>
  		</div>
  		<div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
			<div class="workshopData">
				&(workshop.agenda:h);
  			</div>
  		</div>
  		<div class="tab-pane fade" id="participants" role="tabpanel" aria-labelledby="participants-tab">
			<form id="workshop-participants">
				<h4><?php printf($data['l10n']->get('invite link to client screen %s'), htmlentities($workshop->title))?></h4>
				<hr class="my-4">
				<div class="workshopData">
					<div class="form-inline">
      					<div class="input-group mx-sm-3 mb-2">
      						<input type="email" class="form-control" id="inputEmail" required="required" size="45" placeholder="<?php echo $data['l10n']->get('enter an email address');?>">
							<div class="input-group-append">
		  						<button type="submit" class="btn btn-primary mb-2 submitEmail">
          							<i class="fa fa-envelope-o" aria-hidden="true"></i>
          							<?php echo $data['l10n']->get('submit');?>
          						</button>
							</div>
  						</div>
  					</div>
  				</div>
  			</form>
  		</div>
	</div>

	<div class="modal" id="confirmModal" tabindex="-1" role="dialog">
  		<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title"><?php echo $data['l10n']->get('please confirm');?></h5>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
      			</div>
      			<div class="modal-body">
        			<p><?php echo sprintf($data['l10n']->get('you want to finish this workshop %s ?'), htmlentities($workshop->title));?></p>
      			</div>
      			<div class="modal-footer">
        			<a type="button" class="btn btn-primary confirm-button" href="&(url_archived_workshops);"><?php echo $data['l10n']->get('yes');?></a>
        			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $data['l10n']->get('no');?></button>
      			</div>
    		</div>
  		</div>
	</div>

    <div class="jumbotron">
        <h4>
			<a class="btn btn-success float-right createButton" href="&(url_session_create);"<?php echo $workflow->render_attributes();?>>
    			<i class="fa fa-plus" aria-hidden="true"></i>
    			<?php printf($data['l10n_midcom']->get('create %s'), $data['l10n']->get('session'));?>
			</a>
        	<?php echo $data['l10n']->get('session list');?>
        </h4>
        <hr class="my-4">
        <div class="alert alert-info helptext<?php if (count($data['sessions']) > 0) { echo ' d-none';} ?>"><?php echo $data['l10n']->get('no sessions helptext'); ?></div>
        <ul id="session-list">
        	<?php
                foreach ($data['sessions'] as $session) {
                    $workflow_delete = new midcom\workflow\delete([
                        'object' => $session,
                        'label' => sprintf($data['l10n']->get('sessions data %s'), htmlentities($session->get_label())),
                        'dialog_text' => sprintf($data['l10n_midcom']->get('delete %s'), htmlentities($session->get_label())),
                        'relocate' => false
                    ]);

                    $edit_url = $data['router']->generate('update_session', ['session_guid' => $session->guid, 'guid' => $workshop->guid]);
                    $delete_url = $data['router']->generate('delete_session', ['session_guid' => $session->guid, 'guid' => $workshop->guid]);

                echo "<li>";
                echo "<span class='session-label'>" . htmlentities($session->get_label()) . "</span>"; ?>

        	<span class="object-controls">
            	<button class='btn btn-primary mr-2 editButton' href="&(edit_url);" title="<?php echo $data['l10n']->get('while the session is running, it can not be edited');?>"<?php echo $workflow->render_attributes() ?>>
                	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </button>
                <button class='btn btn-danger deleteButton' href="&(delete_url);" title="<?php echo $data['l10n']->get('while the session is running, it can not be deleted');?>"<?php echo $workflow_delete->render_attributes() ?>>
                     <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
            </span>

            <span class="session-controls">
            	<button data-session="&(session.guid);" data-question="&(session.question);" class='btn btn-success session-start' title="<?php echo $data['l10n']->get('the session is running');?>">
                	<i class="fa fa-play-circle" aria-hidden="true"></i>
                    <?php echo $data['l10n']->get('start session')?>
                </button>
                <button data-session="&(session.guid);" class='btn btn-info session-stop-input' title="<?php echo $data['l10n']->get('only available while the session is running');?>">
                    <i class="fa fa-ban" aria-hidden="true"></i>
                    <?php echo $data['l10n']->get('stop input')?>
                </button>
                <button data-session="&(session.guid);" class='btn btn-danger session-stop' title="<?php echo $data['l10n']->get('only available while the session is running');?>">
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                    <?php echo $data['l10n']->get('exit button')?>
                </button>
             </span>
           </li>
          <?php } ?>
		</ul>
	</div>
</div>