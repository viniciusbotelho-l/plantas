<?php
namespace dao;

interface IPlantaDAO {
    public function listar(): array;
    public function listarId(int $id): ?array;
    public function inserir(string $nomeCientifico, string $nomePopular): bool;
    public function alterar(int $id, string $nomeCientifico, string $nomePopular): bool;
    public function excluir(int $id): bool;
    public function buscarPorNome(string $termo): array;
}