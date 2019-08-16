<?php
$guid = midcom::get()->auth->user->get_storage()->guid;
$l10n = midcom::get()->i18n->get_l10n('de.ccb.workshop');
$log_out = $l10n->get('log out');
$log_in = $l10n->get('log in');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
	<a class="navbar-brand" href="/"><?php echo $l10n->get('workshoppy nav')?></a>
  		<div id="navbar" class="collapse navbar-collapse">
    		<ul class="navbar-nav mr-auto">
				<li class="nav-item"><a class="nav-link" href="/account/view/&(guid);/"><?php echo $l10n->get('profile nav')?></a></li>
    		</ul>
    		<ul class="navbar-nav navbar-right">
      			<li class="nav-item"><?php
                    $user = midcom::get('auth')->user;
                    if ($user) {
                        echo '</li><li>';
                        echo "<a href=\"/midcom-logout-\" class=\"nav-link logout\">$log_out</a>";
                    } else {
                        echo "<a href=\"/midcom-login-\" class=\"nav-link\">$log_in</a>";
                    }
                    ?>
       			</li>
    		</ul>
  		</div>
	</div>
</nav>
<script type="text/javascript">
$(document).ready(function() {
    $.each($('#navbar').find('li'), function() {
        $(this).toggleClass('active', 
            window.location.pathname.indexOf($(this).find('a').attr('href')) > -1);
    }); 
})
</script>