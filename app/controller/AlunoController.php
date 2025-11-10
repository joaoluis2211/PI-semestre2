<?php
require_once __DIR__ . '/../config/AlunoDAO.php';
require_once __DIR__ . '/../model/Aluno.php';

class AlunoController {
    private $alunoDAO;
    public function __construct() {
        $this->alunoDAO = new AlunoDAO();
    }

    public function cadastrar(Aluno $aluno){
        try {
            $this->alunoDAO->cadastrarAluno($aluno);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao cadastrar aluno: " . $e->getMessage() . "');</script>";
        }
    }

    public function getIdAluno(Aluno $aluno){
        try {
            return $this->alunoDAO->procurarAluno($aluno);
        } catch (Exception $e) {
            echo "<script>console.log('Localizar idaluno error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function getAluno(int $idaluno){
        try {
            return $this->alunoDAO->procurarAlunoPorId($idaluno);
        } catch (Exception $e) {
            echo "<script>console.log('Localizar aluno error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function atualizarTurma(Aluno $aluno, int $idturma){
        try {
            $this->alunoDAO->updateTurma($aluno, $idturma);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Localizar turma error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }
}