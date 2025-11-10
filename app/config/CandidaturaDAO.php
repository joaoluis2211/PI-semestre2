<?php
require_once __DIR__ . '/dbconection.php';

class CandidaturaDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function cadastrarCandidatura(Candidatura $candidatura){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO candidatura (dataInicio, dataFim, idturma) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$candidatura->getDataInicio(), $candidatura->getDataFim(), $candidatura->getIdturma()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar candidatura error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function listarCandidaturas(){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT c.idcandidatura, c.dataInicio, c.dataFim, c.idturma, t.semestre, t.curso FROM candidatura c INNER JOIN turma t ON c.idturma = t.idturma";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar candidaturas error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function excluirCandidatura(int $idcandidatura){
        try {
            $$conn = $this->db->getConnection();
            $sql = "DELETE FROM candidatura WHERE idcandidatura = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute($idcandidatura);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Excluir candidatura error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }
}
?>