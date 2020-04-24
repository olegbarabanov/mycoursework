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

    public function notify(?string $event = null, ?RepositoryObjectInterface $data = null)
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
                $queryBuilder->like($filter["field"], $filter["value"]);
            };
        };

        //filled
        if (isset($params["filter"]) && is_array($params["filter"])) {
            foreach ($params["filter"] as $filter) {
                $queryBuilder->lte($filter["field"], $filter["value"]);
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

    public function insert(RepositoryObjectInterface $obj): array
    {
        $rawData = $obj->getRawData();
        $table = $this->getDatabaseTable();
        $success = $this->db->table($table)->insert($rawData);
        $lastId = $success ? $this->db->getLastId() : null;
        return ["save" => $success, "id" => $lastId];
    }

    public function update(RepositoryObjectInterface $obj): array
    {
        $rawData = $obj->getRawData();
        $table = $this->getDatabaseTable();
        $success = $this->db($table)->eq("id", $obj->id)->update($rawData);
        return ["save" => $success, "id" => $obj->id];
    }

    public function delete(RepositoryObjectInterface $obj): array
    {
        $table = $this->getDatabaseTable();
        $success = $table->eq("id", $obj->id)->remove();
        return ["save" => $success, "id" => $obj->id];
    }

    /**
     * Return custom map field in the used table;
     * 
     * @return array
     */
    abstract public function getScheme(): array;

}