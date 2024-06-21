CREATE
DATABASE testes_sql CHARACTER SET utf8 COLLATE utf8_general_ci;
USE
testes_sql;

CREATE TABLE conta_bancaria
(
    id    INT            NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cpf   VARCHAR(11)    NOT NULL UNIQUE,
    nome  VARCHAR(150)   NOT NULL,

    -- DECIMAL(10, 2) indica que o campo aceita até 10 números com 2 casas decimais
    -- Exemplo: 12345678.90
    -- Ou seja, o campo aceita até 8 números antes da vírgula e 2 números após a vírgula
    -- totalizando 10 números
    saldo DECIMAL(10, 2) NOT NULL
);

CREATE TABLE movimentacao
(
    id                INT            NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_conta          INT            NOT NULL,
    valor             DECIMAL(10, 2) NOT NULL,
    tipo              ENUM('C', 'D') NOT NULL,
    data_movimentacao DATETIME       NOT NULL,
    FOREIGN KEY (id_conta) REFERENCES conta_bancaria (id)
);


-- Inserindo dados na tabela conta_bancaria
INSERT INTO conta_bancaria (cpf, nome, saldo)
VALUES ('12345678901', 'Carlos', 1000.00);
INSERT INTO conta_bancaria (cpf, nome, saldo)
VALUES ('12345678902', 'Jhonny', 2000.00);
INSERT INTO conta_bancaria (cpf, nome, saldo)
VALUES ('12345678903', 'Adriana', 3000.00);
INSERT INTO conta_bancaria (cpf, nome, saldo)
VALUES ('12345678904', 'Fernanda', 4000.00);

-- Movimentações para a conta de Carlos (id_conta = 1)
INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (1, 500.00, 'C', '2024-06-01 10:00:00');

INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (1, -200.00, 'D', '2024-06-02 14:30:00');

INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (1, 1500.00, 'C', '2024-06-05 11:00:00');

INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (1, -500.00, 'D', '2024-06-06 12:30:00');

-- Movimentações para a conta de Jhonny (id_conta = 2)
INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (2, 1000.00, 'C', '2024-06-03 09:00:00');

INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (2, -300.00, 'D', '2024-06-04 16:45:00');

INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (2, 2000.00, 'C', '2024-06-07 13:00:00');

INSERT INTO movimentacao (id_conta, valor, tipo, data_movimentacao)
VALUES (2, -1000.00, 'D', '2024-06-08 15:30:00');


----------------- CONSULTA ONDE NOSSO WHERE É UMA OUTRA CONSULTA ----------------------
SELECT *
FROM movimentacao
WHERE id_conta = 1

-- Buscar as movimentações de todos os clientes que tem o nome contendo Carlos

-- Observe que nosso where do nosso select tem uma outra consulta buscando somente o id do cliente
-- que tem o nome contendo Carlos, dessa forma conseguimos buscar as movimentações de um cliente
-- que tem o nome contendo Carlos sem precisar saber o id do cliente
-- Importante, quando utilizamos um select em um where, nosso select deve retornar apenas um unico valor, no caso estamos utilizando o id
SELECT *
FROM movimentacao
WHERE id_conta = (SELECT id FROM conta_bancaria WHERE nome LIKE '%carlos%')


----------------- CONSULTA COM ORDENAÇAO ----------------------

-- Buscar todas as movimentações ordenadas pela data de movimentação
-- ASC = Crescente
-- DESC = Decrescente
-- Como nosso campo data_movimentacao é do tipo DATETIME, ele irá ordenar pela data e hora
-- O order by é um comando muito importante, pois ele nos permite ordenar os resultados da nossa consulta
-- de acordo com um campo específico, também pode ser utilizado em textos, números, datas, etc
-- Em texto se comporta como ordem alfabética, em números como ordem crescente ou decrescente
SELECT * FROM movimentacao ORDER BY data_movimentacao DESC
SELECT * FROM movimentacao ORDER BY data_movimentacao ASC


----------------- CONSULTA COM SOMA DE VALORES E CAMPO QUE NÃO EXISTE NA TABELA SENDO UMA NOVA CONSULTA ----------------------

-- Buscar todas as movimentações de deposito dos clientes junto com a soma de todas as movimentações
-- Vamos analizar a consulta abaixo, pois temos alguns pontos interessantes
SELECT id,
        id_conta,
        tipo AS tipo_movimentacao,
       -- Aqui estamos somando todos os valores do campo 'valor' da nossa consulta de movimentação
       -- O "AS" é utilizado para renomear o campo, ou seja, o campo que irá retornar na nossa busca
        SUM(valor) AS soma_movimentacao,

       -- Podemos criar um campo que irá retornar na nossa busca onde esse campo executa um outro select
       -- Perceba que estamos buscando o nome do cliente que tem o id igual ao id_conta da movimentação
       -- e estamos renomeando esse campo para nome_cliente
       -- Utilize sempre os parenteses para garantir que o campo seja executado antes do select principal
       (SELECT nome FROM conta_bancaria WHERE id = id_conta) AS nome_cliente
