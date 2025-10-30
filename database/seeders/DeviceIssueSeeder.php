<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeviceIssue;
use App\Models\IssueCategory;

class DeviceIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
     public function run(): void
    {
        $issues = [
            [
                'issue' => 'Battery not charging',
                'description' => 'The device battery fails to charge or drains quickly.',
                'category' => 'Power Issues',
            ],
            [
                'issue' => 'Overheating',
                'description' => 'Device heats up excessively during use.',
                'category' => 'Performance Issues',
            ],
            [
                'issue' => 'System crash',
                'description' => 'Operating system frequently crashes or freezes.',
                'category' => 'Software Issues',
            ],
            [
                'issue' => 'Low storage space',
                'description' => 'Device storage is full or insufficient.',
                'category' => 'Storage Issues',
            ],
            [
                'issue' => 'Screen flickering',
                'description' => 'Display is flickering or unstable.',
                'category' => 'Display Issues',
            ],
            [
                'issue' => 'Water damage',
                'description' => 'Device exposed to liquid and malfunctioning.',
                'category' => 'Liquid Damage Issues',
            ],
            [
                'issue' => 'Wi-Fi not connecting',
                'description' => 'Unable to connect to wireless networks.',
                'category' => 'Connectivity Issues',
            ],
            [
                'issue' => 'Printer not responding',
                'description' => 'External output device not functioning properly.',
                'category' => 'Output Issues',
            ],
            [
                'issue' => 'Keyboard not working',
                'description' => 'Mechanical input failure such as keys not responding.',
                'category' => 'Mechanical Issues',
            ],
            [
                'issue' => 'Motherboard failure',
                'description' => 'Critical hardware component malfunctioning.',
                'category' => 'Hardware Issues',
            ],
        ];

        foreach ($issues as $issue) {
            $category = IssueCategory::where('name', $issue['category'])->first();

            if ($category) {
                DeviceIssue::create([
                    'issue' => $issue['issue'],
                    'description' => $issue['description'],
                    'issue_category_id' => $category->id,
                ]);
            }
        }
    }
}
