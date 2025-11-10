<?php

class Candidato
{
    private int $idcandidato;
    private int $idcandidatura;
    private int $idaluno;
    private int $qtdVotos = 0;


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

    public function getIdCandidatura(): int
    {
        return $this->idcandidatura;
    }

    public function setIdcandidatura(int $idcandidatura): void
    {
        $this->idcandidatura = $idcandidatura;
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
}