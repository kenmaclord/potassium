<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class PublishabilityStrategyCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'strategy:publishable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new publishability strategy class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Publishability Strategy';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return resource_path().'/stubs/publishable.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Strategies\Publishability';
    }
}
