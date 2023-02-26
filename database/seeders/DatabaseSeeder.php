<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.

    public function run(): void {
        Company::factory(1000)->create()->each(fn ($company) =>
            User::factory(50)->create([
                'company_id' => $company->id
            ])
        );
    }
     */

    public function run() {
        $company = Company::factory()->create();
        User::factory(20)->create(['company_id' => $company->id])->each(fn ($user)  =>
            Post::factory(5)->create([
                'author_id' => $user->id
            ])
        );
    }
}
