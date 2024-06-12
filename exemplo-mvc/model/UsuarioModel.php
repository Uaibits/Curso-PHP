<?php
require_once 'Conexao.php';

function cadastrarUsuario($nome, $email, $senha)
{
    $conexao = conexao();
    $conexao->query("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', MD5('$senha'))");
}

function buscarUsuarioPeloId($idUsuario)
{
    $conexao = conexao();
    $usuario = $conexao->query("SELECT * FROM usuarios WHERE id = '$idUsuario'");
    return $usuario->fetch_assoc();
}

function buscarUsuarioPeloEmail($email)
{
    $conexao = conexao();
    $usuario = $conexao->query("SELECT * FROM usuarios WHERE email = '$email'");
    return $usuario->fetch_assoc();
}

function verificaCredenciais($email, $senha)
{
    $conexao = conexao();
    $usuario = $conexao->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = MD5('$senha')");
    return $usuario->fetch_assoc();
}