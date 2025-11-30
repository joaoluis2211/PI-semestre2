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
            $ideleicao = $_POST['ideleicao'] ?? null;
            $candidato = new Candidato();
            $candidato->setIdaluno($idaluno);
            $candidato->setIdeleicao($ideleicao);
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
            $ideleicao = $_POST['ideleicao'] ?? null;

            $candidato = new Candidato();
            $candidato->setIdaluno($idaluno);
            $candidato->setIdeleicao($ideleicao);
            $this->candidatoDAO->removerCandidato($candidato);
            echo json_encode(['sucesso' => true]);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidaturas: " . $e->getMessage() . "');</script>";
        }
    }

    public function deleteAll(int $ideleicao){
        try {
            return $this->candidatoDAO->removerAllCandidatos($ideleicao);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao remover candidatos: " . $e->getMessage() . "');</script>";
        }
    }

    public function listar() {
        try {
            $ideleicao = $_POST['ideleicao'] ?? null;
            $votosNulos = $this->candidatoDAO->contarVotosNulos($ideleicao);

            $candidatos = $this->candidatoDAO->listarCandidatos($ideleicao);

            echo json_encode([
                'sucesso' => true,
                'candidatos' => $candidatos,
                'votosNulos' => $votosNulos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'sucesso' => false,
                'erro' => 'Erro ao listar candidatos.',
                'detalhes' => $e->getMessage()
            ]);
        }
    }

    public function verificarCandidaturaExistente($idaluno, $ideleicao){
        try {
            return $this->candidatoDAO->verificarCandidaturaExistente($idaluno, $ideleicao);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao verificar candidato existente: " . $e->getMessage() . "');</script>";
        }
    }

    public function adicionarVoto(Candidato $candidato){
        try {
            return $this->candidatoDAO->adicionarVoto($candidato);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao adicionar voto: " . $e->getMessage() . "');</script>";
        }
    }

    public function getCandidato(int $idcandidato){
        try {
            return $this->candidatoDAO->procurarCandidatoPorId($idcandidato);
        } catch (Exception $e) {
            echo "<script>console.log('Localizar candidato error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }
}