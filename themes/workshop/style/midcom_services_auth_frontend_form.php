<?php
$data = $this->data;
?>
<form name="midcom_services_auth_frontend_form" method="post" id="midcom_services_auth_frontend_form">
    <div class="form-group">
        <label for="username"><?php echo midcom::get()->i18n->get_string('username', 'midcom'); ?></label>
        <input name="username" id="username" type="text" class="form-control" required />

    </div>
    <div class="form-group">
        <label for="password"><?php echo midcom::get()->i18n->get_string('password', 'midcom'); ?></label>
        <input name="password" id="password" type="password" class="form-control" required />

    </div>
<?php
if (!empty($data['restored_form_data'])) {
    foreach ($data['restored_form_data'] as $key => $value) {
        echo "                <input type=\"hidden\" name=\"restored_form_data[{$key}]\" value=\"{$value}\" />\n";
    }

    echo "                <div class=\"form-group form-check\">\n";
    echo "                    <input name=\"restore_form_data\" id=\"restore_form_data\" type=\"checkbox\" value=\"1\" checked=\"checked\" class=\"form-check-input\" />\n";
    echo "                    <label for=\"restore_form_data\">\n";
    echo "                        " . midcom::get()->i18n->get_string('restore submitted form data', 'midcom') . "?\n";
    echo "                    </label>\n";
    echo "                </div>\n";
}
?>
  <input type="submit" class="btn btn-primary" name="midcom_services_auth_frontend_form_submit" id="midcom_services_auth_frontend_form_submit" value="<?php
    echo midcom::get()->i18n->get_string('login', 'midcom'); ?>" />
</form>