<?php


namespace App\Services;


use Exception;

/**
 * Class FileManagerService
 * @package App\Services
 */
class FileManagerService
{
    private static $file;
    public const
        READ_ONLY = 'r',
        WRITE_ONLY = 'w',
        READ_WRITE = 'r+',
        WRITE_READ = 'w+',
        APPEND = 'a',
        APPEND_EXTENDED = 'a+';
    private const FILE_MODES = [
        self::READ_ONLY => self::READ_ONLY,
        self::WRITE_ONLY => self::WRITE_ONLY,
        self::READ_WRITE => self::READ_WRITE,
        self::WRITE_READ => self::WRITE_READ,
        self::APPEND => self::APPEND,
        self::APPEND_EXTENDED => self::APPEND_EXTENDED
    ];

    /**
     * @param $path
     * @param $mode
     * @throws Exception
     */
    public static function open($path, $mode)
    {

        self::$file = fopen($path, self::FILE_MODES[$mode]);
        if (!self::$file) {
            throw new Exception("Can't open file:$path");
        }
    }

    /**
     * @param $data
     * @throws Exception
     */
    public static function write($data)
    {
        $writtenData = $data;
        if (!is_string($writtenData)) {
            $writtenData = serialize($writtenData);
        }
        $result = fwrite(self::$file, $writtenData);
        $fileName = stream_get_meta_data(self::$file)['uri'];
        if (!$result) {
            throw new Exception("Can't write data to file:$fileName");
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function read()
    {
        $data = file_get_contents(self::$file);
        $fileName = stream_get_meta_data(self::$file)['uri'];
        if (!$data) {
            throw new Exception("Can't write data to file:$fileName");
        } else {
            return $data;
        }
    }

    /**
     * @throws Exception
     */
    public static function close()
    {
        $result = fclose(self::$file);
        $fileName = stream_get_meta_data(self::$file)['uri'];
        if (!$result) {
            throw new Exception("Can't close file:$fileName");
        }
    }
}