<?php
require_once __DIR__ . '/dbconection.php';

class AlunoDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    
    public function cadastrarAluno(Aluno $aluno){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO aluno (nome, idturma, ra) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$aluno->getNome(), $aluno->getIdturma(), $aluno->getRa()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar aluno error: " . $th->getMessage() . "');</script>";
            return false;
        }
        
    }

    public function procurarAluno(Aluno $aluno){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT idaluno FROM aluno WHERE nome = ? AND idturma = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$aluno->getNome(), $aluno->getIdturma()]);
            $idaluno = $stmt->fetchColumn();
            return $idaluno;
        } catch (\Throwable $th) {
            echo "<script>console.log('Procurar aluno error: " . $th->getMessage() . "');</script>";
            return null;
        }
        
    }

    public function procurarTurma(Aluno $aluno){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT idaluno FROM aluno WHERE nome = ? AND idturma = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$aluno->getNome(), $aluno->getIdturma()]);
            $idaluno = $stmt->fetchColumn();
            return $idaluno;
        } catch (\Throwable $th) {
            echo "<script>console.log('Procurar aluno error: " . $th->getMessage() . "');</script>";
            return null;
        }
    }

    public function procurarAlunoPorId(int $idaluno){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT * FROM aluno WHERE idaluno = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idaluno]);
            $aluno = $stmt->fetchObject('Aluno');
            return $aluno;
        } catch (\Throwable $th) {
            echo "<script>console.log('Pegar aluno error: " . $th->getMessage() . "');</script>";
            return null;
        }
    }
    

    public function updateTurma(Aluno $aluno, int $idturma){
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare('UPDATE aluno set idturma = ? where idaluno = ?');
            $stmt->execute([$idturma, $aluno->getIdaluno()]);
            $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
            return $aluno;
        } catch (Exception $e) {
            echo "<script>console.log('Localizar turma error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function getAlunoPorTurma(int $idturma){
        try {
            $conn = $this->db->getConnection();
            $sql = "SELECT * FROM aluno WHERE idturma = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idturma]);
            $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $alunos;
        } catch (\Throwable $th) {
            echo "<script>console.log('Pegar alunos por turma error: " . $th->getMessage() . "');</script>";
            return null;
        }
    }
}
?>