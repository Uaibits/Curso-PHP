<?php
require 'funcoes.php';
$usuario = getUsuario();
if ($usuario != false) {
    // Destroi a sessão ativa
    session_destroy();
    header('Location: http://php.test/exemplo-login/login.php');
}