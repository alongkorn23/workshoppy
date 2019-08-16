<?php
$title = $this->data['midcom_services_auth_show_login_page_title'];
$login_warning = $this->data['midcom_services_auth_show_login_page_login_warning'];
$head = midcom::get()->head;
$head->add_stylesheet(MIDCOM_STATIC_URL . "/workshop/theme.css");
?>
<!DOCTYPE html>
<html lang="<?php echo midcom::get()->i18n->get_current_language(); ?>">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
       	<link rel="stylesheet" type="text/css" href="/midcom-static/workshop/bootstrap-4.3.0-dist/css/bootstrap.min.css" />
        <?php echo midcom::get()->head->print_head_elements(); ?>
    </head>

    <body class="login" onload="self.focus();document.midcom_services_auth_frontend_form.username.focus();">
        <div class="container">
            <div class="jumbotron col-md-6 ml-auto mr-auto">
                <h1>Workshoppy</h1>
                <p class="lead"><?php echo $title; ?></p>
                <hr class="my-4">
                <div id="content">
                    <?php
                    if ($login_warning == '') {
                        echo "<div class=\"alert alert-info\">" . midcom::get()->i18n->get_string('login message - please enter credentials', 'midcom') . "</div>\n";
                    } else {
                        echo "<div class=\"alert alert-danger\">{$login_warning}</div>\n";
                    }
                    ?>
                    <div id="login">
                        <?php
                        midcom::get()->auth->show_login_form();
                        ?>
                    </div>
                </div>
            </div>

            <(footer)>
        </div>
    </body>
    <?php
    midcom::get()->uimessages->show();
    ?>
</html>
