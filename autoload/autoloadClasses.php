<?php

function __autoload($class_name) 
{
    $bigLetters = preg_replace('~[^A-Z]~', '', $class_name);
    $length = strlen($bigLetters);
    $filePath = ltrim(preg_replace( '~[A-Z]~', DIRECTORY_SEPARATOR . '$0', $class_name.'.php'), DIRECTORY_SEPARATOR);
    $filename = substr_replace($filePath, $class_name.'.php', strripos($filePath, DIRECTORY_SEPARATOR)+1);

    for ($i = 1; $i <= $length; $i++) {
        if (!file_exists($filename)) {
            $filePath = substr_replace($filePath, '', strripos($filePath, DIRECTORY_SEPARATOR), 1);
            $filename = substr_replace($filePath, $class_name.'.php', strripos($filePath, DIRECTORY_SEPARATOR)+1);
            $i++;
        } else {
            include $filename;
            break;
        }
    }
}

