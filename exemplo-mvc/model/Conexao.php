<?php

function conexao()
{
    $mysqli = new mysqli('localhost', 'root', '', 'site_jornal');
    // Esta linha é importante pq ela faz com que funcione os caracteres com acento como por exemplo
    // é ç à â....
    // sem ele os caracteres com acento será exibidos como o caracter �
    $mysqli->set_charset("utf8mb4");
    return $mysqli;
}