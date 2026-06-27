<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::insert([
            [
                'title' => 'Men Fashion',
                'image' => 'banners/banner.png',
                'link' => '/shop',
                'status' => 1,
                'position' => 'home_slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Women Fashion',
                'image' => 'banners/banner1.jpg',
                'link' => '/shop',
                'status' => 1,
                'position' => 'home_slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kids Fashion',
                'image' => 'banners/banner1.jpg',
                'link' => '/shop',
                'status' => 1,
                'position' => 'offer_left',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Big Sale 50%',
                'image' => 'banners/banner2.jpg',
                'link' => '/shop',
                'status' => 1,
                'position' => 'offer_right',
                'created_at' => now(),
                'updated_at' => now(),
            ],

                        [
                'title' => 'children',
                'image' => 'banners/banner2.jpg',
                'link' => '/shop',
                'status' => 1,
                'position' => 'offer_top',
                'created_at' => now(),
                'updated_at' => now(),
            ],

                        [
                'title' => 'woman',
                'image' => 'banners/banner2.jpg',
                'link' => '/shop',
                'status' => 1,
                'position' => 'offer_bottom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
