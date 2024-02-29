<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function isAuth() : void {
    session_start();

    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : void{
    session_start();

    if (!$_SESSION['admin']) {
        header('Location: /');
    }
}