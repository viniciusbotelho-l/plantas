<?php
namespace generic;

class Controller {
    private $arrChamadas = [];
    
    public function __construct() {
        $this->arrChamadas = [
            "" => new Acao("Home", "index"),
            "home" => new Acao("Home", "index"),
            
            "planta/lista" => new Acao("Planta", "listar"),
            "planta/formulario" => new Acao("Planta", "formulario"),
            "planta/inserir" => new Acao("Planta", "inserir"),
            "planta/alterar-form" => new Acao("Planta", "alterarForm"),
            "planta/alterar" => new Acao("Planta", "alterar"),
            "planta/excluir" => new Acao("Planta", "excluir"),
            "planta/visualizar" => new Acao("Planta", "visualizar"),
            
            "usuario/lista" => new Acao("Usuario", "listar"),
            "usuario/formulario" => new Acao("Usuario", "formulario"),
            "usuario/inserir" => new Acao("Usuario", "inserir"),
            "usuario/alterar-form" => new Acao("Usuario", "alterarForm"),
            "usuario/alterar" => new Acao("Usuario", "alterar"),
            "usuario/excluir" => new Acao("Usuario", "excluir"),
            "usuario/visualizar" => new Acao("Usuario", "visualizar"),
            
            "cuidado/lista" => new Acao("Cuidado", "listar"),
            "cuidado/formulario" => new Acao("Cuidado", "formulario"),
            "cuidado/inserir" => new Acao("Cuidado", "inserir"),
            "cuidado/alterar-form" => new Acao("Cuidado", "alterarForm"),
            "cuidado/alterar" => new Acao("Cuidado", "alterar"),
            "cuidado/excluir" => new Acao("Cuidado", "excluir"),
            "cuidado/visualizar" => new Acao("Cuidado", "visualizar"),
        ];
    }

    public function verificarChamadas($rota) {
        $rota = trim($rota, '/');
        
        if (isset($this->arrChamadas[$rota])) {
            try {
                $acao = $this->arrChamadas[$rota];
                $acao->executar();
                return;
            } catch (\Exception $e) {
                $this->erro500($e->getMessage());
                return;
            }
        }

        echo 'erro404';
    }

    
}