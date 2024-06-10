<?php
require 'funcoes.php';
$usuario = getUsuario();
if ($usuario == false) {
    header('Location: http://php.test/exemplo-login/login.php');
    return;
}

print_r("<pre>");
print_r($_SESSION);
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
<h1>Olá <?= $usuario['nome'] ?></h1>

<a href="sair.php">Clique aqui para sair</a>
</body>
</html>