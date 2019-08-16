<?php
$log_out = $data ['l10n']->get ('log out');
$log_in = $data ['l10n']->get ('log in');
?>

<script>
var WS_CONFIG = {
	url: '<?php echo $data['config']->get('websocket_server'); ?>'
};
window.workshoppy.guid = '<?php echo $data['workshop']->guid; ?>';
</script>

<nav class="navbar navbar-expand-lg navbar-light bg-light loginNav">
	<div class="container-fluid">
		<ul class="navbar-nav ml-auto" id="nav-element">
			<li class="nav-item"><a class="nav-link" id="loginName"></a></li>
			<li class="nav-item"><a class="nav-link active" id="log-out" href="">
					<i class="fa fa-sign-out" aria-hidden="true"></i>
    						<?php echo $data['l10n']->get('log out');?>
    					</a></li>
		</ul>
	</div>
</nav>

<div id="loginByUsername" class="container">
	<div id="stage-welcome" class="container">
		<h1 class="text-center"><?php echo $data['l10n']->get('welcome to workshoppy');?></h1>
	</div>		
	<div id="overlay-content" class="container">
		<form id="register">
			<div class="form-group row" id="setUsernameForm">
				<label id="setUsername"><?php echo $data['l10n']->get('please enter your name');?>:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" required id="userName"
						placeholder="<?php echo $data['l10n']->get('enter your name');?>">
				</div>
			</div>
			<button class="btn btn-primary btn-block" type="submit">
				<i class="fa fa-floppy-o" aria-hidden="true"></i>
                <?php echo $data['l10n']->get('save');?>
            </button>
		</form>
	</div>
</div>

<div class="alert alert-danger alert-dismissible fade show"
	id="connection-close" role="alert" style="display: none;">
	<?php echo $data['l10n']->get('connection unreachable');?>
</div>

<div class="container stage" id="stage-waiting">
	<h1 class="text-center"><?php echo $data['l10n']->get('please wait');?></h1>
</div>

<div class="container stage" id="stage-session">
	<h2 id="question" class="text-center"></h2>
	<hr class="my-4">
	<form id="answer">
		<div class="form-group row">
			<div class="col-sm-12">
				<textarea rows="4" cols="56" id="message_input" required
					class="form-control"
					placeholder="<?php echo $data['l10n']->get('enter your message');?>"></textarea>
			</div>
		</div>
		<!--<label id="selectCategory"><?php //echo $data['l10n']->get('select category');?></label>-->
		<!--  <select class="browser-default custom-select">
  			<option value="unsorted"><?php //echo $data['l10n']->get('unsorted');?></option>
		</select>-->
		<button class="btn btn-primary btn-block" type="submit">
			<i class="fa fa-comment" aria-hidden="true"></i>
			<?php echo $data['l10n']->get('submit');?>
		</button>
	</form>
</div>
