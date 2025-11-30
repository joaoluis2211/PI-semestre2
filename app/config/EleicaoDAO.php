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
                    t.semestre, t.curso, e.idturma
                    FROM eleicao e 
                    INNER JOIN turma t ON e.idturma = t.idturma where e.status = 'VOTAÇÃO' OR e.status = 'ENCERRADA'";
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
            $sql = "SELECT e.ideleicao, e.dataInicioCandidatura, e.dataFimCandidatura, e.idturma, e.status, t.semestre, t.curso 
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
                           e.idturma, e.status, t.semestre, t.curso 
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

    public function listarVotacoesEncerradasPorTurma(int $idturma){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT e.ideleicao, e.dataInicioVotacao, e.dataFimVotacao, 
                           e.idturma, e.status, t.semestre, t.curso 
                    FROM eleicao e  
                    INNER JOIN turma t ON e.idturma = t.idturma
                    WHERE  e.idturma = ? and e.status = 'ENCERRADA'";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idturma]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar votações encerradas por turma error: " . $th->getMessage() . "');</script>";
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

    public function encerrarVotacao(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "UPDATE eleicao SET status = 'ENCERRADA' where ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Encerrar votação error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }
    
    public function candidatosPorVotos(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT a.nome, c.qtdVotos FROM candidato c INNER JOIN aluno a ON c.idaluno = a.idaluno WHERE c.ideleicao = ? ORDER BY c.qtdVotos DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Erro ao pegar os candidatos por quantidade de votos: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function listarAlunosVotacao(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT a.nome, a.ra, t.semestre, t.curso FROM aluno a inner join turma t ON a.idturma = t.idturma inner join voto v on v.idaluno = a.idaluno inner join candidato c ON v.idcandidato = c.idcandidato WHERE c.ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Erro ao pegar os alunos que votaram: " . $th->getMessage() . "');</script>";
            return false;
        }
    }
    
}
?>