<?php

class Turma {
    private int $id;
    private int $semestre;
    private string $curso;


    public function getId(): int
    {
        return $this->id;
    }

    public function getSemestre(): int
    {
        return $this->semestre;
    }

    public function setSemestre(int $semestre): void
    {
        $this->semestre = $semestre;
    }
    
    public function setCurso(string $curso): void
    {
        $this->curso = $curso;
    }

    public function getCurso(): string
    {
        return $this->curso;
    }
}