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
            $sql = "INSERT INTO candidato (idaluno, idcandidatura, qtdVotos) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$candidato->getIdaluno(), $candidato->getIdcandidatura(), $candidato->getQtdVotos()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar candidatura error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function removerCandidato(Candidato $candidato){
        try {
            $conn = $this->db->getConnection();
            $sql = "DELETE FROM candidato WHERE idaluno = ? AND idcandidatura = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$candidato->getIdaluno(), $candidato->getIdcandidatura()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar candidaturas error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function listarCandidatos(int $idcandidatura){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT a.nome FROM candidato c INNER JOIN aluno a ON c.idaluno = a.idaluno where c.idcandidatura = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idcandidatura]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar candidatos error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function verificarCandidaturaExistente($idaluno, $idcandidatura) {
    try {
        $conn = $this->db->getConnection();
        $sql = "SELECT COUNT(*) AS total FROM candidato WHERE idaluno = ? AND idcandidatura = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idaluno, $idcandidatura]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0; // true se já existe
    } catch (\Throwable $th) {
        echo "<script>console.log('Verificar candidatura error: " . $th->getMessage() . "');</script>";
        return null;
    }
    }

    public function removerAllCandidatos(int $idcandidatura){
        try {
            $conn = $this->db->getConnection();
            $sql = "DELETE FROM candidato WHERE idcandidatura = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idcandidatura]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Excluir all candidatos error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }
}
?>