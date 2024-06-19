<?php
require_once '../components/UtilsComponent.php';
require_once 'Conexao.php';

function adicionarImagemAoAlbum($id_album, $nome_imagem)
{
    insert('albuns_images',
        [
            'id_album' => $id_album,
            'imagem' => $nome_imagem,
        ]
    );
}

function buscarImagensDoAlbum($id_album)
{
    $imagens = select('albuns_images', true, [], "id_album=$id_album");
    if ($imagens !== null) {
        foreach ($imagens as &$imagem) {
            // Adicionando o link completo da imagem
            $imagem['link'] = DOMINIO . '/public/uploads/albums/album_' . $id_album . '/' . $imagem['imagem'];
        }
    }
    return $imagens;
}

function buscarImagemPeloId($id_imagem)
{
    $imagem = select('albuns_images', false, [], "id=$id_imagem");
    return $imagem;
}

function deletarImagem($id_imagem)
{
    delete('albuns_images', "id=$id_imagem");
}
