<?php

namespace App\Services;

use App\Contract\AchievementContract;
use App\Models\User;
use App\Models\AcheivementCount;

class AchievementService implements AchievementContract
{
    private $lessonsCount;
    private $commentsCount;
    private $achievementTemplate;
    private $totalAchievements;

    public function __construct(User $user){
        $this->lessonsCount = $user->watched()->count();
        $this->commentsCount = $user->comments()->count();
        $this->achievementTemplate = config('achievements');
        $this->totalAchievements = $user->watched()->count() + $user->comments()->count();
    }

    /**
    * returns all achievements reached at for both comments and lessons
    * @return array
    */
    public function unlockedAchievements(): array{
        //initialize an dempty array
        
        $unlockedAchievement = array();

        //get the lessons acheieved from custom method below
        $unlockedAchievement['Lessons Achievement'] = $this->getAchievements("Lessons", $this->lessonsCount);
        $unlockedAchievement['Comments Achievement'] = $this->getAchievements("Comments", $this->commentsCount);

        //return the array created
        return $unlockedAchievement;
    }

    /**
    * returns the next level achievements for both comment and lessons
    * @return array
    */
    public function nextAvailableAchievements(): array{
        //initialize an dempty array

        //get the lessons acheieved from custom method below
        $nextLesson = $this->getAchievements("Lessons", $this->lessonsCount);
        $nextComment = $this->getAchievements("Comments", $this->commentsCount);

        //calculate the next available achievement for lesson and comment
        $achievementTemplate = $this->achievementTemplate['Lessons'];
        $achKey = array_search(intval( $nextLesson), $achievementTemplate, true);
        $nextLevelLesson = $achievementTemplate[$achKey + 1];

        $achievementTemplate = $this->achievementTemplate['Comments'];
        $achKey = array_search(intval( $nextComment), $achievementTemplate, true);
        $nextLevelComments = $achievementTemplate[$achKey + 1];

        $nextAvailableAchievement = array();

        $nextAvailableAchievement['nextAvailableLessonAchievement'] = $nextLevelLesson;
        $nextAvailableAchievement['nextAvailableCommentAchievement'] = $nextLevelComments;

        //create an array and add both for comment and acheivements
        return $nextAvailableAchievement;
    }

    /**
    * return the current badge acheived
    * @return string
    */
    public function currentBadge(): string{
        //get users count for lessons and comments combined
        $totalAchievements = $this->totalAchievements;

        //calculate the badge worth and award
        $achievementTemplate = $this->achievementTemplate['Badges'];

        $sizeOfArray = count($achievementTemplate) - 1;
        $highestComment = $achievementTemplate[$sizeOfArray];

        $level = '';

        // custom forloop to go hrough the list of achievements
        for($i = 0; $i <= $sizeOfArray; $i++){

            if($totalAchievements <  $achievementTemplate[0]){
                $level = "Non Achieved";
                break;
            }

            if($totalAchievements >= $achievementTemplate[$i] && $totalAchievements <= ((count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1))){

                $level = $achievementTemplate[$i];
                break;

            } else if($totalAchievements > $achievementTemplate[$sizeOfArray]){

                $level = "Greater Badge";
                break;

            }

        }
        
        //return string with badge name
        return $level;
    }

    /**
    * returns next badge to be achieved
    * @return string
    */
    public function nextBadge(): string{
        //get users count for lessons and comments combined
        $totalAchievements = $this->totalAchievements;

        //calculate the badge worth and award
        $achievementTemplate = $this->achievementTemplate['Badges'];

        $sizeOfArray = count($achievementTemplate) - 1;
        $highestComment = $achievementTemplate[$sizeOfArray];

        $level = '';

        // custom forloop to go hrough the list of achievements   
        for($i = 0; $i <= $sizeOfArray; $i++){

            if($totalAchievements <  $achievementTemplate[0]){
                $level = "Non Achieved";
                break;
            }

            if($totalAchievements >= $achievementTemplate[$i] && $totalAchievements <= ((count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1))){

                $level = $achievementTemplate[$i];
                break;

            } else if($totalAchievements > $achievementTemplate[$sizeOfArray]){

                $level = "Greater Badge";
                break;

            }

        }

        $achKey = array_search($level, $achievementTemplate, true);
        $nextBadge = $achievementTemplate[$achKey + 1];
        
        //return string with badge name
        return $nextBadge;
    }

    /**
    * reurns the remaning acheivements to level up
    * @return int
    */
    public function remainingAcheivements(): int{
        //get users count for lessons and comments combined
        $totalAchievements = $this->totalAchievements;

        //calculate the badge worth and award
        $achievementTemplate = $this->achievementTemplate['Badges'];

        $sizeOfArray = count($achievementTemplate) - 1;
        $highestComment = $achievementTemplate[$sizeOfArray];

        $level = '';

        // custom forloop to go hrough the list of achievements
        for($i = 0; $i <= $sizeOfArray; $i++){

            if($totalAchievements <  $achievementTemplate[0]){
                $level = 0;
                break;
            }

            if($totalAchievements >= $achievementTemplate[$i] && $totalAchievements <= ((count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1))){

                $level = $achievementTemplate[$i];
                break;

            } else if($totalAchievements > $achievementTemplate[$sizeOfArray]){

                $level = "Greater Badge";
                break;

            }

        }

        if($totalAchievements <  $achievementTemplate[0]){

            $remaining = $achievementTemplate[0] - $totalAchievements;

        } else {

            $achKey = array_search($level, $achievementTemplate, true);
            $remaining = $achievementTemplate[$achKey + 1] - $achievementTemplate[$achKey];

        }

        
        //return int with remaning achievements
        return $remaining;
    }

    /**
     * returns achievement
     * @param  String $type
     * @param  tnt $count
     * @return string
     */
    public function getAchievements($type, $count): string{

        $level = '';

        $achievementTemplate = $this->achievementTemplate[$type];

        $sizeOfArray = count($achievementTemplate) - 1;
        $highestComment = $achievementTemplate[$sizeOfArray];

        for($i = 0; $i <= $sizeOfArray; $i++){

            if($count == 0){
                $level = "Non Achieved";
                break;
            }

            if($count >= $achievementTemplate[$i] && $count <= ((count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1))){

                $level = $achievementTemplate[$i];
                break;

            } else if($count > $achievementTemplate[$sizeOfArray]){

                $level = "Greater Achieved";
                break;

            }

        }

        return $level;
    }

    public function __destruct(){
        $this->user = null;
    }
}