<?php
require_once __DIR__ . '/../config/UsuarioDAO.php';
require_once __DIR__ . '/../controller/TurmaController.php';
require_once __DIR__ . '/../controller/AlunoController.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../model/Turma.php';
require_once __DIR__ . '/../model/Aluno.php';
session_start();
class UsuarioController {
    private $usuarioDAO;
    private $usuario;
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
        $this->usuario = new Usuario();
    }

    public function cadastrar(){
        try {
            $aluno = new Aluno();
            $turma = new Turma();

            $aluno->setNome(isset($_POST['nome']) ? trim($_POST['nome']) : '');

            $this->usuario->setEmail(isset($_POST['email']) ? trim($_POST['email']) : '');
            $this->usuario->setSenha(isset($_POST['senha']) ? $_POST['senha'] : '');
            $this->usuario->setTipo('aluno');

            $turma->setCurso(isset($_POST['curso']) ? trim($_POST['curso']) : '');
            $turma->setSemestre(isset($_POST['semestre']) ? (int)$_POST['semestre'] : 0);

            if (empty($aluno->getNome()) || empty($this->usuario->getEmail()) || empty($this->usuario->getSenha()) || empty($turma->getSemestre())) {
                $_SESSION['erro'] = 'Por favor, preencha todos os campos obrigatórios.';
                header('Location: app/view/usuario/cadastrarView.php');
                exit;
            }
            $emailExists = $this->usuarioDAO->verificarEmailExiste($this->usuario->getEmail());
            if ($emailExists === true) {
                $_SESSION['erro'] = 'E‑mail já cadastrado.';
                header('Location: app/view/usuario/cadastrarView.php');
                exit;
            }

            $turmaController = new TurmaController();
            $idturma = $turmaController->getIdTurma($turma);
            if (!$idturma) {
                $turmaController->cadastrar($turma);
                $idturma = $turmaController->getIdTurma($turma);
            }
            $aluno->setIdturma($idturma);
            $alunoController = new AlunoController();
            $alunoController->cadastrar($aluno);
            $idaluno = $alunoController->getIdAluno($aluno);
            $this->usuario->setIdaluno($idaluno);
            $this->usuarioDAO->cadastrarUsuario($this->usuario);
            $_SESSION['sucesso'] = 'Cadastro realizado com sucesso. Faça login.';
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao cadastrar usuário: " . $e->getMessage() . "');</script>";
        }
    }

    public function login(){
        try {
            $this->usuario->setEmail(isset($_POST['email']) ? trim($_POST['email']) : '');
            $this->usuario->setSenha(isset($_POST['senha']) ? $_POST['senha'] : '');
            $user = $this->usuarioDAO->iniciarSessao($this->usuario->getEmail(), $this->usuario->getSenha());
            $_SESSION['user'] = $user;
            if (!$user) {
                $_SESSION['erro'] = 'E‑mail ou senha inválidos.';
                header('Location: index.php');
                exit;
            }
            if ($_SESSION['user']->getTipo() === 'administrador') {
            header('Location: app/view/admin/home_admin.html');
            } elseif ($_SESSION['user']->getTipo() === 'aluno') {
            $aluno = $this->getAlunoUsuario($user);
            $turmaController = new TurmaController();
            $turma = new Turma();
            $turma = $turmaController->procurarTurma($aluno->getIdturma());
            $mes = date('m');
            $semestre = $turma->getSemestre();
            if ($mes == 1 || $mes == 7 && $semestre <= 6 ) {
                $alunoController = new AlunoController();
                $alunoController->atualizarTurma($aluno, $semestre);
            }
            header('Location: app/view/usuario/home.html');
        }
            return $user;
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao iniciar sessão: " . $e->getMessage() . "');</script>";
        }
    }

    public function logout(Usuario $usuario){
        try {
            $this->usuarioDAO->fecharSessao($usuario);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao encerrar sessão: " . $e->getMessage() . "');</script>";
        }
    }

    public function getAlunoUsuario(Usuario $usuario){
        try {
            return $this->usuarioDAO->pegarAlunoUsuario($usuario);
        } catch (Exception $e) {
            echo "<script>console.log('Erro ao buscar aluno: " . $e->getMessage() . "');</script>";
            return null;
        }
    }
}