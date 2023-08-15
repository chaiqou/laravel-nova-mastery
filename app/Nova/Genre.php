<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Genre extends Resource
{
    public static string $model = \App\Models\Genre::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'parent.name',
    ];

    public static $with = ['parent'];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()
                ->sortable(),

            Text::make('Name')
                ->rules('required', 'string', 'max:60'),

            BelongsTo::make('Parent', resource: Genre::class)
                ->help('If this genre is a sub-genre, select the parent genre.')
                ->nullable(),

            HasMany::make('Books'),

            HasMany::make('Sub-Genres', 'subGenres', Genre::class),
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
