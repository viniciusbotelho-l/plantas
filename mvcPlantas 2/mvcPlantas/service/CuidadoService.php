<?php
namespace service;

use dao\mysql\CuidadoDAO;
use dao\mysql\UsuarioDAO;
use dao\mysql\PlantaDAO;

class CuidadoService {
    private CuidadoDAO $dao;
    private UsuarioDAO $usuarioDao;
    private PlantaDAO $plantaDao;

    public function __construct() {
        $this->dao = new CuidadoDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->plantaDao = new PlantaDAO();
    }

    public function listarCuidado(): array {
        return $this->dao->listar();
    }

    public function listarId(int $id): ?array {
        return $this->dao->listarId($id);
    }

    public function inserir(int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): bool {
        $this->validarDados($usuarioId, $plantaId, $tipoCuidado, $frequencia);
        return $this->dao->inserir($usuarioId, $plantaId, $tipoCuidado, $frequencia);
    }

    public function alterar(int $id, int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): bool {
        $this->validarDados($usuarioId, $plantaId, $tipoCuidado, $frequencia);
        return $this->dao->alterar($id, $usuarioId, $plantaId, $tipoCuidado, $frequencia);
    }

    public function excluir(int $id): bool {
        return $this->dao->excluir($id);
    }

    public function obterUsuarios(): array {
        return $this->usuarioDao->listar();
    }

    public function obterPlantas(): array {
        return $this->plantaDao->listar();
    }

    private function validarDados(int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): void {
        $usuario = $this->usuarioDao->listarId($usuarioId);
        if (empty($usuario)) {
            throw new \Exception("Usuário não encontrado.");
        }

        $planta = $this->plantaDao->listarId($plantaId);
        if (empty($planta)) {
            throw new \Exception("Planta não encontrada.");
        }

        $tiposPermitidos = ['Regar', 'Adubar', 'Podar', 'Trocar de vaso', 'Limpar folhas', 'Pulverizar água'];
        if (!in_array($tipoCuidado, $tiposPermitidos)) {
            throw new \Exception("Tipo de cuidado inválido.");
        }

        if ($frequencia < 1 || $frequencia > 365) {
            throw new \Exception("A frequência deve estar entre 1 e 365 dias.");
        }
    }
}