<?php
//Utilize os components para adicionar código que possam ser utilizados em vários controller
// Um controller não deve dar require em outro controller, caso tenha algum código que vc precise utilizar em mais
// de um controller, considere criar um component agrupando por funções de acordo com a necessidade
// Como por exemplo este component criado para dar print nos dados sem precisar ficar repetindo print_r

/**
 * @param $variavel
 * @param $titulo
 * OBS: se ficar confuso essa função, utilize print_r mesmo e ignore a existencia dela
 *
 * O objetivo dessa função é exibir o print_r de forma estilizada com background div e uma cor aleatória
 * Não se preocupe com essa função, ela foi criada apenas para facilitar vc encontrar o print_r e conseguir diferenciar um do outro
 */

function exibirPrintR($variavel, $titulo)
{
    // Isso irá gerar um codigo hex de cor aleatoria, por ex #0F1FF4
    $cor = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    echo "
        <div style='background: $cor'>
            <pre>
            <h1>------  INICIO PRINT $titulo ------ </h1>

    ";
        print_r($variavel);
    echo "  
            <h1>------  FIM PRINT $titulo ------ </h1>
            </pre>
        </div>
        ";
}