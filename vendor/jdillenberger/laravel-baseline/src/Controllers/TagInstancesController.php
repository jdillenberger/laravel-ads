<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

/**
 * @group Tags (for Instances)
 */
class TagInstancesController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Tags (for Model Instance)
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function listInstanceTags(string $taggable_slug, int $taggable_id)
    {
        $taggable_slug = \Illuminate\Support\Str::singular($taggable_slug);
        $taggable_class = config('laravel-baseline.tags.tagable_models')[$taggable_slug];
        $taggable = $taggable_class::with('tags')->findOrFail($taggable_id);

        return $this->successResourceFetched([
            'tags' => $taggable->tags()->get()->makeHidden('pivot'),
        ]);
    }

    /**
     * Attach Tag (to Model Instance)
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function attach(string $taggable_slug, int $taggable_id, string $tag_slugs)
    {
        $taggable_slug = \Illuminate\Support\Str::singular($taggable_slug);
        $taggable_class = config('laravel-baseline.tags.tagable_models')[$taggable_slug];
        $taggable = $taggable_class::with('tags')->findOrFail($taggable_id);
        $tagSlugs = explode(',', $tag_slugs);
        $taggable->attachTags($tagSlugs);
        $taggable->load('tags');

        return $this->successResourceCreated([
            $taggable_slug => $taggable->makeHidden('pivot'),
        ]);
    }

    /**
     * Detach Tag (from Model Instance)
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function detach(string $taggable_slug, int $taggable_id, string $tag_slugs)
    {
        $taggable_slug = \Illuminate\Support\Str::singular($taggable_slug);
        $taggable_class = config('laravel-baseline.tags.tagable_models')[$taggable_slug];
        $taggable = $taggable_class::with('tags')->findOrFail($taggable_id);
        $tagSlugs = explode(',', $tag_slugs);
        $taggable->detachTags($tagSlugs);
        $taggable->load('tags');

        return $this->successResourceDeleted([
            $taggable_slug => $taggable,
        ]);
    }
}
