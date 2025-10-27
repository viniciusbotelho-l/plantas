<?php
namespace dao\mysql;

use dao\ICuidadoDAO;
use generic\MysqlFactory;

class CuidadoDAO extends MysqlFactory implements ICuidadoDAO {

    public function listar(): array {
        $sql = "SELECT 
                    c.id,
                    c.usuario_id,
                    c.planta_id,
                    c.tipo_cuidado,
                    c.frequencia,
                    u.nome as usuario_nome,
                    u.email as usuario_email,
                    p.nome_cientifico as planta_cientifico,
                    p.nome_popular as planta_popular
                FROM cuidados c
                INNER JOIN usuarios u ON c.usuario_id = u.id
                INNER JOIN plantas p ON c.planta_id = p.id
                ORDER BY c.id DESC";
        
        $retorno = $this->banco->executar($sql);
        return is_array($retorno) ? $retorno : [];
    }

    public function listarId(int $id): ?array {
        $sql = "SELECT 
                    c.id,
                    c.usuario_id,
                    c.planta_id,
                    c.tipo_cuidado,
                    c.frequencia,
                    u.nome as usuario_nome,
                    p.nome_popular as planta_popular
                FROM cuidados c
                INNER JOIN usuarios u ON c.usuario_id = u.id
                INNER JOIN plantas p ON c.planta_id = p.id
                WHERE c.id = :id";
        
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        
        return (!empty($retorno) && is_array($retorno)) ? $retorno : null;
    }

    public function inserir(int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): bool {
        $sql = "INSERT INTO cuidados (usuario_id, planta_id, tipo_cuidado, frequencia) 
                VALUES (:usuario_id, :planta_id, :tipo_cuidado, :frequencia)";
        $param = [
            ":usuario_id" => $usuarioId,
            ":planta_id" => $plantaId,
            ":tipo_cuidado" => $tipoCuidado,
            ":frequencia" => $frequencia
        ];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function alterar(int $id, int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): bool {
        $sql = "UPDATE cuidados 
                SET usuario_id = :usuario_id,
                    planta_id = :planta_id,
                    tipo_cuidado = :tipo_cuidado,
                    frequencia = :frequencia
                WHERE id = :id";
        $param = [
            ":usuario_id" => $usuarioId,
            ":planta_id" => $plantaId,
            ":tipo_cuidado" => $tipoCuidado,
            ":frequencia" => $frequencia,
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function excluir(int $id): bool {
        $sql = "DELETE FROM cuidados WHERE id = :id";
        $param = [":id" => $id];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function listarPorUsuario(int $usuarioId): array {
        $sql = "SELECT 
                    c.id,
                    c.tipo_cuidado,
                    c.frequencia,
                    p.nome_popular as planta_popular,
                    p.nome_cientifico as planta_cientifico
                FROM cuidados c
                INNER JOIN plantas p ON c.planta_id = p.id
                WHERE c.usuario_id = :usuario_id
                ORDER BY c.id DESC";
        
        $param = [":usuario_id" => $usuarioId];
        $retorno = $this->banco->executar($sql, $param);
        
        return is_array($retorno) ? $retorno : [];
    }

    public function listarPorPlanta(int $plantaId): array {
        $sql = "SELECT 
                    c.id,
                    c.tipo_cuidado,
                    c.frequencia,
                    u.nome as usuario_nome,
                    u.email as usuario_email
                FROM cuidados c
                INNER JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.planta_id = :planta_id
                ORDER BY c.id DESC";
        
        $param = [":planta_id" => $plantaId];
        $retorno = $this->banco->executar($sql, $param);
        
        return is_array($retorno) ? $retorno : [];
    }
}