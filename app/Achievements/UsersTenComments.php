<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;

class UsersTenComments extends Achievement
{
    public $name = 'Discussion Master';

    public $description = 'Write ten comments';

    public $icon = '🎤';

    public function unlockWhen($achiever)
    {
        return $achiever->comments()->count() >= 10;
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
