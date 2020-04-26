<?php

namespace App\Core\Storage;

class FileStorage implements FileStorageInterface {

    protected \SplFileInfo $path;
    protected string $salt; // Hash salt
    
    public function __construct(\SplFileInfo $path, string $salt = "") {
        $this->path = $path;
        $this->salt = $salt;
    }
    
    public function setFile(\SplFileObject $file): string {
        $newName = crypt($this->path.time(), $this->salt);
        $newFile = new \SplFileObject($this->path
                                      .DIRECTORY_SEPARATOR
                                      .$newName
                                      .'.pdf', "w+");
        $newFile->fwrite($file->fread(0)); //FIXME 0 to length. It's safety my server @ Oleg Barabanov
        return $newName;
    }
    
    public function deleteFile(string $id): void {
        unlink($this->path . DIRECTORY_SEPARATOR . $id);
    }
    
    public function getFile(string $id): SplFileObject {
        return new \SplFileObject($this->path . DIRECTORY_SEPARATOR . $id, "r");
    }

    public function isAccess(): bool {
        return true;
    }
   
}
