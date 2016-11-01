<?php

namespace App\Contracts\Importer;

interface ImporterInterface
{
    /**
     * Import data from an array of data paths.
     *
     * The argument should be an associative array where the keys are
     * table names and the values are absolute paths to the associated data files.
     *
     * For example:
     *
     * [
     *     'heroes' => '/path/to/heroes.csv'
     * ]
     *
     * @param  array $paths
     * @return void
     */
    public function import(array $paths);
}
