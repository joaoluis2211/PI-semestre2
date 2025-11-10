<?php
// Roteador simples

$controller = $_GET['controller'];
$acao = $_GET['acao'];

// Monta o nome do arquivo e da classe
$controllerFile = "app/controller/" . ucfirst($controller) . "Controller.php";
$controllerClass = ucfirst($controller) . "Controller";

// Inclui e executa
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $obj = new $controllerClass();

    if (method_exists($obj, $acao)) {
        $obj->$acao();
    } else {
        echo "Ação '$acao' não encontrada.";
    }
} else {
    echo "Controller '$controller' não encontrado.";
}