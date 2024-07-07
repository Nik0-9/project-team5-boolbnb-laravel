<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages =[
            [
                'id' => 1,
                'apartment_id' => 2,
                'message' => 'Hello, world!',
                'name' => 'John Doe',
                'surname' => 'Smith',
                'body' => 'Salve, vorrei prenotare l\'appartamento per una settimana a partire dal 15 settembre.',
                'created_at' => now(),
            ]
            ];
            DB::table('messages')->insert($messages);
    }
}
