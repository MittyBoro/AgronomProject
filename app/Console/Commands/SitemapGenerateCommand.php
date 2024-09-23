<?php

namespace App\Console\Commands;

use App\Services\Seo\SitemapService;
use Illuminate\Console\Command;

class SitemapGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сгенерировать карту сайта';

    /**
     *
     */
    public function handle(): void
    {
        SitemapService::generate();

        $this->info('Карта сайта сгенерирована');
    }
}
