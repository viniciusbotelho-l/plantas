<?php
namespace dao;

interface ICuidadoDAO {
    public function listar(): array;
    public function listarId(int $id): ?array;
    public function inserir(int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): bool;
    public function alterar(int $id, int $usuarioId, int $plantaId, string $tipoCuidado, int $frequencia): bool;
    public function excluir(int $id): bool;
    public function listarPorUsuario(int $usuarioId): array;
    public function listarPorPlanta(int $plantaId): array;
}