<?php
require_once 'Conexao.php';
require_once 'UsuarioModel.php';
require_once '../components/UtilsComponent.php';

function buscarAlbumPeloSlugEUsuario($slug, $usuario_id)
{
    $album = select('usuarios_albuns', false, [], "slug='$slug' AND id_usuario=$usuario_id AND privado=false");
    return $album;
}
function criarAlbum($usuario_id, $nome_album, $privado)
{
    $slug = gerarSlug($nome_album);
    // Verifica se o slug já existe
    if (buscarAlbumPeloSlugEUsuario($slug, $usuario_id) != null) {
        // Se existir, adiciona um id único ao final do slug
        $slug = $slug . "-" . uniqid();
    }

    return insert('usuarios_albuns', [
        'id_usuario' => $usuario_id,
        'slug' => $slug,
        'nome_album' => $nome_album,
        'privado' => $privado
    ]);
}

function buscarAlbunsDoUsuario($usuario_id)
{
    $albuns = select('usuarios_albuns', true, [], "id_usuario=$usuario_id");
    return $albuns;
}

function buscarAlbumPeloId($album_id)
{
    $album = select('usuarios_albuns', false, [], "id=$album_id");
    return $album;
}

function buscarAlbunsPublicos()
{
    $albuns = select('usuarios_albuns', true, [], "privado=false");
    if ($albuns != null) {
        foreach ($albuns as &$album) {
            $album['usuario'] = buscarUsuarioPeloId($album['id_usuario']);
        }
    }
//    print_r("<pre>");
//    print_r($albuns);
    return $albuns;
}

function deletarAlbum($album_id)
{
    delete('usuarios_albuns', "id=$album_id");
}