<?php

class Candidatura{
    private int $idcandidatura;
    private string $dataInicio;
    private string $dataFim;
    private int $idturma;

    public function getIdcandidatura(): int
    {
        return $this->idcandidatura;
    }

    public function getDataInicio(): string
    {
        return $this->dataInicio;
    }

    public function setDataInicio(string $dataInicio): void
    {
        $this->dataInicio = $dataInicio;
    }

    public function getDataFim(): string
    {
        return $this->dataFim;
    }

    public function setDataFim(string $dataFim): void
    {
        $this->dataFim = $dataFim;
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