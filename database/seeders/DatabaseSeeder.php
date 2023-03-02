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
     *
     * public function run(): void {
     * Company::factory(1000)->create()->each(fn ($company) =>
     * User::factory(50)->create([
     * 'company_id' => $company->id
     * ])
     * );
     * }
     */
    /**
     * run for chapter five
     *
     * public function run() {
     * $company = Company::factory()->create();
     * $users = User::factory(250)->create(['company_id' => $company->id])->each(fn($user) => Post::factory()->create([
     * 'author_id' => $user->id
     * ])
     * );
     *
     * $users->each(fn($user) => Login::factory(10)->create([
     * 'user_id' => $user->id
     * ])
     * );
     *
     * Feature::factory(60)->create()->each(function ($feature) use ($users) {
     * Comment::factory(rand(1, 50))->create([
     * 'feature_id' => $feature->id,
     * 'user_id' => $users->random()->id
     * ]);
     * });
     * }
     */

    public function run() {
        $this->getUsers();

        Feature::factory(60)->create()->each(function ($feature) {
            Comment::factory(rand(1, 50))->existing()->create([
                'feature_id' => $feature->id
            ]);
        });
    }

    protected function getUsers() {
        $company = Company::factory()->create();
        $attrs = [
            ['name' => 'Lacey Kertzmann', 'photo' => 'female-1.jpeg'],
            ['name' => 'Tina Trantow', 'photo' => 'female-2.jpeg'],
            ['name' => 'Vanessa Gerhold', 'photo' => 'female-3.jpeg'],
            ['name' => 'Mina Prohaska', 'photo' => 'female-4.jpeg'],
            ['name' => 'Micah Daugherty', 'photo' => 'female-5.jpeg'],
            ['name' => 'Marianne Kunde', 'photo' => 'female-6.jpeg'],
            ['name' => 'Veronica Johnson', 'photo' => 'female-7.jpeg'],
            ['name' => 'Cecile Volkman', 'photo' => 'female-8.jpeg'],
            ['name' => 'Hannah Feeney', 'photo' => 'female-9.jpeg'],
            ['name' => 'Sandy Ullrich', 'photo' => 'female-10.jpeg'],
            ['name' => 'Christopher Bernier', 'photo' => 'male-1.jpeg'],
            ['name' => 'Angelo Murray', 'photo' => 'male-2.jpeg'],
            ['name' => 'Raleigh Welch', 'photo' => 'male-3.jpeg'],
            ['name' => 'Darby Jenkins', 'photo' => 'male-4.jpeg'],
            ['name' => 'Bart Hirthe', 'photo' => 'male-5.jpeg'],
            ['name' => 'Jarrell Von', 'photo' => 'male-6.jpeg'],
            ['name' => 'Stephon Marvin', 'photo' => 'male-7.jpeg'],
            ['name' => 'Kane Barton', 'photo' => 'male-8.jpeg'],
            ['name' => 'Baron Mayer', 'photo' => 'male-9.jpeg'],
            ['name' => 'John Richards', 'photo' => 'male-10.jpeg'],
        ];

        foreach ($attrs as $attr) {
            User::factory()->create([
                'name' => $attr['name'],
                'photo' => $attr['photo'],
                'company_id' => $company->id
            ]);
        }
    }
}
