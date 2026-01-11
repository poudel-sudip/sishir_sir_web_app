<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement;
use App\Models\Categories;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();
        // $this->advertisementSeeder();
        $this->webPageSeedeer();
    }

    private function advertisementSeeder()
    {
        $ads = [
            [
                'banner' => '',
                'link' => '',
                'info' => 'Authentication Top Advertisement (750X50) ',
                'position' => 'auth_top_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Authentication Bottom Advertisement (1000X100) ',
                'position' => 'auth_bottom_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below Landing Advertisement (1600X100)',
                'position' => 'home_below_landing_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below Mock Test Advertisement (1600X100)',
                'position' => 'home_below_mock_test_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below PDF Bank Advertisement (1600X100)',
                'position' => 'home_below_pdf_bank_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below Library Advertisement (1600X100)',
                'position' => 'home_below_library_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below Blog Advertisement (1600X100)',
                'position' => 'home_below_blog_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below Books Advertisement (1600X100)',
                'position' => 'home_below_books_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Home Below Video Advertisement (1600X100)',
                'position' => 'home_below_video_ad',
                'status' => 'Inactive'
            ],
            [
                'banner' => '',
                'link' => '',
                'info' => 'Page Content Advertisement (1600X100)',
                'position' => 'page_content_ad',
                'status' => 'Inactive'
            ],          
            [
                'banner' => '',
                'link' => '',
                'info' => 'Page Sidebar Advertisement (200X300)',
                'position' => 'page_sidebar_ad',
                'status' => 'Inactive'
            ]                  
        ];

        foreach ($ads as $ad) {
            Advertisement::create($ad);
        }
    }

    private function webPageSeedeer()
    {
        $pages = [
            [
                'type' => 'webpage-about',
                'name' => 'About Us',
                'status' => 'Active',
            ],
            [
                'type' => 'webpage-policy',
                'name' => 'Privacy Policy',
                'status' => 'Active',
            ],
            [
                'type' => 'webpage-vision',
                'name' => 'Vision',
                'status' => 'Active',
            ],
            [
                'type' => 'webpage-contact',
                'name' => 'Contact',
                'status' => 'Active',
            ],
            
        ];

        foreach ($pages as $page) {
            Categories::create($page);
        }

    }
}
