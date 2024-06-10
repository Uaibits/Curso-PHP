<?php
require 'funcoes.php';


$usuario = login($_POST['email'], $_POST['senha']);
session_start();
session_start();
exit();
if ($usuario != NULL) {

    //Iniciar uma sessão para que os dados permaneçam
    $_SESSION['id_usuario'] = $usuario['id'];
    unset($_SESSION['erro']);
    header('Location: http://php.test/exemplo-login/home.php');

} else {
    $_SESSION['erro'] = 'Usuario ou senha incorreto';
    header('Location: http://php.test/exemplo-login/login.php');
}