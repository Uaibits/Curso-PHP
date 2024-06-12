<?php
require_once __DIR__ . '/../components/NoticiasComponent.php';
require_once __DIR__ . '/../components/AuthComponent.php';

if (!verificaSeEstaLogado()) {
    header('Location: LoginView.php');
}

$usuario = pegarUsuarioLogado();

$todasNoticias = noticiasLista();
$noticias = $todasNoticias['noticias'];
$qtd_noticias = $todasNoticias['quantidade_noticias'];

//// Experimente descomentar o codigo abaixo
//print_r("<pre>");
//print_r($noticias);

?>

<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Noticias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>

<section class="noticias">
    <h1>Olá <?= $usuario['nome'] ?> Veja as noticias abaixo</h1>
    <a href="../controller/LogoutController.php">Sair</a>

    <hr>
    <form>
        <input class="input-filtro" name="filtro" placeholder="Buscar noticia pelo titulo" type="text"
               value="<?= isset($_GET['filtro']) ? $_GET['filtro'] : '' ?>">
    </form>
    <?php foreach ($noticias as $noticia): ?>

        <article class="noticia">
            <h1 class="noticia_titulo"><?= $noticia['titulo'] ?></h1>
            <p class="noticia_conteudo"><?= $noticia['texto_noticia'] ?></p>
            <div class="noticia_curtidas">

                <!-- Formulario POST para não ficar salvo no histórico do navegador  e não ser possivel acessar a rota via URL diretamente -->
                <form method="post" action="../controller/CurtirNoticiaController.php">
                    <!-- Input hidden para enviar o id da noticia que o usuario esta curtindo -->
                    <input type="hidden" name="noticia_id" value="<?= $noticia['id'] ?>">
                    <button>
                        <!-- Se o usuario ja curtiu a noticia, será adicionado a classe 'ja_curtiu' no icone -->
                        <i class="fa-regular fa-heart  <?= verificarSeUsuarioJaCurtiuNoticia($noticia['id'], $usuario['id']) == true ? 'ja_curtiu' : '' ?>"></i>
                    </button>
                    <span><?= $noticia['qtd_curtidas'] ?></span>

                    <ul class="noticia_curtidas_lista">
                        <h3>Curtidas</h3>
                        <?php foreach ($noticia['curtidas'] as $curtida): ?>
                            <li><?= $curtida['usuario']['nome'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </form>

            </div>
        </article>

    <?php endforeach; ?>
</section>

</body>
</html>
