<?php
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/AlbunsComponent.php';
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

if (verificaSeEstaLogado() == false) {
    redirecionar('login');
    return;
}

$meusAlbuns = meusAlbuns();
$erros_imagens = flash('erro_images');
?>

<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Noticias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= cssUrl('home.css') ?>">
</head>
<body>


<?php require __DIR__ . '/layout/MenuLayout.php'; ?>


<!-- Vamos utilizar o javascript para esconder a div flash-mensagens -->
<!-- Veja no javascript assets/js/flash-menssagem.js o codigo que irá fazer isso -->
<section class="flash-mensagens">

    <!--    Exibindo mensagens de erro e sucesso -->
    <?php if (flashIsSet('erro')): ?>
        <div class="flash-mensagem flash-mensagem-error">
            <?= flash('erro') ?>
        </div>
    <?php endif; ?>

    <?php if ($erros_imagens != null): ?>
        <!-- Como no nosso controller definimos um array de erros para a key, vamo fazer um foreach para cada erro -->
        <?php foreach ($erros_imagens as $erro): ?>
            <div class="flash-mensagem flash-mensagem-error">
                <?= $erro ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (flashIsSet('sucesso')): ?>
        <div class="flash-mensagem flash-mensagem-success">
            <?= flash('sucesso') ?>
        </div>
    <?php endif; ?>

</section>

<form action="<?= linkUrl('api/novo-album') ?>" method="post" enctype="multipart/form-data" class="form-novo-album">
    <h1 class="form-novo-album__titulo">Novo Album</h1>
    <div class="form-novo-album__campo">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="true" name="privado" id="privado">
        <label class="form-check-label" for="privado">
            Album privado
        </label>
    </div>

    <h2 class="form-novo-album__titulo">Imagens</h2>
    <section class="form-novo-album__imagens">
        <div class="form-novo-album__campo">
            <label for="imagems">
                <i class="fa-regular fa-images"></i>
                <span>
                    Selecione uma ou mais imagens
                </span>
            </label>
            <!-- o atributo multiple permite que o input receba mais de um arquivo de uma vez -->
            <!-- ou seja, você pode selecionar mais de uma imagem de uma vez -->
            <input type="file" id="imagems" name="imagens[]" multiple>
        </div>
    </section>

    <button class="form-novo-album__botao" type="submit">Criar</button>

</form>

<!-- Para adicionar um script no HTML é necessário utilizar a tag <script> -->
<!-- O flash-menssagem.js é um arquivo que contém o código javascript que será utilizado nesta página -->
<script src="<?= jsUrl('flash-menssagem.js') ?>"></script>

</body>
</html>
