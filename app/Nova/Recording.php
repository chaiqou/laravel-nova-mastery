<?php

namespace App\Nova;

use Illuminate\Validation\Rules\File;
use Laravel\Nova\Fields\Audio;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Recording extends Resource
{
    public static string $model = \App\Models\Recording::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'string', 'max:255'),

            Audio::make('Audio')
                ->path('recordings')
                ->showOnIndex()
                ->creationRules('required')
                ->rules(File::types('mp3', 'wav', 'ogg')->max(1024 * 20))
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
