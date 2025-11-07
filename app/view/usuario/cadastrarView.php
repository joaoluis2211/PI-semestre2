<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="assets/icone.png" type="image/png">
  <title>ELEJA - Cadastro</title>

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
        },
      },
    }
  </script>
</head>

<body class="font-sans bg-gray-200 text-black">
  <main class="min-h-screen flex items-center justify-center">
    <section class="bg-white px-10 py-6 rounded-lg border-2 shadow-xl w-full max-w-xl text-center">
      <header class="mb-4">
        <img src="../../../assets/logo-sem-fundo.png" alt="Logo do sistema Eleja" class="mx-auto w-40" />
      </header>

      <form action="../../../roteador.php?controller=Usuario&acao=cadastrar" method="post" class="text-left border px-8 py-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4 text-center">Cadastrar</h1>
        <?php
        session_start();
          if (isset($_SESSION['erro'])) {
              echo '<p class="text-red-500 mb-4">' . htmlspecialchars($_SESSION['erro']) . '</p>';
              unset($_SESSION['erro']);
          }
          ?>
        <label for="nome" class="block mb-1">Nome:</label>
        <input type="text" id="nome" name="nome" required
          class="w-full px-4 py-2 border border-gray-300 rounded mb-4" />

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
        
        <label for="email" class="block mb-1">Email:</label>
        <input type="email" id="email" name="email" required
          class="w-full px-4 py-2 border border-gray-300 rounded mb-4" />
        
        <label for="senha" class="block mb-1">Senha</label>
        <input type="password" id="senha" name="senha" required
          class="w-full px-4 py-2 border border-gray-300 rounded mb-4" />

        <button type="submit" class="w-full bg-[#b20000] hover:bg-red-500 text-white font-semibold py-3 rounded mb-4">CADASTRAR</button>
        <div class="text-sm text-center pt-2">
            <p class="text-gray-600">Já tem uma conta? <a href="/PI-semestre1/index.php" class="text-sm font-semibold text-[#b20000] hover:underline">Faça Login</a></p>
        </div>
      </form>

      <footer class="mt-6">
        <p class="text-sm text-gray-600">Sistema de Votação Escolar</p>
      </footer>
    </section>
  </main>
  <script src="/PI-semestre1/public/js/script.js"></script>
</body>
</html>