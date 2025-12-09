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

$cursoata = str_replace(' ', '_', $curso);
$cursoata = str_replace('Ç', 'C', $cursoata);
$cursoata = str_replace('Ã', 'A', $cursoata);
$cursoata = strtolower($cursoata);
$semestre = $turma->getSemestre();

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
// --- monta HTML do PDF (estilizado para DOMPDF)
$html = '
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<style>
  @page { margin: 40px 40px; }
  body { font-family: "Times New Roman", "serif"; font-size: 13px; color: #000; line-height: 1.4; }
  .header { width:100%; display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
  .att-paragraph { text-align:justify; text-justify:inter-word; margin-top:10px; margin-bottom:10px; }
  .small { font-size:12px; }
  .table-sign { width:100%; border-collapse: collapse; margin-top:18px; }
  .table-sign th, .table-sign td { border: 1px solid #000; padding:6px; font-size:13px; text-align:left; }
  .table-sign th { font-weight:700; text-align:center; }
  .signature-cell { height:auto; text-align:center; font-size:12px; }
  .footer { position: fixed; bottom: 20px; left: 40px; right: 40px; text-align:center; font-size:11px; }
</style>
</head>
<body>

<!-- Cabeçalho mantido igual -->
<table style="width:100%; margin-bottom:10px;">
    <tr>
        <td style="width:25%; text-align:left;">' . ($logoGov ? '<img src="'.$logoGov.'" style="height:70px;">' : '') . '</td>
        <td style="width:50%; text-align:center;">
            <div style="font-size:16px; font-weight:bold;">
                Faculdade de Tecnologia de Itapira –<br>
                “Ogari de Castro Pacheco”
            </div>
            <div style="font-size:12px; margin-top:4px;">Diretoria Acadêmica</div>
        </td>
        <td style="width:25%; text-align:right;">' . ($logoCPS ? '<img src="'.$logoCPS.'" style="height:70px;">' : '') . '</td>
    </tr>
</table>

<div style="width:100%; border-top:2px solid #000; margin-bottom:12px;"></div>

<div class="att-paragraph small">
    DATA DE ELEIÇÃO DE REPRESENTANTES DE TURMA DO ANO DE '. strftime('%Y', strtotime($dataAta)) . 
    ' DO CURSO DE '. $curso .' DA FACULDADE DE TECNOLOGIA DE ITAPIRA “OGARI DE CASTRO PACHECO”. 
    Ao ' . strftime('%d', strtotime($dataAta)) . ' dia(s) do mês de ' . strftime('%B', strtotime($dataAta)) . 
    ' de ' . strftime('%Y', strtotime($dataAta)) . 
    ', foram apurados os votos dos alunos regularmente matriculados para eleição dos novos representantes de turma.
</div>

<div class="att-paragraph small">
    Foi eleito(a) como representante o(a) aluno(a) <b>' . htmlspecialchars($representante) . '</b>, 
    R.A. nº '. $raRepresentante .' e eleito como vice o(a) aluno(a) 
    <b>' . htmlspecialchars($vice) . '</b>, R.A. nº '. $raVice .'.
</div>

<!-- NOVO TEXTO: assinatura automática -->
<div class="att-paragraph small">
    <b>Nota:</b> A assinatura dos alunos é automaticamente validada pelo registro de voto no sistema ELEJA, 
    não sendo necessária assinatura manual na presente ata.
</div>

<div style="text-align:right; margin-top:12px;">
    <b>Itapira, ' . htmlspecialchars($dataExtenso) . '.</b>
</div>

<table class="table-sign">
    <thead>
      <tr>
        <th style="width:6%;">Nº</th>
        <th style="width:44%;">NOME</th>
        <th style="width:25%;">R.A. COMPLETO</th>
        <th style="width:25%;">ASSINATURA (VOTO)</th>
      </tr>
    </thead>
    <tbody>
';

$contador = 1;

foreach ($alunos as $aluno) {
    $ra = $aluno['ra'] ?? '';
    $nome = htmlspecialchars($aluno['nome']);

    $html .= "
        <tr>
            <td>{$contador}</td>
            <td>{$nome}</td>
            <td>" . htmlspecialchars($ra) . "</td>

            <!-- COLUNA ALTERADA -->
            <td class='signature-cell'>
                <span style='font-weight:bold;'>Voto registrado</span>
            </td>
        </tr>
    ";

    $contador++;
}

$html .= '
    </tbody>
</table>

<div class="footer">
    <p>www.fatecitapira.edu.br</p>
    Rua Tereza Lera Paoletti, 590 • Jardim Bela Vista • 13974-080 • Itapira • SP • Tel.: (19) 3843-7537
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
$dompdf->stream("Ata_Eleicao_{$semestre}_turma_" . $cursoata . ".pdf", ["Attachment" => true]);
exit;