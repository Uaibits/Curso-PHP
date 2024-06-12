<?php

require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../model/NoticiaModel.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

if ($_POST['noticia_id']) {
    $usuario = pegarUsuarioLogado();
    if ($usuario != null) {
        if (verificarSeUsuarioJaCurtiuNoticia($_POST['noticia_id'], $usuario['id']) == true) {
            descurtirNoticia($_POST['noticia_id'], $usuario['id']);
        } else {
            curtirNoticia($_POST['noticia_id'], $usuario['id']);
        }
    }
}

redirecionar('view/NoticiasView.php');
