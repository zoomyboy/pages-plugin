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

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $page = Page::find($this->argument('filename'));

        $zgData = json_decode($page->viewBag['zg_data']);
        dd($zgData);

        $zgData->sections = collect($zgData->sections)->map(function($section) {
            $s = (object) [];
            $s->rows = $section->data->rows;
            $s->meta = (object) [
                'type' => $section->type,
                'title' => $section->data->title,
                'background' => $section->data->background
            ];

            return $s;
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
        return [];
    }
}
