<?php

require_once __DIR__ . '/../model/NoticiaModel.php';
require_once __DIR__ . '/../components/PrintComponent.php';

// Pode colocar aqui todas as funções referentes a página principal, por exemplo listagem de noticia

function noticiasLista()
{
    $noticias = [];
    //Pegando o filtro da URL caso exista para buscar noticia pelo titulo
    if (isset($_GET['filtro'])) {
        $noticias = buscarNoticias($_GET['filtro']);
    } else {
        $noticias = buscarNoticias();
    }

    // Experimente descomentar a linha abaixo ou exibir um print_r($noticias)
//    exibirPrintR($noticias, "NOTICIAS");

    // Lembre de passar o & pois iremos alterar o array de noticia para colocar as curtidas
    foreach ($noticias as &$noticia) {
        $curtidas = curtidasDaNoticia($noticia['id']);
        $noticia['curtidas'] = $curtidas;
        $noticia['qtd_curtidas'] = sizeof($curtidas);
    }

    // Experimente descomentar a linha abaixo ou exibir um print_r($noticias)
//    exibirPrintR($noticias, "NOTICIAS COMPLETAS");

    // Retornando um novo array pq preciso retornar tanto as noticias quanto a quantidade de noticias
    //Ou seja, preciso retornar mais de um dado, por isso crio um array com as keys
    // 'quantidade_noticias' e 'noticias'
    return [
        'quantidade_noticias' => sizeof($noticias),
        'noticias' => $noticias
    ];
}