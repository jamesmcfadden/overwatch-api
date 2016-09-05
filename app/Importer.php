<?php

namespace App;

use DB;
use Symfony\Component\Console\Output\OutputInterface;

class Importer
{
    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * Tables the importer supports.
     *
     * Order is important to satisfy foreign key constraints, so
     * should mimic the order of the migrations
     *
     * @var array
     */
    protected $tables = [
        'roles',
        'sub_roles',
        'heroes',
        'hero_sub_roles',
        'map_modes',
        'events',
        'maps',
        'map_stages',
        'abilities',
        'qualities',
        'currencies',
        'reward_types',
        'rewards',
        'achievements',
        'platforms',
        'game_modes',
        'brawl_types',
        'brawls',
    ];

    /**
     * @param Symfony\Component\Console\Output\ConsoleOutput $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @return void
     */
    public function importAll()
    {
        foreach ($this->tables as $table) {
            $filename = $this->getFilenameForTable($table);

            if (! is_readable($filename)) {
                throw new \Exception(
                    'Trying to import data for table: '.$table.
                    ', but cannot read data file: '.$filename
                );
            }
            $csvData = trim(file_get_contents($filename));
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
            DB::table($table)->insert($data);

            $this->output->writeln('Imported '.count($data).' records for '.$table);
        }
    }

    /**
     * @param  string $table
     * @return string
     */
    public function getFilenameForTable($table)
    {
        return data_path($table.'.csv');
    }
}
