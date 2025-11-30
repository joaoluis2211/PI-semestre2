<?php
require_once __DIR__ . '/dbconection.php';
// SELECT * FROM voto v inner join candidato c on v.idcandidato = c.idcandidato inner join eleicao e on e.ideleicao = c.ideleicao WHERE v.idcandidato = (SELECT idcandidato from  
class VotoDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function verificarJaVotou(int $idaluno, int $ideleicao){
    try {
        $conn = $this->db->getConnection();
        $sql = "SELECT 1
                FROM voto v
                INNER JOIN eleicao e ON e.ideleicao = v.ideleicao
                WHERE e.ideleicao = ? AND v.idaluno = ?
                LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$ideleicao, $idaluno]);

        $result = $stmt->fetchColumn();

        // ⬇️ SE HOUVER ALGUMA LINHA → já votou
        return $result !== false;

    } catch (\Throwable $th) {
        echo "<script>console.log('Verificar voto error: " . $th->getMessage() . "');</script>";
        return false;
    }
}

    public function votar($idaluno, $idcandidato, $ideleicao){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO voto (idaluno, idcandidato, ideleicao) values (?, ?, ?) ";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idaluno, $idcandidato, $ideleicao]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Votar error: " . $th->getMessage() . "');</script>";
            return false;
        }
    }

}
?>




