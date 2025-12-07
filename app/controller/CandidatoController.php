<?php
require_once __DIR__ . '/../config/CandidatoDAO.php';
require_once __DIR__ . '/../model/Candidato.php';

class CandidatoController {
    private $candidatoDAO;
    public function __construct() {
        $this->candidatoDAO = new CandidatoDAO();
    }

    public function cadastrar() {
    try {

        $idaluno = $_POST['idaluno'] ?? null;
        $ideleicao = $_POST['ideleicao'] ?? null;

        // VERIFICA CAMPOS
        if (!$idaluno || !$ideleicao) {
            echo json_encode(['sucesso' => false, 'erro' => 'Dados incompletos']);
            return;
        }

        // VERIFICA SE A IMAGEM FOI ENVIADA
        if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== 0) {
            echo json_encode(['sucesso' => false, 'erro' => 'Imagem não enviada']);
            return;
        }

        $imagem = $_FILES['imagem'];

        // Caminho onde a imagem será salva
        $nomeImagem = uniqid() . "_" . basename($imagem['name']);
        $destino = __DIR__ . "/../../uploads/candidatos/" . $nomeImagem;

        // Cria diretório se não existir
        if (!is_dir(__DIR__ . "/../../uploads/candidatos/")) {
            mkdir(__DIR__ . "/../../uploads/candidatos/", 0777, true);
        }

        // MOVE A IMAGEM PARA O SERVIDOR
        if (!move_uploaded_file($imagem['tmp_name'], $destino)) {
            echo json_encode(['sucesso' => false, 'erro' => 'Falha ao mover a imagem']);
            return;
        }

        // SALVA NO BANCO
        $candidato = new Candidato();
        $candidato->setIdaluno($idaluno);
        $candidato->setIdeleicao($ideleicao);
        $candidato->setQtdVotos(0);
        $candidato->setImagem($nomeImagem);  // <-- IMPORTANTE

        // Executa o DAO
        $this->candidatoDAO->cadastrarCandidato($candidato);

        // RETORNO PARA O JS
        echo json_encode([
            'sucesso' => true,
            'foto' => $nomeImagem
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'sucesso' => false,
            'erro' => $e->getMessage()
        ]);
    }
}

    public function remover(){
        try {
            $idaluno = $_POST['idaluno'] ?? null;
            $ideleicao = $_POST['ideleicao'] ?? null;

            $candidato = new Candidato();
            $candidato->setIdaluno($idaluno);
            $candidato->setIdeleicao($ideleicao);
            $this->candidatoDAO->removerCandidato($candidato);
            echo json_encode(['sucesso' => true]);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao listar candidaturas: " . $e->getMessage() . "');</script>";
        }
    }

    public function deleteAll(int $ideleicao){
        try {
            return $this->candidatoDAO->removerAllCandidatos($ideleicao);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao remover candidatos: " . $e->getMessage() . "');</script>";
        }
    }

    public function listar() {
        try {
            $ideleicao = $_POST['ideleicao'] ?? null;
            $votosNulos = $this->candidatoDAO->contarVotosNulos($ideleicao);

            $candidatos = $this->candidatoDAO->listarCandidatos($ideleicao);

            echo json_encode([
                'sucesso' => true,
                'candidatos' => $candidatos,
                'votosNulos' => $votosNulos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'sucesso' => false,
                'erro' => 'Erro ao listar candidatos.',
                'detalhes' => $e->getMessage()
            ]);
        }
    }

    public function verificarCandidaturaExistente($idaluno, $ideleicao){
        try {
            return $this->candidatoDAO->verificarCandidaturaExistente($idaluno, $ideleicao);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao verificar candidato existente: " . $e->getMessage() . "');</script>";
        }
    }

    public function adicionarVoto(Candidato $candidato){
        try {
            return $this->candidatoDAO->adicionarVoto($candidato);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao adicionar voto: " . $e->getMessage() . "');</script>";
        }
    }

    public function getCandidato(int $idcandidato){
        try {
            return $this->candidatoDAO->procurarCandidatoPorId($idcandidato);
        } catch (Exception $e) {
            echo "<script>console.log('Localizar candidato error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }
}