<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task)
    {
        return $user->id === $task->project->user_id;
    }

    public function create(User $user)
    {
        return true; // Or your custom logic
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->project->user_id;
    }

    public function delete(User $user, Task $task)
    {
        return $user->id === $task->project->user_id;
    }
}