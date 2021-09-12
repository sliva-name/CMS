<?php

namespace Engine\Core\DataBase;

use PDO;
use PDOException;

class Connect
{
    /**
     * PDO object
     *
     * @var PDO
     */
    private $pdo;
    /**
     * Connected DataBase
     *
     * @var bool
     */
    private $isConnected;
    /**
     * PDO statement object
     *
     * @var \PDOStatement
     */
    private $statement;
    /**
     * The DataBase settings
     *
     * @var array
     */
    protected $settings = [];
    /**
     * DataBase parameters
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Connect constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
        $this->connect();
    }

    private function connect()
    {
        $dns = 'mysql:dbname=' . $this->settings['db_name'] . ';host=' . $this->settings['host'];
        try {
            $this->pdo = new PDO($dns, $this->settings['user'], $this->settings['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->settings['charset']]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->isConnected = true;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

    }
    public function closeConnection()
    {
        $this->pdo = null;
    }
    private function init(string $query, array $parameters = [])
    {
        if (!$this->isConnected) {
            $this->connect();
        }
        try {
            $this->statement = $this->pdo->prepare($query);
            $this->bind($parameters);

            if (!empty($this->parameters)) {
                foreach ($this->parameters as $value) {
                    if (is_int($value[1])) {
                        $type = PDO::PARAM_INT;
                    } elseif (is_bool($value[1])) {
                        $type = PDO::PARAM_BOOL;
                    } elseif (is_null($value[1])) {
                        $type = PDO::PARAM_NULL;
                    } else {
                        $type = PDO::PARAM_STR;
                    }
                    $this->statement->bindValue($value[0], $value[1], $type);
                }
            }
            $this->statement->execute();
            $this->closeConnection();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        $this->parameters = [];
    }

    /**
     * @return void
     *
     * @param array $parameters
     */
    private function bind(array $parameters): void
    {
        if (!empty($parameters) and is_array($parameters)) {
            $columns = array_keys($parameters);
            foreach ($columns as $column) {
                $this->parameters[sizeof($this->parameters)] = [
                    ':' . $column,
                    $parameters[$column],
                ];
            }
        }
    }

    /**
     * @param string $query
     * @param array $parameters
     * @param int $mode
     * @return array|int|null
     */
    public function query(string $query, array $parameters = [], $mode = PDO::FETCH_ASSOC)
    {
        $query = trim(str_replace('\r', '', $query));
        $this->init($query, $parameters);
        $rawStatement = explode(' ', preg_replace("/\s+|\t+|\n+/", " ", $query));
        $statement = strtolower($rawStatement[0]);
        switch ($statement) {
            case 'show':
            case 'select':
                return $this->statement->fetchAll($mode);
            case 'update':
            case 'delete':
            case 'insert':
                return $this->statement->rowCount();
            default:
                return null;
        }
    }

    /**
     * @return string
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

}
