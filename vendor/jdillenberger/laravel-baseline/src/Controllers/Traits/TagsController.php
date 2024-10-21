<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

/**
 * @group Tags
 */
class TagsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Tags
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function list()
    {
        return $this->defaultList(config('larave-baseline.tags.tagable_models'));
    }

    /**
     * Single Tag
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function single(\Jdillenberger\LaravelBaseline\Models\Tag $tag)
    {
        return $this->defaultSingle($tag);
    }

    /**
     * Delete Tag
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function delete(\Jdillenberger\LaravelBaseline\Models\Tag $tag)
    {
        return $this->defaultDelete($tag);
    }

    /**
     * Create Tag
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function create(\Illuminate\Http\Request $request)
    {
        return $this->defaultCreate(getBaselineTagModel()::class, $request->all());
    }
}
