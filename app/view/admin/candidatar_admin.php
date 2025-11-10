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

<body class="flex flex-col min-h-screen font-sans bg-white text-black" onload="excluirCandidatura()">
    <nav class="flex flex-col bg-white max-h-max justify-between items-center">
        <div class="flex items-center w-full justify-between">
            <a href="home_admin.html"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center h-12 bg-[#b20000]">
            <ul class="flex items-center gap-16 text-white text-xl">
                <li><a class="hover:text-black" href="home_admin.html">Início</a></li>
                <li><a class="hover:text-black" href="voto_admin.html">Votação</a></li>
                <li><a class="hover:text-black" href="candidatar_admin.php">Candidatar</a></li>
                <li><a class="hover:text-black" href="regulamento_admin.html">Regulamento</a></li>
                <li><a class="hover:text-black" href="notificacao_admin.html">Notificações</a></li>
            </ul>
            <a class="hover:text-black text-white text-xl absolute right-6" href="../../../index.html">Sair</a>
        </div>
    </nav>
    
    <main class="flex flex-col items-center">
        <div class="w-full flex flex-row h-20 border-b border-gray-400 shadow-sm mb-8 items-center justify-around">
            <div class="flex relative items-center">
                <input class="min-w-[500px] px-4 py-2 border border-gray-400 rounded-3xl" placeholder="Buscar Candidatura" type="text" id="filtro" name="filtro">
                <button class="absolute right-3 flex items-center pointer-events-none"><img class="w-7" src="../../../assets/lupa.png" alt="filtro"></button>
            </div>
            <button class="absolute right-6 criarCandidatura w-max p-2 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white" data-modal="modal-formulario" type="button">CRIAR CANDIDATURA</button>
        </div>

        <div class="flex flex-col w-full min-h-max border-gray-400 justify-center mb-8">

            <h2 class="m-auto text-3xl font-bold mb-5">Candidaturas</h2>
            <?php
            require_once __DIR__ . '/../../controller/CandidaturaController.php';
            $candidaturaController = new CandidaturaController();
            $candidaturas = $candidaturaController->listarCandidaturas();
            foreach ($candidaturas as $candidatura):
            ?>
            <div class="flex flex-col border px-12 py-6 shadow-md mb-10 w-max mx-auto min-h-[200px]">
                <h2 class="text-2xl font-semibold mb-1">Candidatura para representante de sala do <?= htmlspecialchars($candidatura['semestre']) ?>º Semestre / 
            <?= htmlspecialchars($candidatura['curso']) ?></h2>
                <p class="mx-auto mb-8">Disponível até: <?= date('d/m/Y', strtotime($candidatura['dataFim'])) ?> 19:45</p>
                <div class="flex">
                    <button id="excluirCandidatura" class="mx-auto w-max p-3 rounded-lg bg-white outline border-gray-300 text-xl font-semibold text-gray-300 mt-auto" type="button">EXCLUIR CANDIDATURA</button>
                    <button  class="votar mx-auto w-max p-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white mt-auto" data-modal="modal-candidatos" type="button">VIZUALIZAR CANDIDATURA</button>
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
                <h2 class="mx-auto text-3xl font-bold">Criar candidatura</h2>
                <button class="absolute right-8 cancelar w-8 bg-[#b20000] rounded-md" data-modal="modal-formulario"><img class="h-8 mx-auto" src="../../../assets/cancelar.png" alt="botão cancelar"></button>
            </div>

            <div class="flex gap-4 overflow-x-auto pl-4 pr-4 scroll-pl-4 snap-x">
                <form action="../../../roteador.php?controller=Candidatura&acao=cadastrar" class="flex flex-col w-full" method="post">

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

                    <label for="dataInicio" class="text-lg">Data de Início:</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded mb-4" name="dataInicio" required>

                    <label for="dataFim" class="text-lg">Data de Fechamento:</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded mb-4" name="dataFim" required>
                    <button type="submit" class=" mx-auto w-[16rem] py-3 rounded-lg bg-[#b20000] hover:bg-red-600 text-xl font-semibold text-white">Criar</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="modal-candidatos">
        <div class="flex flex-col p-5 gap-6 max-w-[900px]">
            <div class="flex">
                <h2 class="mx-auto text-2xl font-bold">Alunos candidatos a representante de turma</h2>
                <button class="absolute right-4 cancelar w-8 bg-[#b20000] rounded-md" data-modal="modal-candidatos"><img class="h-8 mx-auto" src="../../../assets/cancelar.png" alt="botão cancelar"></button>
            </div>
            <?php
            //require_once __DIR__ . '/../../controller/CandidatoController.php';
            //$candidatoController = new CandidatoController();
            //$candidatos = $candidatoController->listarCandidatos($idcandidatura);
            //foreach ($candidatos as $candidato):
            ?>
            <div class="flex gap-4 overflow-x-auto pb-3 pl-4 pr-4 scroll-pl-4 snap-x">

                <div class="flex flex-col items-center gap-2 border-2 py-4 rounded-md w-56 snap-start shrink-0">
                    <img class="w-40" src="../../../assets/user.png" alt="">
                    <!--<p class="text-lg font-semibold"><?= htmlspecialchars($candidato['nome']) ?></p>-->
                </div>

                <div class="flex flex-col items-center gap-2 border-2 py-4 rounded-md w-56 snap-start shrink-0">
                    <img class="w-40" src="../../../assets/user.png" alt="">
                    <p class="text-lg font-semibold">Nome Completo</p>
                </div>

                <div class="flex flex-col items-center gap-2 border-2 py-4 rounded-md w-56 snap-start shrink-0">
                    <img class="w-40" src="../../../assets/user.png" alt="">
                    <p class="text-lg font-semibold">Nome Completo</p>
                </div>

                <div class="flex flex-col items-center gap-2 border-2 py-4 rounded-md w-56 snap-start shrink-0">
                    <img class="w-40" src="../../../assets/user.png" alt="">
                    <p class="text-lg font-semibold">Nome Completo</p>
                </div>

            </div>
          <?php //endforeach; ?>
        </div>
    </dialog>

    <script src="../../../public/js/script.js"></script>
</body>
</html>
