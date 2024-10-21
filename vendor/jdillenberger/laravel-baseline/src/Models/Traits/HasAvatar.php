<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;



trait HasAvatar
{
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->acceptsMimeTypes([
            'image/jpeg',
            'image/png',
            'image/gif',
        ]);
    }

    public function getAvatarAttribute()
    {
        return collect($this->getMedia('avatar'))->first();
    }

    public function setAvatarAttribute($file)
    {
        $newMedia = null;

        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $newMedia = $this->addMedia($file)->preservingOriginal()->toMediaCollection('avatar');
        }

        if (is_string($file) && \Illuminate\Support\Str::startsWith($file, ['data:'])) {
            $newMedia = $this->addMediaFromBase64($file)->toMediaCollection('avatar');
        }

        $this->clearMediaCollectionExcept('avatar', $newMedia);

        return $newMedia;
    }
}
