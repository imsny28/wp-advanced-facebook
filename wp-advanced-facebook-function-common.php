<?php
add_filter('plugin_action_links', 'new_fb_plugin_action_links', 10, 2);

function new_fb_plugin_action_links($links, $file) {

    if ($file != FACEBOOK_BASE_FILE) return $links;
    $settings_link = '<a href="' . esc_url(menu_page_url('nextend-facebook-connect', false)) . '">' . esc_html(__('Settings', 'nextend-facebook-connect')) . '</a>';
    array_unshift($links, $settings_link);

    return $links;
}


add_filter('get_avatar', 'new_fb_insert_avatar', 5, 5);

function new_fb_insert_avatar($avatar = '', $id_or_email, $size = 96, $default = '', $alt = false) {

    $id = 0;
    if (is_numeric($id_or_email)) {
        $id = $id_or_email;
    } else if (is_string($id_or_email)) {
        $u  = get_user_by('email', $id_or_email);
        $id = $u->id;
    } else if (is_object($id_or_email)) {
        $id = $id_or_email->user_id;
    }
    if ($id == 0) return $avatar;
    $pic = get_user_meta($id, 'fb_profile_picture', true);
    if (!$pic || $pic == '') return $avatar;
    $avatar = preg_replace('/src=("|\').*?("|\')/i', 'src=\'' . $pic . '\'', $avatar);

    return $avatar;
}
