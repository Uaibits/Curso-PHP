CREATE DATABASE galeria_fotos CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Informando ao SQL que os CREATE TABLE abaixo vão ser inserido no database site_jornal criada acima
USE galeria_fotos;


CREATE TABLE IF NOT EXISTS usuarios
(
    id         INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome       VARCHAR(255) NOT NULL,
    username   VARCHAR(255) NOT NULL UNIQUE,
    email      VARCHAR(255) NOT NULL UNIQUE,
    senha      VARCHAR(33)  NOT NULL,

    -- Vamos criar 3 novos campos para termos melhor controle do dos dados

    -- created_at será preenchido automaticamente ao criar um novo dado com a data e hora atual

    -- updated_at iremos atualizar sempre que realizarmos um update table

    -- deleted_at iremos utilizar ao invés de deletar de fato o dado para que possamos ter ele salvo
    -- caso tenha sido deletado por acidente seja possível recuperá-lo
    -- essa estratégia chama-se ("softdelete") ela é opcional, mas bem interessante de se utilizar
    -- principalmente em casos onde podem ocorrer deleções acidentais
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    deleted_at DATETIME
);

CREATE TABLE IF NOT EXISTS usuarios_albuns
(
    id         INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT          NOT NULL,
    nome_album VARCHAR(255) NOT NULL,
    privado    BOOLEAN  default true,
    -- slug geralmente utilizamos para criar urls amigáveis, ou seja, ao invés de passar um id na url
    -- passamos um slug que é mais amigável para o usuário, por exemplo:
    -- www.site.com/album/1
    -- www.site.com/album/album-do-carlos
    -- o slug geralmente é gerado a partir do nome do album sem espaços e com traços
    slug       VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    deleted_at DATETIME,

    FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
);

CREATE TABLE IF NOT EXISTS albuns_images
(
    id         INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_album   INT          NOT NULL,
    imagem     VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    deleted_at DATETIME,

    -- Aqui iremos utilizar uma nova funcionalidade da FOREING key o "ON DELETE CASCADE"
    -- essa propriedade informa a essa tabela 'albuns_images' que caso ocorra uma deleção
    -- na tabela 'usuarios_albuns' todas as linhas de albuns_images que tenha o id_album igual ao id de usuarios_albuns
    -- também será deletado
    -- Ou seja, caso um usuário delete um album todas as imagens deste album também serão deletadas automaticamente
    FOREIGN KEY (id_album) REFERENCES usuarios_albuns (id) ON DELETE CASCADE

);

-- A senha do usuário é 123
INSERT INTO usuarios (nome, email, username, senha)
VALUES ('Carlos', 'carlos@mail.com', 'EduardoMGP', '202cb962ac59075b964b07152d234b70');
INSERT INTO usuarios (nome, email, username, senha)
VALUES ('Jhonny', 'jhonny@mail.com', 'JhonnyASoares', '202cb962ac59075b964b07152d234b70');
INSERT INTO usuarios (nome, email, username, senha)
VALUES ('Adriana', 'adriana@mail.com', 'AdrianaOl', '202cb962ac59075b964b07152d234b70');
INSERT INTO usuarios (nome, email, username, senha)
VALUES ('Fernanda', 'fernanda@mail.com', 'Fe', '202cb962ac59075b964b07152d234b70');


INSERT INTO `usuarios_albuns` (`id`, `id_usuario`, `nome_album`, `slug`, `privado`, `created_at`, `updated_at`,
                               `deleted_at`)
VALUES (1, 1, 'One Piece', 'one-piece', 0, '2024-06-19 01:28:39', NULL, NULL),
       (2, 1, 'Boku no Hero', 'boku-no-hero', 0, '2024-06-19 01:44:25', NULL, NULL),
       (3, 2, 'sgds', 'sgds', 0, '2024-06-19 01:50:57', NULL, '2024-06-19 01:57:23'),
       (4, 2, 'Bleach', 'bleach', 0, '2024-06-19 01:52:25', NULL, NULL),
       (5, 2, 'Viagem para Argentina', 'viagem-para-argentina', 1, '2024-06-19 01:55:00', NULL, NULL);

INSERT INTO `albuns_images` (`id`, `id_album`, `imagem`, `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 1, '66725e77c890a.gif', '2024-06-19 01:28:39', NULL, NULL),
       (2, 1, '66725e77ce512.jpg', '2024-06-19 01:28:39', NULL, NULL),
       (3, 1, '66725e77cf0cb.jpg', '2024-06-19 01:28:39', NULL, NULL),
       (4, 1, '66725e77cfd69.jpg', '2024-06-19 01:28:39', NULL, NULL),
       (5, 1, '66725e77d092a.gif', '2024-06-19 01:28:39', NULL, NULL),
       (6, 2, '66726229b5302.gif', '2024-06-19 01:44:25', NULL, NULL),
       (7, 2, '66726229b5fc9.jpg', '2024-06-19 01:44:25', NULL, NULL),
       (8, 2, '66726229b64f7.jpg', '2024-06-19 01:44:25', NULL, NULL),
       (9, 4, '6672640a51d2d.jpg', '2024-06-19 01:52:26', NULL, NULL),
       (10, 4, '6672640a53404.jpg', '2024-06-19 01:52:26', NULL, NULL),
       (11, 4, '6672640a53f92.jpg', '2024-06-19 01:52:26', NULL, NULL),
       (12, 5, '667264a48f5cc.jpg', '2024-06-19 01:55:00', NULL, NULL),
       (13, 5, '667264a48ff77.png', '2024-06-19 01:55:00', NULL, NULL),
       (14, 5, '667264a4909ef.jpeg', '2024-06-19 01:55:00', NULL, NULL);
