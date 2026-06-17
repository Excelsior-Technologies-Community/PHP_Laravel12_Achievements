<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;


class UsersTenPosts extends Achievement
{

    public $name = 'Content Creator';


    public $description = 'Create ten posts';


    public $icon = '🥇';



    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }

}