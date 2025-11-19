<?php

namespace BackstageStaticSiteGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BackstageStaticSiteGenerator\BackstageStaticSiteGenerator
 */
class BackstageStaticSiteGenerator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BackstageStaticSiteGenerator\BackstageStaticSiteGenerator::class;
    }
}
