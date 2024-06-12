<?php
require_once __DIR__ . '/../model/UsuarioModel.php';
function logar($senha, $email)
{
    $usuario = verificaCredenciais($_POST['email'], $_POST['senha']);
    if ($usuario != null) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['id_usuario'] = $usuario['id'];
        return true;
    }

    return false;
}

function deslogar()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_destroy();
}

function verificaSeEstaLogado()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return isset($_SESSION['id_usuario']);
}

function pegarUsuarioLogado()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (verificaSeEstaLogado()) {
        return buscarUsuarioPeloId($_SESSION['id_usuario']);
    }
    return null;
}