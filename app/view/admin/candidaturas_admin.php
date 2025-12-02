<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone.png" type="image/png">
    <title>ELEJA - Candidatos</title>
    
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

<body class="flex flex-col min-h-screen font-sans bg-white text-black" onload="votar(), excluirCandidatura()">
    <nav class="flex flex-col bg-white max-h-max justify-between items-center">
        <div class="flex items-center w-full justify-between">
            <a href="home_admin.php"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center h-12 bg-[#b20000]">
            <ul class="flex items-center gap-16 text-white text-xl">
                <li><a class="hover:text-black" href="home_admin.php">Início</a></li>
                <li><a class="hover:text-black" href="votacao_admin.php">Votações</a></li>
                <li><a class="hover:text-black" href="candidaturas_admin.php">Eleições</a></li>
                <li><a class="hover:text-black" href="regulamento_admin.html">Regulamento</a></li>
            </ul>
            <a class="hover:text-black text-white text-xl absolute right-6" href="../../../index.php">Sair</a>
        </div>
    </nav>
    
    <main class="flex flex-col items-center">
        <div class="w-full flex flex-row h-20 border-b border-gray-400 shadow-sm mb-8 items-center justify-around">
            <div class="flex relative items-center">
                <input class="min-w-[500px] px-4 py-2 border border-gray-400 rounded-3xl" placeholder="Buscar Eleições" type="text" id="filtro" name="filtro">
                <button class="absolute right-3 flex items-center pointer-events-none"><img class="w-7" src="../../../assets/lupa.png" alt="filtro"></button>
            </div>
            <button class="absolute right-6 criarCandidatura w-max p-2 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" data-modal="modal-formulario" type="button">CRIAR ELEIÇÃO</button>
        </div>

        <div class="flex flex-col w-full min-h-max border-gray-400 justify-center mb-8">

            <h2 class="m-auto text-3xl font-bold mb-5">Eleições</h2>
            <?php
            require_once __DIR__ . '/../../controller/EleicaoController.php';
            $eleicaoController = new EleicaoController();
            $candidaturas = $eleicaoController->listarCandidaturas();
            foreach ($candidaturas as $candidatura):
            ?>
            <div id="candidatura-<?= $candidatura['ideleicao'] ?>" class="flex flex-col border px-12 py-6 shadow-md mb-10 w-full md:max-w-[1000px] mx-auto min-h-[200px]">
                <h2 class="text-2xl md:text-xl md:text-center font-semibold mb-1">Eleição para representante de sala do <?= htmlspecialchars($candidatura['semestre']) ?>º Semestre / 
            <?= htmlspecialchars($candidatura['curso']) ?></h2>
                <p class="mx-auto mb-8">Disponível até: <?= date('d/m/Y', strtotime($candidatura['dataFimCandidatura'])) ?> 19:45</p>
                <div class="flex">
                    <button data-ideleicao="<?= htmlspecialchars($candidatura['ideleicao']) ?>" class="excluirCandidatura mx-auto w-max p-3 rounded-lg bg-white outline border-gray-300 md:text-base text-xl font-semibold text-gray-300 mt-auto" type="button">EXCLUIR ELEIÇÃO</button>
                    <button  data-ideleicao="<?= htmlspecialchars($candidatura['ideleicao']) ?>" class="votar mx-auto w-max p-3 rounded-lg bg-[#b20000] hover:bg-red-600 md:text-base text-xl font-semibold text-white mt-auto" data-modal="modal-candidatos" type="button">VIZUALIZAR ELEIÇÃO</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-black flex justify-center mt-auto items-center py-3 gap-4">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>

    <dialog id="modal-formulario" class="min-w-[50%]">
        <div class="flex flex-col p-5 gap-6 max-w-[900px]">
            <div class="flex">
                <h2 class="mx-auto text-3xl font-bold">Criar eleição</h2>
                <button class="absolute right-8 cancelar w-8 bg-[#b20000] rounded-md" data-modal="modal-formulario"><img class="h-8 mx-auto" src="../../../assets/cancelar.png" alt="botão cancelar"></button>
            </div>

            <div class="flex gap-4 overflow-x-auto pl-4 pr-4 scroll-pl-4 snap-x">
                <form action="../../../roteador.php?controller=Eleicao&acao=cadastrar" class="flex flex-col w-full" method="post">

                    <label for="curso" class="block mb-1">Curso:</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded mb-4" name="curso">
                        <option value="Desenvolvimento de Software Multiplataforma">Desenvolvimento de Software Multiplataforma</option>
                        <option value="Gestão de Produção Industrial">Gestão de Produção Industrial</option>
                        <option value="Gestão Empresarial">Gestão Empresarial</option>
                    </select>

                    <label for="semestre" class="block mb-1">Semestre:</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded mb-4" name="semestre">
                        <option value="1">1º Semestre</option>
                        <option value="2">2º Semestre</option>
                        <option value="3">3º Semestre</option>
                        <option value="4">4º Semestre</option>
                        <option value="5">5º Semestre</option>
                        <option value="6">6º Semestre</option>
                    </select>

                    <label for="dataInicioCandidatura" class="text-lg">Data de Início da eleição:</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded mb-4" name="dataInicioCandidatura" required>

                    <label for="dataFimCandidatura" class="text-lg">Data de Fechamento da eleição:</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded mb-4" name="dataFimCandidatura" required>

                    <label for="dataInicioVotacao" class="text-lg">Data de Início da votação:</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded mb-4" name="dataInicioVotacao" required>

                    <label for="dataFimVotacao" class="text-lg">Data de Fechamento da votação:</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded mb-4" name="dataFimVotacao" required>

                    <button type="submit" class=" mx-auto w-[16rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white">Criar</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="modal-candidatos">
        <div class="flex flex-col p-5 gap-6 max-w-[900px] min-w-[700px]">
            <div class="flex w-auto gap-16">
                <h2 class="mx-auto w-auto text-2xl font-bold">Alunos candidatos a representante de turma</h2>
                <button class="absolute right-4 cancelar w-8 bg-[#b20000] rounded-md" data-modal="modal-candidatos"><img class="h-8 mx-auto" src="../../../assets/cancelar.png" alt="botão cancelar"></button>
            </div>
            <div class="flex gap-4 overflow-x-auto pb-3 pl-4 pr-4 scroll-pl-4 snap-x">
                <div id="listaCandidatos" class="flex m-auto gap-2">
                </div>
            </div>
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
</body>
</html>
