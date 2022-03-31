<?php

namespace App\Services;

use App\Contract\AchievementContract;
use App\Models\User;
use App\Models\AcheivementCount;

class AchievementService implements AchievementContract
{
    private $lessonsCount;
    private $commentsCount;

    public function __construct(User $user){
        $this->lessonsCount = $user->comments()->count();
        $this->commentsCount = $user->watched()->count();
    }

    /**
    *
    * @return array
    */
    public function unlockedAchievements(): array{
        //get users counts for both lessons and comments
        //get acheivements for both lessons and comments from there count
        //create and array and add both achievements
    }

    /**
    *
    * @return array
    */
    public function nextAvailableAchievements(): array{
        //get users counts for lessons and comments
        //compare count vs next level achievemen
        //create an array and add both for comment and acheivements
    }

    /**
    *
    * @return string
    */
    public function currentBadge(): string{
        //get users count for lessons and comments combined
        //calculate the badge worth and award
        //return string with badge name
    }

    /**
    *
    * @return string
    */
    public function nextBadge(): string{
        //get users count for lessons and comments combined
        //calculate the badge next 
        //return string
    }

    /**
    *
    * @return int
    */
    public function remainingAcheivements(): int{
        //get users count for lessons and comments combined
        //calaulate the remainder for acheivement
        //return the number
    }

    public function __destruct(){
        $this->user = null;
    }
}