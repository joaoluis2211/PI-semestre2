<?php
require_once __DIR__ . '/../../model/Usuario.php'; // 
session_start();
$usuario = $_SESSION['user'];
if ($usuario->getTipo() != 'administrador') {
    header("Location: ../../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone.png" type="image/png">
    <title>ELEJA - Votações</title>
    
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

<body class="flex flex-col font-sans bg-white text-black min-h-screen" onload="excluirVotacao(), votar(), resultado()">
    <nav class="flex flex-col bg-white max-h-max justify-between items-center">
        <div class="flex items-center w-full justify-between">
            <a href="home_admin.php"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center h-12 bg-[#b20000]">
            <ul class="flex items-center gap-16 text-white text-xl">
                <li><a class="hover:text-black" href="home_admin.php">Início</a></li>
                <li><a class="hover:text-black" href="candidaturas_admin.php">Eleições</a></li>
                <li><a class="hover:text-black" href="votacao_admin.php">Votações</a></li>
                <li><a class="hover:text-black" href="regulamento_admin.html">Regulamento</a></li>
            </ul>
            <a class="hover:text-black text-white text-xl absolute right-6" href="../../../index.php">Sair</a>
        </div>
    </nav>  
    
    <main class="flex flex-col items-center pb-16">
        <div class="w-full flex flex-row h-20 border-b border-gray-400 shadow-sm mb-8 items-center justify-center">
              <h1 class="text-3xl font-bold">Votações</h1>
        </div>
        <?php
        require_once __DIR__ . '/../../controller/EleicaoController.php';
        $eleicaoController = new EleicaoController();
        $votacoes = $eleicaoController->listarVotacoes();
        foreach ($votacoes as $votacao):
            if ($votacao['status'] == 'VOTACAO'):
        ?>
        <div class="grid gap-6 grid-flow-row w-full justify-center">

            <div id="votacao-<?= $votacao['ideleicao'] ?>" class="border px-12 py-6 shadow-md">
                <h2 class="text-xl font-semibold max-w-[52rem]">Eleição para representante de sala do <?= htmlspecialchars($votacao['semestre']) ?>º Semestre / 
            <?= htmlspecialchars($votacao['curso']) ?></h2>
                <div class="flex justify-between items-center">
                    <div class="flex flex-col gap-1 mt-1">
                        <p>Situação: <?= htmlspecialchars($votacao['status']) ?></p>
                        <p>Data de inicio: <?= date('d/m/Y', strtotime($votacao['dataInicioVotacao'])) ?></p>
                        <p>Data de Encerramento: <?= date('d/m/Y', strtotime($votacao['dataFimVotacao'])) ?></p>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <button data-tipo="<?= htmlspecialchars($votacao['status']) ?>" data-ideleicao="<?= htmlspecialchars($votacao['ideleicao']) ?>" class="votar w-[14rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" data-modal="modal-candidatos" type="button">VIZUALIZAR</button>
                    </div>
                </div>
            </div>
        <?php endif;
            if ($votacao['status'] == 'ENCERRADA'):
        ?>
            <div class="border px-12 py-4 shadow-md">
                <h2 class="text-xl font-semibold">Eleição para representante de sala do <?= htmlspecialchars($votacao['semestre']) ?>º Semestre / 
            <?= htmlspecialchars($votacao['curso']) ?></h2>
                <div class="flex justify-between gap-16 items-center">
                    <div>
                        <p>Situação: <?= htmlspecialchars($votacao['status']) ?></p>
                        <p>Data de inicio: <?= date('d/m/Y', strtotime($votacao['dataInicioVotacao'])) ?></p>
                        <p>Data de Encerramento: <?= date('d/m/Y', strtotime($votacao['dataFimVotacao'])) ?></p>
                    </div>
                    <div>
                        <button data-tipo="<?= htmlspecialchars($usuario->getTipo()) ?>" data-idturma="<?= htmlspecialchars($votacao['idturma']) ?>" data-ideleicao="<?= htmlspecialchars($votacao['ideleicao']) ?>" class="resultado w-[14rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" type="button">VER RESULTADO</button>
                    </div>
                </div>
            </div>

            <?php endif;
            endforeach; ?>

        </div>
    </main>

    <footer class="bg-black flex justify-center items-center py-3 mt-auto gap-4">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>

    <dialog id="modal-candidatos">
        <div class="flex flex-col p-5 gap-6 max-w-[900px] min-w-[400px]">
            <div class="flex">
                <h2 class="mx-auto text-2xl font-bold">Votação em andamento</h2>
                <button class="absolute right-4 cancelar w-8 bg-[#b20000] rounded-md" data-modal="modal-candidatos"><img class="h-8 mx-auto" src="../../../assets/cancelar.png" alt="botão cancelar"></button>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-3 pl-4 pr-4 scroll-pl-4 snap-x">

                <div id="listaCandidatos" class="flex m-auto gap-4">
                </div>

            </div>
        </div>
    </dialog>
    <script src="../../../public/js/script.js"></script>
</body>
</html>