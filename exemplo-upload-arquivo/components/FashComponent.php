<?php

function setFlash($key, $menssagem)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $_SESSION["flash.$key"] = $menssagem;
}

function flash($key)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION["flash.$key"])) {
        $menssagem = $_SESSION["flash.$key"];
        unset($_SESSION["flash.$key"]);
        return $menssagem;
    } else {
        return null;
    }
}

function flashIsSet($key)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    return isset($_SESSION["flash.$key"]);
}