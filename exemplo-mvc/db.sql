-- Isso é um comentário no SQL
-- Você pode copiar todo o sql e jogar ele diretamente no SQL do phpmyadmin, não precisa selecionar base de dados pq abaixo
-- criamos uma base de dados de forma automática via código

-- Criando uma DATABASE (base de dados) de forma automática
-- Caso ja tenha criado a base de dados manual ignore essa linha e a linha do USE site_jornal;
CREATE DATABASE site_jornal CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Informando ao SQL que os CREATE TABLE abaixo vão ser inserido no database site_jornal criada acima
USE site_jornal;

CREATE TABLE usuarios
(
    id    INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome  VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha VARCHAR(33)  NOT NULL
);

CREATE TABLE noticias
(
    id            INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo        VARCHAR(150) NOT NULL,
    texto_noticia TEXT         NOT NULL
);

-- Esta tabela é uma tabela apenas de ligação, ou seja que liga uma curtida a um usuario
-- É importante entender o conceito de ligação, pois ele é muito utilizado
-- Por exemplo, um usuário pode curtir várias noticias e uma noticia tem várias curtidas de vários usuários
CREATE TABLE noticias_curtidas
(
    id         INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_noticia INT NOT NULL
);

-- A senha do usuário é 123
INSERT INTO usuarios (nome, email, senha) VALUES ('Carlos', 'carlos@mail.com', '202cb962ac59075b964b07152d234b70');
INSERT INTO usuarios (nome, email, senha)
VALUES ('Jhonny', 'jhonny@mail.com', '202cb962ac59075b964b07152d234b70');
INSERT INTO usuarios (nome, email, senha)
VALUES ('Adriana', 'adriana@mail.com', '202cb962ac59075b964b07152d234b70');
INSERT INTO usuarios (nome, email, senha)
VALUES ('Fernanda', 'fernanda@mail.com', '202cb962ac59075b964b07152d234b70');

INSERT INTO noticias (titulo, texto_noticia)
VALUES ("Prefeitura dorense e seus trabalhos realizados recentemente",
        "A Prefeitura Municipal de Dores do Turvo vem trabalhando com afinco nas diversas áreas da administração pública e nos últimos dias realizou atuações nos diversos setores.");

INSERT INTO noticias (titulo, texto_noticia)
VALUES ("Temperatura volta a subir a partir desta terça-feira na região",
        "A massa de ar quente que atua no estado de Minas Gerais há mais de 30 dias continua com força na região. Nesta semana, as temperaturas podem atingir os 38 ºC.");

INSERT INTO noticias (titulo, texto_noticia)
VALUES ("Está chegando o dia da apresentação de Eduardo Costa, em Presidente Bernardes",
        "É pessoal, o Eduardo Costa pode até não ter pressa, mas em Presidente Bernardes todos estão cheios de pressa pra esse Festão chegar logo.
    Faltam pouco mais de 40 dias para a Festa da Cana 2024, em Presidente Bernardes e Eduardo Costa fará um grande show. Aguardem a programação da Festa da Cana 2024, em Presidente Bernardes.");


INSERT INTO noticias_curtidas (id_noticia, id_usuario) VALUES (1, 1);
INSERT INTO noticias_curtidas (id_noticia, id_usuario) VALUES (1, 2);

