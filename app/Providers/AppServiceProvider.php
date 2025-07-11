<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "IT" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('IT') ? true : null;
        });

        // mapping nama model untuk flow item type
        Relation::morphMap([
            'komponen' => 'App\Models\Komponen',
            'proses' => 'App\Models\Proses',
            'qc' => 'App\Models\Qc',
        ]);

        // Add a custom macro to the Query Builder
        Builder::macro('search', function (array $fields, string $searchTerm) {
            return $fields
                ? $this->where(function ($query) use ($fields, $searchTerm) {
                    for ($i = 0; $i < count($fields); $i++) {
                        $i === 0
                            ? $query->where($fields[$i], 'like', '%' . $searchTerm . '%')
                            : $query->orwhere($fields[$i], 'like', '%' . $searchTerm . '%');
                    }
                }) : $this;
        });
    }
}
