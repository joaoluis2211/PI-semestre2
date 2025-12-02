create database eleja;

use eleja;

create table turma(
idturma int primary key auto_increment not null,
semestre int not null,
curso varchar(60) not null
);

create table aluno(
idaluno int primary key auto_increment not null,
nome varchar(120) not null,
idturma int not null,
ra int not null,
constraint fk_turma_aluno foreign key (idturma) references turma (idturma)
);

create table usuario(
idusuario int primary key auto_increment not null,
email varchar(120) not null,
senha varchar(60) not null,
tipo enum("aluno", "administrador"),
idaluno int null,
constraint fk_aluno_usuario foreign key (idaluno) references aluno (idaluno)
);

create table eleicao(
ideleicao int primary key auto_increment not null,
dataInicioCandidatura date not null,
dataFimCandidatura date not null,
dataInicioVotacao date not null,
dataFimVotacao date not null,
idturma int not null,
status varchar(60) not null,
constraint fk_turma_eleicao foreign key (idturma) references turma (idturma)
);

create table candidato(
idcandidato int primary key auto_increment not null,
idaluno int not null,
ideleicao int not null,
qtdVotos int not null,
constraint fk_aluno_candidato foreign key (idaluno) references aluno (idaluno),
constraint fk_eleicao_candidato foreign key (ideleicao) references eleicao (ideleicao)
);

create table ata(
idata int primary key auto_increment not null,
representante varchar(60) not null,
vice varchar(60) not null,
ideleicao int not null,
idturma int not null,
data date not null,
constraint fk_turma_ata foreign key (idturma) references turma (idturma),
constraint fk_eleicao_ata foreign key (ideleicao) references eleicao (ideleicao)
);

create table voto(
idvoto int primary key auto_increment not null,
idaluno int not null,
idcandidato int null,
ideleicao int not null,
constraint fk_aluno_voto foreign key (idaluno) references aluno (idaluno),
constraint fk_eleicao_voto foreign key (ideleicao) references eleicao (ideleicao),
constraint fk_candidato_voto foreign key (idcandidato) references candidato (idcandidato)
);

INSERT INTO usuario (email, senha, tipo) values ('elejaadmin@fatec.sp.gov.br', '123456', 'administrador');

INSERT INTO turma (semestre, curso) values ('1', 'Desenvolvimento de Software Multiplataforma');
INSERT INTO turma (semestre, curso) values ('2', 'Desenvolvimento de Software Multiplataforma');
INSERT INTO turma (semestre, curso) values ('3', 'Desenvolvimento de Software Multiplataforma');
INSERT INTO turma (semestre, curso) values ('4', 'Desenvolvimento de Software Multiplataforma');
INSERT INTO turma (semestre, curso) values ('5', 'Desenvolvimento de Software Multiplataforma');
INSERT INTO turma (semestre, curso) values ('6', 'Desenvolvimento de Software Multiplataforma');

INSERT INTO turma (semestre, curso) values ('1', 'Gestão de Produção Industrial');
INSERT INTO turma (semestre, curso) values ('2', 'Gestão de Produção Industrial');
INSERT INTO turma (semestre, curso) values ('3', 'Gestão de Produção Industrial');
INSERT INTO turma (semestre, curso) values ('4', 'Gestão de Produção Industrial');
INSERT INTO turma (semestre, curso) values ('5', 'Gestão de Produção Industrial');
INSERT INTO turma (semestre, curso) values ('6', 'Gestão de Produção Industrial');

INSERT INTO turma (semestre, curso) values ('1', 'Gestão Empresarial');
INSERT INTO turma (semestre, curso) values ('2', 'Gestão Empresarial');
INSERT INTO turma (semestre, curso) values ('3', 'Gestão Empresarial');
INSERT INTO turma (semestre, curso) values ('4', 'Gestão Empresarial');
INSERT INTO turma (semestre, curso) values ('5', 'Gestão Empresarial');
INSERT INTO turma (semestre, curso) values ('6', 'Gestão Empresarial');


INSERT INTO aluno (nome, idturma, ra) values ('Paulo Lopes', '2', '25846321');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('paulo.lopes@fatec.sp.gov.br', '123456', 'aluno', 1);

INSERT INTO aluno (nome, idturma, ra) values ('Andre Silva', '2', '25846322');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('andre.silva@fatec.sp.gov.br', '123456', 'aluno', 2);

INSERT INTO aluno (nome, idturma, ra) values ('Pedro Lima', '2', '25846323');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('pedro.lima@fatec.sp.gov.br', '123456', 'aluno', 3);

INSERT INTO aluno (nome, idturma, ra) values ('Jessica Lopes', '2', '25846324');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('jessica.lopes@fatec.sp.gov.br', '123456', 'aluno', 4);

INSERT INTO aluno (nome, idturma, ra) values ('Andressa Fagundes', '2', '25846325');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('andressa.fagundes@fatec.sp.gov.br', '123456', 'aluno', 5);

