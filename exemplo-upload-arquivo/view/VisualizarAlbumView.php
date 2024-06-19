<?php

require_once __DIR__ . '/../components/AlbunsComponent.php';
require_once __DIR__ . '/../components/UtilsComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';

// acesse uma url exemplo como http://php.test/exemplo-upload-arquivo/album/1/teste
// E veja o print_r($_GET) abaixo
// https://prnt.sc/tViTvbBm9ApZ
//print_r("<pre>");
//print_r($_GET);

$album = buscarAlbumSlug($_GET['slug'], $_GET['username']);
if ($album == null) {
    redirecionar();
    return;
}

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

<section class="albuns-publicos">
    <h1>Visualizando Album</h1>
    <div class="album">
        <div class="album-titulo">
            <span><?= $album['id'] ?> - <?= $album['nome_album'] ?></span>
            <span>By: <?= $album['usuario']['nome'] ?></span>
        </div>

        <div class="imagens">
            <?php foreach ($album['imagens'] as $imagem): ?>
                <img src="<?= $imagem['link'] ?>" alt="">
            <?php endforeach; ?>
        </div>

    </div>
</section>

</body>
</html>
