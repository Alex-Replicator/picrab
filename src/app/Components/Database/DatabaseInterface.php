<?php
namespace Picrab\Components\Database;

interface DatabaseInterface
{
    public function connect(string $password);
    public function query(string $sql, array $params = []): array;
    public function execute(string $sql, array $params = []): bool;
}