<?php

class Aluno {
    private int $idaluno;
    private string $nome;
    private int $idturma;


    public function getIdaluno(): int
    {
        return $this->idaluno;
    }

    public function setIdaluno(int $idaluno): void
    {
        $this->idaluno = $idaluno;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getIdturma(): int
    {
        return $this->idturma;
    }

    public function setIdturma(int $idturma): void
    {
        $this->idturma = $idturma;
    }
}
