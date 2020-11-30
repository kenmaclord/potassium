<?php

namespace Potassium\App\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\GeneratorCommand;

class NewPageCommand extends Command
{
    protected $page;
    protected $model;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:page {page} { --model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Créé une nouvelle page dans l'admin";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->page = strtolower($this->argument('page'));
        $model = $this->getModelName($this->option('model'));


        $this->modelFile = "{$model}.php";
        $this->modelFullPath = "\App\Entities\\{$model}";
        $this->modelForController = "App\\Entities\\{$model}";


        $this->makeModel();
        $this->makeView();
        $this->makeJs();
        $this->makeCss();
        $this->updateSidebar();
        $this->updateRoutes();
        $this->makeController();
    }


    public function getModelName($option)
    {
        return is_null($option) ? ucwords($this->page) : ucwords(strtolower($option));
    }


    /**
     * Création de la vue
     */
    public function makeView()
    {
        tap(resource_path("views/admin/pages/{$this->page}"), function ($folder){
            if(!File::exists($folder)){
                File::makeDirectory($folder, 0755, true);
                $view = $folder."/index.blade.php";
                File::copy(base_path("/vendor/kenmaclord/potassium/src/stubs/pages/index.blade.php"), $view);
                file_put_contents($view,str_replace('@page',$this->page,file_get_contents($view)));
            }
        });
    }


    /**
     * Création du js
     */
    public function makeJs()
    {
        tap(resource_path("js/admin/pages/{$this->page}"), function ($folder){
            if(!File::exists($folder)){
                File::makeDirectory($folder);
                $js = $folder."/{$this->page}.js";
                File::copy(base_path("/vendor/kenmaclord/potassium/src/stubs/pages/page.js"), $js);
                file_put_contents($js,str_replace('@page',$this->page,file_get_contents($js)));

                $admin_js = resource_path("js/admin/admin.js");
                $placeholder = "//@newJs";
                $template = "import {$this->page} \t\t\tfrom './pages/{$this->page}/{$this->page}'\n\n{$placeholder}";

                $this->replace($admin_js, $placeholder, $template);
            }
        });
    }

    /**
     * Création du css
     */
    public function makeCss()
    {
        tap(resource_path("sass/admin/pages/{$this->page}.scss"), function ($css){
            if(!File::exists($css)){
                File::copy(base_path("/vendor/kenmaclord/potassium/src/stubs/pages/page.scss"), $css);
                file_put_contents($css,str_replace('@page',$this->page,file_get_contents($css)));

                $admin_scss = resource_path("sass/admin/admin.scss");
                $placeholder = "//@newCss";
                $template = "@import \"pages/{$this->page}\";\n\n{$placeholder}";

                $this->replace($admin_scss, $placeholder, $template);
            }
        });
    }

    /**
     * Sidebar
     */
    public function updateSidebar()
    {
        $sidebar = resource_path("views/admin/app/sidebar.blade.php");
        $placeholder = "{{-- @page --}}";
        $template = "@can('manage', [App\Entities\User::class, 'users'])\n\t\t\t<li><a href='/admin/{$this->page}'>".ucwords($this->page)."</a></li>\n\t\t@endcan\n\n\t\t{$placeholder}";

        $this->replace($sidebar, $placeholder, $template);
    }


    /**
     * Routes
     */
    public function updateRoutes()
    {
        $routes = base_path("routes/admin.php");
        $placeholder = "// @PageRoutes";
        $template = "\t\t/**\n\t\t* Routes pour les ".ucwords($this->page)."\n\t\t*/\n\t\tRoute::group(['prefix'=>'{$this->page}', 'middleware' => 'can:manage,App\Entities\User'], function(){\n\t\t\tRoute::get('/', '".ucwords($this->page)."Controller@index');\n\t\t});\n\n{$placeholder}";

        $this->replace($routes, $placeholder, $template);
    }

    public function makeController()
    {
        $controller_name = ucwords($this->page)."Controller";

        Artisan::call("make:controller", ["name" => "\Admin\\{$controller_name}", "-q" => true, "--model" => $this->modelForController]);

        $controller = app_path("Http/Controllers/Admin/{$controller_name}.php");
        $placeholder ="public function index()\n    {\n        //\n    }";
        $template = "public function index()\n\t{\n\t\treturn view('admin.pages.{$this->page}.index');\n\t}";

        $this->replace($controller, $placeholder, $template);
    }

    public function makeModel()
    {
        if (File::exists(base_path("app/Entities/{$this->modelFile}"))) {
            unlink(base_path("app/Entities/{$this->modelFile}"));
        }

        Artisan::call("make:model", ["name" => $this->modelFullPath, "-m"=> true, "-f"=>true]);
    }


    public function replace($file, $placeholder, $template)
    {
        file_put_contents($file, str_replace($placeholder, $template, file_get_contents($file)));
    }
}
