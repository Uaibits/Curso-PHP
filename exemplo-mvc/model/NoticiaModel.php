<?php

require_once 'Conexao.php';
require_once 'UsuarioModel.php';

/**
 * @param $filtro
 * @return array
 * Função para buscar noticias no banco de dados com possibilidade de buscar noticia pelo title
 *
 * $filtro = null no parametro da função significa que o parametro caso não seja passado terá por padrão o valor null,
 * ou seja, a função pode ser chamada tanto assim
 * buscarNoticias("filtro teste");
 * quanto assim buscarNoticias() -> Caso seja chamada dessa forma o parametro $filtro terá o valor null por padrão
 */
function buscarNoticias($filtro = null)
{
    $conexao = conexao();
    $query = "SELECT * FROM noticias";
    if ($filtro != null) {
        // Caso o filtro seja diferente de null irá concatenar o WHERE na variavel $query e a consulta completa será
        // SELECT * FROM noticias WHERE titulo = $filtro
        $query .= " WHERE titulo = '$filtro'";
    }
    $noticias = $conexao->query($query);
    return $noticias->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param $idNoticia
 *
 * Essa função pode ficar em 'NoticiaModel' mesmo, como a tabela noticias_curtidas no banco de dados
 * faz apenas ligação de um id de usuário que curtiu com um id de noticia
 * essa tabela n tem outra informação a n ser isso então n precisa de uma Model só para ela, seria um arquivo a mais
 * desnecessário
 */
function curtidasDaNoticia($idNoticia)
{
    $conexao = conexao();
    $curtidas = $conexao->query("SELECT * FROM noticias_curtidas WHERE id_noticia = '$idNoticia'");
    $curtidas = $curtidas->fetch_all(MYSQLI_ASSOC);

    // Experimente descomentar a linha abaixo ou exibir um print_r($curtidas)
//    exibirPrintR($curtidas, "CURTIDAS DA NOTICIA DE ID $idNoticia");


    // Como a tabela noticias_curtidas nos temos somente o id da noticia e o id do usuário, precisamos buscar
    // o nome do usuário para exibir na lista de curtidas, nossa tabela noticias_curtidas temos 2 campos
    // 'id_usuario' e 'id_noticia', vamos buscar o usuário pelo id_usuario
    foreach ($curtidas as &$curtida) {
        $usuario = buscarUsuarioPeloId($curtida['id_usuario']);
        $curtida['usuario'] = $usuario;
    }

    // Experimente descomentar a linha abaixo ou exibir um print_r($curtidas)
//    exibirPrintR($curtidas, "CURTIDAS COMPLETAS DA NOTICIA DE ID $idNoticia");


    return $curtidas;
}

function curtirNoticia($idNoticia, $idUsuario)
{
    $conexao = conexao();
    $conexao->query("INSERT INTO noticias_curtidas (id_noticia, id_usuario) VALUES ('$idNoticia', '$idUsuario')");
}

function descurtirNoticia($idNoticia, $idUsuario)
{
    $conexao = conexao();
    $conexao->query("DELETE FROM noticias_curtidas WHERE id_noticia = '$idNoticia' AND id_usuario = '$idUsuario'");
}

function verificarSeUsuarioJaCurtiuNoticia($idNoticia, $idUsuario)
{
    $conexao = conexao();
    $curtida = $conexao->query("SELECT * FROM noticias_curtidas WHERE id_noticia = '$idNoticia' AND id_usuario = '$idUsuario'");
    if ($curtida->fetch_assoc() != null) {
        return true;
    }
    return false;
}