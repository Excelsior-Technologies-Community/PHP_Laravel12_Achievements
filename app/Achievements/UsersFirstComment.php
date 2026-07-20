<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;

class UsersFirstComment extends Achievement
{
    public $name = 'First Comment';

    public $description = 'Write your first comment';

    public $icon = '💬';

    public function unlockWhen($achiever)
    {
        return $achiever->comments()->count() >= 1;
    }

    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }
}
