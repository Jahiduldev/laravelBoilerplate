<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewTemplateGenerator extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:tem-gen {name : The name of the files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $name = $this->makeSubCategory($name);

        $this->generateController($name);

        $directory = resource_path("views/admin/{$name}");

        if ($this->makeFolder($directory)) {
            $this->copyFile($name, $directory);
        }

        $this->info('Files generated successfully.' . $name);
    }

    private function modifyContent(string $content, string $name): string
    {
        return str_replace('{{ name }}', $name, $content);
    }

    private function copyFile($name, $directory)
    {
        // Get all files from the template directory
        $sourceDirectory = resource_path("views/templates/view");
        $files = File::files($sourceDirectory);

        // Loop through each file and generate content dynamically
        foreach ($files as $file) {

            $content = File::get($file);

            $modifiedContent = $this->modifyContent($content, $name);

            // Determine the destination path for the file
            $destination = "{$directory}/" . pathinfo($file, PATHINFO_BASENAME);

            // Write the modified content to the destination file
            File::put($destination, $modifiedContent);

            $this->info("File '{$destination}' generated successfully.");
        }

        $files = File::files($sourceDirectory . '/js');
        $directory = resource_path("assets/js");

        foreach ($files as $file) {

            $content = File::get($file);

            $modifiedContent = $this->modifyContent($content, $name);

            // Determine the destination path for the file
            $destination = "{$directory}/{$name}" . ".js" ;

            // Write the modified content to the destination file
            File::put($destination, $modifiedContent);
        }


        $this->info('Files generated successfully.');
    }

    public function makeFolder($directory): bool
    {
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info("Directory '{$directory}' created successfully.");

            return true;
        }

        $this->info("Directory '{$directory}' already exists.");

        return false;
    }

    private function generateController($name): void
    {
        $content = view('templates.controller.controller', compact('name'))->render();
        $name = ucfirst($name);
        $filePath = app_path("Http/Controllers/Admin/{$name}Controller.php");
        File::put($filePath, "<?php \n \n \n". $content);
    }

    function makeSubCategory($string) {

        $subwords = explode('_', $string);


        foreach ($subwords as &$subword) {
            $subword = ucfirst($subword);
        }


        $result = implode('', $subwords);

        // Make the first letter lowercase
        return lcfirst($result);
    }

}
