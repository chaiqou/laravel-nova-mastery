<?php

namespace App\Nova;

use Illuminate\Validation\Rules\File;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Publisher extends Resource
{
    public static string $model = \App\Models\Publisher::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Avatar::make('Logo')
                ->nullable()
                ->path('publishers')
                ->rules('nullable', File::image()->max(1024 * 2)),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'string', 'max:255'),

        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [];
    }

    public function filters(NovaRequest $request): array
    {
        return [];
    }

    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
