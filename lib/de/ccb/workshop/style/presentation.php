<?php
$url_client = midcom::get()->get_host_name();
$workshop = $data['workshop'];
?>

<div class="alert alert-danger alert-dismissible fade show" id= "connection-close" role="alert" style="display:none;">
	<?php echo $data['l10n']->get('connection unreachable');?>
</div>

<div class="button-container">
		<button class="btn btn-info" id="createCategory" data-workshop="<?php echo $workshop->id;?>" style="display:none;">
        		<i class="fa fa-plus" aria-hidden="true"></i>
        		<?php echo $data['l10n']->get('create a new category'); ?>
        </button>

        <button class="btn btn-success" id="qrcode-show" style="display:none;">
        		<i class="fa fa-qrcode" aria-hidden="true"></i>
        		<?php echo $data['l10n']->get('qrcode show'); ?>
        </button>

        <button class="btn btn-danger" id="qrcode-exit" style="display:none;">
        	    <i class="fa fa-window-close" aria-hidden="true"></i>
        	    <?php echo $data['l10n']->get('qrcode hide')?>
        </button>

        <button class="btn btn-dark" id="fullscreen-button">
        		<i class="fa fa-arrows-alt" aria-hidden="true"></i>
        </button>

</div>

<div class="text-center" id="toggle-qrcode" style="margin-top: 8rem; display:none;"></div>
<p class="text-center" id="item-qrcode" style="font-size: 20px; display:none;"><?php echo $data['l10n']->get('qrcode to client url'); ?></p>

<div class="container-fluid stage" id="stage-welcome">
	<h1 class="text-center" id="welcome-message"><?php echo $data['l10n']->get('welcome to workshoppy') ?></h1>
	<?php
	   if (!$workshop->agenda) { ?>
	   	<div class="col-sm-12 text-center" id="qrcode"></div>
		<p class="text-center" style="font-size: 20px;"><?php echo $data['l10n']->get('qrcode to client url'); ?></p>

	   <?php } else { ?>
	   	<div id="show-agenda" class="row">
	   		<div class="col-sm-6 ml-auto text-center">
		   		<div id="qrcode"></div>
				<p id="qrcode-description"><?php echo $data['l10n']->get('qrcode to client url'); ?></p>
	   		</div>
			<div id="agenda-text" class="col-sm-5 mr-auto">
				<h2 id="workshop-title"><strong><?php echo sprintf($data['l10n']->get('workshop %s'), $workshop->title)?></strong></h2>
				<p><font size="5">&(workshop.agenda:h);</font></p>
			</div>
		</div>
	   <?php }
	?>
</div>

<div class="container-fluid stage" id="stage-session">
	<h2 id="question" class="text-center"></h2>
	<hr class="my-4">
	<div id="message_output"></div>
	<div id="category_output"></div>
</div>

<script>
	var WS_CONFIG = {
		url: '<?php echo $data['config']->get('websocket_server'); ?>'
	};
	window.workshoppy.guid = '<?php echo $data['workshop']->guid; ?>';

	$(window).on('resize', function() {
		var url = '<?php echo $url_client; ?>/client/' + window.workshoppy.guid + '/';
	    $('#qrcode').empty();
	    var size = Math.min($('#qrcode').width(), $(window).height() - ($('#qrcode').offset().top + 55));
    	$('#qrcode').qrcode({width: size, height: size, text: url});
    });
	$(window).trigger('resize');
    $('#toggle-qrcode').qrcode({width: 580,height: 580, text: '<?php echo $url_client; ?>/client/' + window.workshoppy.guid + '/'});
</script>