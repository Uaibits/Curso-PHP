<?php

function conexao()
{
    return new mysqli('localhost', 'root', '', 'hotel');
}

function login($email, $senha)
{
    $conexao = conexao();
    $usuario = $conexao->query("SELECT * FROM usuario WHERE email = '$email' AND senha = MD5('$senha')");
    return $usuario->fetch_assoc();
}

function getUsuarioById($id)
{
    $conexao = conexao();
    $usuario = $conexao->query("SELECT * FROM usuario WHERE id = '$id'");
    return $usuario->fetch_assoc();
}

function getUsuario()
{
    // Verifica se a sessão não existe
    if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
    if (isset($_SESSION['id_usuario'])) {
        return getUsuarioById($_SESSION['id_usuario']);
    }
    return false;
}
