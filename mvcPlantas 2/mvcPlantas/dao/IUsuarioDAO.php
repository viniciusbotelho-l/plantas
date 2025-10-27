<?php
namespace dao;

interface IUsuarioDAO {
    public function listar(): array;
    public function listarId(int $id): ?array;
    public function inserir(string $nome, string $email): bool;
    public function alterar(int $id, string $nome, string $email): bool;
    public function excluir(int $id): bool;
    public function buscarPorEmail(string $email): ?array;
}