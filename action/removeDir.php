<?php

class removeDir {

    function RDir( $path ) {
        // если путь существует и это папка
        if ( file_exists( $path ) AND is_dir( $path ) ) {
            // открываем папку
            $dir = opendir($path);
            while ( false !== ( $element = readdir( $dir ) ) ) {
                // удаляем только содержимое папки
                if ( $element != '.' AND $element != '..' )  {
                    $tmp = $path . '/' . $element;
                    chmod( $tmp, 777 );
                    // если элемент является папкой, то
                    // удаляем его используя нашу функцию RDir
                    if ( is_dir( $tmp ) ) {
                        RDir( $tmp );
                        // если элемент является файлом, то удаляем файл
                    } else {
                        unlink( $tmp );
                    }
                }
            }
            // закрываем папку
            closedir($dir);
            // удаляем саму папку
            if ( file_exists( $path ) ) {
                rmdir( $path );
            }
        }
    }
}