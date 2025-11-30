<?php
require_once __DIR__ . '/dbconection.php';

class CandidatoDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function cadastrarCandidato(Candidato $candidato){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO candidato (idaluno, ideleicao, qtdVotos) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$candidato->getIdaluno(), $candidato->getIdeleicao(), $candidato->getQtdVotos()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar eleicao error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function removerCandidato(Candidato $candidato){
        try {
            $conn = $this->db->getConnection();
            $sql = "DELETE FROM candidato WHERE idaluno = ? AND ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$candidato->getIdaluno(), $candidato->getIdeleicao()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Remover candidato error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function listarCandidatos(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT a.nome, c.qtdVotos, c.idcandidato FROM candidato c INNER JOIN aluno a ON c.idaluno = a.idaluno where c.ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar candidatos error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function verificarCandidaturaExistente(int $idaluno, int $ideleicao) {
    try {
        $conn = $this->db->getConnection();
        $sql = "SELECT COUNT(*) AS total FROM candidato WHERE idaluno = ? AND ideleicao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idaluno, $ideleicao]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0; // true se já existe
    } catch (\Throwable $th) {
        echo "<script>console.log('Verificar eleicao error: " . $th->getMessage() . "');</script>";
        return null;
    }
    }

    public function removerAllCandidatos(int $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "DELETE FROM candidato WHERE ideleicao = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ideleicao]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Excluir all candidatos error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }
    
    public function adicionarVoto(Candidato $candidato){
        try {
            $conn = $this->db->getConnection();
            $sql = "UPDATE candidato SET qtdVotos = ? WHERE idcandidato = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$candidato->getQtdVotos(), $candidato->getIdcandidato()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Excluir all candidatos error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function procurarCandidatoPorId(int $idcandidato){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT * FROM candidato WHERE idcandidato = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idcandidato]);
            $candidato = $stmt->fetchObject('Candidato');
            return $candidato;
        } catch (\Throwable $th) {
            echo "<script>console.log('Pegar candidato error: " . $th->getMessage() . "');</script>";
            return null;
        }
    }

    public function contarVotosNulos($ideleicao) {
    try {
        $conn = $this->db->getConnection();
        $sql = "SELECT COUNT(*) AS total FROM voto 
                WHERE ideleicao = ? AND idcandidato IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ideleicao]);
        return $stmt->fetchColumn();
    } catch (\Throwable $th) {
        echo "<script>console.log('Contar votos nulos error: " . $th->getMessage() . "');</script>";
        return 0;
}
}
}
?>