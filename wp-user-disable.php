<?php
/*
* Plugin Name: WP UserDisable
* Plugin URI: https://kevin-benabdelhak.fr/plugins/wp-user-disable/
* Description: WP User Disable est un plugin WordPress qui permet aux administrateurs de désactiver un compte WordPress temporairement, en conservant les données de ce dernier.
* Version: 1.0
* Author: Kevin Benabdelhak
* Author URI: https://kevin-benabdelhak.fr/
* Contributors: kevinbenabdelhak
*/



if (!defined('ABSPATH')) {
    exit;
}





if ( !class_exists( 'YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
    require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
}
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$monUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/kevinbenabdelhak/WP-User-Disable/', 
    __FILE__,
    'wp-user-disable' 
);
$monUpdateChecker->setBranch('main');












add_filter('manage_users_columns', 'add_user_deactivate_column');
add_action('manage_users_custom_column', 'show_user_deactivate_column', 10, 3);
add_filter('manage_users_sortable_columns', 'make_user_deactivate_column_sortable');
add_action('wp_ajax_update_user_deactivate_status', 'update_user_deactivate_status');
add_action('authenticate', 'prevent_disabled_user_login', 30, 3);

function add_user_deactivate_column($columns) {
    $columns['user_deactivate'] = __('Désactiver', 'textdomain');
    return $columns;
}

function show_user_deactivate_column($output, $column_name, $user_id) {
    if ($column_name == 'user_deactivate') {
        $is_deactivated = get_user_meta($user_id, 'user_deactivated', true);
        $checked = $is_deactivated ? 'checked' : '';
        $output = '<input type="checkbox" class="user-deactivate-checkbox" data-user-id="' . esc_attr($user_id) . '" ' . esc_attr($checked) . ' />';
    }
    return $output;
}

function make_user_deactivate_column_sortable($columns) {
    $columns['user_deactivate'] = 'user_deactivate';
    return $columns;
}

function update_user_deactivate_status() {
    if (!current_user_can('edit_users')) {
        wp_send_json_error('Pas de permission');
    }

    $user_id = intval($_POST['user_id']);
    if ($user_id === get_current_user_id()) {
        wp_send_json_error('Vous ne pouvez pas vous désactiver vous-même.');
    }

    $is_deactivated = get_user_meta($user_id, 'user_deactivated', true);
    $new_status = $is_deactivated ? 0 : 1;
    update_user_meta($user_id, 'user_deactivated', $new_status);

    if ($new_status) {
        if (function_exists('wp_destroy_all_sessions') && class_exists('WP_Session_Tokens')) {
            $session_tokens = WP_Session_Tokens::get_instance($user_id);
            $session_tokens->destroy_all();
        }
    }

    wp_send_json_success($new_status);
}

function prevent_disabled_user_login($user, $username, $password) {
    if ($user && !is_wp_error($user)) {
        $is_deactivated = get_user_meta($user->ID, 'user_deactivated', true);
        if ($is_deactivated) {
            return new WP_Error('user_disabled', __('Ce compte est désactivé. Veuillez contacter un administrateur.', 'textdomain'));
        }
    }
    return $user;
}

add_action('admin_footer', 'enqueue_user_deactivate_script');
function enqueue_user_deactivate_script() {
    ?>
    <style>
        .user-deactivated {
            opacity: 0.3 !important;
        }
        .user-deactivated:hover {
            opacity: 1 !important;
        }
    </style>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('tr').each(function() {
                if ($(this).find('.user-deactivate-checkbox').is(':checked')) {
                    $(this).addClass('user-deactivated');
                }
            });

            $('.user-deactivate-checkbox').change(function() {
                var userId = $(this).data('user-id');
                var parentRow = $(this).closest('tr');
                var isChecked = $(this).is(':checked');

                if (isChecked) {
                    parentRow.addClass('user-deactivated');
                } else {
                    parentRow.removeClass('user-deactivated');
                }

                $.post(ajaxurl, {
                    action: 'update_user_deactivate_status',
                    user_id: userId
                }, function(response) {
                    if (!response.success) {
                        alert('Erreur: ' + response.data);
                        if (isChecked) {
                            parentRow.removeClass('user-deactivated');
                            $(this).prop('checked', false);
                        } else {
                            parentRow.addClass('user-deactivated');
                            $(this).prop('checked', true);
                        }
                    } else {
                        console.log('État mis à jour: ' + response.data);
                    }
                });
            });
        });
    </script>
    <?php
}


/* Si le plugin est amélioré avec d'autres fonctions, il faudra les ranger dans des dossiers séparés, pour l'instant ça va le fichier est court et lisible, à voir la v1.1 si il y a. */