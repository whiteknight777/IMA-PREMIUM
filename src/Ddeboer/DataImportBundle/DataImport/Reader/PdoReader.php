<?php
namespace Ddeboer\DataImportBundle\DataImport\Reader;

/**
 * Reads data through PDO
 */
class PdoReader implements CountableReaderInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var array
     */
    private $data;

    /**
     * Constructor
     *
     * @param PDO        $pdo Database connection
     * @param string     $sql        SQL statement
     * @param array      $params     SQL statement parameters
     */
    public function __construct(\PDO  $pdo, $sql, array $params = array())
    {
        $this->pdo = $pdo;
        $this->statement = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $this->statement->bindValue($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        if ($this->statement->execute()) {
            // Statement executed successfully
            // Grab the first row to find keys
            $row = $this->statement->fetch(\PDO::FETCH_ASSOC);
            // Return field keys, or empty array no rows remain
            return array_keys($row ? $row : array());
        } else {
            // If the statement errors return empty
            return array();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        $key = key($this->data);

        return ($key !== null && $key !== false);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->loadData();
        reset($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $this->loadData();

        return count($this->data);
    }

    /**
     * Load data if it hasn't been loaded yet
     */
    protected function loadData()
    {
        if (null === $this->data) {
            $this->statement->execute();
            $this->data = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
