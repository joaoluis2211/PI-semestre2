<?php

class Ata{
    private int $id;
    private int $ideleicao;
    private int $idturma;
    private string $representante;
    private string $vice;
    private string $data;

    public function getId(): int {
        return $this->id;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getIdeleicao(): int {
        return $this->ideleicao;
    }
    public function setIdeleicao(int $ideleicao): void {
        $this->ideleicao = $ideleicao;
    }

    public function getIdturma(): int {
        return $this->idturma;
    }
    public function setIdturma(int $idturma): void {
        $this->idturma = $idturma;
    }

    public function getRepresentante(): string {
        return $this->representante;
    }
    public function setRepresentante(string $representante): void {
        $this->representante = $representante;
    }

    public function getVice(): string {
        return $this->vice;
    }
    public function setVice(string $vice): void {
        $this->vice = $vice;
    }

    public function getData(): string {
        return $this->data;
    }
    public function setData(string $data): void {
        $this->data = $data;
    }
}