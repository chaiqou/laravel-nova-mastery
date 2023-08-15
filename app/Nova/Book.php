<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Book extends Resource
{
    public static string $model = \App\Models\Book::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'title',
        'blurb',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Book Title', 'title')->sortable()->required(),
            Number::make('Pages', 'number_of_pages')->filterable()->hideFromIndex(),
            Number::make('Copies', 'number_of_copies')->sortable()->hideFromIndex(),
            Boolean::make('Featured', 'is_featured')->filterable(),
            Image::make('Cover')->path('covers'),
            File::make('PDF')->path('pdfs'),
            Trix::make('Blurb'),
            URL::make('Purchase URL')->displayUsing(fn($value) => $value ? parse_url($value, PHP_URL_HOST) : null ),

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
