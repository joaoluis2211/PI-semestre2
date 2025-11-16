<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone.png" type="image/png">
    <title>ELEJA - Candidatar</title>
    
    <!-- Importando a fonte Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAleart2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<body class="flex flex-col min-h-screen font-sans bg-white text-black" onload="candidatar()">
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
            <a class="hover:text-black text-white text-xl absolute right-6" href="../index.html">Sair</a>
        </div>
    </nav>

    <div class="w-full flex h-20 border-b border-gray-400 shadow-sm items-center justify-center">
        <div class="flex relative items-center">
            <h1 class="text-3xl font-bold">CANDIDATURAS</h1>
        </div>
    </div>
    
    <main class="flex flex-col h-auto items-center mb-auto py-14">
        
        <div class="flex flex-col w-full min-h-max border-gray-400 justify-center mb-8">

            <?php
            require_once __DIR__ . '/../../controller/CandidaturaController.php';
            require_once __DIR__ . '/../../controller/CandidatoController.php';
            require_once __DIR__ . '/../../controller/AlunoController.php';
            require_once __DIR__ . '/../../model/Usuario.php';
            session_start();
            $usuario = $_SESSION['user'];

            $candidaturaController = new CandidaturaController();
            $candidaturas = $candidaturaController->listarCandidaturas();
            $alunoController = new AlunoController();
            $candidatoController = new CandidatoController();
            $aluno = $alunoController->getAluno($usuario->getIdaluno());
            $idturma = $aluno->getIdturma();
            foreach ($candidaturas as $candidatura):
                if ($candidatura['idturma'] == $idturma):
                    $jaCandidatado = $candidatoController->verificarCandidaturaExistente($aluno->getIdaluno(), $candidatura['idcandidatura']);
            ?>
            <div class="flex flex-col border px-12 py-6 shadow-md mb-10 w-max mx-auto min-h-[200px]">
                <h2 class="text-2xl font-semibold mb-1">Candidatura para representante de sala do <?= htmlspecialchars($candidatura['semestre']) ?>º Semestre / 
            <?= htmlspecialchars($candidatura['curso']) ?></h2>
                <p class="mx-auto mb-4">Disponível até: <?= date('d/m/Y', strtotime($candidatura['dataFim'])) ?> 19:45</p>
                <button id="btnCandidatar"
                    data-aluno="<?= htmlspecialchars($aluno->getIdaluno()) ?>"
                    data-candidatura="<?= htmlspecialchars($candidatura['idcandidatura']) ?>"
                    data-candidatado=<?= $jaCandidatado ? 'true' : 'false'?>
                    class="mx-auto w-[14rem] py-4 rounded-lg text-xl font-semibold text-white mt-auto
                    <?= $jaCandidatado ? 'bg-gray-600 hover:bg-gray-700' : 'bg-[#b20000] hover:bg-red-600' ?>"
                    type="button"><?= $jaCandidatado ? 'REMOVER CANDIDATURA' : 'CANDIDATAR-SE'?></button>
            </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>

    </main>

    <footer class="bg-black flex justify-center items-center py-3 gap-4">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>

    <div id="modalConfirmacao" style="display:none; position:fixed; top:0; left:0;
        width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:10px; text-align:center;">
            <p id="mensagemModal"></p>
            <button onclick="fecharModal()">OK</button>
        </div>
    </div>
    <script src="../../../public/js/script.js"></script>
</body>
</html>