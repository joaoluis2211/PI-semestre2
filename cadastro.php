<?php
session_start();
if (isset($_SESSION['erro_cadastro'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">' . $_SESSION['erro_cadastro'] . '</div>';
    unset($_SESSION['erro_cadastro']);
}
if (isset($_SESSION['sucesso_cadastro'])) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">' . $_SESSION['sucesso_cadastro'] . '</div>';
    unset($_SESSION['sucesso_cadastro']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="assets/icone.png" type="image/png">
  <title>ELEJA - Cadastro</title>

  <!-- Fonte Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Configuração da fonte no Tailwind -->
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
        <img src="assets/logo-sem-fundo.png" alt="Logo do sistema Eleja" class="mx-auto w-40" />
      </header>

      <form action="processa_cadastro.php" method="post" class="text-left border px-8 py-6 rounded-lg shadow-md space-y-4">
        <h1 class="text-2xl font-semibold mb-4 text-center">Cadastre-se para votar</h1>

        <label for="nome" class="block mb-1">Nome completo</label>
        <input type="text" id="nome" name="nome" required
          class="w-full px-4 py-2 border border-gray-300 rounded mb-2" />

        <label for="curso" class="block mb-1">Curso</label>
        <select class="w-full px-4 py-3 border border-gray-300 rounded mb-4" name="curso" id="curso">
            <option value="desenvolvimento de software multiplataforma">Desenvolvimento de Software Multiplataforma</option>
            <option value="gestao de producao industrial">Gestão de Produção Industrial</option>
            <option value="gestao empresarial">Gestão Empresarial</option>
        </select>

        <label for="periodo" class="block mb-1">Turma</label>
        <select class="w-full px-4 py-3 border border-gray-300 rounded mb-4" name="periodo" id="periodo">
            <option value="primeiro semestre">Primeiro semestre</option>
            <option value="segundo semestre">Segundo semestre</option>
            <option value="terceiro semestre">Terceiro semestre</option>
            <option value="quarto semestre">Quarto semestre</option>
            <option value="quinto semestre">Quinto semestre</option>
            <option value="sexto semestre">Sexto semestre</option>
        </select>

        <label for="email" class="block mb-1">E-mail(constitucional)</label>
        <input type="email" id="email" name="email" required
          class="w-full px-4 py-2 border border-gray-300 rounded mb-2" />

        <label for="senha" class="block mb-1">Senha</label>
        <input type="password" id="senha" name="senha" required
          class="w-full px-4 py-2 border border-gray-300 rounded mb-4" />

        <button type="submit"
          class="w-full bg-[#b20000] hover:bg-red-500 text-white font-semibold py-3 rounded">CADASTRAR-SE</button>

        <a href="login.php" class="block mt-4 text-center text-sm font-semibold text-[#091113] hover:underline">Já tem conta? Faça login</a>
      </form>

      <footer class="mt-6">
        <p class="text-sm text-gray-600">Sistema de Votação Escolar</p>
      </footer>
    </section>
  </main>
</body>
</html>
