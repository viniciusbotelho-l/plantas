<?php
namespace service;

use dao\mysql\UsuarioDAO;
use dao\mysql\CuidadoDAO;

class UsuarioService {
    private UsuarioDAO $dao;
    private CuidadoDAO $cuidadoDao;

    public function __construct() {
        $this->dao = new UsuarioDAO();
        $this->cuidadoDao = new CuidadoDAO();
    }

    public function listarUsuario(): array {
        return $this->dao->listar();
    }

    public function listarId(int $id): ?array {
        if ($id <= 0) throw new \Exception("ID inválido.");
        return $this->dao->listarId($id);
    }

    public function inserir(string $nome, string $email): bool {
        $this->validarDados($nome, $email);
        
        if ($this->dao->buscarPorEmail($email)) {
            throw new \Exception("Este email já está cadastrado.");
        }
        
        return $this->dao->inserir($nome, $email);
    }

    public function alterar(int $id, string $nome, string $email): bool {
        $this->validarDados($nome, $email);
        
        $usuario = $this->dao->listarId($id);
        if (empty($usuario)) {
throw new \Exception("Usuário não encontrado.");
} $usuarioComEmail = $this->dao->buscarPorEmail($email);
    if ($usuarioComEmail && $usuarioComEmail['id'] != $id) {
        throw new \Exception("Este email já está sendo usado por outro usuário.");
    }
    
    return $this->dao->alterar($id, $nome, $email);
}

public function excluir(int $id): bool {
    $totalCuidados = $this->dao->contarCuidados($id);
    if ($totalCuidados > 0) {
        throw new \Exception("Não é possível excluir. Este usuário possui {$totalCuidados} cuidado(s) associado(s).");
    }
    
    return $this->dao->excluir($id);
}

public function listarCuidadosDoUsuario(int $usuarioId): array {
    return $this->cuidadoDao->listarPorUsuario($usuarioId);
}

private function validarDados(string $nome, string $email): void {
    if (empty(trim($nome))) {
        throw new \Exception("O nome é obrigatório.");
    }
    if (strlen($nome) < 3) {
        throw new \Exception("O nome deve ter no mínimo 3 caracteres.");
    }
    if (strlen($nome) > 100) {
        throw new \Exception("O nome deve ter no máximo 100 caracteres.");
    }

    if (empty(trim($email))) {
        throw new \Exception("O email é obrigatório.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new \Exception("Email inválido.");
    }
    if (strlen($email) > 100) {
        throw new \Exception("O email deve ter no máximo 100 caracteres.");
    }
}
}