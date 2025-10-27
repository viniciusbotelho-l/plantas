<?php
namespace dao\mysql;

use dao\IPlantaDAO;
use generic\MysqlFactory;

class PlantaDAO extends MysqlFactory implements IPlantaDAO {

    public function listar(): array {
        $sql = "SELECT id, nome_cientifico, nome_popular 
                FROM plantas 
                ORDER BY nome_popular ASC";
        $retorno = $this->banco->executar($sql);
        return is_array($retorno) ? $retorno : [];
    }

    public function listarId(int $id): ?array {
        $sql = "SELECT id, nome_cientifico, nome_popular 
                FROM plantas 
                WHERE id = :id";
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        
        return (!empty($retorno) && is_array($retorno)) ? $retorno : null;
    }

    public function inserir(string $nomeCientifico, string $nomePopular): bool {
        $sql = "INSERT INTO plantas (nome_cientifico, nome_popular) 
                VALUES (:nome_cientifico, :nome_popular)";
        $param = [
            ":nome_cientifico" => $nomeCientifico,
            ":nome_popular" => $nomePopular
        ];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function alterar(int $id, string $nomeCientifico, string $nomePopular): bool {
        $sql = "UPDATE plantas 
                SET nome_cientifico = :nome_cientifico, 
                    nome_popular = :nome_popular 
                WHERE id = :id";
        $param = [
            ":nome_cientifico" => $nomeCientifico,
            ":nome_popular" => $nomePopular,
            ":id" => $id
        ];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function excluir(int $id): bool {
        $sql = "DELETE FROM plantas WHERE id = :id";
        $param = [":id" => $id];
        
        return $this->banco->executar($sql, $param) !== false;
    }

    public function buscarPorNome(string $termo): array {
        $sql = "SELECT id, nome_cientifico, nome_popular 
                FROM plantas 
                WHERE nome_cientifico LIKE :termo 
                   OR nome_popular LIKE :termo 
                ORDER BY nome_popular ASC";
        $param = [":termo" => "%{$termo}%"];
        $retorno = $this->banco->executar($sql, $param);
        
        return is_array($retorno) ? $retorno : [];
    }

    public function contarCuidados(int $id): int {
        $sql = "SELECT COUNT(*) as total 
                FROM cuidados 
                WHERE planta_id = :id";
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        
        return isset($retorno[0]['total']) ? (int)$retorno[0]['total'] : 0;
    }
}