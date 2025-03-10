<?php

namespace Yemenpoint\FilamentTree;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTreeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-tree')
            ->hasAssets()
            ->hasTranslations()
            ->hasViews();
    }
}

