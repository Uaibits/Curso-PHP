<?php
require_once __DIR__ . '/../components/AuthComponent.php';
require_once __DIR__ . '/../components/AlbunsComponent.php';
require_once __DIR__ . '/../components/FashComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';

$meusAlbuns = meusAlbuns();
$albunsPublicos = albunsPublicos();
?>

<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Noticias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!--
    <link rel="stylesheet" href="../assets/css/home.css">
    Lembre-se de não voltar diretorio para importar também o css, pois o .htaccess faz com que vc esteja na pasta
     principal do projeto, por isso basta acessar a pasta assets como se sua HomeView.php estivesse na pasta exemplo-upload-arquivo-->
    <link rel="stylesheet" href="<?= cssUrl('home.css') ?>">
</head>
<body>


<?php require __DIR__ . '/layout/MenuLayout.php'; ?>


<section class="flash-mensagens">

    <!--    Exibindo mensagens de erro e sucesso -->
    <?php if (flashIsSet('erro')): ?>
        <div class="flash-mensagem flash-mensagem-error">
            <?= flash('erro') ?>
        </div>
    <?php endif; ?>

    <?php if (flashIsSet('sucesso')): ?>
        <div class="flash-mensagem flash-mensagem-success">
            <?= flash('sucesso') ?>
        </div>
    <?php endif; ?>

</section>

<?php if (verificaSeEstaLogado()): ?>
    <section class="albuns-privados">
        <h1>Seus Albuns</h1>
        <div class="albuns">
            <?php foreach ($meusAlbuns as $album): ?>
                <div class="album">
                    <span>ID: <?= $album['id'] ?> Nome: <?= $album['nome_album'] ?></span>

                    <div class="imagens">
                        <?php foreach ($album['imagens'] as $imagem): ?>
                            <img src="<?= $imagem['link'] ?>" alt="">
                        <?php endforeach; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<section class="albuns-publicos">
    <h1>Albuns Públicos</h1>
    <div class="albuns">
        <?php foreach ($albunsPublicos as $album): ?>
            <div class="album">
               <div class="album-titulo">
                   <span>
                       <?= $album['id'] ?> - <?= $album['nome_album'] ?>
                       <a href="<?= linkUrl('album/' . $album['usuario']['username'] . '/' . $album['slug']) ?>"> (Ver Album)</a>
                   </span>
                   <span>By: <?= $album['usuario']['nome'] ?></span>
               </div>

                <div class="imagens">
                    <?php foreach ($album['imagens'] as $imagem): ?>
                        <img src="<?= $imagem['link'] ?>" alt="">
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</section>

<script src="<?= jsUrl('flash-menssagem.js') ?>"></script>

</body>
</html>
