<?php

use App\Hero;
use App\Importer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\Console\Output\NullOutput;

class ImporterTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');
        $importer = new Importer(new NullOutput, $artisan);

        $this->importer = $importer;
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
    public function testRefresh()
    {
        factory(Hero::class, 50)->create();

        $this->assertCount(50, Hero::all());

        $this->importer->refresh();

        $this->assertCount(0, Hero::all());
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
