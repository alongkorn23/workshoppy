<?php
$l10n = midcom::get()->i18n->get_l10n('de.ccb.workshop');
?>

<div class="wrapper-footer full-width">
	<div class="container">
		<footer class="site-footer main-width font-small">
			<nav class="nav-main left small">
				<ul>
					<li><a href=""><?php echo $l10n->get('imprint'); ?></a></li>
        			<li><a href=""><?php echo $l10n->get('term of use'); ?></a></li>
        			<li><a href=""><?php echo $l10n->get('privacy statement'); ?></a></li>
                	<li><a href=""><?php echo $l10n->get('contacts'); ?></a></li>
        			<li><a href=""><?php echo $l10n->get('help'); ?></a></li>
              	</ul>
              	<div class="col">
              		<a class="copyright" href="https://contentcontrol.berlin/" target="_blank"><?php echo $l10n->get('copyright'); ?></a>
              	</div>
			</nav>
		</footer>
	</div>
</div>