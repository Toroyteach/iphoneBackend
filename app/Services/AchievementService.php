<?php

namespace App\Services;

use App\Contract\AchievementContract;
use App\Models\User;
use App\Models\AcheivementCount;

/**
 * This service class handles all the request from the controller index method
 * in the AchievementsController class.
 */

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
            
        //get the lessons acheieved from custom method below
        $unlockedAchievementLesson = $this->getAchievements("Lessons", $this->lessonsCount);
        $unlockedAchievementComment = $this->getAchievements("Comments", $this->commentsCount);
        
        //crete an arrray and then add data and return   
        $unlockedAchievement = array();
        $unlockedAchievement['LessonsAchievement'] = $this->getAchievementName("Lessons", $unlockedAchievementLesson); 
        $unlockedAchievement['CommentsAchievement'] = $this->getAchievementName("Comments", $unlockedAchievementComment); 

        return $unlockedAchievement;
    }

    /**
    * returns the next level achievements for both comment and lessons
    * @return array
    */
    public function nextAvailableAchievements(): array{
        //initialize an dempty array

        //get the lessons acheieved from custom method below
        $currentLesson = $this->getAchievements("Lessons", $this->lessonsCount);
        $currentComment = $this->getAchievements("Comments", $this->commentsCount);

        //calculate the next available achievement for lesson and comment
        $achievementTemplateL = $this->achievementTemplate['Lessons'];
        $achKeyL = array_search($currentLesson, $achievementTemplateL, true);

        $achievementTemplateC = $this->achievementTemplate['Comments'];
        $achKeyC = array_search($currentComment, $achievementTemplateC, true);


        $nextAvailableAchievement = array();
        $achievementTemplateLess = $this->achievementTemplate['LessonsHeading'];
        $achievementTemplateComm = $this->achievementTemplate['CommentsHeading'];
        //dd($nextComment);

        //Lessons
        if($currentLesson >= $achievementTemplateL[count($achievementTemplateL) - 1]){

            $nextAvailableAchievement['NextAvailableLessonAchievement'] =  "Maximum Achievement Achieved";

        } else {

            $nextAvailableAchievement['NextAvailableLessonAchievement'] =  array_search($achievementTemplateL[$achKeyL + 1], $achievementTemplateLess, true);

        }
        
        //Comments
        if($currentComment >= $achievementTemplateC[count($achievementTemplateC) - 1]) {

           $nextAvailableAchievement['NextAvailableCommentAchievement'] = "Maximum Achievement Achieved";

        } else {

            $nextAvailableAchievement['NextAvailableCommentAchievement'] = array_search($achievementTemplateC[$achKeyC + 1], $achievementTemplateComm, true);

        }


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
        //$highestComment = $achievementTemplate[$sizeOfArray];

        $level = '';

        // custom forloop to go hrough the list of achievements
        for($i = 0; $i <= $sizeOfArray; $i++){

            if($totalAchievements <=  $achievementTemplate[0]){
                $level = $achievementTemplate[0];
                break;
            }

            if($totalAchievements >= $achievementTemplate[$i] && $totalAchievements <= (count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1)){

                $level = $achievementTemplate[$i];
                break;

            } else if($totalAchievements > $achievementTemplate[$sizeOfArray]){

                $level = $achievementTemplate[$sizeOfArray];
                break;

            }

        }


        $achievementTemplateBagde = $this->achievementTemplate['BadgesHeading'];
        $currentBadge = array_search(intval($level), $achievementTemplateBagde, true);
        
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
        //$highestComment = $achievementTemplate[$sizeOfArray];

        $level = '';

        // custom forloop to go hrough the list of achievements   
        for($i = 0; $i <= $sizeOfArray; $i++){

            if($totalAchievements <  $achievementTemplate[0]){
                $level = $achievementTemplate[0];
                break;
            }

            if($totalAchievements >= $achievementTemplate[$i] && $totalAchievements <= ((count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1))){

                $level = $achievementTemplate[$i];
                break;

            } else if($totalAchievements > $achievementTemplate[$sizeOfArray]){

                $level = $achievementTemplate[$sizeOfArray];
                break;

            }

        }


        $achKey = array_search($level, $achievementTemplate, true);
        //dd($totalAchievements, $achievementTemplate[$sizeOfArray], $this->commentsCount, $this->lessonsCount);

        if($totalAchievements >=  $achievementTemplate[$sizeOfArray]){

            $nextBadge = "Maximum Badge Achieved";

        } else {

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

                $level = $achievementTemplate[$sizeOfArray];    
                break;

            }

        }

        if($totalAchievements <  $achievementTemplate[0]){

            $remaining = $achievementTemplate[0] - $totalAchievements;

        } else if($totalAchievements >  $achievementTemplate[$sizeOfArray]){

            $remaining = 0;

        } else {

            $achKey = array_search($level, $achievementTemplate, true);
            $remaining = $achievementTemplate[$achKey + 1] - $totalAchievements;

        }

        
        //return int with remaning achievements
        return $remaining;
    }

    /**
     * returns achievement
     * @param  String $type
     * @param  tnt $count
     * @return int
     */
    public function getAchievements($type, $count): int{

        $level = '';

        $achievementTemplate = $this->achievementTemplate[$type];

        $sizeOfArray = count($achievementTemplate) - 1;
        $highestComment = $achievementTemplate[$sizeOfArray];

        for($i = 0; $i <= $sizeOfArray; $i++){

            if($count == 0){
                $level = $achievementTemplate[0];
                break;
            }

            if($count >= $achievementTemplate[$i] && $count <= ((count($achievementTemplate) == ( $i + 1 ) ? $achievementTemplate[$i] : $achievementTemplate[$i + 1] - 1))){

                $level = $achievementTemplate[$i];
                break;

            } else if($count > $achievementTemplate[$sizeOfArray]){

                $level = $achievementTemplate[$sizeOfArray];
                break;

            }

        }

        return $level;
    }

    /**
     * returns achievement
     * @param  String $type
     * @param  tnt $level 
     * @return string
     */
    public function getAchievementName($type, $level): string{

        $name = '';
        switch($type){
            case "Lessons":

                $achievementTemplate = $this->achievementTemplate['LessonsHeading'];
                $name = array_search($level, $achievementTemplate, true);

                break;
            case "Comments":

                $achievementTemplate = $this->achievementTemplate['CommentsHeading'];
                $name = array_search($level, $achievementTemplate, true);

                break;
            default;
                echo "Wrong Choice";
        }

        return $name;
    }

    public function __destruct(){
        $this->user = null;
    }

}