INSERT INTO aluno (nome, idturma, ra) values ('Amanda Lopes', '2', '25846326');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('amanda.lopes@fatec.sp.gov.br', '123456', 'aluno', 6);

INSERT INTO aluno (nome, idturma, ra) values ('Lucas Silva', '2', '25846327');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('lucas.silva@fatec.sp.gov.br', '123456', 'aluno', 7);

INSERT INTO aluno (nome, idturma, ra) values ('Carlos Ferreira', '2', '25846328');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('carlos.ferreira@fatec.sp.gov.br', '123456', 'aluno', 8);

INSERT INTO aluno (nome, idturma, ra) values ('Leandro Silva', '2', '25846329');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('leandro.silva@fatec.sp.gov.br', '123456', 'aluno', 9);

INSERT INTO aluno (nome, idturma, ra) values ('Jenifer Lopes', '2', '25846330');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('jenifer.lopes@fatec.sp.gov.br', '123456', 'aluno', 10);

insert into eleicao (dataInicioCandidatura, dataFimCandidatura, dataInicioVotacao, dataFimVotacao, idturma, status) values ('2025-11-11', '2025-11-20', '2025-12-01', '2025-12-20', 2, 'VOTACAO');

insert into candidato (idaluno, ideleicao, qtdVotos) values (1, 1, 0);
insert into candidato (idaluno, ideleicao, qtdVotos) values (2, 1, 2);
insert into candidato (idaluno, ideleicao, qtdVotos) values (3, 1, 7);


insert into voto (idaluno, idcandidato, ideleicao) values (2, 2, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (3, 2, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (4, 3, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (5, 3, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (6, 3, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (7, 3, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (8, 3, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (9, 3, 1);
insert into voto (idaluno, idcandidato, ideleicao) values (10, 3, 1);


INSERT INTO aluno (nome, idturma, ra) values ('Paulo Silva', '3', '12547864');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('paulo.silva@fatec.sp.gov.br', '123456', 'aluno', 11);

INSERT INTO aluno (nome, idturma, ra) values ('Andre Lopes', '3', '12478532');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('andre.lopes@fatec.sp.gov.br', '123456', 'aluno', 12);

INSERT INTO aluno (nome, idturma, ra) values ('Pedro Ferreira', '3', '54698521');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('pedro.ferreira@fatec.sp.gov.br', '123456', 'aluno', 13);

INSERT INTO aluno (nome, idturma, ra) values ('Jessica Silva', '3', '25463215');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('jessica.silva@fatec.sp.gov.br', '123456', 'aluno', 14);

INSERT INTO aluno (nome, idturma, ra) values ('Andressa Lopes', '3', '25487691');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('andressa.lopes@fatec.sp.gov.br', '123456', 'aluno', 15);

INSERT INTO aluno (nome, idturma, ra) values ('Amanda Lima', '3', '12458691');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('amanda.lima@fatec.sp.gov.br', '123456', 'aluno', 16);

INSERT INTO aluno (nome, idturma, ra) values ('Lucas Ferreira', '3', '36589214');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('lucas.ferreira@fatec.sp.gov.br', '123456', 'aluno', 17);

INSERT INTO aluno (nome, idturma, ra) values ('Carlos Oliveira', '3', '15487962');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('carlos.oliveira@fatec.sp.gov.br', '123456', 'aluno', 18);

INSERT INTO aluno (nome, idturma, ra) values ('Leandro Oliveira', '3', '65894587');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('leandro.oliveira@fatec.sp.gov.br', '123456', 'aluno', 19);

INSERT INTO aluno (nome, idturma, ra) values ('Jenifer Silva', '3', '14785963');
INSERT INTO usuario (email, senha, tipo, idaluno) values ('jenifer.silva@fatec.sp.gov.br', '123456', 'aluno', 20);

insert into eleicao (dataInicioCandidatura, dataFimCandidatura, dataInicioVotacao, dataFimVotacao, idturma, status) values ('2025-11-11', '2025-11-20', '2025-11-25', '2025-12-01', 3, 'ENCERRADA');

insert into candidato (idaluno, ideleicao, qtdVotos) values (11, 2, 5);
insert into candidato (idaluno, ideleicao, qtdVotos) values (12, 2, 3);
insert into candidato (idaluno, ideleicao, qtdVotos) values (13, 2, 2);


insert into voto (idaluno, idcandidato, ideleicao) values (11, 4, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (12, 4, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (13, 4, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (14, 4, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (15, 4, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (16, 5, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (17, 5, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (18, 5, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (19, 6, 2);
insert into voto (idaluno, idcandidato, ideleicao) values (20, 6, 2);

insert into ata (representante, vice, ideleicao, idturma, data) values ('Paulo Silva', 'Andre Lopes', 2, 3, '2025-12-01');