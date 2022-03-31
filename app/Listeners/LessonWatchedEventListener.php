<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Lesson;

class LessonWatchedEventListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //Mark lesson as watched
        $lesson = Lesson::find($event->lesson->id);
        $user = User::find($event->user->id);
        $user->watched()->attach($lesson, ['watched' => 1 ]);
    }
}
