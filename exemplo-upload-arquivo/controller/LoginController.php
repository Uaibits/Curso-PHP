<?php
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

if (!empty($_POST['email']) && !empty($_POST['senha'])) {
    if (logar($_POST['email'], $_POST['senha']) == true) {
        setFlash('sucesso', 'Logado com sucesso');
        redirecionar();
    } else {
        setFlash('erro', 'Credenciais inválidas');
        redirecionar('login');
    }
} else {
    setFlash('erro', 'Preencha todos os campos');
    redirecionar('login');
}