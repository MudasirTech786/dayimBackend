<?php

namespace Database\Seeders;

use App\Models\Dayim;
use Illuminate\Database\Seeder;

class DM_eventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            '<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fdayimmarketing%2Fposts%2Fpfbid02tJtmzAYMrbt38sxm3n78jfqNGv3WZ8mDNiJNFQibgJuebFvyRtivZexCZ2hiYXNLl&show_text=true&width=500" width="500" height="787" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>',
            '<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fdayimmarketing%2Fposts%2Fpfbid02UytWz5VQStKmmJ7a8gD3Xwp44scP7EQ2AziaCFjrwHgKSw3jEuxKJVVZQfUEtYhFl&show_text=true&width=500" width="500" height="811" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>',
            '<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fdayimmarketing%2Fposts%2Fpfbid0upv4pZZNMduF5uEkKwQ6TewL5mi3944hQvCT2bmAtsyp6JuNvPRZxHbp6cjghtzDl&show_text=true&width=500" width="500" height="786" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>',
        ];

        foreach ($events as $event) {
            Dayim::create(['event' => $event]);
        }
    }
}
