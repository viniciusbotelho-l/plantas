<?php
/**
 * Autoloader PSR-4 compatível para o projeto MVC
 */

spl_autoload_register(function($class) {
    // Diretório base do projeto
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    
    // Substitui namespace separators por directory separators
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    
    // Caminho completo do arquivo
    $fullPath = $baseDir . '..' . DIRECTORY_SEPARATOR . $file;
    
    // Se o arquivo existe, inclui
    if (file_exists($fullPath)) {
        require_once $fullPath;
        return true;
    }
    
    return false;
});

// Define constante de DEBUG
define('DEBUG', true);

// Configuração de erros para desenvolvimento
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
}