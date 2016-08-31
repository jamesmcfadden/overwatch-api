<?php

use App\Importer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\Console\Output\NullOutput;

class ImporterTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->importer = new Importer(new NullOutput);
    }

    /**
     * @todo  This is marked incomplete due to SQLite being incompatible with
     *        how we import data.
     *
     * @return void
     */
    public function testImportAll()
    {
        $this->markTestIncomplete('SQLite inconsistencies');

        $importer->importAll();
    }

    /**
     * @return void
     */
    public function testGetFilenameForTable()
    {
        $this->assertEquals(
            data_path('hot_dogs.csv'),
            $this->importer->getFilenameForTable('hot_dogs')
        );
    }
}
