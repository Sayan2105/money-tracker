<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = \App\Models\User::first();

        $categories = ['food', 'travel', 'shopping', 'bills', 'other'];

        for ($i = 1; $i <= 40; $i++) {
            \App\Models\Expense::create([
                'title'    => 'Expense ' . $i,
                'amount'   => rand(100, 5000) / 10,
                'category' => $categories[array_rand($categories)],
                'date'     => now()->subDays(rand(0, 30))->format('Y-m-d'),
                'user_id'  => 3
            ]);
        }
    }
}
