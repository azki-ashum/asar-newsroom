<?php

namespace Botble\Mitra\Providers;

use Botble\Mitra\Models\Mitra;
use Illuminate\Support\ServiceProvider;
use Botble\Mitra\Repositories\Caches\MitraCacheDecorator;
use Botble\Mitra\Repositories\Eloquent\MitraRepository;
use Botble\Mitra\Repositories\Interfaces\MitraInterface;
use Illuminate\Support\Facades\Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class MitraServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(MitraInterface::class, function () {
            return new MitraCacheDecorator(new MitraRepository(new Mitra));
        });

        $this->setNamespace('plugins/mitra')->loadHelpers();
    }

    public function boot(): void
    {
        $this
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes();

        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Mitra::class, [
                'name',
            ]);
        }

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-mitra',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/mitra::mitra.name',
                'icon'        => 'fa fa-list',
                'url'         => route('mitra.index'),
                'permissions' => ['mitra.index'],
            ]);
        });
    }
}
