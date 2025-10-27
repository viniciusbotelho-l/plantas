<?php
namespace service;

use dao\mysql\PlantaDAO;
use dao\mysql\CuidadoDAO;

class PlantaService {
    private PlantaDAO $dao;
    private CuidadoDAO $cuidadoDao;

    public function __construct() {
        $this->dao = new PlantaDAO();
        $this->cuidadoDao = new CuidadoDAO();
    }

    public function listarPlanta(): array {
        try {
            return $this->dao->listar();
        } catch (\Exception $e) {
            error_log("Erro ao listar plantas: " . $e->getMessage());
            throw new \Exception("Não foi possível listar as plantas.");
        }
    }

    public function listarId(int $id): ?array {
        try {
            if ($id <= 0) {
                throw new \Exception("ID inválido.");
            }
            return $this->dao->listarId($id);
        } catch (\Exception $e) {
            error_log("Erro ao buscar planta #{$id}: " . $e->getMessage());
            throw new \Exception("Não foi possível buscar a planta.");
        }
    }

    public function inserir(string $nomeCientifico, string $nomePopular): bool {
        try {
            $this->validarDados($nomeCientifico, $nomePopular);
            $resultado = $this->dao->inserir($nomeCientifico, $nomePopular);
            
            if (!$resultado) {
                throw new \Exception("Falha ao inserir planta no banco de dados.");
            }
            return true;
        } catch (\Exception $e) {
            error_log("Erro ao inserir planta: " . $e->getMessage());
            throw $e;
        }
    }

    public function alterar(int $id, string $nomeCientifico, string $nomePopular): bool {
        try {
            if ($id <= 0) {
                throw new \Exception("ID inválido.");
            }

            $this->validarDados($nomeCientifico, $nomePopular);

            $plantaExistente = $this->dao->listarId($id);
            if (empty($plantaExistente)) {
                throw new \Exception("Planta não encontrada.");
            }

            $resultado = $this->dao->alterar($id, $nomeCientifico, $nomePopular);
            
            if (!$resultado) {
                throw new \Exception("Falha ao atualizar planta.");
            }
            return true;
        } catch (\Exception $e) {
            error_log("Erro ao alterar planta #{$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function excluir(int $id): bool {
        try {
            if ($id <= 0) {
                throw new \Exception("ID inválido.");
            }

            $plantaExistente = $this->dao->listarId($id);
            if (empty($plantaExistente)) {
                throw new \Exception("Planta não encontrada.");
            }

            $totalCuidados = $this->dao->contarCuidados($id);
            if ($totalCuidados > 0) {
                throw new \Exception("Não é possível excluir. Esta planta possui {$totalCuidados} cuidado(s) associado(s).");
            }

            $resultado = $this->dao->excluir($id);
            
            if (!$resultado) {
                throw new \Exception("Falha ao excluir planta.");
            }
            return true;
        } catch (\Exception $e) {
            error_log("Erro ao excluir planta #{$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function buscarPorNome(string $termo): array {
        try {
            return $this->dao->buscarPorNome($termo);
        } catch (\Exception $e) {
            error_log("Erro ao buscar plantas: " . $e->getMessage());
            return [];
        }
    }

    public function listarCuidadosDaPlanta(int $plantaId): array {
        try {
            return $this->cuidadoDao->listarPorPlanta($plantaId);
        } catch (\Exception $e) {
            error_log("Erro ao listar cuidados da planta: " . $e->getMessage());
            return [];
        }
    }

    private function validarDados(string $nomeCientifico, string $nomePopular): void {
        if (empty(trim($nomeCientifico))) {
            throw new \Exception("O nome científico é obrigatório.");
        }
        if (strlen($nomeCientifico) < 3) {
            throw new \Exception("O nome científico deve ter no mínimo 3 caracteres.");
        }
        if (strlen($nomeCientifico) > 150) {
            throw new \Exception("O nome científico deve ter no máximo 150 caracteres.");
        }

        if (empty(trim($nomePopular))) {
            throw new \Exception("O nome popular é obrigatório.");
        }
        if (strlen($nomePopular) < 2) {
            throw new \Exception("O nome popular deve ter no mínimo 2 caracteres.");
        }
        if (strlen($nomePopular) > 100) {
            throw new \Exception("O nome popular deve ter no máximo 100 caracteres.");
        }
    }
}