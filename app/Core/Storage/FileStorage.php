<?php

namespace App\Core\Storage;

use SplFileInfo;

class FileStorage implements FileStorageInterface {

    protected SplFileInfo $path;
    protected string $salt; //Соль
    
    public function __construct(SplFileInfo $path, string $salt = "") {
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
    
    public function deleteFile(string $id): void {
        unlink($this->path . DIRECTORY_SEPARATOR . $id);
    }
    
    public function getFile(string $id): SplFileObject {
        return new SplFileObject($this->path . DIRECTORY_SEPARATOR . $id, "r");
    }

    public function isAccess(): bool {
        return true;
    }
   
}
