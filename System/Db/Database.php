<?php
class Database
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var
     */
    protected $sql;

    /**
     * @var
     */
    protected $statement;

    /**
     * @var
     */
    protected $paginate;

    /**
     *
     */
    public function __construct()
    {
        try {
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $this->pdo = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME, USERNAME, PASSWORD, $options);
            // Convert encode to UTF8
            $this->pdo->query('set names utf8');
        } catch (PDOException $e) {
            //return false;
            exit($e->getMessage());
        }
    }

    /**
     * @param $sql
     * @return $this
     */
    public function setQuery($sql)
    {
        $this->sql = trim($sql);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->sql;
    }

    /**
     * @param $params
     * @return mixed|void
     */
    public function row($params = [])
    {
        try {
            $this->statement = $this->pdo->prepare($this->sql);
            $this->statement->execute($params);
            return $this->statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param $params
     * @return array|false|void
     */
    public function rows($params = [])
    {
        try {
            if ($this->paginate) {
                $this->sql .= " LIMIT " . $this->paginate['offset'] . ", " . $this->paginate['limit'];
            }
            $this->statement = $this->pdo->prepare($this->sql);
            $this->statement->execute($params);
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param $params
     * @return bool|void
     */
    public function save($params = [])
    {
        try {
            $this->statement = $this->pdo->prepare($this->sql);
            return $this->statement->execute($params);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function disconnect()
    {
        $this->pdo = $this->statement = null;
    }

    /**
     * @param $limit
     * @param $offset
     * @return void
     */
    public function paginate($limit, $offset)
    {
        $this->paginate = [
            'limit' => $limit,
            'offset' => $offset
        ];
    }
}
