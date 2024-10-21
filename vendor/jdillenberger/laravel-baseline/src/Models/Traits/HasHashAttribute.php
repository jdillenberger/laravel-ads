<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait HasHashAttribute
{
    public static function bootHasHashAttribute()
    {
        static::saving(function ($model) {
            $this->attributes['hash'] = $this->hash(true);
        });
    }

    public function getHashAttribute()
    {
        return $this->getHash();
    }

    private function hash(bool $forceRehash = false)
    {

        if (! $forceRehash && ! is_null($this->hash)) {
            return $this->hash;
        }

        $hashAttributes = collect($this->attributes)->only($this->hashAttributes ?? collect($this->fillable)->except(['hash']));

        return hash('sha512', implode('', $hashAttributes->values()->toArray()));
    }
}
