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

    public function fieldsForIndex(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name', function () {
                if ($this->parent) {
                    return "{$this->name}/{$this->parent->name}";
                }

                return $this->name;
            }),
        ];
    }
}
