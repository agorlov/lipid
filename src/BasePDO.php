<?php

namespace Lipid;

use PDO;
use PDOStatement;

/**
 * BasePDO - decorator with lazy load
 *
 * BasePDO initialized by config params:
 *   dbname
 *   dbhost
 *   dbuser
 *   dbpass
 *
 * @SuppressWarnings("TooManyPublicMethods")
 * @author agorlov
 */
class BasePDO extends PDO
{
    
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function pdo()
    {
        static $cachedPDO;
        if ($cachedPDO) {
            return $cachedPDO;
        }

        $config = $this->config;
        $cachedPDO = new PDO(
            "mysql:dbname={$config->param('dbname')};host={$config->param('dbhost')}",
            $config->param('dbuser'),
            $config->param('dbpass')
        );

        $cachedPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $cachedPDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        //$this->exec('SET NAMES utf8');
        return $cachedPDO;
    }

    public function beginTransaction(): bool
    {
        return $this->pdo()->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo()->commit();
    }

    public function errorCode() : string
    {
        return $this->pdo()->errorCode();
    }

    public function errorInfo() : array
    {
        return $this->pdo()->errorInfo();
    }

    public function exec($query) : int
    {
        return $this->pdo()->exec($query);
    }

    public function getAttribute($attribute)
    {
        return $this->pdo()->getAttribute($attribute);
    }

    public function inTransaction() : bool
    {
        return $this->pdo()->inTransaction();
    }

    public function lastInsertId($seqname = null): string
    {
        return $this->pdo()->lastInsertId($seqname);
    }

    public function prepare($statement, $driverOptions = null): PDOStatement
    {
        return $this->pdo()->prepare($statement, $driverOptions);
    }

    public function query(string $statement) : PDOStatement
    {
        return $this->pdo()->query($statement);
    }

    public function quote($string, $paramtype = null)
    {
        return $this->pdo()->quote($string, $paramtype);
    }

    public function rollBack() : bool
    {
        return $this->pdo()->rollBack();
    }

    public function setAttribute($attribute, $value) : bool
    {
        return $this->pdo()->setAttribute($attribute, $value);
    }
}
