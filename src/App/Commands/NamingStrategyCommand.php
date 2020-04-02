<?php

namespace Potassium\App\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class NamingStrategyCommand extends GeneratorCommand
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'strategy:naming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new naming strategy class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Naming Strategy';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/kenmaclord/potassium/src/stubs/naming.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Strategies\Naming';
    }
}
