<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CommentWritten;
use App\Models\AchievementCount;

class CommentWrittenEventListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        //get all the listners and comment it with the user model
        //this to increase the count of listners
        
    }
}
