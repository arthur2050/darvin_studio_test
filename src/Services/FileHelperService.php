<?php


namespace App\Services;


use Exception;

class FileHelperService
{

    /**
     * @param $path
     * @param $mode
     * @param $data
     * @throws \Exception
     */
    public function writeData($path, $mode, $data)
    {
        FileManagerService::open($path, $mode);
        FileManagerService::write($data);
        FileManagerService::close();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function readData()
    {
        return FileManagerService::read();
    }
}