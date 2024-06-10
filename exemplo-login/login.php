<?php
require 'funcoes.php';
if (getUsuario() != false) {
    header('Location: http://php.test/exemplo-login/home.php');
    return;
}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<form action="api_login.php" method="post" style="background: honeydew; width: 50%; margin: 0 auto; padding: 25px">
    <?php if (isset($_SESSION['erro'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['erro'] ?>
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
    <button class="btn btn-primary">Login</button>
</form>
</body>
</html>