<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function ifLoggedIn()
{
    if (!($_SESSION['user_id'])) {
        header("Location: ../login/login_view.php");
        die();
    }
}
ifLoggedIn();
