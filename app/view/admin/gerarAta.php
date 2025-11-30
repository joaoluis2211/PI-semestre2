<?php
require_once __DIR__ . '/../../controller/EleicaoController.php';
require_once __DIR__ . '/../../controller/TurmaController.php';
require_once __DIR__ . '/../../controller/AlunoController.php';
require_once __DIR__ . '/../../controller/AtaController.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function embedImageDataUri(string $path) : string {
    if (!file_exists($path)) return '';
    $info = getimagesize($path);
    if ($info === false) return '';
    $mime = $info['mime'];
    $data = base64_encode(file_get_contents($path));
    return "data:$mime;base64,$data";
}

$ideleicao = $_GET['ideleicao'];
$idturma = $_GET['idturma'];

$ataController = new AtaController();
$turmaController = new TurmaController();
$turma = $turmaController->procurarTurma($idturma);
$ata = $ataController->obterAta($ideleicao, $idturma);

$representante = $ata['representante'];
$vice = $ata['vice'];
$dataAta = $ata['data'];

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
$dataExtenso = strftime('%d de %B de %Y', strtotime($dataAta));

$curso = $turma->getCurso();
$curso = strtoupper($curso);

$controller = new EleicaoController();
// pega a lista completa dos alunos
$alunos = $controller->listarAlunosVotacao($ideleicao);
$alunoController = new AlunoController();
$alunosPorTurma = $alunoController->getAlunoPorTurma($idturma);
foreach ($alunosPorTurma as $alunoPorTurma) {
    // apenas os alunos da turma específica
    if ($alunoPorTurma['nome'] == $representante) {
        $raRepresentante = $alunoPorTurma['ra'];
    }
    if ($alunoPorTurma['nome'] == $vice) {
        $raVice = $alunoPorTurma['ra'];
    }
}

// paths das imagens (ajuste nomes se necessário)
$assetsDir = __DIR__ . '/../../../assets/';
$logoCPSFile = $assetsDir . 'logo-cps.png';            // você citou logo CPS
$logoGovFile = $assetsDir . 'logo-governo-sp.png';     // ajuste se o nome for diferente

$logoCPS = embedImageDataUri($logoCPSFile);
$logoGov = embedImageDataUri($logoGovFile);

// preparar dados (fallbacks seguros)
if ($ata && is_array($ata)) {
    $representante = $ata['representante'] ?? 'NÃO DEFINIDO';
    $vice = $ata['vice'] ?? 'NÃO DEFINIDO';
    $dataAta = $ata['data'] ?? date('Y-m-d');
    $curso_text = $ata['curso'] ?? '';       // se você salvou curso na ata
    $periodo_text = $ata['periodo'] ?? '';   // se você salvou periodo
} else {
    // se não houver ata, geramos um PDF informando isso (não deixaremos o navegador receber HTML antes do PDF)
    $representante = 'NÃO DEFINIDO';
    $vice = 'NÃO DEFINIDO';
    $dataAta = date('Y-m-d');
    $curso_text = '';
    $periodo_text = '';
}

// formata data por extenso (em português)
setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
$dataExtenso = strftime('%d de %B de %Y', strtotime($dataAta));

