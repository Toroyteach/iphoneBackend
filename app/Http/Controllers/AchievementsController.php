<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Service\AchievementService;

class AchievementsController extends Controller
{
    public function index(User $user)
    {

        $achievementServiceObj = new AchievementService($user);

        $unlockedAchievements = $achievementServiceObj->unlockedAchievements();
        $nextAvailableAchievements = $achievementServiceObj->nextAvailableAchievements();
        $currentBadge = $achievementServiceObj->currentBadge();
        $nextBadge = $achievementServiceObj->nextBadge();
        $remainingToUnlockNextBadge = $achievementServiceObj->remainingAcheivements();

        
        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaing_to_unlock_next_badge' => $remainingToUnlockNextBadge
        ]);
    }
}
