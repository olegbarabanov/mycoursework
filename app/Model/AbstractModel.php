<?php 

namespace App\Model;

use App\Repository\AbstractRepository;

abstract class AbstractModel {

    protected AbstractRepository $repository;
    protected string $repositoryClass;

    public function __construct(AbstractRepository $repository){
        $this->repository = $repository;
    }

    public function getCollection(array $data = []): array
    {
        return $this->repository->getCollection($data);
    }

    public function insert(iterable $data): iterable
    {
        $dataClass = $this->repository->getDataClass();
        $item = new $dataClass;
        foreach ($data as $key => $value) $item->$key = $value;
        $item->id = null;
        return $this->repository->insert($item);
    }

    public function update(iterable $data): iterable
    {
        $dataClass = $this->repository->getDataClass();
        $item = new $dataClass;
        foreach ($data as $key => $value) $item->$key = $value;
        return $this->repository->update($item);
    }

    public function delete(int $id): array
    {
        $dataClass = $this->repository->getDataClass();
        $item = new $dataClass;
        $item->id = $id;
        return $this->repository->delete($item);
    }

    public function getScheme(?int $id = null): array {
        return $this->repository->getScheme($id);
    }

}
