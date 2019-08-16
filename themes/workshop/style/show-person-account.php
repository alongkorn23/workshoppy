<div class="container">
<?php
$username = $data['account']->get_username();

if ($username) {
    echo "<p>{$username}</p>\n";
    $user = new midcom_core_user($data['person']);
    if ($user->is_online() == 'online') {
        echo '<p>' . $data['l10n']->get('user is online') . "</p>\n";
    } elseif ($lastlogin = $user->get_last_login()) {
        $formatter = $data['l10n']->get_formatter();
        echo '<p>' . $data['l10n']->get('last login') . ': ' . $formatter->datetime($lastlogin) . "</p>\n";
    }
    if (   $data['person']->id == midcom_connection::get_user()
        || midcom::get()->auth->can_user_do('org.openpsa.user:manage', null, org_openpsa_user_interface::class)) {
        $workflow = new midcom\workflow\datamanager;
        echo '<p>';
        echo '<a class="btn btn-primary" href="' . $data['router']->generate('account_edit', ['guid' => $data['person']->guid]) . '" ' . $workflow->render_attributes() . ' />' . $data['l10n_midcom']->get('edit') . "</a>\n";
        $workflow = new midcom\workflow\delete([
            'object' => $data['person'],
            'label' => $data['l10n']->get('account')
        ]);
        echo '<a href="' . $data['router']->generate('account_delete', ['guid' => $data['person']->guid]). '" ' . $workflow->render_attributes() . '" class="btn btn-danger">';
        echo '<span class="toolbar_label">' . $data['l10n_midcom']->get('delete') . '</span></a>';
        if (    midcom::get()->config->get('auth_allow_trusted') === true
             && $data['person']->can_do('org.openpsa.user:su')) {
             echo '<a class="btn btn-secondary" href="' . $data['router']->generate('account_su', ['guid' => $data['person']->guid]) . '" />' . $data['l10n']->get('switch to user') . "</a>\n";
        }
        echo "</p>\n";
    }
} else {
    echo '<p><span class="metadata">' . $data['l10n']->get("no account") . '</span></p>';
    if (   $data['person']->id == midcom_connection::get_user()
        || midcom::get()->auth->can_user_do('org.openpsa.user:manage', null, org_openpsa_user_interface::class)) {
        $workflow = new midcom\workflow\datamanager;
        echo '<p>';
        echo '<a class="button" href="' . $data['router']->generate('account_create', ['guid' => $data['person']->guid]) . '" ' . $workflow->render_attributes() . '/>' . $data['l10n']->get('create account') . "</a>\n";
        echo "</p>\n";
    }
} ?>
</div>