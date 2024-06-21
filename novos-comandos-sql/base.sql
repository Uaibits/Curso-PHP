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