<?php
namespace App\Services;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private static $instanceDb2 = null;
    private $pdo;
    private $pdoDb2;

    private function __construct()
    {
        $host = 'NGUYENQUOCKHANH\QK02092001';
        $dbname = 'MPARKINGKH';
        $username = 'sa';
        $password = 'Qk020901';

        $dsn = "sqlsrv:Server=$host;Database=$dbname";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            // Optional: set fetch mode and error handling
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }

        $hostDb2 = 'NGUYENQUOCKHANH\QK02092001';
        $dbnameDb2 = 'MPARKINGEVENTTM';
        $usernameDb2 = 'sa';
        $passwordDb2 = 'Qk020901';

        $dsnDb2 = "sqlsrv:Server=$hostDb2;Database=$dbnameDb2";

        try {
            $this->pdoDb2 = new PDO($dsnDb2, $usernameDb2, $passwordDb2);
            $this->pdoDb2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Second DB connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }

    public static function getSecondInstance(): PDO
    {
        if (self::$instanceDb2 === null) {
            self::$instanceDb2 = new self();
        }

        return self::$instanceDb2->pdoDb2;
    }
}
