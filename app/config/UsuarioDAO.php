<?php
require_once __DIR__ . '/dbconection.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDAO {
    private $db;
    public function __construct() { 
        $this->db = new Database();
    }
    public function cadastrarUsuario(Usuario $usuario){
        try {
            $conn = $this->db->getConnection();
            $sql = "INSERT INTO usuario (email, senha, tipo, idaluno) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$usuario->getEmail(), $usuario->getSenha(), $usuario->getTipo(), $usuario->getIdaluno()]);
            return true;
        } catch (\Throwable $th) {
            echo "<script>console.log('Cadastrar usuário error: " . $th->getMessage() . "');</script>";
            return false;
        }
        // Implementar lógica para cadastrar usuário no banco de dados
        
    }

    public function iniciarSessao(string $email, string $senha){
        try {
            // Ajuste o nome da tabela/colunas conforme seu banco:
            // Aqui assumimos uma tabela 'usuarios' com colunas: ra (matrícula), senha_hash, nome, role
            $sql = 'SELECT * FROM usuario WHERE email = ? and senha = ? LIMIT 1';
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$email, $senha]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $usuario = new Usuario();
                $usuario->setId($row['idusuario']);
                $usuario->setEmail($row['email']);
                $usuario->setSenha($row['senha']);
                $usuario->setTipo($row['tipo']);
                $usuario->setIdaluno($row['idaluno'] ?? 0);
                return $usuario;
            }
            return null;
        } catch (Exception $e) {
            echo "<script>console.log('Iniciar sessão error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function fecharSessao(){
        // Implementar lógica para encerrar sessão do usuário
    }

    public function pegarAlunoUsuario(Usuario $usuario){
        try {
            // Ajuste o nome da tabela/colunas conforme seu banco:
            // Aqui assumimos uma tabela 'usuarios' com colunas: ra (matrícula), senha_hash, nome, role
            $sql = 'SELECT a.idaluno, a.nome, a.idturma FROM usuario u inner join aluno a on u.idaluno = a.idaluno WHERE a.idaluno = ? LIMIT 1';
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$usuario->getIdaluno()]);
            $aluno = $stmt->fetchObject('Aluno');
            return $aluno;
        } catch (Exception $e) {
            echo "<script>console.log('Iniciar sessão error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function verificarEmailExiste($email){
        try {
            $sql = 'SELECT COUNT(*) FROM usuario WHERE email = ?';
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "<script>console.log('Verificar email error: " . $e->getMessage() . "');</script>";
            return false;
        }
    }
}