<?php
require_once __DIR__ . '/../config/CandidaturaDAO.php';
require_once __DIR__ . '/../model/Candidatura.php';
require_once __DIR__ . '/../model/Turma.php';
require_once __DIR__ . '/TurmaController.php';

class CandidaturaController {
    private $candidaturaDAO;
    public function __construct() {
        $this->candidaturaDAO = new CandidaturaDAO();
    }

    public function cadastrar(){
        try {
            $turma = new Turma();
            $turma->setCurso(isset($_POST['curso']) ? trim($_POST['curso']) : '');
            $turma->setSemestre(isset($_POST['semestre']) ? (int)$_POST['semestre'] : 0);
        
            $turmaController = new TurmaController();
            $idturma = $turmaController->getIdTurma($turma);

            $dataInicio = isset($_POST['dataInicio']) ? trim($_POST['dataInicio']) : '';
            $dataFim = isset($_POST['dataFim']) ? trim($_POST['dataFim']) : '';
            $candidatura = new Candidatura();
            $candidatura->setDataInicio($dataInicio);
            $candidatura->setDataFim($dataFim);
            $candidatura->setIdturma($idturma);
            header("Location: app/view/admin/candidatar_admin.php");
            return $this->candidaturaDAO->cadastrarCandidatura($candidatura);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao cadastrar candidatura: " . $e->getMessage() . "');</script>";
        }
    }

    public function listarCandidaturas(){
        try {
            return $this->candidaturaDAO->listarCandidaturas();
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidaturas: " . $e->getMessage() . "');</script>";
        }
    }
}