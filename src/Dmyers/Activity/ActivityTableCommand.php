<?php namespace Dmyers\Activity;

// currently unused

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ActivityTableCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'activity:table';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a migration for the Activity database table';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$fullPath = $this->createBaseMigration();

		file_put_contents($fullPath, $this->getMigrationStub());

		$this->info('Migration created successfully!');

		$this->call('dump-autoload');
	}

	/**
	 * Create a base migration file for the model.
	 *
	 * @return string
	 */
	protected function createBaseMigration()
	{
		$name = 'create_activity_table';

		$path = $this->laravel['path'].'/database/migrations';

		return $this->laravel['migration.creator']->create($name, $path);
	}

	/**
	 * Get the contents of the sluggable migration stub.
	 *
	 * @return string
	 */
	protected function getMigrationStub()
	{
		$stub = file_get_contents(__DIR__.'/stubs/migration.stub');
		
		$table = str_plural(strtolower($this->argument('table')));
		$column = $this->argument('column');
		
		if (empty($column)) {
			$column = str_singular($table).'_id';
		}
		
		$table = 'activity_'.$table;
		
		return str_replace(
			array('activity_table', 'activity_column'),
			array($table, $column),
			$stub
		);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('table',  InputArgument::REQUIRED, 'The name of your activity table.'),
			array('column', InputArgument::OPTIONAL, 'The name of your activity primary ID column name.'),
		);
	}

}