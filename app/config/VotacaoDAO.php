<?php
require_once __DIR__ . '/dbconection.php';

class VotacaoDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function listarVotacoes(){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT v.idvotacao, v.dataIncio, v.dataFim, v.idcandidatura, 
                           c.idturma, t.semestre, t.curso 
                    FROM votacao v 
                    INNER JOIN candidatura c ON v.idcandidatura = c.idcandidatura 
                    INNER JOIN turma t ON c.idturma = t.idturma";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar votações error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoesAbertas(){
        try {
            $conn = $this->db->getConnection();
            $dataAtual = date('Y-m-d');
            $sql = "SELECT v.idvotacao, v.dataIncio, v.dataFim, v.idcandidatura, 
                           c.idturma, t.semestre, t.curso 
                    FROM votacao v 
                    INNER JOIN candidatura c ON v.idcandidatura = c.idcandidatura 
                    INNER JOIN turma t ON c.idturma = t.idturma
                    WHERE v.dataIncio <= ? AND v.dataFim >= ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$dataAtual, $dataAtual]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar votações abertas error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }

    public function listarVotacoesAbertasPorTurma(int $idturma){
        try {
            $conn = $this->db->getConnection();
            $dataAtual = date('Y-m-d');
            $sql = "SELECT v.idvotacao, v.dataIncio, v.dataFim, v.idcandidatura, 
                           c.idturma, t.semestre, t.curso 
                    FROM votacao v 
                    INNER JOIN candidatura c ON v.idcandidatura = c.idcandidatura 
                    INNER JOIN turma t ON c.idturma = t.idturma
                    WHERE v.dataIncio <= ? AND v.dataFim >= ? AND c.idturma = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$dataAtual, $dataAtual, $idturma]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>console.log('Listar votações abertas por turma error: " . $th->getMessage() . "');</script>";
            return [];
        }
    }
}
?>



