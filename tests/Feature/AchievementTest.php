<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
Use App\Models\Lesson;
use App\Services\AchievementService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AchievementTest extends TestCase
{
    
    use DatabaseTransactions;

    /**
     * A Aseert status 200 that Achievement route can be reached at with user params
     *
     * @return void
     */
    public function test_AchievementRouteCanBeReached()
    {

        $userId = User::factory()->create();
        
        $response = $this->get("/users/{$userId->id}/achievements");

        $response->assertStatus(200);

    }

    /**
     * A Aseert true count comments equates to an achievement
     *
     * @return void
     */
    public function test_unlockedAchievemtsReturnedIsTheRightOne()
    {
        $user = User::factory()->has(Comment::factory()->count(1))->create();

        $lesson = Lesson::factory()->count(1)->create();

        $user->watched()->attach($lesson, ['watched' => 1 ]);

        $serviceClass = new AchievementService($user);

        $testObj = $serviceClass->unlockedAchievements();

        $expectedArray = array([
            'LessonsAchievement' => 'First Lesson Achievement',
            'CommentsAchievement' => 'First Comment Achievement',
        ]);

        $this->assertContains( $testObj, $expectedArray );
    }

    /**
     * Aseert true count Lessons equates to an achievement
     *
     * @return void
     */
    public function test_nextAchievementsReturnIsRight()
    {
        $user = User::factory()->has(Comment::factory()->count(20))->create();

        $lesson = Lesson::factory()->count(25)->create();

        $user->watched()->attach($lesson, ['watched' => 1 ]);

        $serviceClass = new AchievementService($user);

        $testObj = $serviceClass->nextAvailableAchievements();

        $expectedArray = array([
            'NextAvailableLessonAchievement' => '50th Lesson Achievement',
            'NextAvailableCommentAchievement' => 'Maximum Achievement Achieved',
        ]);

        $this->assertContains( $testObj, $expectedArray );
    }

    /**
     * Aseert true count achievemtns equates to a Badge
     *
     * @return void
     */
    public function test_theCurrentBadgeReturnedIsRight()
    {
        $user = User::factory()->has(Comment::factory()->count(3))->create();

        $lesson = Lesson::factory()->count(5)->create();

        $user->watched()->attach($lesson, ['watched' => 1 ]);

        $serviceClass = new AchievementService($user);
    
        $testObj = $serviceClass->currentBadge();

        $this->assertEquals('Advanced', $testObj);
    }

    /**
     * Aseert true Next badge will always be current plus one
     *
     * @return void
     */
    public function test_nextBadgeWillBeCurrentPlusOne()
    {
        $user = User::factory()->has(Comment::factory()->count(5))->create();

        //$commment = Comment::factory()->has($user)->count(5)->create();
        $lesson = Lesson::factory()->count(5)->create();

        //$user->comments()->attach($commment);
        $user->watched()->attach($lesson, ['watched' => 1 ]);

        $serviceClass = new AchievementService($user);
    
        $testObj = $serviceClass->nextBadge();

        $this->assertEquals('Maximum Badge Achieved', $testObj);
    }

    /**
     * Aseert true Next badge will always be current plus one
     *
     * @return void
     */
    public function test_remaningAchievementToLevelUpIsCorrent()
    {
        $user = User::factory()->has(Comment::factory()->count(3))->create();

        $lesson = Lesson::factory()->count(5)->create();

        $user->watched()->attach($lesson, ['watched' => 1 ]);

        $serviceClass = new AchievementService($user);
    
        $testObj = $serviceClass->remainingAcheivements();

        $this->assertEquals(2, $testObj);
    }
    /**
     * Aseert true to the return types
     *
     * @return void
     */
    public function test_onlyArraysAndStringsAndIntAreReturnedInTheMethods()
    {
        $testObj = User::factory(Comment::factory()->count(3))->create();
        $serviceClass = new AchievementService($testObj);

        $unlockedAttachmentArray = $serviceClass->unlockedAchievements();
        $nextAvailableAchievementsArray = $serviceClass->nextAvailableAchievements();
        $currentBadgeString = $serviceClass->currentBadge();
        $nextBadgeString = $serviceClass->nextBadge();
        $remainingAchievementInt = $serviceClass->remainingAcheivements();

        $this->assertIsArray( $unlockedAttachmentArray, "assert variable is array");

        $this->assertIsArray( $nextAvailableAchievementsArray, "assert variable is array");

        $this->assertIsString($nextBadgeString);

        $this->assertIsString($currentBadgeString);

        $this->assertIsInt($remainingAchievementInt);
    }
}
