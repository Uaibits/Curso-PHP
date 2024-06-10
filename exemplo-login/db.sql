CREATE TABLE usuario
(
    id    INT                 NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(250) UNIQUE NOT NULL,
    senha VARCHAR(33)         NOT NULL,
    nome  VARCHAR(150)        NOT NULL
);

CREATE TABLE endereco
(
    id          INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario  INT          NOT NULL,
    rua         VARCHAR(250) NOT NULL,
    numero      VARCHAR(250),
    bairro      VARCHAR(250) NOT NULL,
    cidade      VARCHAR(250) NOT NULL,
    estado      CHAR(2)      NOT NULL,
    complemento VARCHAR(250),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id)
)