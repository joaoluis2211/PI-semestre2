<?php
require_once __DIR__ . '/../../controller/CandidaturaController.php';
require_once __DIR__ . '/../../controller/VotacaoController.php';
require_once __DIR__ . '/../../controller/AlunoController.php';
require_once __DIR__ . '/../../model/Usuario.php';

session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: ../../../index.php");
    exit();
}

$usuario = $_SESSION['user'];
$candidaturaController = new CandidaturaController();
$votacaoController = new VotacaoController();
$alunoController = new AlunoController();

// Buscar informações do aluno
$aluno = $alunoController->getAluno($usuario->getIdaluno());
$idturma = $aluno ? $aluno->getIdturma() : null;

// Buscar candidaturas e votações em aberto para a turma do aluno
$candidaturasAbertas = [];
$votacoesAbertas = [];

if ($idturma) {
    $candidaturasAbertas = $candidaturaController->listarCandidaturasAbertasPorTurma($idturma);
    $votacoesAbertas = $votacaoController->listarVotacoesAbertasPorTurma($idturma);
}

$temCandidaturasAbertas = !empty($candidaturasAbertas);
$temVotacoesAbertas = !empty($votacoesAbertas);
$temAlgoAberto = $temCandidaturasAbertas || $temVotacoesAbertas;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone-branco.png" type="image/png">
    <title>ELEJA - Home</title>
    
    <!-- Importando a fonte Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configuração da fonte no Tailwind via CDN -->
    <script>
        tailwind.config = {
        theme: {
            extend: {
            fontFamily: {
                sans: ['Montserrat', 'sans-serif'],
            },
            colors: {
                'meu-vermelho': '#b20000',
            },
            },
        },
        }
    </script>
</head>

<body class="flex flex-col min-h-screen font-sans bg-white text-black">
    <nav class="flex flex-col bg-white max-h-max justify-between items-center">
        <div class="flex items-center w-full justify-between">
            <a href="home.php"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center h-12 bg-[#b20000]">
            <ul class="flex items-center gap-16 text-white text-xl">
                <li><a class="hover:text-black" href="home.php">Início</a></li>
                <li><a class="hover:text-black" href="voto.html">Votação</a></li>
                <li><a class="hover:text-black" href="candidatar.php">Candidatar</a></li>
                <li><a class="hover:text-black" href="regulamento.html">Regulamento</a></li>
                <li><a class="hover:text-black" href="notificacao.html">Notificações</a></li>
            </ul>
            <a class="hover:text-black text-white text-xl absolute right-6" href="../../../index.php">Sair</a>
        </div>
    </nav>
    
    <main class="flex flex-col items-center justify-center my-auto py-10">
        <?php if ($temAlgoAberto): ?>
            <!-- Exibir informações quando há candidaturas ou votações abertas -->
            <div class="flex flex-col items-center gap-8 w-full max-w-4xl px-4">
                <?php if ($temVotacoesAbertas): ?>
                    <?php foreach ($votacoesAbertas as $votacao): ?>
                        <div class="flex flex-col border px-12 py-6 shadow-md w-full">
                            <h2 class="text-3xl font-bold mb-4 text-center">Votação em Andamento!</h2>
                            <p class="text-xl font-semibold mb-2 text-center">
                                Eleição para representante de sala do <?= htmlspecialchars($votacao['semestre']) ?>º Semestre / 
                                <?= htmlspecialchars($votacao['curso']) ?>
                            </p>
                            <p class="text-lg mb-4 text-center text-gray-600">
                                Disponível até: <?= date('d/m/Y', strtotime($votacao['dataFim'])) ?> 19:45
                            </p>
                            <a href="voto.html">
                                <button class="mx-auto w-full max-w-xs py-4 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" type="button">
                                    IR VOTAR
                                </button>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ($temCandidaturasAbertas): ?>
                    <?php foreach ($candidaturasAbertas as $candidatura): ?>
                        <div class="flex flex-col border px-12 py-6 shadow-md w-full">
                            <h2 class="text-3xl font-bold mb-4 text-center">Candidaturas Abertas!</h2>
                            <p class="text-xl font-semibold mb-2 text-center">
                                Candidatura para representante de sala do <?= htmlspecialchars($candidatura['semestre']) ?>º Semestre / 
                                <?= htmlspecialchars($candidatura['curso']) ?>
                            </p>
                            <p class="text-lg mb-4 text-center text-gray-600">
                                Disponível até: <?= date('d/m/Y', strtotime($candidatura['dataFim'])) ?> 19:45
                            </p>
                            <a href="candidatar.php">
                                <button class="mx-auto w-full max-w-xs py-4 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" type="button">
                                    CANDIDATAR-SE
                                </button>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Exibir mensagem quando não há nada aberto -->
            <div class="flex flex-col items-center">
                <h1 class="text-5xl font-bold mb-2">No momento nenhuma candidatura ou votação está aberta!</h1>
                <p class="text-xl font-medium mb-7 text-gray-500">(Você receberá uma notificacão assim que algo estiver disponivel)</p>
                <button class="mx-auto w-max p-3 rounded-lg bg-white outline border-gray-300 text-xl font-semibold text-gray-300 mt-auto" type="button" disabled>NENHUMA AÇÃO DISPONIVEL</button>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-black flex justify-center items-center py-3 gap-4">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>
</body>
</html>

