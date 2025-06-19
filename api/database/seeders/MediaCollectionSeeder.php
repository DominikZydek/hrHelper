<?php

namespace Database\Seeders;

use App\Models\MediaCollection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'name' => 'documents',
                'display_name' => 'Dokumenty',
                'organization_id' => 1,
            ],
            [
                'name' => 'files',
                'display_name' => 'Pliki',
                'organization_id' => 1,
            ],
            [
                'name' => 'documents/a',
                'display_name' => 'Dokumenty A',
                'organization_id' => 1,
            ],
            [
                'name' => 'archive',
                'display_name' => 'Archiwum',
                'organization_id' => 1,
            ]
        ];

        foreach ($collections as $collection) {
            MediaCollection::create($collection);
        }
    }
}
