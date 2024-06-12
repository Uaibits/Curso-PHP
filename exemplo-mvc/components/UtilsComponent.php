<?php

// Essa função foi criada para facilitar o redirecionamento não sendo necessário ficar voltando muitas pastas usando ../
function redirecionar($rota = '')
{
    // Mude o valor da variável $dominio para o domínio do seu projeto
    $dominio = "http://php.test/exemplo-mvc";
    header("Location: $dominio/$rota");
}