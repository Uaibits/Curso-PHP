<?php

function connection()
{
    return new mysqli('localhost', 'root', '', 'hotel');
}

function getAllClientes()
{
    $connection = connection();
    $select = $connection->query("SELECT * FROM cliente");
    // Lembre-se, fetch_all se utiliza sempre que precisar buscar mais de 1 dado na tabela,
    // por exemplo endereços de um usuáro
    // MYSQLI_ASSOC é importante para que nosso array seja associativo, ou seja as keys dele
    // tenham o mesmo nome das colunas
    return $select->fetch_all(MYSQLI_ASSOC);
}

function getClientById($id)
{
    $connection = connection();
        $select = $connection->query("SELECT * FROM cliente WHERE id = $id");
    // fetch_assoc é recomendado utilizar quando é necessário trazer somente um único dado
    return $select->fetch_assoc();
}

function updateClientById($clientID, $name)
{
    $connection = connection();
    $connection->query("UPDATE cliente SET nome = '$name' WHERE id = $clientID");
}

function deleteClientById($clientID)
{
    $connection = connection();
    $connection->query("DELETE FROM cliente WHERE id = $clientID");
}

// Buscando todos os clientes
$clientes = getAllClientes();
print_r($clientes);

print_r("------------------\n");

// Buscando somente o cliente de ID 1
$cliente = getClientById(1);
print_r($cliente);

// Atualizando um cliente
updateClientById(1, "Carlos");

// Buscando somente o cliente de ID 1
$cliente = getClientById(1);
print_r($cliente);