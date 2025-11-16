<?php
require_once __DIR__ . '/../config/VotacaoDAO.php';
require_once __DIR__ . '/../model/Votacao.php';

class VotacaoController {
    private $votacaoDAO;
    public function __construct() {
        $this->votacaoDAO = new VotacaoDAO();
    }

    public function listarVotacoes(){
        try {
            return $this->votacaoDAO->listarVotacoes();
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar votações: " . $e->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoesAbertas(){
        try {
            return $this->votacaoDAO->listarVotacoesAbertas();
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar votações abertas: " . $e->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoesAbertasPorTurma(int $idturma){
        try {
            return $this->votacaoDAO->listarVotacoesAbertasPorTurma($idturma);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar votações abertas por turma: " . $e->getMessage() . "');</script>";
            return [];
        }
    }
}
?>



