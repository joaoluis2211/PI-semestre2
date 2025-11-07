<?php
require_once 'app/config/dbconection.php';

class TurmaDAO{
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function cadastrarTurma(Turma $turma){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO turma (semestre, curso) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$turma->getSemestre(), $turma->getCurso()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar turma error: " . $th->getMessage() . "');</script>";
            return false;
        }
        
    }

    public function localizarTurma(Turma $turma){
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare('SELECT idturma FROM turma WHERE curso = ? AND semestre = ? LIMIT 1');
            $stmt->execute([$turma->getCurso(), $turma->getSemestre()]);
            $turma = $stmt->fetchColumn();
            return $turma;
        } catch (Exception $e) {
            echo "<script>console.log('Localizar turma error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }
    
    public function procurarTurma(int $idturma){
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare('SELECT * FROM turma WHERE idturma = ? LIMIT 1');
            $stmt->execute([$idturma]);
            $turma = $stmt->fetchObject('Turma');
            return $turma;
        } catch (Exception $e) {
            echo "<script>console.log('Localizar turma error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }
}