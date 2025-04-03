<?php
spl_autoload_register(function ($className) {
    $classPath = str_replace("_", "/", $className);

    @include getcwd() . '/lib/psr/log/' . $classPath . '.php';
});
