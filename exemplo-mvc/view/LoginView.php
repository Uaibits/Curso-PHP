<?php
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';

if (verificaSeEstaLogado()) {
    header('Location: NoticiasView.php');
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>

<form action="../controller/LoginController.php" method="post" style="background: honeydew; width: 50%; margin: 0 auto; padding: 25px">
    <?php if (flashIsSet('erro')): ?>
        <div class="alert alert-danger" role="alert">
            <?= flash('erro') ?>
        </div>
    <?php endif; ?>

    <div>
        <label class="form-label">E-mail</label>
        <input placeholder="Email" type="email" class="form-control" name="email">
    </div>

    <div>
        <label class="form-label">Senha</label>
        <input placeholder="Senha" type="password" class="form-control" name="senha">
    </div>
    <button class="btn btn-primary">Logar</button>

    <a href="RegistrarView.php">Registrar</a>
</form>

</body>
</html>
