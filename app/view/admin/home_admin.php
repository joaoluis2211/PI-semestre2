<?php
require_once __DIR__ . '/../../controller/EleicaoController.php';
session_start();


$eleicaoController = new EleicaoController();
$candidaturas = $eleicaoController->listarCandidaturas();
$dataAtual = date('Y-m-d');
foreach ($candidaturas as $candidatura){
    if ($candidatura['dataFimCandidatura'] < $dataAtual) {
        $eleicaoController->abrirVotacao($candidatura['ideleicao']);
    }
    if ($candidatura['dataFimVotacao'] < $dataAtual) {
        $eleicaoController->encerrarVotacao($candidatura['ideleicao']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone.png" type="image/png">
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
            <a href="home_admin.php"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center h-12 bg-[#b20000]">
            <ul class="flex items-center gap-16 text-white text-xl">
                <li><a class="hover:text-black" href="home_admin.php">Início</a></li>
                <li><a class="hover:text-black" href="votacao_admin.php">Votações</a></li>
                <li><a class="hover:text-black" href="candidaturas_admin.php">Eleições</a></li>
                <li><a class="hover:text-black" href="regulamento_admin.html">Regulamento</a></li>
                <li><a class="hover:text-black" href="notificacao_admin.html">Notificações</a></li>
            </ul>
            <a class="hover:text-black text-white text-xl absolute right-6" href="../../../index.php">Sair</a>
        </div>
    </nav>
    
    <main class="flex flex-col items-center justify-between my-auto">
        <img class="w-[100px] md:w-[80px] md:mb-8 mb-12" src="../../../assets/team-management.png" alt="">
        <P class="text-5xl md:text-3xl font-semibold mb-4">Bem-vindo ao painel de controle</P>
        <div class="flex flex-col md:flex-row items-center justify-center gap-6 mt-6">
            <a href="candidaturas_admin.php"><button class="w-[20rem] md:w-[18rem] p-3 rounded-lg bg-[#b20000] hover:bg-[#a00000] text-xl md:text-base font-semibold text-white" type="button">GERENCIAR ELEIÇÕES</button></a>
            <a href="votacao_admin.php"><button class="w-[20rem] md:w-[18rem] p-3 rounded-lg bg-[#b20000] hover:bg-[#a00000] text-xl md:text-base font-semibold text-white" type="button">GERENCIAR VOTAÇÕES</button></a>
        </div>
    </main>

    <footer class="bg-black flex justify-center items-center py-3 gap-4">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>
</body>
</html>