FROM movimentacao
WHERE tipo = 'C'

-- Este group by agrupa os resultados pelo id_conta, ou seja, só irá retornar um unico registro para cada id_conta
-- Porém a soma_movimentacao irá somar todos os valores de movimentação de cada id_conta
GROUP BY id_conta



----------------- CONSULTA COM CONTADOR DE DADOS ----------------------
SELECT id,
       -- Não coloquei o AS para renomear o campo para q vc observe o que ocorre neste caso, mas poderia ser colocado
       COUNT(id) -- as qtd_movimentacoes
        FROM movimentacao GROUP BY id_conta
-- A consulta acima nós buscamos a quantidade de movimentações cada cliente fez
-- O COUNT é um comando que nos permite contar a quantidade de registros de um campo
-- O GROUP BY em nossa consulta é para que traga somente um registro para cada id_conta
-- dessa forma cada linha da nossa consulta irá trazer o id_conta e a quantidade de movimentações que ele fez
-- Se não tivermos o group by pelo id_conta a consulta irá fazer um COUNT de todos os registros da tabela movimentacao


----------------- CONSULTA TRAZENDO O MENOR E MAIOR VALOR DE TRANSAÇÃO REALIZADO ----------------------
SELECT id,
       id_conta,
       MIN(valor) AS menor_valor_movimentacao
FROM movimentacao

SELECT id,
       id_conta,
       MAX(valor) AS maior_valor_movimentacao
FROM movimentacao

----------------- CONSULTA TRAZENDO O MENOR VALOR DE TRANSAÇÃO REALIZADO DE UMA CONTA ESPECIFICA ----------------------
SELECT id,
       id_conta,
       MIN(valor) AS menor_valor_movimentacao
FROM movimentacao
WHERE id_conta = 1


----------------- CONSULTA TRAZENDO O MENOR VALOR DE TRANSAÇÃO REALIZADO DE CADA CLIENTE ----------------------
SELECT id,
       id_conta,
       MIN(valor) AS menor_valor_movimentacao
FROM movimentacao
-- Aqui estamos agrupando os resultados pelo id_conta, ou seja, só irá retornar um unico registro para cada id_conta
GROUP BY id_conta


----------------- CONSULTA BUSCANDO A MÉDIA DE TRANSAÇÕES DE CREDITO ----------------------
SELECT id,
       id_conta,
       AVG(valor) AS media_valor_movimentacao
FROM movimentacao
WHERE tipo = 'C'


----------------- CONSULTA BUSCANDO AS MOVIMENTAÇÕES DE 2 USUÁRIOS COM PELO ID ----------------------
SELECT *
FROM movimentacao
-- Aqui estamos buscando as movimentações dos clientes com id_conta 1 e 2
-- Nosso in é um comando que nos permite buscar registros que tenham um valor específico em um campo
-- Seria como se vc informasse uma lista (array) de valores possíveis que aquele campo pode ter para atender
-- a condição do where
WHERE id_conta IN (1, 2)


----------------- CONSULTA BUSCANDO MOVIMENTAÇÕES NO VALOR ENTRE 500 A 1000 ----------------------
SELECT *
FROM movimentacao
-- Aqui estamos buscando as movimentações que tenham o valor entre 500 e 1000
-- O BETWEEN é um comando que nos permite buscar registros que tenham um valor entre um intervalo
WHERE valor BETWEEN 500 AND 1000

-- Podemos também fazer entre datas
SELECT *
FROM movimentacao
-- Aqui estamos buscando as movimentações que tenham a data entre 2024-06-01 e 2024-06-05
WHERE data_movimentacao BETWEEN '2024-06-01' AND '2024-06-05'


-- Leia para entender mais sobre

-- GROUP BY https://www.w3schools.com/sql/sql_orderby.asp
-- SUM https://www.w3schools.com/sql/sql_sum.asp
-- COUNT https://www.w3schools.com/sql/sql_count.asp
-- MIN https://www.w3schools.com/sql/sql_min.asp
-- MAX https://www.w3schools.com/sql/sql_max.asp
-- AVG https://www.w3schools.com/sql/sql_avg.asp
-- IN https://www.w3schools.com/sql/sql_in.asp
-- BETWEEN https://www.w3schools.com/sql/sql_between.asp