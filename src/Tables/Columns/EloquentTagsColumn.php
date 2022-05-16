<?php

namespace Filament\Tables\Columns;

use Illuminate\Database\Eloquent\Builder;

class EloquentTagsColumn extends TagsColumn
{
    protected ?string $type = null;

    public function getTags(): array
    {
        $record = $this->getRecord();

        $tags = $record->tags;

        return $tags->pluck('name')->toArray();
    }


    public function applyEagerLoading(Builder $query): Builder
    {
        if ($this->isHidden()) {
            return $query;
        }

        return $query->with(['tags']);
    }
}
