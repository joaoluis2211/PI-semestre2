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
presidente varchar(60) not null,
vice varchar(60) not null,
totalVoto int not null,
ideleicao int not null,
constraint fk_eleicao_ata foreign key (ideleicao) references eleicao (ideleicao)
);

create table voto(
idvoto int primary key auto_increment not null,
idaluno int not null,
idcandidato int not null,
constraint fk_aluno_voto foreign key (idaluno) references aluno (idaluno),
constraint fk_candidato_voto foreign key (idcandidato) references candidato (idcandidato)
);

INSERT INTO usuario (email, senha, tipo) values ('administrador@gmail.com', '123', 'administrador');

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






