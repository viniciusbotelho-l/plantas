<?php
namespace generic;

use PDO;
use PDOException;

class MysqlSingleton {
    private static $instance = null;
    private $conexao = null;
    
    private $host = 'localhost';
    private $dbname = 'mvcplantas';
    private $usuario = 'root';
    private $senha = '';
    private $charset = 'utf8mb4';
    private $dsn;

    private function __construct() {
        try {
            $this->dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            
            $this->conexao = new PDO($this->dsn, $this->usuario, $this->senha);
            
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch (PDOException $e) {
            error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
            die("Erro ao conectar com o banco de dados. Verifique as configurações.");
        }
    }

    private function __clone() {}

    public function __wakeup() {
        throw new \Exception("Não é possível deserializar um Singleton.");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new MysqlSingleton();
        }
        return self::$instance;
    }

    public function executar($query, $param = []) {
        try {
            if ($this->conexao === null) {
                throw new \Exception("Conexão com o banco não estabelecida.");
            }

            $stmt = $this->conexao->prepare($query);
            
            foreach ($param as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->execute();
            
            if (stripos(trim($query), 'SELECT') === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmt->rowCount() > 0;
            }
            
        } catch (PDOException $e) {
            error_log("Erro ao executar query: " . $e->getMessage());
            error_log("Query: " . $query);
            throw new \Exception("Erro ao executar operação no banco de dados.");
        }
    }

    public function lastInsertId() {
        return $this->conexao->lastInsertId();
    }

    public function beginTransaction() {
        return $this->conexao->beginTransaction();
    }

    public function commit() {
        return $this->conexao->commit();
    }

    public function rollback() {
        return $this->conexao->rollback();
    }

    public function fecharConexao() {
        $this->conexao = null;
    }
}