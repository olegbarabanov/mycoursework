<?php

namespace App\Repository;

use App\Core\Storage\DatabaseStorageInterface;
use App\Core\Storage\FileStorageInterface;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository implements \SplSubject
{
    protected DatabaseStorageInterface $db;
    protected FileStorageInterface $fs;
    protected array $observers = [];

    public function __construct(DatabaseStorageInterface $db, FileStorageInterface $fs)
    {
        $this->db = $db;
        $this->fs = $fs;
    }

    abstract protected function getDatabaseTable(): string;
    abstract protected function getDataClass(): string;
    
    /**
     * Return custom map field in the used table;
     * 
     * @return array //Scheme
     */
    abstract public function getScheme(): array;

    public function attach(\SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(\SplObserver $observer): void
    {
        $i = array_search($this->observers, $observer);
        if ($i !== false) {
            unset($this->observers[$i]);
        }
    }

    public function notify(?string $event = null, ?RepositoryObjectPrototypeInterface $data = null)
    {
        foreach ($this->observers as $observer) {
            $observer->update($this, $event, $data);
        }
    }

    /**
     * Return filled array from the used table. 
     * It is alternative SQL operator SELECT
     * 
     * @param array $params
     * 
     * @return array
     */
    public function getCollection(array $params): array
    {
        $table = $this->getDatabaseTable();
        $queryBuilder = $this->db->table($table);
        
        //id => it's primary key.
        if (isset($params["id"]) && is_numeric($params["id"])) {
            $queryBuilder->eq("id", $params["id"]);
        };

        //for GROUP BY. 
        if (isset($params["group"]) && is_array($params["group"])) {
            foreach ($params["group"] as $group) {
                $queryBuilder->groupBy($group["field"]);
            }
        };

        //for ORDER BY ASC
        if (isset($params["asc"]) && is_array($params["asc"])) {
            foreach ($params["asc"] as $asc) {
                $queryBuilder->asc($asc["field"]);
            }
        };

        //for ORDER BY DESC
        if (isset($params["desc"]) && is_array($params["desc"])) {
            foreach ($params["desc"] as $desc) {
                $queryBuilder->desc($desc["field"]);
            }
        };

        //filled data for SQL %LIKE%
        if (isset($params["filter"]) && is_array($params["filter"])) {
            foreach ($params["filter"] as $filter) {
                $queryBuilder->like($filter["field"], "%".$filter["value"]."%");
            };
        };

        if (isset($params["lte"]) && is_array($params["lte"])) {
            foreach ($params["lte"] as $filter) {
                $queryBuilder->lte($filter["field"], $filter["value"]);
            };
        };

        if (isset($params["gte"]) && is_array($params["gte"])) {
            foreach ($params["gte"] as $filter) {
                $queryBuilder->gte($filter["field"], $filter["value"]);
            };
        };

        $dataList = $queryBuilder->findAll();
        $prototypeClass = $this->getDataClass();
        foreach ($dataList as $index => $data) {
            $dataList[$index] = $this->db->mapArrayToObject($data, new $prototypeClass);
        };

        return $dataList;
    }

    public function insert(RepositoryObjectPrototypeInterface $obj): array
    {
        $rawData = $obj->getRawData();
        $table = $this->getDatabaseTable();
        foreach ($rawData as $key => $value) {
            if ($value instanceof \SplFileObject) {
                $rawData[$key] = $this->fs->setFile($value);
            };
        };
        $success = $this->db->table($table)->insert($rawData);
        $obj->id = $success ? $this->db->getLastId() : null;
        if ($success) $this->notify("insert", $obj);
        return ["save" => $success, "id" => $obj->id];
    }

    public function update(RepositoryObjectPrototypeInterface $obj): array
    {
        $rawData = $obj->getRawData();
        $table = $this->getDatabaseTable();
        foreach ($rawData as $key => $value) {
            if ($value instanceof \SplFileObject) {
                $rawData[$key] = $this->fs->setFile($value);
            };
        };
        $success = $this->db->table($table)->eq("id", $obj->id)->update($rawData);
        if ($success) $this->notify("update", $obj);
        return ["save" => $success, "id" => $obj->id];
    }

    public function delete(RepositoryObjectPrototypeInterface $obj): array
    {
        $table = $this->getDatabaseTable();
        $success = $this->db->table($table)->eq("id", $obj->id)->remove();
        if ($success) $this->notify("delete", $obj);
        return ["save" => $success, "id" => $obj->id];
    }

}