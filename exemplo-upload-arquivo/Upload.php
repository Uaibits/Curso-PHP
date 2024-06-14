<?php

print_r("<pre>");
print_r($_POST);
print_r($_FILES);

$tipo_arquivo = $_FILES['foto-perfil']['type'];
$tmp_arquivo = $_FILES['foto-perfil']['tmp_name'];
$tamanho_arquivo = $_FILES['foto-perfil']['size'];
$nome_arquivo = $_FILES['foto-perfil']['name'];

// pathinfo retorna as informações de um arquivo
// informações com nome, diretorio, extensão
// para usar basta chamar pathinfo($nome_do_arquivo)
print_r(pathinfo($nome_arquivo));
$extensao = pathinfo($nome_arquivo)['extension'];

// o preg_match funciona como o like do sql, ele vai validar se a string
// possui o que estiver dentro do delimitador, nosso delimitador é o +
// o delimitador deverá ficar antes e depois do nosso texto
if (preg_match('+image+', $tipo_arquivo)) {

    // uniqueid gera uma string aleatoria sempre que é executado
    // portanto as imagens nunca terão o mesmo nome
    $nome_nova_imagem = uniqid() . '.' . $extensao;
    $diretorio = './imagens';
    $novo_arquivo = $diretorio . '/' . $nome_nova_imagem;

    // is_dir verifica se o path (caminho) passado é um diretorio
    if (is_dir($diretorio) == false) {
        // se não for um diretorio é porque ele não existe, então iremos criar
        // o diretorio usando a função mkdir passando o path (caminho) desse diretorio
        mkdir($diretorio);
    }

    move_uploaded_file($tmp_arquivo, $novo_arquivo);
    echo "<h1 style='color: green'> Upload de imagem feita com sucesso! </h1>";

} else {
    echo "<h1 style='color: red'> Tipo de arquivo não permitido </h1>";
}


