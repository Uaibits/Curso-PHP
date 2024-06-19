<?php

define('DOMINIO', 'http://php.test/exemplo-upload-arquivo');

// Essa função foi criada para facilitar o redirecionamento não sendo necessário ficar voltando muitas pastas usando ../
function redirecionar($rota = '')
{
    header("Location: " . DOMINIO . "/$rota");
}

// Essa função foi criado para facilitar o uso do link de css, não sendo necessário ficar voltando muitas pastas usando ../
// Isso facilita devido aos erros que o .htaccess pode causar
function cssUrl($arquivo = '')
{
    return DOMINIO . "/assets/css/$arquivo";
}

function linkUrl($url = '')
{
    return DOMINIO . "/$url";
}

function jsUrl($arquivo = '')
{
    return DOMINIO . "/assets/js/$arquivo";
}

function urlBase($diretorio)
{
    return DOMINIO . "/$diretorio";
}

function gerarSlug($string)
{
    // substituir espaços por hífen
    $slug = str_replace(' ', '-', $string);
    // remover caracteres especiais, ficando apenas letras de A-Z e números de 0-9 e -
    // o sinal ^ dentro dos colchetes significa negação
    // A-Z: letras de A a Z
    // a-z: letras de a a z
    // 0-9: números de 0 a 9
    // -: hífen
    // ou seja, essa função irá dar replace em tudo que não for letras de A-Z, a-z, números de 0-9 e hífen por nada
    // preg_replace ao invés de str_replace para poder usar REGEX
    // o / no início e no final da expressão regular é o delimitador
    // [^A-Za-z0-9-]: é um regex que pega tudo que não for letras de A-Z, a-z, números de 0-9 e hífen
    // se remover o ^ ele irá pegar tudo que for letras de A-Z, a-z, números de 0-9 e hífen
    $slug = preg_replace('/^[A-Za-z0-9-]/', '', $slug);
    return strtolower($slug);
}