<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

/**
 * @group Tags (Type Level)
 */
class TagModelsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Types
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function listTaggableModels()
    {
        return $this->successResourceFetched([
            'tagables' => array_keys(config('larave-baseline.tags.tagable_models')),
        ]);
    }

    /**
     * Get Tags (for Type)
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function getTagsForModelSlug(string $model)
    {
        $taggable_slug = \Illuminate\Support\Str::singular($model);
        $taggable_class = config('larave-baseline.tags.tagable_models')[$taggable_slug];

        $tags = \Jdillenberger\LaravelBaseline\Models\Tag::whereIn('id', function ($query) use ($taggable_class) {
            $query->select('tag_id')
                ->from('taggables')
                ->where('taggable_type', $taggable_class);
        })->get();

        return $this->successResourceFetched([
            'tags' => $tags,
        ]);
    }

    /**
     * List Tags (for Type)
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function taggedWith(string $model, string $delimited_tag_slugs)
    {
        $taggable_slug = \Illuminate\Support\Str::singular($model);
        $taggable_class = config('larave-baseline.tags.tagable_models')[$taggable_slug];
        $tagSlugs = explode(',', $delimited_tag_slugs);

        $pager = $taggable_class::with('tags')->withAnyTags($tagSlugs)->paginate();

        return $this->successResourceFetched([
            'pagination' => $this->pagerMeta($pager),
            'tags' => $pager->items(),
        ]);
    }
}
