<?php
namespace controller;

class Home {
    public function index() {
        // Renderizar home.php diretamente, sem usar template
        $caminhoCompleto = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "mvcPlantas" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "home" . DIRECTORY_SEPARATOR . "index.php";
        
        if (file_exists($caminhoCompleto)) {
            include $caminhoCompleto;
        } else {
            echo "Arquivo não encontrado: " . $caminhoCompleto;
        }
    }
}