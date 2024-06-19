<?php
require_once __DIR__ . '/../model/UsuarioAlbunsModel.php';
require_once __DIR__ . '/../model/AlbumImagensModel.php';

function meusAlbuns()
{
    if (verificaSeEstaLogado() == true) {
        $usuario = pegarUsuarioLogado();
        $usuarioAlbuns = buscarAlbunsDoUsuario($usuario['id']);
        foreach ($usuarioAlbuns as &$album) {
            $album['imagens'] = buscarImagensDoAlbum($album['id']);
        }

//        print_r("<pre>");
//        print_r($usuarioAlbuns);

        return $usuarioAlbuns;
    } else {
        return [];
    }

}

function albunsPublicos()
{
    $albuns = buscarAlbunsPublicos();
    foreach ($albuns as &$album) {
        $album['imagens'] = buscarImagensDoAlbum($album['id']);
    }

    return $albuns;
}

function buscarAlbumSlug($slug, $usuario_username)
{
    $usuario = buscarUsuarioPeloUsername($usuario_username);
    if ($usuario != null) {
        $album = buscarAlbumPeloSlugEUsuario($slug, $usuario['id']);
        if ($album != null) {
            $album['imagens'] = buscarImagensDoAlbum($album['id']);
            $album['usuario'] = $usuario;
            return $album;
        }
    }
    return null;
}