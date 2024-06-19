<?php
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../model/UsuarioModel.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

if (!empty($_POST['email']) && !empty($_POST['senha']) && !empty($_POST['nome']) && !empty($_POST['username'])) {

    //Verifica se o username possui apenas letras e números
    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        if (buscarUsuarioPeloEmail($_POST['email']) == null && buscarUsuarioPeloUsername($_POST['username']) == null) {
            cadastrarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);

            if (logar($_POST['email'], $_POST['senha']) == true) {
                redirecionar();
            } else {
                setFlash('erro', 'Credenciais inválidas');
                redirecionar('registrar');
            }
        } else {
            setFlash('erro', 'Email ou username já cadastrado');
            redirecionar('registrar');
            return;
        }
    } else {
        setFlash('erro', 'Username inválido');
        redirecionar('registrar');
    }


} else {
    setFlash('erro', 'Preencha todos os campos');
    redirecionar('registrar');
}