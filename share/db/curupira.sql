DROP DATABASE IF EXISTS CURUPIRA;
CREATE DATABASE CURUPIRA CHARACTER SET utf8 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT COLLATE utf8_unicode_ci;
DROP USER 'curupira'@'localhost';
DROP USER 'curupira'@'%';
CREATE USER 'curupira'@'localhost' IDENTIFIED BY '@t1r310P@uN0G@t0';
CREATE USER 'curupira'@'%' IDENTIFIED BY '@t1r310P@uN0G@t0';
GRANT ALL ON CURUPIRA.* TO 'curupira'@'localhost' WITH GRANT OPTION;

USE CURUPIRA;

CREATE TABLE Usuario (
	usuario_id INT UNSIGNED AUTO_INCREMENT,
	usuario VARCHAR (256) NOT NULL,
	senha VARCHAR (128) NOT NULL,
	PRIMARY KEY (usuario_id),
	UNIQUE (usuario)
) ENGINE = InnoDB;

CREATE TABLE Pessoa (
	pessoa_id INT UNSIGNED AUTO_INCREMENT,
	usuario_id INT UNSIGNED,
	nome VARCHAR (64) NOT NULL,
	numero_pessoa VARCHAR (16) NOT NULL,
	email VARCHAR (256) NOT NULL,
	data_nascimento DATETIME,
	genero CHAR(1),
	PRIMARY KEY (pessoa_id),
	INDEX (usuario_id),
	FOREIGN KEY (usuario_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Comissionado (
	comissionado_id INT UNSIGNED AUTO_INCREMENT,
	PRIMARY KEY (comissionado_id),
	FOREIGN KEY (comissionado_id) REFERENCES Pessoa (pessoa_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Produto (
	produto_id INT UNSIGNED AUTO_INCREMENT,
	produto VARCHAR (32) NOT NULL,
	preco FLOAT,
	comissao FLOAT,
	PRIMARY KEY (produto_id),
	UNIQUE (produto)
) ENGINE = InnoDB;

CREATE TABLE Conta (
	conta_id INT UNSIGNED AUTO_INCREMENT,
	conta VARCHAR (32) NOT NULL,
	PRIMARY KEY (conta_id),
	UNIQUE (conta)
) ENGINE = InnoDB;

CREATE TABLE UsuarioConta (
	usuario_conta_id INT UNSIGNED AUTO_INCREMENT,
	usuario_id INT UNSIGNED,
	conta_id INT UNSIGNED,
	PRIMARY KEY (usuario_conta_id),
	INDEX (usuario_id),
	INDEX (conta_id),
	FOREIGN KEY (usuario_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Sessao (
	sessao_id INT UNSIGNED AUTO_INCREMENT,
	usuario_id INT UNSIGNED,
	conta_id INT UNSIGNED,
	data_entrada DATETIME,
	data_saida DATETIME,
	saldo_entrada FLOAT,
	saldo_saida FLOAT,
	PRIMARY KEY (sessao_id),
	INDEX (usuario_id),
	INDEX (conta_id),
	FOREIGN KEY (usuario_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE TipoPagamento (
	tipo_pagamento_id INT UNSIGNED AUTO_INCREMENT,
	tipo_pagamento VARCHAR (32) NOT NULL,
	PRIMARY KEY (tipo_pagamento_id),
	UNIQUE (tipo_pagamento)
) ENGINE = InnoDB;

CREATE TABLE Venda (
	venda_id INT UNSIGNED AUTO_INCREMENT,
	usuario_id INT UNSIGNED,
	conta_id INT UNSIGNED,
	comissionado_id INT UNSIGNED,
	tipo_pagamento_id INT UNSIGNED,
	venda VARCHAR (256),
	data_venda DATETIME,
	valor_venda FLOAT,
	valor_recebido FLOAT,
	valor_troco FLOAT,
	PRIMARY KEY (venda_id),
	INDEX (usuario_id),
	INDEX (conta_id),
	INDEX (comissionado_id),
	FOREIGN KEY (usuario_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (comissionado_id) REFERENCES Comissionado (comissionado_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (tipo_pagamento_id) REFERENCES TipoPagamento (tipo_pagamento_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE VendaProduto (
	venda_produto_id INT UNSIGNED AUTO_INCREMENT,
	venda_id INT UNSIGNED,
	produto_id INT UNSIGNED,
	quantidade INT UNSIGNED,
	PRIMARY KEY (venda_produto_id),
	INDEX (venda_id),
	INDEX (produto_id),
	FOREIGN KEY (venda_id) REFERENCES Venda (venda_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (produto_id) REFERENCES Produto (produto_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Devolucao (
	devolucao_id INT UNSIGNED AUTO_INCREMENT,
	venda_id INT UNSIGNED,
	usuario_id INT UNSIGNED,
	conta_id INT UNSIGNED,
	motivo VARCHAR (256),
	data_devolucao DATETIME,
	PRIMARY KEY (devolucao_id),
	INDEX (venda_id),
	INDEX (usuario_id),
	INDEX (conta_id),
	FOREIGN KEY (venda_id) REFERENCES Venda (venda_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (usuario_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Cartao (
	cartao_id INT UNSIGNED AUTO_INCREMENT,
	codigo_barra VARCHAR(32),
        creditos INT UNSIGNED,
        venda_id INT UNSIGNED,
	PRIMARY KEY (cartao_id),
	INDEX (venda_id),
	FOREIGN KEY (venda_id) REFERENCES Venda (venda_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Catraca (
	catraca_id INT UNSIGNED AUTO_INCREMENT,
	identificador_sequencial INT UNSIGNED,
	descricao VARCHAR(64),
	mensagem_padrao VARCHAR(256) DEFAULT 'SEJA BEM VINDO',
	inativo TINYINT UNSIGNED DEFAULT (0),
	inner_catraca TINYINT UNSIGNED DEFAULT (1),
	usa_urna TINYINT UNSIGNED DEFAULT (0),
	usa_teclado TINYINT UNSIGNED DEFAULT (0),
	sentido_teclado TINYINT UNSIGNED DEFAULT (0),
	usa_leitor_1 TINYINT UNSIGNED DEFAULT (1),
	sentido_leitor_1 TINYINT UNSIGNED DEFAULT (0),
	acionamento_leitor_1 TINYINT UNSIGNED DEFAULT(0),
	usa_leitor_2 TINYINT UNSIGNED DEFAULT (0),
	sentido_leitor_2 TINYINT UNSIGNED DEFAULT (0),
	acionamento_leitor_2 TINYINT UNSIGNED DEFAULT (0),
	tempo_acao_rele_1 TINYINT UNSIGNED DEFAULT (1),
	tempo_acao_rele_2 TINYINT UNSIGNED DEFAULT (1),
	forma_entrada TINYINT UNSIGNED DEFAULT (7),
	tempo_entrada TINYINT UNSIGNED DEFAULT (5),
	catraca_acionamento TINYINT UNSIGNED DEFAULT (6),
	catraca_tempo_acionamento TINYINT UNSIGNED DEFAULT (5),
	catraca_sensor_giro_invertido TINYINT UNSIGNED DEFAULT (0),
	data_cadastro DATETIME DEFAULT (NOW()),
	PRIMARY KEY (catraca_id),
	INDEX (identificador_sequencial)
) ENGINE = InnoDB;

CREATE TABLE CartaoCatraca (
   cartao_catraca_id INT UNSIGNED AUTO_INCREMENT,
	cartao_id INT UNSIGNED,
   catraca_id INT UNSIGNED,
	data_acesso DATETIME,
	PRIMARY KEY (cartao_catraca_id),
	INDEX (cartao_id),
	INDEX (catraca_id),
	FOREIGN KEY (cartao_id) REFERENCES Cartao (cartao_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (catraca_id) REFERENCES Catraca (catraca_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE TipoDespesa (
	tipo_despesa_id INT UNSIGNED AUTO_INCREMENT,
	tipo_despesa VARCHAR (32) NOT NULL,
	PRIMARY KEY (tipo_despesa_id),
	UNIQUE (tipo_despesa)
) ENGINE = InnoDB;

CREATE TABLE Despesa (
	despesa_id INT UNSIGNED AUTO_INCREMENT,
	tipo_despesa_id INT UNSIGNED,
	usuario_id INT UNSIGNED,
	conta_id INT UNSIGNED,
	comissionado_id INT UNSIGNED,
	despesa VARCHAR (256),
	data_despesa DATETIME,
	valor FLOAT,
	PRIMARY KEY (despesa_id),
	INDEX (tipo_Despesa_id),
	INDEX (usuario_id),
	INDEX (conta_id),
	INDEX (comissionado_id),
	FOREIGN KEY (tipo_despesa_id) REFERENCES TipoDespesa (tipo_despesa_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (usuario_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (comissionado_id) REFERENCES Comissionado (comissionado_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Lancamento (
	lancamento_id INT UNSIGNED AUTO_INCREMENT,
	usuario_origem_id INT UNSIGNED,
	usuario_destino_id INT UNSIGNED,
	conta_destino_id INT UNSIGNED,
	data_lancamento DATETIME,
	valor FLOAT,
	PRIMARY KEY (lancamento_id),
	INDEX (usuario_origem_id),
	INDEX (usuario_destino_id),
	INDEX (conta_destino_id),
	FOREIGN KEY (usuario_origem_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (usuario_destino_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_destino_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Transferencia (
	transferencia_id INT UNSIGNED AUTO_INCREMENT,
	usuario_origem_id INT UNSIGNED,
	usuario_destino_id INT UNSIGNED,
	conta_origem_id INT UNSIGNED,
	conta_destino_id INT UNSIGNED,
	data_transferencia DATETIME,
	valor FLOAT,
	PRIMARY KEY (transferencia_id),
	INDEX (usuario_origem_id),
	INDEX (usuario_destino_id),
	INDEX (conta_origem_id),
	INDEX (conta_destino_id),
	FOREIGN KEY (usuario_origem_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (usuario_destino_id) REFERENCES Usuario (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_origem_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (conta_destino_id) REFERENCES Conta (conta_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO TipoDespesa (tipo_despesa) VALUES ('Comissão');
INSERT INTO TipoDespesa (tipo_despesa) VALUES ('Conta de Água');
INSERT INTO TipoDespesa (tipo_despesa) VALUES ('Conta de Energia Elétrica');
INSERT INTO TipoDespesa (tipo_despesa) VALUES ('Conta de internet');
INSERT INTO TipoDespesa (tipo_despesa) VALUES ('Manutenção');

INSERT INTO TipoPagamento (tipo_pagamento) VALUES ('Dinheiro');
INSERT INTO TipoPagamento (tipo_pagamento) VALUES ('Cartão de Crédito');
INSERT INTO TipoPagamento (tipo_pagamento) VALUES ('Cartão de Débito');

INSERT INTO Usuario (usuario, senha) VALUES ('root', SHA2(SHA2('pr0t3c@0', 512), 512));
INSERT INTO Usuario (usuario, senha) VALUES ('aleclemente@gmail.com', SHA2(SHA2('1234', 512), 512));
INSERT INTO Pessoa (usuario_id, nome, numero_pessoa, email) VALUES (2, 'Alexandre Clemente', '046.175.994-28', 'aleclemente@gmail.com');