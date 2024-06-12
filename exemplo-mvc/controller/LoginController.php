<?php
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

if (!empty($_POST['email']) && !empty($_POST['senha'])) {
    if (logar($_POST['email'], $_POST['senha']) == true) {
        redirecionar('view/NoticiasView.php');
    } else {
        setFlash('erro', 'Credenciais inválidas');
        redirecionar('view/LoginView.php');
    }
} else {
    setFlash('erro', 'Preencha todos os campos');
    redirecionar('view/LoginView.php');
}