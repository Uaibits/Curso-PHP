<?php

require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/ArquivosComponent.php';
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../model/UsuarioAlbunsModel.php';
require_once __DIR__ . '/../model/AlbumImagensModel.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

print_r("<pre>");
print_r($_POST);
// Sempre printe a variavel abaixo para saber como irá trabalhar com ela
print_r("<pre>");
print_r($_FILES);

// Ao realizarmos upload de multiplos arquivos o PHP irá ter a seguinte estrutura na variavel $_FILES
// Para ver o exemplo de upload de uma unica imagem veja o controller UsuarioFotoPerfilController.php
// $_FILES['nome_do_campo_no_input']['propriedade_do_arquivo']['indice_do_arquivo']
/*
Array
(
    [imagens] => Array
        (
            [name] => Array
                (
                    [0] => carrinho-de-compras.png
                    [1] => bicicleta-de-entrega.png
                )

            [full_path] => Array
                (
                    [0] => carrinho-de-compras.png
                    [1] => bicicleta-de-entrega.png
                )

            [type] => Array
                (
                    [0] => image/png
                    [1] => image/png
                )

            [tmp_name] => Array
                (
                    [0] => C:\Users\carlo\AppData\Local\Temp\php8FA6.tmp
                    [1] => C:\Users\carlo\AppData\Local\Temp\php8FB6.tmp
                )

            [error] => Array
                (
                    [0] => 0
                    [1] => 0
                )

            [size] => Array
                (
                    [0] => 11796
                    [1] => 10223
                )

        )

)
 */

/**
 * Informações sobre cada propriedade do arquivo
 *
 * name: Nome do arquivo enviado, ou seja, o nome do arquivo que o usuário escolheu para enviar
 *
 * full_path: Caminho completo do arquivo enviado
 *
 * type: Tipo do arquivo, por exemplo, image/png, image/jpeg, application/pdf, etc
 * Existem uma infinidade de tipos de arquivos, para saber mais acesse: https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Basico_sobre_HTTP/MIME_types
 * Você pode utilizar esse campo para validar se o arquivo enviado é do tipo que você deseja
 *
 * tmp_name: Diretorio com nome temporário do arquivo!
 * O PHP irá salvar o arquivo em um diretório temporário, você pode mover o arquivo para o diretório que desejar
 *
 * error: Código de erro, caso o arquivo não tenha sido enviado com sucesso
 * Para validarmos se o arquivo foi realizado o upload corretamente utilizamos o  UPLOAD_ERR_OK
 * Para ver todos os erros possiveis acesse: https://www.php.net/manual/en/features.file-upload.errors.php
 *
 * size: Tamanho do arquivo em bytes
 * Você pode utilizar esse campo para validar se o arquivo enviado é do tamanho que você deseja
 * Por exemplo, você pode limitar o tamanho do arquivo para 2MB, 5MB, 10MB, etc
 * OBS: O PHP não irá validar o tamanho do arquivo, você deve fazer isso manualmente
 */

if (verificaSeEstaLogado()) {

    if (!empty($_POST['nome'])) {

        $usuario = pegarUsuarioLogado();

        // Nosso checkbox irá retornar true caso esteja marcado, caso não esteja marcado ele não irá retornar nada
        // por isso criamos uma variavel $privado e setamos como false por padrão
        $privado = 0;

        if (!empty($_POST['privado'])) {
            $privado = 1;
        }

        // Cria um album no banco de dados
        $id_album = criarAlbum($usuario['id'], $_POST['nome'], $privado);
        $ARQUIVOS = converterArrayDeFilesParaPadrao($_FILES['imagens']);
        $diretorio = __DIR__ . '/../public/uploads/albums/album_' . $id_album;

        $salvo_com_sucesso = [];
        $erros = [];
        // Vamos salvar os arquivos, caso algum arquivo não seja salvo corretamente
        // iremos cancelar o salvamento do album e exibir uma mensagem de erro
        foreach ($ARQUIVOS as $arquivo) {
            $retorno__ = salvarArquivo($arquivo, $diretorio);
            if ($retorno__['sucesso'] === false) {
                $erros[] = $retorno__['mensagem'];
            } else {
                $salvo_com_sucesso[] = $retorno__;
            }
        }

        // Se todos os arquivos foram salvos com sucesso ou seja, se a lista de erros for vazia,
        // então iremos salvar as imagens no banco de dados
        if (empty($erros)) {

            foreach ($salvo_com_sucesso as $key => $value) {
                adicionarImagemAoAlbum($id_album, $value['nome_arquivo']);
            }

            setFlash('sucesso', 'Album criado com sucesso!');
            redirecionar();

        } else {

            // Vamos deletar o album que foi criado
            deletarAlbum($id_album);
            deletarDiretorio($diretorio);

            setFlash('erro', 'Erro ao salvar as imagens');
            // Vamos salvar os erros na sessão para exibir na tela
            setFlash('erro_images', $erros);
            redirecionar('album/novo');
        }

    } else {
        setFlash('erro', 'Preencha o nome do album');
        redirecionar('album/novo');
    }

} else {
    redirecionar('login');
}
