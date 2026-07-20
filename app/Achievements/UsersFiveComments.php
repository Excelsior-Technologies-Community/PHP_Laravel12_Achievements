<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;

class UsersFiveComments extends Achievement
{
    public $name = 'Active Commenter';

    public $description = 'Write five comments';

    public $icon = '🗨️';

    public function unlockWhen($achiever)
    {
        return $achiever->comments()->count() >= 5;
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
