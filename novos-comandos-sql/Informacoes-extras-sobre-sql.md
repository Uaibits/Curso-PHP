#### Importe o arquivo base.sql para criar as tabelas e inserir os dados para realizar as consultas abaixo

Indice
1. [Consulta Onde Nosso Where é uma Outra Consulta](#consulta-onde-nosso-where-é-uma-outra-consulta)
2. [Consulta com Ordenação](#consulta-com-ordenaçao)
3. [Consulta com Soma de Valores e Campo que Não Existe na Tabela Sendo uma Nova Consulta](#consulta-com-soma-de-valores-e-campo-que-não-existe-na-tabela-sendo-uma-nova-consulta)
4. [Consulta com Contador de Dados](#consulta-com-contador-de-dados)
5. [Consulta Trazendo o Menor e Maior Valor de Transação Realizado](#consulta-trazendo-o-menor-e-maior-valor-de-transação-realizado)
6. [Consulta Trazendo o Menor Valor de Transação Realizado de uma Conta Especifica](#consulta-trazendo-o-menor-valor-de-transação-realizado-de-uma-conta-especifica)
7. [Consulta Trazendo o Menor Valor de Transação Realizado de Cada Cliente](#consulta-trazendo-o-menor-valor-de-transação-realizado-de-cada-cliente)


# CONSULTA ONDE NOSSO WHERE É UMA OUTRA CONSULTA
### Vamos buscar as movimentações de todos os clientes que contenha "Carlos" no nome

Observe que nosso **where** do nosso select tem uma outra consulta buscando somente o id do cliente
que contenha o nome Carlos, dessa forma conseguimos buscar as movimentações de um cliente
que tem o nome contendo Carlos sem precisar saber o id do cliente.  
> Importante, quando utilizamos um select em um where, nosso select deve retornar apenas um unico valor, no caso estamos utilizando o id

```sql
SELECT *
FROM movimentacao
WHERE id_conta = 1
```
```sql
SELECT *
FROM movimentacao
WHERE id_conta = (SELECT id FROM conta_bancaria WHERE nome LIKE '%carlos%')
```

# CONSULTA COM ORDENAÇAO
### Vamos buscar todas as movimentações ordenando pela data de movimentação
O order by é um comando muito importante, pois ele nos permite ordenar os resultados da nossa consulta
de acordo com um campo específico, também pode ser utilizado em textos, números, datas, etc
Em texto se comporta como ordem alfabética, em números como ordem crescente ou decrescente

>ASC = Crescente  
DESC = Decrescente


Como nosso campo `data_movimentacao` é do tipo `DATETIME`, ele irá ordenar pela data e hora
```sql
SELECT * FROM movimentacao ORDER BY data_movimentacao DESC
```

```sql
SELECT * FROM movimentacao ORDER BY data_movimentacao ASC
```

# CONSULTA COM SOMA DE VALORES E CAMPO QUE NÃO EXISTE NA TABELA SENDO UMA NOVA CONSULTA
Vamos buscar as movimentações de deposito dos clientes junto com a soma do valor de todas as movimentações
### Vamos analizar a consulta abaixo, pois temos alguns pontos interessantes

> `SUM(valor) AS soma_movimentacao` Aqui estamos somando todos os valores do campo **valor** da nossa consulta de movimentação

> O **AS** é utilizado para renomear o campo, ou seja, o campo que irá retornar na nossa busca

> **(SELECT nome FROM conta_bancaria WHERE id = id_conta) AS nome_cliente** Podemos realizar uma busca dando um nome de um campo que executa um outro select
Perceba que estamos buscando o `nome` do cliente que tem o id igual ao `id_conta` da movimentação
e estamos renomeando esse campo para nome_cliente
Utilize sempre os parenteses para garantir que o campo seja executado antes do select principal

> **GROUP BY id_conta** Este group by agrupa os resultados pelo `id_conta`, ou seja, só irá retornar **um unico registro** para cada `id_conta`  
Porém a `soma_movimentacao` irá somar todos os valores de movimentação de cada id_conta
```sql
SELECT id,
id_conta,
tipo AS tipo_movimentacao,

SUM(valor) AS soma_movimentacao, 
(SELECT nome FROM conta_bancaria WHERE id = id_conta) AS nome_cliente
FROM movimentacao
WHERE tipo = 'C'
GROUP BY id_conta
```

# CONSULTA COM CONTADOR DE DADOS
### Na consulta abaixo nós buscamos a quantidade de movimentações cada cliente fez
> O COUNT é um comando que nos permite contar a quantidade de registros de um campo

> O GROUP BY em nossa consulta é para que traga somente um registro para cada `id_conta` dessa forma cada linha da nossa consulta irá trazer o `id_conta` e a quantidade de movimentações que ele fez  
Se não tivermos o group by pelo `id_conta` a consulta irá fazer um COUNT de todos os registros da tabela movimentacao

```sql
SELECT id,
-- Não coloquei o AS para renomear o campo para q vc observe o que ocorre neste caso, mas poderia ser colocado
COUNT(id) -- as qtd_movimentacoes
FROM movimentacao GROUP BY id_conta
```

# CONSULTA TRAZENDO O MENOR E MAIOR VALOR DE TRANSAÇÃO REALIZADO

```sql
SELECT id,
id_conta,
MIN(valor) AS menor_valor_movimentacao
FROM movimentacao
```

```sql
SELECT id,
id_conta,
MAX(valor) AS maior_valor_movimentacao
FROM movimentacao
```

# CONSULTA TRAZENDO O MENOR VALOR DE TRANSAÇÃO REALIZADO DE UMA CONTA ESPECIFICA

```sql
SELECT id,
id_conta,
MIN(valor) AS menor_valor_movimentacao
FROM movimentacao
WHERE id_conta = 1
```

# CONSULTA TRAZENDO O MENOR VALOR DE TRANSAÇÃO REALIZADO DE CADA CLIENTE

```sql
SELECT id,
id_conta,
MIN(valor) AS menor_valor_movimentacao
FROM movimentacao
-- Aqui estamos agrupando os resultados pelo id_conta, ou seja, só irá retornar um unico registro para cada id_conta
GROUP BY id_conta
```



# CONSULTA BUSCANDO A MÉDIA DE TRANSAÇÕES DE CREDITO
```sql
SELECT id,
id_conta,
AVG(valor) AS media_valor_movimentacao
FROM movimentacao
WHERE tipo = 'C'
```

# CONSULTA BUSCANDO AS MOVIMENTAÇÕES DE 2 USUÁRIOS COM PELO ID
```sql
SELECT *
FROM movimentacao
-- Aqui estamos buscando as movimentações dos clientes com id_conta 1 e 2
-- Nosso in é um comando que nos permite buscar registros que tenham um valor específico em um campo
-- Seria como se vc informasse uma lista (array) de valores possíveis que aquele campo pode ter para atender
-- a condição do where
WHERE id_conta IN (1, 2)
```

# CONSULTA BUSCANDO MOVIMENTAÇÕES NO VALOR ENTRE 500 A 1000
```sql
SELECT *
FROM movimentacao
-- Aqui estamos buscando as movimentações que tenham o valor entre 500 e 1000
-- O BETWEEN é um comando que nos permite buscar registros que tenham um valor entre um intervalo
WHERE valor BETWEEN 500 AND 1000
```

```sql
-- Podemos também fazer entre datas
SELECT *
FROM movimentacao
-- Aqui estamos buscando as movimentações que tenham a data entre 2024-06-01 e 2024-06-05
WHERE data_movimentacao BETWEEN '2024-06-01' AND '2024-06-05'
```

## Leia para entender mais sobre

**GROUP BY** https://www.w3schools.com/sql/sql_orderby.asp  
**SUM** https://www.w3schools.com/sql/sql_sum.asp  
**COUNT** https://www.w3schools.com/sql/sql_count.asp  
**MIN** https://www.w3schools.com/sql/sql_min.asp  
**MAX** https://www.w3schools.com/sql/sql_max.asp  
**AVG** https://www.w3schools.com/sql/sql_avg.asp  
**IN** https://www.w3schools.com/sql/sql_in.asp  
**BETWEEN** https://www.w3schools.com/sql/sql_between.asp  