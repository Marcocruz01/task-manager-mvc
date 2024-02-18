<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController
{

    // login
    public static function login(Router $router)
    {
        $alerts = [];
        // Instansed model User
        $user = new User($_POST);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync_up($_POST);
            // validate login with the function 
            $alerts = $user->validate_login();
            // if empty alerts...
            if(empty($alerts)) {
                // verify if user exist in database
                $user = User::where('email', $user->email);
                // verify if user have a tag of verification and verify if exist
                if(!$user || !$user->user_confirm) {
                    User::setAlert('error', '
                    <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        <strong>An error has occurred!</strong> This account hasn`t been verified or don`t exist.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ');
                } else {  
                    // if user exist, to confirm if email and password are correct
                    if( password_verify($_POST['password'], $user->password)) {
                        // let`s start login
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['last_name'] = $user->last_name;
                        $_SESSION['position'] = $user->position;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;
                        header('Location: /dashboard/tasks');
                    } else {
                        User::setAlert('error', '
                        <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                            <strong>An error has occurred!</strong> Password incorrect, try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ');
                    }
                }
            } 
        }
        $alerts = User::getAlerts();
        $router->render('auth/login', [
            'title' => 'Login',
            'alerts' => $alerts,
            'user' => $user
        ]);
    }

    // logout 
    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
    }

    // create account
    public static function create(Router $router)
    {
        $user = new User;
        $alerts = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // we synchronize the input data via POST
            $user->sync_up($_POST);
            // Alerts for the validation of the new account
            $alerts = $user->validate_new_account();
            // If alerts is empty, next steps
            if (empty($alerts)) {
                // Validate that don`t exist other account
                $existing_account = User::where('email', $user->email);
                if ($existing_account) {
                    // Let`s set alert
                    User::setAlert('error', '
                    <div class="fs-4 alert alert-warning alert-dismissible fade show mb-0 " role="alert">
                        <strong>Existing Email!</strong> Email currently exists, try a different email.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ');
                    // Let`s get alert
                    $alerts = User::getAlerts();
                } else {
                    // hash the password
                    $user->hash_password();
                    // Delete the password2 temporally
                    unset($user->password2);
                    // Generate a new token 
                    $user->token();
                    // If there is a result, save a user
                    $result = $user->save();
                    // Instances the values of email of the model
                    $email = new Email($user->email, $user->name, $user->token);
                    // Send email to confirmation
                    $email->sendConfirmation();
                    if ($result) {
                        header('Location: /message-success');
                    }
                }
            }
            // Let`s get alert
            $alerts = User::getAlerts();
        }
        $router->render('auth/create', [
            'title' => 'Create Account',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    // forgot password
    public static function forgot(Router $router)
    {
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instanced Model new User
            $user = new User($_POST);
            // Validate fields empty
            $alerts = $user->validate_email();
            // The alerts is empty...
            if(empty($alerts)) {
                // Search the user with the email into
                $user = User::where('email', $user->email);
                // If user is = true...
                if($user && $user->user_confirm) {
                    // Generated a new token 
                    $user->token();
                    // Delete password2 temporally
                    unset($user->password2);
                    // Temporarily save data until the user updates their password
                    $user->save();
                    // Send email with the instructions
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();
                    // Show successfully message 
                    User::setAlert('success', '
                    <div class="fs-4 alert alert-success alert-dismissible fade show mb-0 " role="alert">
                        <strong>Successful Request!</strong> We send you an email, check your inbox.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ');
                    $alerts = User::getAlerts();
                }
            }
        }
        $router->render('auth/forgot_password', [
            'title' => 'Forgot Password',
            'alerts' => $alerts
        ]);
    }

    public static function restore(Router $router)
    {
        $alerts = [];
        // Sanitize input token and validate if token is true
        $token = s($_GET['token']);
        $valid_token = true;
        // if there isn`t token redirects user
        if(!$token) header('Location: /');
        // if token is true, identify and found the user
        $user = User::where('token', $token);
        // send alert if user not found
        if(!$user) {
            // Let`s set alert
            User::setAlert('error', '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0 " role="alert">
                <strong>An error has occurred!</strong> The token is invalid, try later.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            $valid_token = false;
        }
        // request method
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sync up the post
            $user->sync_up($_POST);
            // validate both passwords
            $alerts = $user->validate_password();
            // if alerts is empty
            if(empty($alerts)) {
                // hash the password
                $user->hash_password();
                // delete password2
                unset($user->password2);
                // modify token, token is empty
                $user->token = '';
                // Save the user with their new password
                $result = $user->save();
                // redirect user 
                if($result) header('Location: /');
            }
        }
        $alerts = User::getAlerts();
        $router->render('auth/restore_password', [
            'title' => 'Restore Password',
            'alerts' => $alerts,
            'valid_token' => $valid_token
        ]);
    }

    // Confirm account
    public static function confirm(Router $router)
    {
        $alerts = [];
        // sanitize the token
        $token = s($_GET['token']);
        // condition to check if there is token
        if (!$token) {
            header('Location: /');
        }
        // Now to consult if there exist a user with the same token
        $user = User::where('token', $token);
        // If there is no user with the same token, we show an error alert
        if (empty($user)) {
            User::setAlert('error', '
            <div class="alert alert-danger alert-dismissible fade show mt-3 fs-4" role="alert">
                <strong class="fs-3">An error has occurred!</strong> We did not find any user with this token, try again later.
            </div>
            ');
        } else {
            // Update user confirm to 1
            $user->user_confirm = 1;
            // Update to null the token 
            $user->token = null;
            // Delete password2 of user
            unset($user->password2);
           // Save the new user
           $user->save();
            // Show success alert
            User::setAlert('success', '
            <div class="alert alert-success p-5 mt-3" role="alert">
                <p class="alert-heading fs-1 fw-bold">Your account was successfully confirmed!</p>
                <p class="fs-3">Now you can enjoy the app, organize your tasks in the best way and have more control over them.</p>
                <hr>
            </div>
            ');
        }
        // Let`s get alert
        $alerts = User::getAlerts();
        $router->render('auth/confirm_account', [
            'title' => 'Confirm Account',
            'alerts' => $alerts
        ]);
    }

    // message success
    public static function message(Router $router)
    {
        $router->render('auth/message_success', [
            'title' => 'Message Success'
        ]);
    }
}
