<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../assets/icone.png" type="image/png">
    <title>ELEJA - Resultado</title>
    
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
<?php
require_once __DIR__ . '/../../controller/EleicaoController.php';
$ideleicao = isset($_GET['ideleicao']) ? (int)$_GET['ideleicao'] : 0;
$idturma = isset($_GET['idturma']) ? (int)$_GET['idturma'] : 0;
$eleicaoController = new EleicaoController();
$candidatos = $eleicaoController->candidatosPorVotos($ideleicao);
?>
<body class="font-sans bg-white text-black">
    <nav class="flex flex-col bg-white max-h-max justify-between items-center">
        <div class="flex items-center w-full justify-between">
            <a href="home.php"><img class="max-w-48" src="../../../assets/logo-fatec.png" alt="logo fatec"></a>
            <img src="../../../assets/logo-cps.png" class="max-w-48" alt="logo cps">
        </div>
        <div class="flex w-full justify-center items-center py-3 bg-[#b20000]">
            <h1 class="text-3xl text-white font-bold">Resultado</h1>
        </div>
    </nav>
    
    <main class="flex flex-col items-center pb-8 bg-white">
        <div class="relative flex min-w-full border-b border-gray-400 pb-8">
            <div class="absolute top-[8%] ml-4">
            <a href="votacao.php"><img class="max-w-12" src="../../../assets/voltar.png" alt="voltar"></a>
            </div>
            <div class="flex flex-col mx-auto pt-8 items-center gap-4">
                <h2 class="text-2xl font-bold">ELEITOS</h2>
                <div class="flex items-end">
                <!-- REPRESENTANTE (1º lugar) -->
                <div class="flex flex-col items-center p-3">
                    <img class="w-[200px] h-[200px] rounded-full object-cover shadow-lg border-4 border-gray-300" 
                        src="<?= "../../../uploads/candidatos/" . htmlspecialchars($candidatos[0]['imagem']) ?>" 
                        onerror="this.src='../../../assets/user.png'" 
                        alt="representante">
                    <h2 class="text-xl font-semibold">Representante</h2>
                    <p class="text-md"><?= htmlspecialchars($candidatos[0]['nome']) ?></p>
                    <p class="text-md"><?= htmlspecialchars($candidatos[0]['qtdVotos']) ?> votos</p>
                </div>

                <!-- VICE REPRESENTANTE (2º lugar) -->
                <div class="flex flex-col items-center p-3">
                    <img class="w-[150px] h-[150px] rounded-full object-cover shadow-lg border-4 border-gray-300" 
                        src="<?= "../../../uploads/candidatos/" . htmlspecialchars($candidatos[1]['imagem']) ?>" 
                        onerror="this.src='../../../assets/user.png'" 
                        alt="vice representante">
                    <h2 class="text-xl font-semibold">Vice-representante</h2>
                    <p class="text-md"><?= htmlspecialchars($candidatos[1]['nome']) ?></p>
                    <p class="text-md"><?= htmlspecialchars($candidatos[1]['qtdVotos']) ?> votos</p>
                </div>
            </div>
            </div>
        </div>
        <div class="flex flex-col py-8 items-center gap-8">
            <h2 class="text-2xl font-bold">LISTA DE ALUNOS</h2>
            <div class="grid gap-x-4 gap-y-2">
            <?php
            $alunos = $eleicaoController->listarAlunosVotacao($ideleicao);
            foreach ($alunos as $aluno):
            ?>
                <div class="flex min-w-full gap-24 items-center border border-gray-300 p-6 rounded-xl">
                    <div class="flex justify-between flex-1 gap-2">
                        <p class="text-base min-w-[200px] "><?= htmlspecialchars($aluno['nome']) ?></p>
                        <p class="text-base min-w-[200px] text-center"><?= htmlspecialchars($aluno['semestre']) ?> período</p>
                        <p class="text-base min-w-[200px] "><?= htmlspecialchars($aluno['curso']) ?></p>
                    </div>
                </div>
        <?php endforeach; ?>
                
            </div>
        </div>
    </main>

    <footer class="bg-black flex justify-center items-center py-3 gap-4 mt-auto">
        <img class="max-w-[150px]" src="../../../assets/logo-sem-fundo-branca.png" alt="logo ELEJA">
        <p class="text-white text-base pt-2">&copy; Todos os direitos reservados ao grupo <b>ELEJA.</b></p>
    </footer>

</body>
</html>