<?php
require_once __DIR__ . '/EleicaoController.php';
require_once __DIR__ . '/../config/AtaDAO.php';
require_once __DIR__ . '/../model/Ata.php';

class AtaController {
    private $ataDAO;
    public function __construct() {
        $this->ataDAO = new AtaDAO();
    }

    public function gerarAta(int $ideleicao, int $idturma){
        try {
            $eleicaoController = new EleicaoController();
            $candidatos = $eleicaoController->candidatosPorVotos($ideleicao);
            $representante = $candidatos[0]['nome'] ?? "NÃO DEFINIDO";
            $vice = $candidatos[1]['nome'] ?? "NÃO DEFINIDO";
            $dataAtual = date('Y-m-d');

            $ata = new Ata();
            $ata->setRepresentante($representante);
            $ata->setVice($vice);
            $ata->setIdeleicao($ideleicao);
            $ata->setIdturma($idturma);
            $ata->setData($dataAtual);

            return $this->ataDAO->cadastrarAta($ata);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao gerar ata: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function obterAta(int $ideleicao, int $idturma) {
        try {
            return $this->ataDAO->buscarAta($ideleicao, $idturma);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao buscar ata: " . $e->getMessage() . "');</script>";
            return null;
        }
        
    }
}