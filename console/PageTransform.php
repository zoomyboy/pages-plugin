<?php namespace Rainlab\Pages\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Rainlab\Pages\Classes\Page;

class PageTransform extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'page:transform';

    /**
     * @var string The console command description.
     */
    protected $description = 'Tranforms a page';

    public function mapSectionMeta($data, $callback) {
        $data->sections = collect($data->sections)->map(function($section) use ($callback) {
            $section->meta = call_user_func($callback, $section->meta);
            return $section;
        })->toArray();

        return $data;
    }

    public function mapModules($data, $callback) {
        $data->sections = collect($data->sections)->map(function($section) use ($callback) {
            $section->rows = collect($section->rows)->map(function($row) use ($callback) {
                $row->columns = collect($row->columns)->map(function($column) use ($callback) {
                    $column->modules = collect($column->modules)->map(function($module) use ($callback) {
                        return call_user_func($callback, $module);
                    })->toArray();
                    return $column;
                })->toArray();
                return $row;
            })->toArray();
            return $section;
        })->toArray();

        return $data;
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $page = Page::find($this->argument('filename'));

        $zgData = json_decode($page->viewBag['zg_data']);
        if (!$this->option('trans')) {
            echo $page->viewBag['zg_data'];
            exit;
        }

        $zgData->sections = collect($zgData->sections)->map(function ($section) {
            unset($section->meta->sidebar);

            $section->sidebar = (object) [
                'meta' => (object) ['position' => false],
                'modules' => [],
            ];

            return $section;
        })->toArray();

        $page->viewBag['zg_data'] = json_encode($zgData);
        $page->fill(['settings' => ['viewBag' => $page->viewBag]]);
        $page->save();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['filename']
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['trans']
        ];
    }
}
