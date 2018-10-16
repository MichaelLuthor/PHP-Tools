<?php
spl_autoload_register(function( $class ) {
    if ( 'Facebook\\WebDriver\\' === substr($class, 0,19) ) {
        $path = __DIR__.'/lib/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($class,19)).'.php';
        if ( file_exists($path) ) {
            require $path;
        }
    }
});