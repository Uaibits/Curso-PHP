<?php
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../model/UsuarioModel.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

if (!empty($_POST['email']) && !empty($_POST['senha']) && !empty($_POST['nome'])) {

    if (buscarUsuarioPeloEmail($_POST['email']) == null) {
        cadastrarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);

        if (logar($_POST['email'], $_POST['senha']) == true) {
            redirecionar("view/NoticiasView.php");
        } else {
            setFlash('erro', 'Credenciais inválidas');
            redirecionar('view/RegistrarView.php');
        }
    } else {
        setFlash('erro', 'Email já cadastrado');
        redirecionar('view/RegistrarView.php');
        return;
    }

} else {
    setFlash('erro', 'Preencha todos os campos');
    redirecionar('view/RegistrarView.php');
}