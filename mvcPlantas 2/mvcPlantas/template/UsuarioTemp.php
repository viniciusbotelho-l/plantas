<?php
namespace template;

class UsuarioTemp implements ITemplate {
    
    public function layout($caminho, $parametro = null) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Usuários</title>
            <link rel="stylesheet" href="/mvcPlantas/public/assets/css/style.css?v=1.0">
            <link rel="stylesheet" href="/mvcPlantas/public/assets/css/tables.css?v=1.0">
        </head>
        <body>
        <?php
        
        $caminhoCompleto = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "mvcPlantas" . str_replace("\\", DIRECTORY_SEPARATOR, $caminho);
        
        if (file_exists($caminhoCompleto)) {
            include $caminhoCompleto;
        } else {
            echo "<div style='background: white; padding: 40px; border-radius: 8px; text-align: center;'>";
            echo "<h2 style='color: #e74c3c;'>Erro 404</h2>";
            echo "<p>O arquivo de visualização não existe:</p>";
            echo "<code style='background: #f5f5f5; padding: 10px; display: block; margin: 10px 0;'>{$caminho}</code>";
            echo "<a href='/mvcPlantas/' style='color: #3498db; text-decoration: none;'>Voltar ao início</a>";
            echo "</div>";
        }
        
        ?>
        </body>
        </html>
        <?php
    }
}