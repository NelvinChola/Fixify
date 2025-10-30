<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssueCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Power Issues',
                'description' => 'Problems related to charging, battery, or power supply failures.',
            ],
            [
                'name' => 'Performance Issues',
                'description' => 'Issues affecting the speed, responsiveness, or efficiency of the device.',
            ],
            [
                'name' => 'Software Issues',
                'description' => 'Bugs, crashes, or incompatibilities with installed applications or operating system.',
            ],
            [
                'name' => 'Storage Issues',
                'description' => 'Errors related to disk space, corrupted files, or failing storage devices.',
            ],
            [
                'name' => 'Display Issues',
                'description' => 'Screen flickering, dead pixels, dim displays, or backlight problems.',
            ],
            [
                'name' => 'Liquid Damage Issues',
                'description' => 'Faults caused by exposure to liquids, such as short circuits or corrosion.',
            ],
            [
                'name' => 'Connectivity Issues',
                'description' => 'Problems with Wi-Fi, Bluetooth, cellular, or network connections.',
            ],
            [
                'name' => 'Output Issues',
                'description' => 'Faults with speakers, printers, projectors, or other output devices.',
            ],
            [
                'name' => 'Mechanical Issues',
                'description' => 'Physical damages such as broken hinges, buttons, fans, or moving parts.',
            ],
            [
                'name' => 'Hardware Issues',
                'description' => 'Failures in physical components like motherboard, CPU, GPU, or RAM.',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('issue_categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
