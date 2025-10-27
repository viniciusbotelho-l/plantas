<?php
namespace controller;

use service\CuidadoService;
use template\CuidadoTemp;

class Cuidado {
    private $template;
    private $service;

    public function __construct() {
        $this->template = new CuidadoTemp();
        $this->service = new CuidadoService();
    }

    public function listar() {
        try {
            $resultado = $this->service->listarCuidado();
            $this->template->layout("\\public\\cuidado\\listar.php", $resultado);
        } catch (\Exception $e) {
            $this->erro("Erro: " . $e->getMessage());
        }
    }


    public function formulario() {
        try {
            $usuarios = $this->service->obterUsuarios();
            $plantas = $this->service->obterPlantas();
            
            $dados = [
                'cuidado' => null,
                'usuarios' => $usuarios,
                'plantas' => $plantas
            ];
            
            $this->template->layout("\\public\\cuidado\\form.php", $dados);
        } catch (\Exception $e) {
            $this->erro("Erro: " . $e->getMessage());
        }
    }

    public function inserir() {
        try {
            if (empty($_POST["usuario_id"]) || empty($_POST["planta_id"]) || 
                empty($_POST["tipo_cuidado"]) || empty($_POST["frequencia"])) {
                header("location: /mvcPlantas/cuidado/formulario?erro=campos_vazios");
                exit;
            }

            $usuarioId = intval($_POST["usuario_id"]);
            $plantaId = intval($_POST["planta_id"]);
            $tipoCuidado = trim($_POST["tipo_cuidado"]);
            $frequencia = intval($_POST["frequencia"]);
            
            $this->service->inserir($usuarioId, $plantaId, $tipoCuidado, $frequencia);
            header("location: /mvcPlantas/cuidado/lista?info=1");
        } catch (\Exception $e) {
            header("location: /mvcPlantas/cuidado/formulario?erro=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function alterarForm() {
        try {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                header("location: /mvcPlantas/cuidado/lista?erro=id_invalido");
                exit;
            }

            $id = intval($_GET["id"]);
            $cuidado = $this->service->listarId($id);

            if (empty($cuidado)) {
                header("location: /mvcPlantas/cuidado/lista?erro=cuidado_nao_encontrado");
                exit;
            }

            $usuarios = $this->service->obterUsuarios();
            $plantas = $this->service->obterPlantas();
            
            $dados = [
                'cuidado' => $cuidado,
                'usuarios' => $usuarios,
                'plantas' => $plantas
            ];
            
            $this->template->layout("\\public\\cuidado\\form.php", $dados);
        } catch (\Exception $e) {
            $this->erro("Erro: " . $e->getMessage());
        }
    }

    public function alterar() {
        try {
            if (empty($_POST["id"]) || empty($_POST["usuario_id"]) || empty($_POST["planta_id"]) || 
                empty($_POST["tipo_cuidado"]) || empty($_POST["frequencia"])) {
                header("location: /mvcPlantas/cuidado/lista?erro=dados_incompletos");
                exit;
            }

            $id = intval($_POST["id"]);
            $usuarioId = intval($_POST["usuario_id"]);
            $plantaId = intval($_POST["planta_id"]);
            $tipoCuidado = trim($_POST["tipo_cuidado"]);
            $frequencia = intval($_POST["frequencia"]);
            
            $this->service->alterar($id, $usuarioId, $plantaId, $tipoCuidado, $frequencia);
            header("location: /mvcPlantas/cuidado/lista?info=1");
        } catch (\Exception $e) {
            $id = intval($_POST["id"]);
            header("location: /mvcPlantas/cuidado/alterar-form?id={$id}&erro=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function excluir() {
        try {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                header("location: /mvcPlantas/cuidado/lista?erro=id_invalido");
                exit;
            }

            $id = intval($_GET["id"]);
            $this->service->excluir($id);
            header("location: /mvcPlantas/cuidado/lista?info=deleted");
        } catch (\Exception $e) {
            header("location: /mvcPlantas/cuidado/lista?erro=" . urlencode($e->getMessage()));
        }
        exit;
    }

    }