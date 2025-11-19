<?php

namespace BackstageStaticSiteGenerator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use BackstageStaticSiteGenerator\Commands\BackstageStaticSiteGeneratorCommand;

class BackstageStaticSiteGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('backstage-static-site-generator')
            ->hasCommand(BackstageStaticSiteGeneratorCommand::class);
    }
}
