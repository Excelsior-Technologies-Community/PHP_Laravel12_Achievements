<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;

class UsersFirstPost extends Achievement
{
    public $name = 'First Post';

    public $description = 'Create your first post';

    public $icon = '🏆';


    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }
}