<?php


namespace Chiven\Http;


use Chiven\Http\Entity\File;

class Request
{
    private $headers;
    private $files;

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files): void
    {
        $this->files = $files;
    }

    public function __construct(array $files = [])
    {
        $this->setFiles($this->buildFilesArray($files));
    }

    public function fromGlobals()
    {
        $this->setFiles($this->buildFilesArray($_FILES));
    }

    /**
     * @param array $files
     * @return File[]
     */
    private function buildFilesArray(array $files)
    {
        $fileObjectsArray = [];
        $fileCount = count($files['name']);

        $purifiedFileArray = [];

        for ($i = 0; $i < $fileCount; $i++) {
            $tmp = [];

            foreach ($files as $fileProperty => $value) {
                foreach ($value as $key => $item) {
                    $tmp[$fileProperty] = $files[$fileProperty][$i];
                }
            }

            $purifiedFileArray[] = $tmp;
        }

        foreach ($purifiedFileArray as $item) {
            $fileObjectsArray[] =  $this->fileObjectBuilder($item);
        }

        return $fileObjectsArray;
    }

    /**
     * @param array $fileArray
     * @return File
     */
    private function fileObjectBuilder(array $fileArray)
    {
        $file = new File();

        $fileNameExloded = explode('.', $fileArray['name']);

        $file->setName($fileArray['name']);
        $file->setSize($fileArray['size']);
        $file->setExtension(array_pop($fileNameExloded));
        $file->setMime($fileArray['type']);
        $file->setTmpName($fileArray['tmp_name']);

        return $file;
    }
}