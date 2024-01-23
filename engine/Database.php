<?php

namespace Engine;

class Database
{
    const MYSQL_PROVIDER = 'mysql';
    private $config;
    protected \Miner $miner;

    public function __construct()
    {
        $this->config = config('database');
    }

    public function innerJoin($table, array $on)
    {
        $this->miner->innerJoin($table, implode(' ', $on));

        return $this;
    }

    public function rightJoin($table, array $on)
    {
        $this->miner->rightJoin($table, implode(' ', $on));

        return $this;
    }

    public function leftJoin($table, array $on)
    {
        $this->miner->leftJoin($table, implode(' ', $on));

        return $this;
    }

    public function groupBy(string $column)
    {
        $this->miner->groupBy($column);

        return $this;
    }

    public function orderBy(string $column, string $order = Miner::ORDER_BY_ASC)
    {
        $this->miner->orderBy($column, $order);

        return $this;
    }

    public function whereIn(string $column, array $values)
    {
        $this->miner->whereIn($column, $values);

        return $this;
    }

    public function andWhere(string $column, mixed $value, string $operator = \Miner::EQUALS)
    {
        $this->miner->andWhere($column, $value, $operator);

        return $this;
    }

    public function orWhere(string $column, mixed $value, string $operator = \Miner::EQUALS)
    {
        $this->miner->orWhere($column, $value, $operator);

        return $this;
    }
    
    protected function updateRow($table, $id, $data)
    {
        $miner = new \Miner(
            $this->getPdoConnect()
        );

        if (isset($data['id'])) {
            unset($data['id']);
        }

        $builder = $miner->update($table);

        foreach ($data as $column => $value) {
            $builder->set($column, $value);
        }

        $builder->where('id', $id);
        $builder->execute();

        return $builder->getPdoConnection()->lastInsertId();
    }
    
    protected function insertRow($table, $data)
    {
        $miner = new \Miner(
            $this->getPdoConnect()
        );

        $builder = $miner->insert($table);

        foreach ($data as $column => $value) {
            $builder->set($column, $value);
        }

        $builder->execute();

        return $builder->getPdoConnection()->lastInsertId();
    }

    protected function findByModel(Model $model, int $id)
    {
        $miner = new \Miner(
            $this->getPdoConnect()
        );

        $this->setSelect($miner, $model->getFillable());

        $statement = $miner->from($model->getTable())
            ->where('id', $id)
            ->limit(1)
            ->execute();

        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }
            
        return $model->setData($data);
    }

    protected function setSelect(\Miner &$miner, array $fields)
    {
        foreach ($fields as $column => $alias) {
            if (is_string($column)) {
                $miner->select($column, $alias);
                continue;
            }

            $miner->select($alias);
        }
    }

    public function getPdoConnect()
    {
        $config = $this->config;
        $provider = $config->provider ?? self::MYSQL_PROVIDER;

        return new \PDO("$provider:host=localhost;dbname={$config->database}", $config->username, $config->password);
    }
}
