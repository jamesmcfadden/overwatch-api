<?php

if (! function_exists('doc_path')) {
    function doc_path($path = null)
    {
        return resource_path().DIRECTORY_SEPARATOR.'docs'.(is_null($path) ? '' : DIRECTORY_SEPARATOR.$path);
    }
}

if (! function_exists('data_path')) {
    function data_path($path = null)
    {
        return resource_path().DIRECTORY_SEPARATOR.'data'.(is_null($path) ? '' : DIRECTORY_SEPARATOR.$path);
    }
}
