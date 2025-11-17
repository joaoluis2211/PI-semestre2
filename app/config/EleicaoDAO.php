<?php
require_once __DIR__ . '/dbconection.php';

class EleicaoDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function cadastrarEleicao(Eleicao $eleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO eleicao (dataInicioCandidatura, dataFimCandidatura, dataInicioVotacao, dataFimVotacao, idturma, status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$eleicao->getDataInicioCandidatura(), $eleicao->getDataFimCandidatura(), $eleicao->getDataFimVotacao(), $eleicao->getDataFimVotacao(), $eleicao->getIdturma(), $eleicao->getStatus()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar eleicao error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function listarCandidaturas(){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT e.ideleicao, e.dataInicioCandidatura, e.dataFimCandidatura, e.idturma, e.status, t.semestre, t.curso FROM eleicao e INNER JOIN turma t ON e.idturma = t.idturma where e.status = 'CANDIDATURA'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar candidaturas error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoes(){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT e.ideleicao, e.dataInicioVotacao, e.dataFimVotacao, e.status,
                    t.semestre, t.curso 
                    FROM eleicao e 
                    INNER JOIN turma t ON e.idturma = t.idturma where e.status = 'VOTAÇÃO'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar votações error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }


    public function listarCandidaturasAbertasPorTurma(int $idturma){
        try {
            $conn = $this->db->getConnection();
            $dataAtual = date('Y-m-d');
            $sql = "SELECT e.ideleicao, e.dataInicioCandidatura, e.dataFimCandidatura, e.idturma, t.semestre, t.curso 
                    FROM eleicao e 
                    INNER JOIN turma t ON e.idturma = t.idturma
                    WHERE e.dataInicioCandidatura <= ? AND e.dataFimCandidatura >= ? AND e.idturma = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$dataAtual, $dataAtual, $idturma]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar candidaturas abertas por turma error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoesAbertasPorTurma(int $idturma){
        try {
            $conn = $this->db->getConnection();
            $dataAtual = date('Y-m-d');
            $sql = "SELECT e.ideleicao, e.dataInicioVotacao, e.dataFimVotacao, 
                           e.idturma, t.semestre, t.curso 
                    FROM eleicao e  
                    INNER JOIN turma t ON e.idturma = t.idturma
                    WHERE e.dataInicioVotacao <= ? AND e.dataFimVotacao >= ? AND e.idturma = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$dataAtual, $dataAtual, $idturma]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar votações abertas por turma error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function excluirCandidatura(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "DELETE FROM eleicao WHERE ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Excluir candidatura error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function abrirVotacao(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "UPDATE eleicao SET status = 'VOTAÇÃO' where ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Abrir votação error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }
}
?>