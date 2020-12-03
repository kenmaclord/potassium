<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class ProcessingStrategyCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'strategy:processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new processing strategy class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Processing Strategy';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/kenmaclord/potassium/src/stubs/Strategies/stubs/processing.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Strategies\Processing';
    }
}
