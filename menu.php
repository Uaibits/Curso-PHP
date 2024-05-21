<?php
 // codigo php aqui
?>

<div class="menu">
    <?php for ($i = 0; $i < 5; $i++): ?>
        <div style="background: red; margin: 10px">
            menu <?= $i ?>
        </div>
    <?php endfor ?>
</div>