DROP DATABASE IF EXISTS kantovitz_garage;
CREATE DATABASE kantovitz_garage;
USE kantovitz_garage;

CREATE TABLE cliente (
    codcli INT AUTO_INCREMENT PRIMARY KEY,
    nome   VARCHAR(100) NOT NULL,
    email  VARCHAR(100) NOT NULL UNIQUE,
    senha  VARCHAR(255) NOT NULL
);

CREATE TABLE produto (
    codprod   INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    preco     DECIMAL(10,2) NOT NULL,
    imagem    VARCHAR(150)
);

CREATE TABLE pedido (
    codped     INT AUTO_INCREMENT PRIMARY KEY,
    data       DATETIME NOT NULL,
    codcliente INT NOT NULL,
    FOREIGN KEY (codcliente) REFERENCES cliente(codcli)
);

CREATE TABLE detalhes (
    codped     INT NOT NULL,
    codprod    INT NOT NULL,
    qtde       INT NOT NULL,
    precovenda DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (codped, codprod),
    FOREIGN KEY (codped)  REFERENCES pedido(codped),
    FOREIGN KEY (codprod) REFERENCES produto(codprod)
);

INSERT INTO produto (nome, descricao, preco, imagem) VALUES
('Kit Turbo T3/T4',   'Kit para projetos de rua ou pista.', 2499.90, 'IMAGENS/kit_turbo.jpg'),
('Suspensão a Rosca', 'Kit para ajuste de altura.',         1189.90, 'IMAGENS/suspensao_rosca.jpg'),
('Filtro Esportivo',  'Maior fluxo de ar.',                  149.90, 'IMAGENS/filtro_ar.jpg'),
('Kit de Freios',     'Mais segurança e desempenho.',       5890.00, 'IMAGENS/freios.jpg'),
('Intercooler',       'Melhor controle da temperatura.',    1349.90, 'IMAGENS/intercooler.jpg'),
('Remap Stage 1',     'Reprogramação da central para mais potência.', 1200.00, 'IMAGENS/remap.svg'),
('Bomba de Combustível', 'Bomba 340 LPH para alta vazão.',   450.00, 'IMAGENS/bomba.jpg');
