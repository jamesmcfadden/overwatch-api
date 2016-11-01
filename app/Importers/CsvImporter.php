<?php

namespace App\Importers;

use Illuminate\Database\Connection;
use App\Contracts\Importer\ImporterInterface;
use App\Exceptions\Importer\ImporterException;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class CsvImporter implements ImporterInterface
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db;

    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutputInterface
     */
    protected $output;

    /**
     * @param \Illuminate\Database\Connection $db
     * @param Symfony\Component\Console\Output\ConsoleOutputInterface $output
     */
    public function __construct(Connection $db, ConsoleOutputInterface $output)
    {
        $this->db = $db;
        $this->output = $output;
    }

    /**
     * Import data from an array of data paths.
     *
     * The argument should be an associative array where the keys are
     * table names and the values are absolute paths to the associated data files.
     *
     * For example:
     *
     * [
     *     'items' => '/path/to/items.csv'
     * ]
     *
     * @param  array $paths
     * @return void
     *
     * @throws App\Exceptions\Importer\ImporterException
     */
    public function import(array $paths)
    {
        foreach ($paths as $table => $path) {
            if (! is_readable($path)) {
                throw new ImporterException(
                    sprintf('Trying to import data for table: %s, but cannot read data file: %s', $table, $path)
                );
            }

            $csvData = trim(file_get_contents($path));
            $lines = explode(PHP_EOL, $csvData);
            $headers = str_getcsv(array_shift($lines));
            $data = [];

            foreach ($lines as $i => $line) {
                foreach (str_getcsv($line, ',') as $x => $item) {
                    if ($item == '') {
                        $item = null;
                    }
                    $data[$i][$headers[$x]] = $item;
                }
            }
            $this->db->table($table)->insert($data);

            $this->output->writeln(sprintf('<info>Imported:</info> %d records for %s', count($data), $table));
        }
        $this->output->writeln(sprintf('<info>Finished importing %d data files</info>', count($paths)));
    }
}
