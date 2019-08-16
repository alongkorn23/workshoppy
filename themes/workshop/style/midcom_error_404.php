<?php

$head = midcom::get('head');
$head->enable_jquery();

$current_language = midcom::get()->i18n->get_current_language();

if ($current_language == 'de')
{
    setlocale(LC_TIME, "de_DE");
}
else
{
    setlocale(LC_TIME, "en_GB");
}

$css_path = MIDCOM_STATIC_URL . "/spoeko/css";
$js_path = MIDCOM_STATIC_URL . "/spoeko/js";

// add css
$head->add_stylesheet($css_path . "/style.css");
// add js
$head->add_jsfile($js_path . "/scripts.js");


echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>Inhalt nicht gefunden</title>
    <?php
    $head->print_head_elements();
    ?>
    <style type="text/css">
        #wrapper {
            opacity: 0.75;
            visibility: visible;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 100000;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            background-color: rgba(0, 56, 101,0.90);
        }
    </style>
</head>
<body class="">
<?php
midcom::get('toolbars')->show();
?>
</body>
</html>
