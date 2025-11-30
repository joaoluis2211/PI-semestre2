<?php
require_once __DIR__ . '/../config/VotoDAO.php';
require_once __DIR__ . '/CandidatoController.php';
require_once __DIR__ . '/../model/Voto.php';

class VotoController {
    private $votoDAO;
    public function __construct() {
        $this->votoDAO = new VotoDAO();
    }

    public function verificarJaVotou(int $idaluno, int $ideleicao){
        try {
            return $this->votoDAO->verificarJaVotou($idaluno, $ideleicao);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao verificar voto: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    public function votar() {
        try {
            $idaluno = $_POST['idaluno'] ?? null;
            $idcandidato = $_POST['idcandidato'] ?? null;
            $idcandidato = $idcandidato === 'NULO' ? null : $idcandidato;
            $ideleicao = $_POST['ideleicao'] ?? null;
            $votou = $this->votoDAO->votar($idaluno, $idcandidato, $ideleicao);
            if ($votou and $idcandidato !== null) {
                $candidatoController = new CandidatoController();
                $candidato = $candidatoController->getCandidato($idcandidato);
                $candidato->incrementarVoto();
                $candidatoController->adicionarVoto($candidato);
            }
            echo json_encode([
                'sucesso' => true,
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'sucesso' => false,
                'erro' => 'Erro ao votar.',
                'detalhes' => $e->getMessage()
            ]);
        }
    }
}
?>




