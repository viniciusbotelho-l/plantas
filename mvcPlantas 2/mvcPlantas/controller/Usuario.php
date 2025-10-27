<?php
namespace controller;

use service\UsuarioService;
use template\UsuarioTemp;

class Usuario {
    private $template;
    private $service;

    public function __construct() {
        $this->template = new UsuarioTemp();
        $this->service = new UsuarioService();
    }

    public function listar() {
        try {
            $resultado = $this->service->listarUsuario();
            $this->template->layout("\\public\\usuario\\listar.php", $resultado);
        } catch (\Exception $e) {
            $this->erro("Erro: " . $e->getMessage());
        }
    }

    public function formulario() {
        $this->template->layout("\\public\\usuario\\form.php");
    }

    public function inserir() {
        try {
            if (empty($_POST["nome"]) || empty($_POST["email"])) {
                header("location: /mvcPlantas/usuario/formulario?erro=campos_vazios");
                exit;
            }

            $nome = trim($_POST["nome"]);
            $email = trim($_POST["email"]);
            
            $this->service->inserir($nome, $email);
            header("location: /mvcPlantas/usuario/lista?info=1");
        } catch (\Exception $e) {
            header("location: /mvcPlantas/usuario/formulario?erro=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function alterarForm() {
        try {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                header("location: /mvcPlantas/usuario/lista?erro=id_invalido");
                exit;
            }

            $id = intval($_GET["id"]);
            $resultado = $this->service->listarId($id);

            if (empty($resultado)) {
                header("location: /mvcPlantas/usuario/lista?erro=usuario_nao_encontrado");
                exit;
            }

            $this->template->layout("\\public\\usuario\\form.php", $resultado);
        } catch (\Exception $e) {
            $this->erro("Erro: " . $e->getMessage());
        }
    }

    public function alterar() {
        try {
            if (empty($_POST["id"]) || empty($_POST["nome"]) || empty($_POST["email"])) {
                header("location: /mvcPlantas/usuario/lista?erro=dados_incompletos");
                exit;
            }

            $id = intval($_POST["id"]);
            $nome = trim($_POST["nome"]);
            $email = trim($_POST["email"]);
            
            $this->service->alterar($id, $nome, $email);
            header("location: /mvcPlantas/usuario/lista?info=1");
        } catch (\Exception $e) {
            $id = intval($_POST["id"]);
            header("location: /mvcPlantas/usuario/alterar-form?id={$id}&erro=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function excluir() {
        try {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                header("location: /mvcPlantas/usuario/lista?erro=id_invalido");
                exit;
            }

            $id = intval($_GET["id"]);
            $this->service->excluir($id);
            header("location: /mvcPlantas/usuario/lista?info=deleted");
        } catch (\Exception $e) {
            header("location: /mvcPlantas/usuario/lista?erro=" . urlencode($e->getMessage()));
        }
        exit;
    }

    
}