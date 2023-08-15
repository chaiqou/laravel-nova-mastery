<?php

namespace App\Nova;

use Illuminate\Validation\Rules\File;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Author extends Resource
{
    public static string $model = \App\Models\Author::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
    ];

    public function fields(NovaRequest $request): array
    {
        return [

            ID::make()
                ->sortable(),

            Avatar::make('Avatar')
                ->showWhenPeeking()
                ->rounded()
                ->rules('required', File::image()->max(1024 * 10))
                ->path('authors'),

            Text::make('Name')
                ->showWhenPeeking()
                ->sortable()
                ->rules('required', 'string', 'max:255'),

            Trix::make('Biography')
                ->showWhenPeeking()
                ->fullWidth()
                ->rules('required', 'string', 'max:10000'),

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
