<?php

namespace BackstageStaticSiteGenerator\Commands;

use Illuminate\Console\Command;

class BackstageStaticSiteGeneratorCommand extends Command
{
    public $signature = 'backstage:generate-static-site {--output=public/static/} {--optimize-images=true} {--minify-html=true}';

    public $description = 'Generate a static version of the production site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching public content...');

        $domains = \Backstage\Models\Domain::with('site.contents')
            ->where('environment', 'production')
            ->get();

        $urls = $domains->pluck('site.contents')
            ->flatten()
            ->filter(function ($content) {
                return $content->public == true;
            })
            ->pluck('url')
            ->map(function ($url) {
                return 'https://'.str_replace('https://', '', $url);
            })
            ->unique();

        // order $urls by length descending
        $urls = $urls->sortByDesc(function ($url) {
            return strlen($url);
        })->values();

        foreach ($domains as $domain) {

            $this->info('Running npm build...');
            exec('npm run build');
            \Illuminate\Support\Facades\File::copyDirectory('./public/build', $this->option('output').$domain->name.'/build');

            // Get default filesystem disk
            $defaultDisk = config('filesystems.default');
            // Get the root and copy to output dir
            $root = config("filesystems.disks.{$defaultDisk}.root");
            $this->info("Copying assets from {$root} to {$this->option('output')}".$domain->name);

            \Illuminate\Support\Facades\File::copyDirectory($root, $this->option('output').$domain->name);

            // Optimize images in the output directory
            if ($this->option('optimize-images')) {
                $this->info('Optimizing images...');
                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $files = \Illuminate\Support\Facades\File::allFiles($this->option('output').$domain->name);

                foreach ($files as $file) {
                    if (in_array(strtolower($file->getExtension()), $imageExtensions)) {
                        $this->optimizeImage($file->getPathname());
                    }
                }
            }

            // Remove the .gitignore file if exists
            if (\Illuminate\Support\Facades\File::exists($this->option('output').$domain->name.'/.gitignore')) {
                \Illuminate\Support\Facades\File::delete($this->option('output').$domain->name.'/.gitignore');
            }

            $this->info('npm build completed successfully.');

            $domainUrls = $urls->map(function ($url) use ($domain) {
                if ($url == config('app.url')) {
                    return 'https://'.$domain->name.'/index.html';
                }
                // $url = str_replace(config('app.url') . '/', '', $url);
                $url = str_replace(config('app.url'), $domain->name, $url);

                return 'https://'.$url.'.html';
            });

            foreach ($domain->site->contents as $page) {

                if ($page->public == false) {
                    continue;
                }

                $slug = $page->slug;
                $this->info("Processing page: {$page->url}");
                $path = empty($page->path) || $page->path == '/' ? 'index' : $page->path;
                $outputDir = $this->option('output').$domain->name.'/'.$path.'.html';

                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->get($page->url);
                if ($response->successful()) {
                    $content = $response->body();

                    foreach ($urls as $index => $url) {
                        $content = preg_replace('/href=["\']'.preg_quote($url, '/').'["\']/', 'href="'.$domainUrls[$index].'"', $content);
                    }
                    $parsedUrl = parse_url(config('app.url'));
                    $originalDomain = $parsedUrl['host'] ?? config('app.url');
                    $content = str_replace($originalDomain, $domain->name, $content);

                    $path = empty($page->path) ? 'index' : $page->path;

                    if ($this->option('minify-html')) {
                        $content = (new \voku\helper\HtmlMin())->minify($content); 
                    }
                    
                    if (!is_dir(dirname($outputDir))) {
                        mkdir(dirname($outputDir), 0755, true);
                    }
                    file_put_contents($outputDir, $content);
                    $this->info("Saved static page to: {$outputDir}");
                } else {
                    $this->error("Failed to fetch page: {$slug}");
                }
            }
        }

        return self::SUCCESS;
    }

    private function optimizeImage($path)
    {
        $image = new \Gumlet\ImageResize($path);
        $this->info("Optimizing image: {$path}");
        if ($image->getSourceWidth() > 1024 || $image->getSourceHeight() > 1024) {
            $image->resizeToBestFit(1024, 1024);
            $image->save(filename: $path, quality: 60);
        } else {
            $image->save(filename: $path, quality: 60);
        }
    }
}
