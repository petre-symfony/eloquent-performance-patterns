<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Feature;
use App\Models\Login;
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
        $users = User::factory(250)->create(['company_id' => $company->id])->each(fn ($user)  =>
            Post::factory()->create([
                'author_id' => $user->id
            ])
        );

        $users->each(fn ($user) =>
            Login::factory(10)->create([
                'user_id' => $user->id
            ])
        );

        Feature::factory(60)->create()->each(function ($feature) use ($users) {
            Comment::factory(rand(1, 50))->create([
                'feature_id' => $feature->id,
                'user_id' => $users->random()->id
            ]);
        });
    }
}
