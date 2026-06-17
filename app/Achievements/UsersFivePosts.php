<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;


class UsersFivePosts extends Achievement
{

    public $name = 'Active Writer';


    public $description = 'Create five posts';


    public $icon = '🥈';



    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }

}