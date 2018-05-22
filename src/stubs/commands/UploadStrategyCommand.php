<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class UploadStrategyCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'strategy:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new upload strategy class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Upload Strategy';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return resource_path().'/stubs/uploadable.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Strategies\Upload';
    }
}
