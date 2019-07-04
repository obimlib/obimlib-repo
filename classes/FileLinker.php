<?php

namespace Push_Message;

/**
 * Класс предназначен для работы с файлами
 *
 * @author Oleg Pyatin o.pyatin@bimlib.pro
 */
class FileLinker
{
    protected static $list_of_tokens;

    protected const PATH_TO_DEFAULT_FILE = 'files/tokens_storage.json';

    protected static function loadTokensFile(string $path)
    {
        if (file_exists($path)) {

            $file = file_get_contents($path);
            static::$list_of_tokens = json_decode($file, true);

        } else {

            if (file_exists(static::PATH_TO_DEFAULT_FILE)) {

                $file = file_get_contents(static::PATH_TO_DEFAULT_FILE);
                static::$list_of_tokens = json_decode($file, true);
            }
        }
    }

    protected static function includeNewTokenToList(string $token_quant)
    {
        static::$list_of_tokens[] = $token_quant;
    }

    protected static function saveTokensFile(string $path)
    {
        $json_array = json_encode(static::$list_of_tokens);

        if (file_exists($path)) {
            $new_file = fopen($path, 'w');
        } else  {
            $new_file = fopen(static::PATH_TO_DEFAULT_FILE, 'w');
        }

        fwrite($new_file, $json_array);
        fclose($new_file);
    }

    public static function getListTokens($path)
    {
        static::loadTokensFile($path);
        return static::$list_of_tokens;
    }

    public static function addNewToken($token, $path=null)
    {
        static::loadTokensFile($path);
        static::includeNewTokenToList($token);
        static::saveTokensFile($path);
    }
}
