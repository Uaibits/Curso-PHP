<?php

function criarDiretorioSeNaoExistir($diretorio)
{
    // Verifica se o diretório existe
    if (!is_dir($diretorio)) {

        // Se o diretório não existir, então criamos ele
        // Se não criarmos o diretório, o PHP irá retornar um erro
        // O segundo parâmetro é a permissão que o diretório terá
        // 0777 é a permissão máxima, ou seja, qualquer usuário do sistema operacional pode ler, escrever e executar, pode deixar 0755 que é a permissão padrão
        // O terceiro parâmetro é para criar o diretório recursivamente, ou seja, se o diretório pai não existir, ele será criado
        mkdir($diretorio, 0755, true);

    }
}

/**
 * @param $diretorio
 * @return void
 *
 * Função para deletar um diretório
 */
function deletarDiretorio($diretorio)
{
    // Verifica se o diretório existe
    if (is_dir($diretorio)) {
        // Para deletar um diretório, precisamos deletar todos os arquivos dentro dele
        // Para isso utilizamos a função glob() que retorna um array com todos os arquivos de um diretório
        // O * é um coringa que significa "todos os arquivos"
        // Veja mais sobre essa função na documentação oficial
        // https://www.php.net/manual/pt_BR/function.glob.php
        $arquivos = glob($diretorio . '/*');

        // Vamos deletar todos os arquivos
        foreach ($arquivos as $arquivo) {
            // unlink() deleta um arquivo especifico, basta passar o caminho completo do arquivo
            unlink($arquivo);
        }

        // Por fim, deletamos o diretório
        rmdir($diretorio);
    }
}

function salvarArquivo($arquivo, $diretorio)
{
//    print_r("<pre>");
//    print_r($arquivo);
    if ($arquivo['error'] === UPLOAD_ERR_OK) {

        // Vamos validar se o tipo do arquivo é png ou jpeg ou gif
        // para que não seja possivel fazer upload de zip, pdf entre outros arquivos
        if ($arquivo['type'] === 'image/png' || $arquivo['type'] === 'image/jpeg' || $arquivo['type'] === 'image/gif') {

            // Vamos validar o tamanho do arquivo para não aceitarmos
            // Arquivos muito grandes que podem comprometer nosso espaço de armazenamento
            // Limitando o tamanho do arquivo para 1KB
            if ($arquivo['size'] <= 100000024) {

                // precisamos verificar se o diretorio existe antes de salvar para que não ocorra erros
                criarDiretorioSeNaoExistir($diretorio);

                //pathinfo($arquivo['name']) retorna um array com informações sobre o nome do arquivo
                //Isso inclui o nome do arquivo, a extensão do arquivo, etc
                //Exemplo de retorno:
                //Array
                //(
                //    [dirname] => .
                //    [basename] => bicicleta-de-entrega.png
                //    [extension] => png
                //    [filename] => bicicleta-de-entrega
                //)

                $informacoes_arquivo = pathinfo($arquivo['name']);
//                print_r("<pre>");
//                print_r($informacoes_arquivo);

                //uniqid() gera um id único baseado na hora atual em microsegundos
                //Ou seja, é praticamente impossível gerar o mesmo id duas vezes
                //O nome do arquivo será o id único gerado concatenado com a extensão do arquivo
                //Exemplo de retorno: 5f3b3b6b618f7.png
                $novo_nome = uniqid() . '.' . $informacoes_arquivo['extension'];

                //O caminho completo do arquivo será o diretório que queremos salvar o arquivo concatenado com o novo nome do arquivo
                $caminho_completo = $diretorio . '/' . $novo_nome;

                //move_uploaded_file() move o arquivo que está no diretório temporário para o diretório que queremos salvar
                move_uploaded_file($arquivo['tmp_name'], $caminho_completo);

                //Retornamos o novo nome do arquivo para salvar no banco de dados
                return [
                    'sucesso' => true,
                    'nome_arquivo' => $novo_nome,
                ];
            } else {
                return [
                    'sucesso' => false,
                    'erro' => 'tamanho_invalido',
                    'mensagem' => 'Tamanho do arquivo inválido, aceitamos apenas arquivos de até 1MB'
                ];
            }

        } else {
            return [
                'sucesso' => false,
                'erro' => 'tipo_invalido',
                'mensagem' => 'Tipo de arquivo inválido, aceitamos apenas imagens do tipo PNG, JPEG ou GIF'
            ];
        }
    }

    return [
        'sucesso' => false,
        'erro' => 'arquivo_nao_enviado',
        'mensagem' => 'Arquivo não foi enviado com sucesso'
    ];
}

/**
 * @param array $files
 * @return array
 *
 * Função para converter o array de arquivos para o mesmo padrão que utilizamos quando enviamos um único arquivo
 * Para facilitar o trabalho com multiplos arquivos
 */
function converterArrayDeFilesParaPadrao($files)
{
    $arquivos = [];

    $qtdeArquivos = count($files['name']);
    $nomes = $files['name'];
    $fullPaths = $files['full_path'];
    $types = $files['type'];
    $tmpNames = $files['tmp_name'];
    $errors = $files['error'];
    $sizes = $files['size'];

    for ($i = 0; $i < $qtdeArquivos; $i++) {
        $arquivos[] = [
            'name' => $nomes[$i],
            'full_path' => $fullPaths[$i],
            'type' => $types[$i],
            'tmp_name' => $tmpNames[$i],
            'error' => $errors[$i],
            'size' => $sizes[$i],
        ];
    }
    return $arquivos;
}