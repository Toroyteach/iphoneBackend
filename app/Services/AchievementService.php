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
        $achievementTemplateLess = $this->achievementTemplate['LessonsHeading'];
        $achievementTemplateComm = $this->achievementTemplate['CommentsHeading'];
        
        $unlockedAchievement = array();

        //get the lessons acheieved from custom method below
        $unlockedAchievementLesson = $this->getAchievements("Lessons", $this->lessonsCount);
        $unlockedAchievementComment = $this->getAchievements("Comments", $this->commentsCount);

        //return the array created
        $unlockedLessons = array_search(intval($unlockedAchievementLesson), $achievementTemplateLess, true);
        $unlockedComments = array_search(intval($unlockedAchievementComment), $achievementTemplateComm, true);

        $unlockedAchievement['Lessons Achievement'] = ($unlockedLessons == false ) ? "No Achievement yet" : $unlockedLessons;
        $unlockedAchievement['Comments Achievement'] = ($unlockedComments == false ) ? "No Achievement yet" : $unlockedComments;

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

        $achievementTemplateLess = $this->achievementTemplate['LessonsHeading'];
        $achievementTemplateComm = $this->achievementTemplate['CommentsHeading'];

        //calculate the next available achievement for lesson and comment
        $achievementTemplateL = $this->achievementTemplate['Lessons'];
        $achKeyL = array_search(intval( $nextLesson), $achievementTemplateL, true);
        $nextLevelLesson = array_search($achKeyL, $achievementTemplateLess, true); //$achievementTemplate[$achKeyL + 1];

        $achievementTemplateC = $this->achievementTemplate['Comments'];
        $achKeyC = array_search(intval( $nextComment), $achievementTemplateC, true);
        $nextLevelComments = array_search($achKeyC, $achievementTemplateComm, true); //$achievementTemplate[$achKeyC + 1];
        //dd($nextComment);


        $nextAvailableAchievement = array();

        if($nextLesson == "None" || $nextComment <= $achievementTemplateL[0]){
            $nextAvailableAchievement['nextAvailableLessonAchievement'] =  array_search(1, $achievementTemplateLess, true);
        } else {
            $nextAvailableAchievement['nextAvailableLessonAchievement'] =  $nextLevelLesson;

        }
        
        if($nextComment == "None" || $nextComment <= $achievementTemplateC[0]) {
            $nextAvailableAchievement['nextAvailableCommentAchievement'] = array_search(1, $achievementTemplateComm, true);
        } else {
            $nextAvailableAchievement['nextAvailableCommentAchievement'] = $nextLevelComments;
        }

        //dd($nextComment, $nextLevelComments, $achievementTemplateC[0]);


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

        if($totalAchievements < $achievementTemplate[0]){

            $currentBadge = "No Badge yet";

        } else {

            $achievementTemplateBagde = $this->achievementTemplate['BadgesHeading'];
            $currentBadge = array_search(intval($level), $achievementTemplateBagde, true);
        }
        
        //return string with badge name
        return $currentBadge;
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
        $achievementTemplateHead = $this->achievementTemplate['BadgesHeading'];

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

        
        if($totalAchievements <  $achievementTemplate[0]){

            $nextCount = $achievementTemplate[0];
            $nextBadge = array_search(intval($nextCount), $achievementTemplateHead, true);

        } else {

            $achKey = array_search($level, $achievementTemplate, true);
            $nextCount = $achievementTemplate[$achKey + 1];
            $nextBadge = array_search(intval($nextCount), $achievementTemplateHead, true);

        }
        
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
                $level = "None";
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