<?php

namespace Controllers;

use Model\User;
use MVC\Router;

class DashboardController {

    public static function index(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }

    public static function change_password(Router $router) {
        session_start();
        isAuth();
        $alerts = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::find('id');
            $user->sync_up($_POST);
            $alerts = $user->validate_fields_passwords();
            if($_POST['new_password']) {
                $alerts = $user->validate_new_password();
            }
            if(empty($alerts)) {
                $result = $user->verify_password();
                if($result) {
                    $user->password = $user->new_password;
                    unset($user->current_password);
                    unset($user->password2);
                    $user->hash_password();
                    //save changes 
                    $result = $user->save();
                    if($result) {
                        User::setAlert('success', '
                            <div class="fs-4 alert alert-success alert-dismissible fade show mb-0 " role="alert">
                                <strong>Changes saved successfully!</strong> The password was saved successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        ');
                        $alerts = User::getAlerts();
                    }
                } else 
                User::setAlert('error', '
                    <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0 " role="alert">
                        <strong>Password verify!</strong> The current password does not match the password saved in the database!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                $alerts = $user->getAlerts();
            }
            
        }
        $router->render('dashboard/account/password', [
            'title' => 'Password',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function profile(Router $router) {
        session_start();
        isAuth();
        $alerts = [];
        $user = User::find('id');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync_up($_POST);
            $alerts = $user->validate_account();
            $exist_user = User::where('email', $user->email);

            if ($exist_user && $exist_user->id !== $user->id) {
                User::setAlert('error', '
                    <div class="fs-4 alert alert-warning alert-dismissible fade show mb-0 " role="alert">
                        <strong>Existing Email!</strong> Email currently exists, try a different email!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                $alerts = $user->getAlerts();
            }

            if (empty($alerts)) {
                // Save user and her changes
                $user->save();
                User::setAlert('success', '
                    <div class="fs-4 alert alert-success alert-dismissible fade show mb-0 " role="alert">
                        <strong>Changes saved successfully!</strong> The data changes were saved successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ');
                $alerts = User::getAlerts();
                // Rewrite the information and update with the last saved value.
                $_SESSION['name'] = $user->name;
                $_SESSION['last_name'] = $user->last_name;
                $_SESSION['email'] = $user->email;
                $_SESSION['position'] = $user->position;
            } 
        }

        $router->render('dashboard/account/index', [
            'title' => 'Account',
            'user' => $user,
            'alerts' => $alerts,
        ]);
    }
}