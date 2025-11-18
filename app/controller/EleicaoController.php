<?php
require_once __DIR__ . '/../config/EleicaoDAO.php';
require_once __DIR__ . '/CandidatoController.php';
require_once __DIR__ . '/../model/Eleicao.php';
require_once __DIR__ . '/../model/Turma.php';
require_once __DIR__ . '/TurmaController.php';

class EleicaoController {
    private $eleicaoDAO;
    public function __construct() {
        $this->eleicaoDAO = new EleicaoDAO();
    }

    public function cadastrar(){
        try {
            $turma = new Turma();
            $turma->setCurso(isset($_POST['curso']) ? trim($_POST['curso']) : '');
            $turma->setSemestre(isset($_POST['semestre']) ? (int)$_POST['semestre'] : 0);
        
            $turmaController = new TurmaController();
            $idturma = $turmaController->getIdTurma($turma);

            $dataInicioCandidatura = isset($_POST['dataInicioCandidatura']) ? trim($_POST['dataInicioCandidatura']) : '';
            $dataFimCandidatura = isset($_POST['dataFimCandidatura']) ? trim($_POST['dataFimCandidatura']) : '';
            $dataInicioVotacao = isset($_POST['dataInicioVotacao']) ? trim($_POST['dataInicioVotacao']) : '';
            $dataFimVotacao = isset($_POST['dataFimVotacao']) ? trim($_POST['dataFimVotacao']) : '';
            $status = 'CANDIDATURA';
            $eleicao = new Eleicao();
            $eleicao->setDataInicioCandidatura($dataInicioCandidatura);
            $eleicao->setDataFimCandidatura($dataFimCandidatura);
            $eleicao->setDataInicioVotacao($dataInicioVotacao);
            $eleicao->setDataFimVotacao($dataFimVotacao);
            $eleicao->setStatus($status);
            $eleicao->setIdturma($idturma);
            header("Location: app/view/admin/candidaturas_admin.php");
            return $this->eleicaoDAO->cadastrarEleicao($eleicao);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao cadastrar eleicao: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function listarCandidaturas(){
        try {
            return $this->eleicaoDAO->listarCandidaturas();
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidaturas: " . $e->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoes(){
        try {
            return $this->eleicaoDAO->listarVotacoes();
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar votacoes: " . $e->getMessage() . "');</script>";
        }
    }


    public function listarCandidaturasAbertasPorTurma(int $idturma){
        try {
            return $this->eleicaoDAO->listarCandidaturasAbertasPorTurma($idturma);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidaturas abertas por turma: " . $e->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoesAbertasPorTurma(int $idturma){
        try {
            return $this->eleicaoDAO->listarVotacoesAbertasPorTurma($idturma);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar votações abertas por turma: " . $e->getMessage() . "');</script>";
            return [];
        }
    }

    public function excluir(){
        try {
            $ideleicao = $_POST['ideleicao'] ?? null;
            $candidatoController = new CandidatoController();
            $resp = $candidatoController->deleteAll($ideleicao);
            if ($resp) {
                $resp2 = $this->eleicaoDAO->excluirCandidatura($ideleicao);
                if ($resp2) {
                    echo json_encode(['sucesso' => true]);
                }else{
                    echo json_encode(['sucesso' => false]);
                }
            }
        } catch (Exception $e) {
            echo "console.error('Erro ao excluir candidaturas" . $e->getMessage() . "')";
            return false;
        }
    }

    public function abrirVotacao(int $ideleicao){
        try {
            return $this->eleicaoDAO->abrirVotacao($ideleicao);
        } catch (Exception $e) {
            echo "console.error('Erro ao abrir votacao" . $e->getMessage() . "')";
            return false;
        }
    }
}