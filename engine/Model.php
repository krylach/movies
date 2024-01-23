<?php

namespace Engine;

use Engine\Database;

class Model extends Database {
    protected array $data;

    public function __construct()
    {
        parent::__construct();
    }

    public function __toString()
    {
        return json_encode($this->data);        
    }

    public function __get($column)
    {
        if (isset($this->data[$column])) {
            return $this->data[$column];
        }

        return null;
    }

    public function __set($column, $value)
    {
        if (in_array($column, $this->getFillable())) {
            $this->data[$column] = $value;
        }
    }

    public function all()
    {
        $statement = $this->miner->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $collection = collect([]);
        foreach ($data as $values) {
            $model = new static();
            $model->setData($values);

            $collection->add($model->setData($values));
        }        
            
        return $collection;
    }

    public function first()
    {
        $statement = $this->miner->execute();

        $data = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }
            
        return $this->setData($data);
    }

    public function delete()
    {
        $model = new static;
        $model->__construct();

        $model->miner = 
            new \Miner(
                $model->getPdoConnect()
            );
        
        return $model->miner->delete()
            ->from($this->table)
            ->where('id', $this->id)
            ->execute();
    }

    public function update(array $data)
    {
        foreach ($data as $column => $value) {
            $this->data[$column] = $value;
        }

        return $this->save();
    }

    public function save()
    {
        if (isset($this->data['id'])) {
            return $this->updateRow($this->table, $this->data['id'], $this->data);
        }

        return $this->insertRow($this->table, $this->data);
    }

    public static function find(int $id)
    {
        $self = new static;

        return $self->findByModel(new static, $id);
    }

    public function isEmpty()
    {
        return empty($this->data);
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function setData(array $data)
    {
        foreach ($data as $column => $value) {
            if (in_array($column, $this->fillable)) {
                $this->data[$column] = $value;
            }
        }

        return $this;
    }

    public static function query()
    {
        $model = new static;
        $model->__construct();

        $model->miner = 
            new \Miner(
                $model->getPdoConnect()
            );

        $fillable = [];
        foreach ($model->getFillable() as $column) {
            $fillable[] = $model->getTable() . ".$column";
        }

        $model->miner->from($model->getTable());
        $model->setSelect($model->miner, $fillable);

        return $model;
    }

    public static function where(string $column, mixed $value, string $operator = \Miner::EQUALS)
    {
        $model = new static;
        $model->__construct();

        $model->miner = 
            new \Miner(
                $model->getPdoConnect()
            );

        $fillable = [];
        foreach ($model->getFillable() as $selectColumn) {
            $fillable[] = $model->getTable() . ".$selectColumn";
        }

        $model->miner->from($model->getTable());
        $model->setSelect($model->miner, $fillable);
        $model->miner->where($model->getTable() . ".$column", $value, $operator);

        return $model;
    }

    public function toSql()
    {
        return $this->miner->__toString();
    }

    public function toArray()
    {
        return $this->data;
    }

    public static function create(array $data)
    {
        $model = new static;
        foreach ($data as $column => $value) {
            $model->data[$column] = $value;
        }

        return $model->findByModel(
            $model,
            $model->save()
        );
    }
}