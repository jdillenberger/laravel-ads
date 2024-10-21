<?php

namespace App\Services\Adfrodite\Seeders;

use Jdillenberger\LaravelAds\Models\AdCampaign;
use Jdillenberger\LaravelAds\Models\AdPlacement;
use Jdillenberger\LaravelAds\Models\Advertisement;
use Carbon\Carbon;

class CampaignSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {

        $campaign = AdCampaign::create([
            'name' => 'Default Campaign',
            'budget' => 10000,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addCenturies(1),
            'status' => 'draft',
        ]);

        $placement = AdPlacement::create([
            'name' => 'Header',
            'description' => '',
            'location' => 'header',
            'width' => 300,
            'height' => 150,
        ]);

        $advertisement1 = Advertisement::create([
            'title' => 'Example Advertisement',
            'link' => 'https://example.com',
            'content' => 'Lorem Ipsum Dolor',
            'type' => 'image',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addCenturies(1),
            'status' => 'draft',
            'campaign_id' => $campaign->id,
            'placement_id' => $placement->id,
        ]);

    }
}
