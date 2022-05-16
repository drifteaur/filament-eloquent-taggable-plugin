<?php

namespace Filament\Forms\Components;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentTaggable\Models\Tag;

class EloquentTagsInput extends TagsInput
{
    protected string | Closure | null $type = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(static function (EloquentTagsInput $component, ?Model $record): void {
            if (! $record) {
                $component->state([]);

                return;
            }

            $tags = $record->tags;

            $component->state($tags->pluck('name'));
        });

        $this->saveRelationshipsUsing(static function (EloquentTagsInput $component, ?Model $record, array $state) {
            $record->retag($state);
        });

        $this->dehydrated(false);
    }

    public function getSuggestions(): array
    {
        if ($this->suggestions !== null) {
            return parent::getSuggestions();
        }

        return Tag::query()
            ->pluck('name')
            ->toArray();
    }

}
