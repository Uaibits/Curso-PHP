<?php
$tituloSite = "PetShop";
$lista = [
    [
        "nome" => "Rex",
        "raca" => "Dálmata",
        "idade" => 3,
        "sexo" => "Macho",
        "dono" => "João",
        "preco" => 10,
        "preco_com_desconto" => 5
    ],
    [
        "nome" => "Totó",
        "raca" => "Pastor Alemão",
        "idade" => 2,
        "sexo" => "Macho",
        "dono" => "Maria",
        "preco" => 22,
        "preco_com_desconto" => 10
    ],
    [
        "nome" => "Rex",
        "raca" => "Poodle",
        "idade" => 4,
        "sexo" => "Macho",
        "dono" => "José",
        "preco" => 10,
        "preco_com_desconto" => null,
    ]
];

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $tituloSite ?></title>
</head>
<body>

<!-- Exemplo de importação de código de outro arquivo.
Ou seja, você pode repartir seu html em vários arquivos
e importar para ser exibido tudo dentro da mesma página no navegador -->
<?php require 'menu.php' ?>

<div>
    <!--
        Para misturar códigos PHP com HTML
        lembre-se sempre de abrir a tag php e fechar <?php ?>
        Caso não deseje criar um if no html da forma abaixo
        -->
    <?php //if ($condicao == true) { ?>

    <?php // } ?>

    pode optar pelo segundo formato colocando ":" que representa a chave abrindo "{"
    e encerrar usando "endif" end alguma coisa que representa a chave sendo fechada "}"
    <?php // if ($condicao == true): ?>

    <?php // endif; ?>
    <!-- não esqueça do ; -->

    <!-- exemplo de foreach -->
    <?php foreach ($lista as $pet): ?>
        <?php if ($pet['sexo'] == "Macho"): ?>
            <div>
                <h2><?php echo $pet["nome"] ?></h2>
                <p>Raça: <?= $pet["raca"] ?></p>
                <p>Idade: <?= $pet["idade"] ?></p>
                <p>Sexo: <?= $pet["sexo"] ?></p>
                <p>Dono: <?= $pet["dono"] ?></p>
                <p>Preço: <?= $pet["preco_com_desconto"] != null ? $pet["preco_com_desconto"] : $pet["preco"]  ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php require 'rodape.php' ?>

</body>
</html>
