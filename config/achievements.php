<?php
return [
        /**
         * Here you can add the dynamic calculation of acheivements
         * 
         * Ensure the corresponding Heading suffix  keys goes together with the key of its array conterpart below to have consistency
         * 
         * For example 'First Comment Achievement' corresponds to key 0 in Comments array and soo on
         *
         */
        'CommentsHeading' => [
                'First Comment Achievement' => 1,
                '3th Comment Achievement' => 3,
                '5th Comment Achievement' => 5,
                '10th Comment Achievement' => 10,
                '20th Comment Achievement' => 20,
        ],
        'Comments' => [
                0 => 1,
                1 => 3,
                2 => 5,
                3 => 10,
                4 => 20,
        ],

        /**
         *
         */
        'LessonsHeading' => [
                'First Lesson Achievement' => 1,
                '5th Lesson Achievement' => 5,
                '10th Lesson Achievement' => 10,
                '25th Lesson Achievement' => 25,
                '50th Lesson Achievement' => 50,
        ],
        'Lessons' => [
                0 => 1,
                1 => 5,
                2 => 10,
                3 => 25,
                4 => 50,
        ],

        /**
         *
         */
        'BadgesHeading' => [
                'Beginner'=> 0,
                'Intermediate' => 4,
                'Advanced' => 8,
                'Master' => 10,
        ],
        'Badges' => [
                0 => 0,
                1 => 4,
                2 => 8,
                3 => 10,
        ],

];