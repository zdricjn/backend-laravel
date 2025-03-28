<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Zedric Gasga',
            'email' => 'zedricgasga@gmail.com',
            'password' => bcrypt('zedric'),
            'role' => 'User',
        ]);

        // Create regular users
        $users = User::factory(5)->create();

        // Create projects for each user
        $users->each(function ($user) {
            $projects = Project::factory(3)->create([
                'user_id' => $user->id
            ]);

            // Create tasks for each project
            $projects->each(function ($project) use ($user) {
                Task::factory(5)->create([
                    'project_id' => $project->id,
                    'user_id' => $user->id
                ]);
            });
        });

        // Create additional test user with known credentials
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Set password to 'password'
        ]);

        // Create projects and tasks for test user
        $projects = Project::factory(2)->create([
            'user_id' => $testUser->id
        ]);

        $projects->each(function ($project) use ($testUser) {
            Task::factory(3)->create([
                'project_id' => $project->id,
                'user_id' => $testUser->id
            ]);
        });
    }
}