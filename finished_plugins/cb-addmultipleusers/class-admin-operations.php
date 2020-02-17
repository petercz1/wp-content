<?php
namespace chipbug\addbulkusers;

class Admin_Operations
{
    public function __construct()
    {
        add_action('wp_ajax_create_users', array($this, 'create_users'));
        add_action('wp_ajax_get_users', array($this, 'get_users'));
    }

    public function create_users()
    {
        if ($this->check_nonce()) {
            // create users
            $bulk_users = ($_POST['cb_addbulkusers_userlist']);
            $password_ext = ($_POST['cb_password_ext']);
            $wp_role = ($_POST['cb_wp_role']);

            $bulk_users = explode(',', $bulk_users);
            $bulk_errors = array();
            foreach ($bulk_users as $individual_user) {
                $individual_user = rtrim($individual_user);
                $individual_user = ltrim($individual_user);
                $individual_user = str_replace(' ', '_', $individual_user);
                $user_id = wp_create_user($individual_user, $individual_user . $password_ext, $individual_user . '@' . $individual_user . '.com');
                if (is_wp_error($user_id)) {
                    $user_id->{'user'} = $individual_user;
                    array_push($bulk_errors, $user_id);
                }
                $user = new \WP_user($user_id);
                $user->set_role($wp_role);
            }
            echo json_encode($bulk_errors);
            write_log($bulk_errors);

            wp_die();
        }
    }

    public function get_users()
    {
        $users_and_roles = $this->get_user_and_roles(get_users());
        echo json_encode($users_and_roles);
        wp_die();
    }

    public function get_user_and_roles($users)
    {
        $users_and_roles = array();
        foreach ($users as $user) {
            $temp_user['id'] = $user->ID;
            $temp_user['display_name'] = $user->data->display_name;
            $temp_user['email'] = $user->data->user_email;
            $temp_user['login'] = $user->data->user_login;
            $temp_user['roles'] = $user->roles;
            write_log($user->roles);
            array_push($users_and_roles, $temp_user);
        }
        return $users_and_roles;
    }

    public function get_roles($user_id)
    {
        $user = new \WP_User($user_id);
        if (empty($user->roles) or ! is_array($user->roles)) {
            return array();
        }
        $wp_roles = new \WP_Roles;
        $names    = $wp_roles->get_names();
        $out      = array();
        foreach ($user->roles as $role) {
            if (isset($names[ $role ])) {
                $out[ $role ] = $names[ $role ];
            }
        }
        return $out;
    }

    public function check_nonce()
    {
        $nonce = $_POST['nonce'];
        if (wp_verify_nonce($nonce, 'number_used_once')) {
            return true;
        } else {
            return false;
        }
    }
}
