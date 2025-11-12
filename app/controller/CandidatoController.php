<?php
require_once __DIR__ . '/../config/CandidatoDAO.php';
require_once __DIR__ . '/../model/Candidato.php';

class CandidatoController {
    private $candidatoDAO;
    public function __construct() {
        $this->candidatoDAO = new CandidatoDAO();
    }

    public function cadastrar(){
        try {
            $idaluno = $_POST['idaluno'] ?? null;
            $idcandidatura = $_POST['idcandidatura'] ?? null;
            $candidato = new Candidato();
            $candidato->setIdaluno($idaluno);
            $candidato->setIdcandidatura($idcandidatura);
            $candidato->setQtdVotos(0);
            $this->candidatoDAO->cadastrarCandidato($candidato);
            echo json_encode(['sucesso' => true]);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao cadastrar candidatura: " . $e->getMessage() . "');</script>";
        }
    }

    public function remover(){
        try {
            $idaluno = $_POST['idaluno'] ?? null;
            $idcandidatura = $_POST['idcandidatura'] ?? null;

            $candidato = new Candidato();
            $candidato->setIdaluno($idaluno);
            $candidato->setIdcandidatura($idcandidatura);
            $this->candidatoDAO->removerCandidato($candidato);
            echo json_encode(['sucesso' => true]);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidaturas: " . $e->getMessage() . "');</script>";
        }
    }

    public function listar(){
        try {
            $idcandidatura = $_POST['idcandidatura'] ?? null;
            $this->candidatoDAO->listarCandidatos($idcandidatura);
            echo json_encode(['sucesso' => true]);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidatos: " . $e->getMessage() . "');</script>";
        }
    }

    public function verificarCandidaturaExistente($idaluno, $idcandidatura){
        try {
            return $this->candidatoDAO->verificarCandidaturaExistente($idaluno, $idcandidatura);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao verificar candidato existente: " . $e->getMessage() . "');</script>";
        }
    }
}