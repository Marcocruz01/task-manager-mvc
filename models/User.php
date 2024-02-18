<?php

namespace Model;

class User extends ActiveRecord
{
    protected static $tabla = 'user';
    protected static $columnasDB = ['id', 'name', 'last_name', 'position', 'email', 'password', 'user_confirm', 'token', 'admin'];


    public $id;
    public $name;
    public $last_name;
    public $position;
    public $email;
    public $password;
    public $password2;
    public $current_password;
    public $new_password;
    public $user_confirm;
    public $token;
    public $admin;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->position = $args['position'] ?? 'update your position';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->current_password = $args['current_password'] ?? '';
        $this->new_password = $args['new_password'] ?? '';
        $this->user_confirm = $args['user_confirm'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? '0';
    }

    // Validate new Account
    public function validate_new_account()
    {
        // Validate fields empty
        if (!$this->name || !$this->last_name || !$this->email || !$this->password || !$this->password2) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Make sure you fill in the empty fields.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        // Validate length password
        if (strlen($this->password) < 8) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Password error!</strong> Password must contain at least 8 characteres.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        // Validate fields password
        if ($this->password !== $this->password2) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Passwords don`t match, try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        return self::$alerts;
    }

    // Validate new Account
    public function validate_account()
    {
        // Validate fields empty
        if (!$this->name || !$this->last_name || !$this->email) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Make sure you fill in the empty fields.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        return self::$alerts;
    }

    public function validate_fields_passwords() : array
    {
        if (!$this->current_password || !$this->new_password) {
            self::$alerts['error'][] = '
                <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong>Error!</strong> Make sure you fill in the empty fields.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
        return self::$alerts;
    }

    // valida new password field
    public function validate_new_password() 
    {
        if (strlen($this->new_password) < 8) {
            self::$alerts['error'][] = '
                <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong>Password error!</strong> Password must contain at least 8 characteres.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
        return self::$alerts;
    }

    // valida field passwords
    public function validate_password()
    {
        // Validate length password
        if(!$this->password || !$this->password2) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Make sure you fill in the empty fields.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        if (strlen($this->password) < 8) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Password error!</strong> Password must contain at least 8 characteres.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        // Validate fields password
        if ($this->password !== $this->password2) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Passwords don`t match, try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    // Validate field emal
    public function validate_email()
    {
        // Validate field email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Invalid Email, try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        return self::$alerts;
    }

    // Validate login
    public function validate_login() 
    {
        if(!$this->email || !$this->password) {
            self::$alerts['error'][] = '
            <div class="fs-4 alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>An error has occurred!</strong> Make sure you fill in the empty fields.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
        return self::$alerts;
    }

    // validate password user
    public function verify_password(): bool {
        return password_verify($this->current_password, $this->password);
    }

    // Hash the password
    public function hash_password() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generate a token new for the validation temporally
    public function token() : void {
        $this->token = uniqid();
    }
}
