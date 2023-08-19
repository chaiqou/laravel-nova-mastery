<?php

namespace App\Nova;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
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
        'author.name',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()
                ->sortable(),

            Image::make('Cover')
                ->path('covers'),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'string', 'min:1', 'max:255')
                ->creationRules('unique:books,title')
                ->updateRules('unique:books,title,{{resourceId}}'),

            BelongsTo::make('Author')
                ->sortable(),

            BelongsTo::make('Publisher')
                ->filterable()
                ->hideFromIndex(),

            Trix::make('Blurb')
                ->alwaysShow()
                ->fullWidth(),

            Number::make('Pages', 'number_of_pages')
                ->filterable()
                ->hideFromIndex()
                ->rules('required', 'integer', 'min:1', 'max:10000'),

            Number::make('Copies', 'number_of_copies')
                ->sortable()
                ->required()
                ->help('The total number of copies of this book that the library owns.'),

            Boolean::make('Featured', 'is_featured')
                ->help('Whether this book is featured on the homepage.')
                ->filterable(),

            File::make('PDF')
                ->path('pdfs'),

            URL::make('Purchase URL')
                ->displayUsing(fn ($value) => $value ? parse_url($value, PHP_URL_HOST) : null)
                ->hideFromIndex(),

            BelongsTo::make('Genre')
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereNull('parent_id');
                })
                ->rules('required', Rule::exists('genres', 'id')->whereNull('parent_id')),

            BelongsTo::make('Subgenre', resource: Genre::class)->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                $query->whereNotNull('parent_id');
            })
                ->rules('required', Rule::exists('genres', 'id')->whereNotNull('parent_id')),

            HasMany::make('Audio Recordings', 'recordings', resource: Recording::class),

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
