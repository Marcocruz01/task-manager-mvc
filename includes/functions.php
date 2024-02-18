<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// scape / sanitized the HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// function that verify if user is admin
function isAdmin() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}
// function that verify if the user is logged
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /create-account');
    }
}