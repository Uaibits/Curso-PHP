<?php
require_once 'Conexao.php';

function cadastrarUsuario($nome, $email, $senha)
{
//    $conexao->query("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', MD5('$senha'))");
    insert('usuarios', [
        'nome' => $nome,
        'email' => $email,
        'senha' => md5($senha)
    ]);
}

function buscarUsuarioPeloId($idUsuario)
{
//    $usuario = $conexao->query("SELECT * FROM usuarios WHERE id = '$idUsuario'");
//    A consulta acima com nossa função que criamos ficaria assim

    $usuario = select('usuarios', false, [], "id=$idUsuario");
    return $usuario;
}

function buscarUsuarioPeloEmail($email)
{
    $conexao = conexao();
//    $usuario = $conexao->query("SELECT * FROM usuarios WHERE email = '$email'");
    $usuario = select('usuarios', false, [], "email='$email'");
    return $usuario;
}

function buscarUsuarioPeloUsername($username)
{
    $usuario = select('usuarios', false, [], "username='$username'");
    return $usuario;
}

function verificaCredenciais($email, $senha)
{
//    $usuario = $conexao->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = MD5('$senha')");
    $usuario = select('usuarios', false, [], "email = '$email' AND senha = MD5('$senha')");
    return $usuario;
}