<?php
namespace controller;

use service\PlantaService;
use template\PlantaTemp;
use template\ITemplate;

class Planta {
    private ITemplate $template;
    private PlantaService $service;

    public function __construct() {
        $this->template = new PlantaTemp();
        $this->service = new PlantaService();
    }

    public function listar() {
        try {
            $resultado = $this->service->listarPlanta();
            $this->template->layout("\\public\\planta\\listar.php", $resultado);
        } catch (\Exception $e) {
            $this->erro("Erro ao listar plantas: " . $e->getMessage());
        }
    }

    public function formulario() {
        try {
            $this->template->layout("\\public\\planta\\form.php");
        } catch (\Exception $e) {
            $this->erro("Erro ao carregar formulário: " . $e->getMessage());
        }
    }

    public function inserir() {
        try {
            if (empty($_POST["nome_cientifico"]) || empty($_POST["nome_popular"])) {
                header("location: /mvcPlantas/planta/formulario?erro=campos_vazios");
                exit;
            }

            $nomeCientifico = $this->sanitizar($_POST["nome_cientifico"]);
            $nomePopular = $this->sanitizar($_POST["nome_popular"]);

            if (strlen($nomeCientifico) < 3) {
                header("location: /mvcPlantas/planta/formulario?erro=nome_curto");
                exit;
            }

            $resultado = $this->service->inserir($nomeCientifico, $nomePopular);
            
            if ($resultado) {
                header("location: /mvcPlantas/planta/lista?info=1");
            } else {
                header("location: /mvcPlantas/planta/formulario?erro=falha_inserir");
            }
            exit;

        } catch (\Exception $e) {
            $this->erro("Erro ao inserir planta: " . $e->getMessage());
        }
    }

    public function alterarForm() {
        try {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                header("location: /mvcPlantas/planta/lista?erro=id_invalido");
                exit;
            }

            $id = intval($_GET["id"]);
            $resultado = $this->service->listarId($id);

            if (empty($resultado)) {
                header("location: /mvcPlantas/planta/lista?erro=planta_nao_encontrada");
                exit;
            }

            $this->template->layout("\\public\\planta\\form.php", $resultado);

        } catch (\Exception $e) {
            $this->erro("Erro ao carregar dados: " . $e->getMessage());
        }
    }

    public function alterar() {
        try {
            if (empty($_POST["id"]) || empty($_POST["nome_cientifico"]) || empty($_POST["nome_popular"])) {
                header("location: /mvcPlantas/planta/lista?erro=dados_incompletos");
                exit;
            }

            $id = intval($_POST["id"]);
            $nomeCientifico = $this->sanitizar($_POST["nome_cientifico"]);
            $nomePopular = $this->sanitizar($_POST["nome_popular"]);

            if (strlen($nomeCientifico) < 3) {
                header("location: /mvcPlantas/planta/alterar-form?id={$id}&erro=nome_curto");
                exit;
            }

            $resultado = $this->service->alterar($id, $nomeCientifico, $nomePopular);
            
            if ($resultado) {
                header("location: /mvcPlantas/planta/lista?info=1");
            } else {
                header("location: /mvcPlantas/planta/alterar-form?id={$id}&erro=falha_alterar");
            }
            exit;

        } catch (\Exception $e) {
            $this->erro("Erro ao alterar planta: " . $e->getMessage());
        }
    }

    public function excluir() {
        try {
            if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
                header("location: /mvcPlantas/planta/lista?erro=id_invalido");
                exit;
            }

            $id = intval($_GET["id"]);
            
            $existe = $this->service->listarId($id);
            if (empty($existe)) {
                header("location: /mvcPlantas/planta/lista?erro=planta_nao_encontrada");
                exit;
            }

            $resultado = $this->service->excluir($id);
            
            if ($resultado) {
                header("location: /mvcPlantas/planta/lista?info=deleted");
            } else {
                header("location: /mvcPlantas/planta/lista?erro=falha_excluir");
            }
            exit;

        } catch (\Exception $e) {
            header("location: /mvcPlantas/planta/lista?erro=" . urlencode($e->getMessage()));
            exit;
        }
    }

}