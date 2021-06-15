<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Orchid\Screen\Layout;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        LayoutFactory::macro('stats', function (string $title, array $metrics) {
            return new class($title, $metrics) extends Layout
            {
                public string $title;
                public array $metrics;

                public function __construct(string $title, array $metrics)
                {
                    $this->title = $title;
                    $this->metrics = $metrics;
                }

                public function build(Repository $repository)
                {
                    return view('components.stats', [
                        'title' => $this->title,
                        'metrics' => $this->metrics,
                    ]);
                }
            };
        });
    }
}
