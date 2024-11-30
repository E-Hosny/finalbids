<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Contact Mail',
                'slug' => 'contact-mail',
                'value' => 'info@example.com',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Tag line',
                'slug' => 'tag-line',
                'value' => 'Our vision is to make all people the best place to live for them',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Youtube link',
                'slug' => 'yt-link',
                'value' => 'info@example.com',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Twitter link',
                'slug' => 'twitter-link',
                'value' => 'info@example.com',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Facebook link',
                'slug' => 'fb-link',
                'value' => 'info@example.com',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Instagram link',
                'slug' => 'insta-link',
                'value' => 'info@example.com',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Linkedin link',
                'slug' => 'linkedin-link',
                'value' => 'info@example.com',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'WhatsApp No.',
                'slug' => 'whatsapp-no',
                'value' => '+917894561230',
                'image' => null,
                'is_static' => 1,
            ],
            [
                'title' => 'Phone No.',
                'slug' => 'phone-no',
                'value' => '+917894561230',
                'image' => null,
                'is_static' => 1,
            ]
        ];

        foreach ($pages as $pageData) {
            Setting::create($pageData);
        }
    }
}