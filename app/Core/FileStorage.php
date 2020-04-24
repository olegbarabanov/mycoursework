<?php

namespace App\Controller;

use App\Model\Model;

class FileStorage implements FileStorageInterface {

    protected SplFileInfo $path;
    protected string $salt; //Соль
    
    private function __construct(SplFileInfo $path, string $salt) {
        $this->path = $path;
        $this->salt = $salt;
    }
    
    public function setFile(SplFileInfo $file): string {
        $path = $file->getRealPath();
        $newName = crypt($path.time(), $this->salt);
        $newFullPath = $this->path . DIRECTORY_SEPARATOR . $newPath;
        rename($path, $newFullPath);
        return $newName;
    }
    
    public function deleteFile(string $id) {
        unlink($this->path . DIRECTORY_SEPARATOR . $id);
    }
    
    public function getFile(string $id): SplFileObject {
        return new SplFileObject($this->path . DIRECTORY_SEPARATOR . $id, "r");
    }
   
}
