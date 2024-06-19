<?php

function conexao()
{
    $mysqli = new mysqli('localhost', 'root', '', 'galeria_fotos');
    // Esta linha é importante pq ela faz com que funcione os caracteres com acento como por exemplo
    // é ç à â....
    // sem ele os caracteres com acento será exibidos como o caracter �
    $mysqli->set_charset("utf8mb4");
    return $mysqli;
}

/**
 * @param string $nome_tabela Nome da tabela que irá ser buscada no banco de dados
 * @param boolean $multiplos Se a consulta irá retornar multiplos resultados ou somente o primeiro
 * @param array $campos_para_buscar Os campos que deseja buscar no banco, isso equivale a SELECT nome, email FROM .... se passar [] ele buscará todos campos *
 * @param string $where Sua condição da consulta, não precisa passar o WHERE por que a consulta já concatena
 * @return array|false|null
 *
 * Esta função é uma função genérica para buscas no banco de dados onde ela cria uma consulta
 * com base nos parametros
 * ela pode ser chamada de várias formas como
 *
 * select('usuarios', true, ['nome', 'id', 'email'], 'nome LIKE "%joao%"')
 * select('usuarios', false, ['nome', 'id', 'email'], 'id=5')
 * select('usuarios', false, [], 'id=5')
 * select('usuarios')
 * select('usuarios', false)
 */
function select($nome_tabela, $multiplos = true, $campos_para_buscar = [], $where = '')
{

    $colunas = '';
    if (sizeof($campos_para_buscar) > 0) {
        /*
         foreach ($campos_para_buscar as $campo) {

            if ($colunas == '') {
                $colunas = $campo;
            } else {
                $colunas = $colunas . ',' . $campo;
            }

        }

        A função implode faz a mesma coisa que o codigo comentado acima, ele pega um array e transforma ele num texto
        separando os valores por ',' ou seja um
        $array = [
            "banana",
            "pera"
        ];

        retornaria "banana, pera"
        */

        $colunas = implode(',', $campos_para_buscar);
    } else {
        $colunas = '*';
    }


    // Aqui iremos adicionar o deleted_at no nosso where para buscarmos somente dados que não foram deletados
    // Se não for passado o where nossa consulta ficaria como 'SELECT ... FROM ... WHERE deleted_at IS NULL
    // Se for passado o where nossa consulta ficaria como 'SELECT ... FROM ... WHERE sua_condicao AND deleted_at IS NULL
    if ($where == '') {
        $where = 'deleted_at IS NULL';
    } else {
        $where = $where .= ' AND deleted_at IS NULL';
    }

    $query = "SELECT $colunas FROM $nome_tabela WHERE $where";

    // Experimente descomentar para entender melhor e visualizar sua consulta completa
//    print_r("<pre>");
//    print_r($query);

    $conexao = conexao();
    $resultado = $conexao->query($query);

    if ($multiplos == true) {
        return $resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        return $resultado->fetch_assoc();
    }

}

/**
 * @param $nome_tabela
 * @param array $values_a_inserir Valores que irá inserir no [formato nome_coluna => valor_coluna] por exemplo
 * [
 *      "email" => "usuario@email.com"
 * ]
 * @return int
 */

function insert($nome_tabela, array $values_a_inserir)
{
    $conexao = conexao();
    $colunas = '';
    $valores = '';
    foreach ($values_a_inserir as $chave => $valor) {
        if ($colunas == '') {
            $colunas = $chave;
            $valores = "'$valor'";
        } else {
            $colunas = $colunas . ',' . $chave;
            $valores .= ", '$valor'";
        }
    }

    $query = "INSERT INTO $nome_tabela ($colunas) VALUES ($valores)";
    // Experimente descomentar para entender melhor e visualizar sua consulta completa
//    print_r("<pre>");
//    print_r($query);

    $conexao->query($query);
    // Vamos retornar o id inserido para que possamos utilizar em outras partes do código
    // Este insert_id é uma propriedade do mysqli que retorna o id do ultimo registro inserido
    $id_inserido = $conexao->insert_id;
    return $id_inserido;
}

/**
 * @param string $nome_tabela Nome da tabela que irá ser buscada no banco de dados
 * @param array $values_a_atualizar Valores que irá atualizar no [formato nome_coluna => valor_coluna] por exemplo
 * [
 *      "email" => "usuario@email.com"
 * ]
 * @param $where Sua condição where, não precisa passar o texto where por que a query ja concatena
 * @return void
 */
function update($nome_tabela, array $values_a_atualizar, $where)
{
    $conexao = conexao();
    $set_valores = '';
    foreach ($values_a_atualizar as $chave => $valor) {
        if ($set_valores == '') {
            $set_valores = $chave . ' = ' . $valor;
        } else {
            $set_valores = $set_valores . ', ' . $chave . ' = ' . $valor;
        }
    }

    $query = "UPDATE $nome_tabela SET $set_valores WHERE $where";
    // Experimente descomentar para entender melhor e visualizar sua consulta completa
//    print_r("<pre>");
//    print_r($query);

    $conexao->query($query);
}

/**
 * @param string $nome_tabela Nome da tabela que irá ser buscada no banco de dados
 * @param $where Sua condição where, não precisa passar o texto where por que a query ja concatena
 * @param $hard Se você deseja deletar de fato a linha ou somente colocar o deleted_at como a data atual
 * @return void
 */
function delete($nome_tabela, $where, $hard = false)
{
    $conexao = conexao();
    if ($hard == true) {
        $query = "DELETE FROM $nome_tabela WHERE $where";
    } else {
        $query = "UPDATE $nome_tabela SET deleted_at = CURRENT_TIMESTAMP WHERE $where";
    }

    // Experimente descomentar para entender melhor e visualizar sua consulta completa
//    print_r("<pre>");
//    print_r($query);

    $conexao->query($query);
}