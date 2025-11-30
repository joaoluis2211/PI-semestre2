<?php
require_once __DIR__ . '/dbconection.php';

class AtaDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function cadastrarAta(Ata $ata){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO ata (representante, vice, ideleicao, idturma, data) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ata->getRepresentante(), $ata->getVice(), $ata->getIdeleicao(), $ata->getIdturma(), $ata->getData()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar ata error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

    public function buscarAta(int $ideleicao, int $idturma) {
    try {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM ata WHERE ideleicao = ? AND idturma = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ideleicao, $idturma]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "<script>console.log('Buscar ata error: " . $th->getMessage() . "');</script>";
        return null;
    }
}
}
?>