// --- monta HTML do PDF (estilizado para DOMPDF)
// Usamos fonts padrão (Times) e estilos que o dompdf interpreta bem
$html = '
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<style>
  @page { margin: 40px 40px; }
  body { font-family: "Times New Roman", "serif"; font-size: 13px; color: #000; line-height: 1.4; }
  .header { width:100%; display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
  .header .left, .header .right { width:30%; }
  .header .center { width:40%; text-align:center; }
  .title { text-align:center; font-weight:700; font-size:16px; margin-top:6px; margin-bottom:6px; }
  .sub { text-align:center; font-size:12px; margin-bottom:12px; }
  .att-paragraph { text-align:justify; text-justify:inter-word; margin-top:10px; margin-bottom:10px; }
  .bold { font-weight:700; }
  .small { font-size:12px; }
  .table-sign { width:100%; border-collapse: collapse; margin-top:18px; page-break-inside: auto; }
  .table-sign th, .table-sign td { border: 1px solid #000; padding:6px; font-size:13px; text-align:left; vertical-align: middle; }
  .table-sign th { font-weight:700; text-align:center; }
  .signature-cell { height:50px; } /* espaço para assinatura */
  .footer { position: fixed; bottom: 20px; left: 40px; right: 40px; text-align:center; font-size:11px; }
  .logos { display:flex; justify-content:space-between; align-items:center; }
  .logo-img { max-height:70px; }
  .gov-logo { max-height:60px; }
</style>
</head>
<body>
  <table style="width:100%; margin-bottom:10px;">
    <tr>
        <!-- Logo do Governo -->
        <td style="width:25%; text-align:left; vertical-align:middle;">
            ' . ($logoGov ? '<img src="'.$logoGov.'" style="height:70px;">' : '') . '
        </td>

        <!-- Texto central -->
        <td style="width:50%; text-align:center; vertical-align:middle;">
            <div style="font-size:16px; font-weight:bold;">
                Faculdade de Tecnologia de Itapira –<br>
                “Ogari de Castro Pacheco”
            </div>
            <div style="font-size:12px; margin-top:4px;">
                Diretoria Acadêmica
            </div>
        </td>

        <!-- Logo CPS -->
        <td style="width:25%; text-align:right; vertical-align:middle;">
            ' . ($logoCPS ? '<img src="'.$logoCPS.'" style="height:70px;">' : '') . '
        </td>
    </tr>
</table>

<!-- Linha abaixo do cabeçalho -->
<div style="width:100%; border-top:2px solid #000; margin-bottom:12px;"></div>


  <div class="att-paragraph small">
    <span class="bold">DATA DE ELEIÇÃO DE REPRESENTANTES DE TURMA DO ANO DE '. strftime('%Y', strtotime($dataAta)) . ' DO CURSO DE '. $curso .' DA FACULDADE DE TECNOLOGIA DE ITAPIRA “OGARI DE CASTRO PACHECO”. ';

$html .= '
    Ao ' . strftime('%d', strtotime($dataAta)) . ' dia(s) do mês de ' . strftime('%B', strtotime($dataAta)) . ' de ' . strftime('%Y', strtotime($dataAta)) . ', foram apurados os votos dos alunos regularmente matriculados do referido período para eleição de novos representantes de turma. 
    Os representantes eleitos fazem a representação dos alunos nos órgãos colegiados da Faculdade, com direito a voz e voto, conforme o disposto no artigo 69 da Deliberação CEETEPS nº 07, de 15 de dezembro de 2006. 
    Foi eleito(a) como representante o(a) aluno(a) <b>' . htmlspecialchars($representante) . '</b>, R.A. nº '. $raRepresentante .' e eleito como vice o(a) aluno(a) <b> ' . htmlspecialchars($vice) . ' </b>, R.A. nº '. $raVice .' . 
    A presente ata, após leitura e concordância, vai assinada por todos os alunos participantes.
  </div>

  <div style="text-align:right; margin-top:12px;"><b>Itapira, ' . htmlspecialchars($dataExtenso) . '.</b></div>

  <table class="table-sign">
    <thead>
      <tr>
        <th style="width:6%;">Nº</th>
        <th style="width:44%;">NOME</th>
        <th style="width:25%;">R.A. COMPLETO</th>
        <th style="width:25%;">ASSINATURA</th>
      </tr>
    </thead>
    <tbody>
';

$contador = 1;
if (count($alunos) === 0) {
    // se não há alunos, mostra linhas em branco suficientes
    for ($i=0; $i<20; $i++) {
        $html .= "<tr>
                    <td>{$contador}</td>
                    <td></td>
                    <td></td>
                    <td class='signature-cell'></td>
                  </tr>";
        $contador++;
    }
} else {
    foreach ($alunos as $aluno) {
        // tenta obter RA se existir; se não, deixa em branco
        $ra = $aluno['ra'] ?? ($aluno['ra'] ?? '');
        $nome = htmlspecialchars($aluno['nome'] ?? '');
        $html .= "<tr>
                    <td>{$contador}</td>
                    <td>{$nome}</td>
                    <td>" . htmlspecialchars($ra) . "</td>
                    <td class='signature-cell'></td>
                  </tr>";
        $contador++;
    }
}

// fechar tabela e adicionar rodapé (logos no rodapé, se quiser)
$html .= '
    </tbody>
  </table>

  <div style="height:30px;"></div>

  <div class="footer">
    <p class="w-full text-center">www.fatecitapira.edu.br</p>
    &nbsp; Rua Tereza Lera Paoletti, 590 • Jardim Bela Vista • 13974-080 • Itapira • SP • Tel.: (19) 3843-7537
  </div>

</body>
</html>
';

// --- RENDERIZAÇÃO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Times New Roman');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// papel A4 retrato
$dompdf->setPaper('A4', 'portrait');

// renderizar
$dompdf->render();

// enviar para o navegador (força download)
$dompdf->stream("Ata_Eleicao_{$ideleicao}_turma{$idturma}.pdf", ["Attachment" => true]);
exit;