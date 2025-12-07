<?php

class Candidato
{
    private int $idcandidato;
    private int $ideleicao;
    private int $idaluno;
    private int $qtdVotos = 0;
    private string $imagem;


    public function getIdaluno(): int
    {
        return $this->idaluno;
    }

    public function setIdaluno(int $idaluno): void
    {
        $this->idaluno = $idaluno;
    }

    public function getIdcandidato(): int
    {
        return $this->idcandidato;
    }

    public function setIdcandidato(int $idcandidato): void
    {
        $this->idcandidato = $idcandidato;
    }

    public function getIdeleicao(): int
    {
        return $this->ideleicao;
    }

    public function setIdeleicao(int $ideleicao): void
    {
        $this->ideleicao = $ideleicao;
    }

    public function getQtdVotos(): int
    {
        return $this->qtdVotos;
    }

    public function setQtdVotos(int $qtdVotos): void
    {
        $this->qtdVotos = $qtdVotos;
    }

    public function incrementarVoto(): void
    {
        $this->qtdVotos++;
    }

    public function getImagem(): string
    {
        return $this->imagem;
    }

    public function setImagem(string $imagem): void
    {
        $this->imagem = $imagem;
    }
}