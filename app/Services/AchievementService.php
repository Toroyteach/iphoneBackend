<?php

namespace App\Services;

use App\Contract\AchievementContract;
use App\Models\User;

class AchievementService implements AchievementContract
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function unlockedAchievements(): array{

    }

    public function nextAvailableAchievements(): array{

    }

    public function currentBadge(): string{

    }

    public function nextBadge(): string{

    }

    public function remainingAcheivements(): int{
        
    }

    public function __destruct(){
        $this->user = null;
    }
}