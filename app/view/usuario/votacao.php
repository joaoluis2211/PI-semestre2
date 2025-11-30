<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone.png" type="image/png">
    <title>ELEJA - Voto</title>
    
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

<body class="flex flex-col font-sans min-h-screen bg-white text-black">
    <nav class="flex flex-col bg-white max-h-max justify-between items-center">
        <div class="flex items-center w-full justify-between">
            <a href="home.php"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center h-12 bg-[#b20000]">
            <ul class="flex items-center gap-16 text-white text-xl">
                <li><a class="hover:text-black" href="home.php">Início</a></li>
                <li><a class="hover:text-black" href="votacao.php">Votações</a></li>
                <li><a class="hover:text-black" href="candidaturas.php">Eleições</a></li>
                <li><a class="hover:text-black" href="regulamento.html">Regulamento</a></li>
            </ul>
            <a class="hover:text-black text-white text-xl absolute right-6" href="../../../index.php">Sair</a>
        </div>
    </nav>

    <div class="w-full flex h-20 border-b border-gray-400 shadow-sm items-center justify-center">
       <h1 class="text-3xl font-bold">VOTAÇÕES</h1>
    </div>
    
    <main class="flex flex-col items-center py-[50px]">

        <?php
        require_once __DIR__ . '/../../controller/EleicaoController.php';
        require_once __DIR__ . '/../../controller/VotoController.php';
        require_once __DIR__ . '/../../controller/AlunoController.php';
        require_once __DIR__ . '/../../model/Usuario.php';
        session_start();
        $usuario = $_SESSION['user'];

        $eleicaoController = new EleicaoController();
        $alunoController = new AlunoController();
        $votoController = new VotoController();
        $aluno = $alunoController->getAluno($usuario->getIdaluno());
        $idturma = $aluno->getIdturma();
        $votacoes = $eleicaoController->listarVotacoesAbertasPorTurma($idturma);
        $encerradas = $eleicaoController->listarVotacoesEncerradasPorTurma($idturma);
        foreach ($votacoes as $votacao):
            $jaVotou = $votoController->verificarJaVotou($aluno->getIdaluno(), $votacao['ideleicao']);
        ?>

        <div class="grid gap-6 grid-flow-row w-max justify-center">
            <div class="border px-12 py-6 shadow-md">
                <h2 class="text-xl font-semibold">Eleição para representante de sala do <?= htmlspecialchars($votacao['semestre']) ?>º Semestre / 
                <?= htmlspecialchars($votacao['curso']) ?></h2>
                <div class="flex justify-between items-center">
                    <div class="flex flex-col gap-1 mt-1">
                        <p>Situação: <?= htmlspecialchars($votacao['status']) ?></p>
                        <p>Data de inicio: <?= date('d/m/Y', strtotime($votacao['dataInicioVotacao'])) ?></p>
                        <p>Data de Encerramento: <?= date('d/m/Y', strtotime($votacao['dataFimVotacao'])) ?></p>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <?php if ($jaVotou): ?>
                        <button 
                            disabled
                            class="w-[14rem] py-3 rounded-lg bg-gray-400 text-xl font-semibold text-white cursor-not-allowed opacity-70">
                            JÁ VOTOU
                        </button>
                        <?php else: ?>
                            <button 
                                data-tipo="VOTAR" 
                                data-ideleicao="<?= htmlspecialchars($votacao['ideleicao']) ?>" 
                                class="votar w-[14rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" 
                                data-modal="modal-candidatos" 
                                type="button">
                                VOTAR
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach;
        foreach ($encerradas as $encerrada):
        ?>
        <div class="border px-12 py-4 shadow-md">
                <h2 class="text-xl font-semibold">Eleição para representante de sala do <?= htmlspecialchars($encerrada['semestre']) ?>º Semestre / 
            <?= htmlspecialchars($encerrada['curso']) ?></h2>
                <div class="flex justify-between gap-16 items-center">
                    <div>
                        <p>Situação: <?= htmlspecialchars($encerrada['status']) ?></p>
                        <p>Data de inicio: <?= date('d/m/Y', strtotime($encerrada['dataInicioVotacao'])) ?></p>
                        <p>Data de Encerramento: <?= date('d/m/Y', strtotime($encerrada['dataFimVotacao'])) ?></p>
                    </div>
                    <div>
                        <button data-tipo="<?= htmlspecialchars($usuario->getTipo()) ?>" data-idturma="<?= htmlspecialchars($encerrada['idturma']) ?>" data-ideleicao="<?= htmlspecialchars($encerrada['ideleicao']) ?>" class="resultado w-[14rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" type="button">VER RESULTADO</button>
                    </div>
                </div>
        </div>
        <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-black flex justify-center items-center py-3 gap-4 mt-auto">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>

    <dialog id="modal-candidatos">
        <div class="flex flex-col p-5 gap-6 max-w-[1200px] min-w-[600px]">
            <div class="flex">
                <h2 class="mx-auto text-2xl font-bold">Selecione seu representante de turma</h2>
                <button class="absolute right-4 cancelar w-8 bg-[#b20000] rounded-md" data-modal="modal-candidatos"><img class="h-8 mx-auto" src="../../../assets/cancelar.png" alt="botão cancelar"></button>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-3 pl-4 pr-4 scroll-pl-4 snap-x">

                <div id="listaCandidatos" class="flex m-auto gap-4"></div>

            </div>
            <button data-idaluno="<?= htmlspecialchars($usuario->getIdaluno()) ?>" data-modal="modal-candidatos" class="confirmarVoto mx-auto w-[16rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" type="button">VOTAR</button>
        </div>
    </dialog>

    <div id="modalConfirmacao" style="display:none; position:fixed; top:0; left:0;
        width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:10px; text-align:center;">
            <p id="mensagemModal"></p>
            <button onclick="fecharModal()">OK</button>
        </div>
    </div>

    <script src="../../../public/js/script.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        votar();
        confirmarVoto();
        resultado();
    });
</script>
</body>
</html>