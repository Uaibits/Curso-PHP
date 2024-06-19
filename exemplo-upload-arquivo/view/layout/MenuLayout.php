<?php
require_once __DIR__ . '/../../components/UtilsComponent.php';
?>

<nav class="menu-topo">

    <div class="menu-esquerda">
        <a href="<?= linkUrl() ?>">Home</a>
    </div>

    <div class="menu-direita">
        <?php if (verificaSeEstaLogado()): ?>
            <a href="<?= linkUrl('album/novo') ?>">Novo Album</a>
        <?php endif; ?>

        <?php if (verificaSeEstaLogado()): ?>
            <a href="<?= linkUrl('logout') ?>">Sair</a>
        <?php else: ?>
            <a href="<?= linkUrl('login') ?>">Login</a>
        <?php endif; ?>
    </div>
</nav>