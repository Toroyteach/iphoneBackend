<?php

namespace App\Providers;

use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * Mapping the listeners to the respective Events
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            CommentWrittenEventListener::class, //this listner is called when the correspendin event is fired
        ],
        LessonWatched::class => [
            LessonWatchedEventListener::class, //this listner is called when the correspendin event is fired
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
