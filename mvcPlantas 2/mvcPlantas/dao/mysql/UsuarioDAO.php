<?php
namespace dao\mysql;

use dao\IUsuarioDAO;
use generic\MysqlFactory;

class UsuarioDAO extends MysqlFactory implements IUsuarioDAO {

    public function listar(): array {
        $sql = "SELECT id, nome, email FROM usuarios ORDER BY nome ASC";
        $retorno = $this->banco->executar($sql);
        return is_array($retorno) ? $retorno : [];
    }

    public function listarId(int $id): ?array {
        $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        
        return (!empty($retorno) && is_array($retorno)) ? $retorno : null;
    }

    public function inserir(string $nome, string $email): bool {
        $sql = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
        $param = [
            ":nome" => $nome,
            ":email" => $email
        ];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function alterar(int $id, string $nome, string $email): bool {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
        $param = [
            ":nome" => $nome,
            ":email" => $email,
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function excluir(int $id): bool {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $param = [":id" => $id];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function buscarPorEmail(string $email): ?array {
        $sql = "SELECT id, nome, email FROM usuarios WHERE email = :email";
        $param = [":email" => $email];
        $retorno = $this->banco->executar($sql, $param);
        
        return (!empty($retorno) && is_array($retorno)) ? $retorno[0] : null;
    }

    public function contarCuidados(int $id): int {
        $sql = "SELECT COUNT(*) as total FROM cuidados WHERE usuario_id = :id";
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        
        return isset($retorno[0]['total']) ? (int)$retorno[0]['total'] : 0;
    }
}