<?php
$head = midcom::get()->head;
$head->enable_jquery();
$current_language = midcom::get()->i18n->get_current_language();

if ($current_language == 'de') {
    setlocale(LC_TIME, "de_DE");
} else {
    setlocale(LC_TIME, "en_GB");
}

// add js
$head->add_jsfile(MIDCOM_STATIC_URL . "/workshop/bootstrap-4.3.0-dist/js/bootstrap.min.js", true);
$head->add_stylesheet(MIDCOM_STATIC_URL . "/workshop/theme.css");

$context = midcom_core_context::get();
$topic = $context->get_key(MIDCOM_CONTEXT_CONTENTTOPIC);
$title_prefix =  $context->get_key(MIDCOM_CONTEXT_PAGETITLE);
$data = $context->get_custom_key('request_data');
?>

<!DOCTYPE html>
<html lang="&(current_language);">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="x-ua-compatible" content="ie=edge" />
    	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    	<title>&(title_prefix); - <(title)></title>
    	<link rel="stylesheet" type="text/css" href="/midcom-static/workshop/bootstrap-4.3.0-dist/css/bootstrap.min.css" />
    	<script>
		window.workshoppy = {};
    	</script>
    	<?php
            $head->print_head_elements();
        ?>
	</head>
	<body class="<?php echo $topic->name; ?> <?php echo str_replace('.', '-', $topic->component); ?>">
		<?php
		if (empty($data['skip_header'])) {
		    ?>
			<(header)>
		<?php
		} ?>
		<?php midcom::get('uimessages')->show(); ?>
		<div class="content-wrapper">
			<(content)>
		</div>
		<?php
		if (empty($data['skip_header'])) {
		    ?>
			<(footer)>
		<?php
		} ?>
		<?php midcom::get()->toolbars->show(); ?>
	</body>
</html>