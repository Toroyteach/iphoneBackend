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
                'No Achievement' => 0,
                'First Comment Achievement' => 1,
                '3th Comment Achievement' => 3,
                '5th Comment Achievement' => 5,
                '10th Comment Achievement' => 10,
                '20th Comment Achievement' => 20,
        ],
        'Comments' => [
                0 => 0,
                1 => 1,
                2 => 3,
                3 => 5,
                4 => 10,
                5 => 20,
        ],

        /**
         *****************************************************
         * lessone heading and lessons count value
         */
        'LessonsHeading' => [
                'No Achievement' => 0,
                'First Lesson Achievement' => 1,
                '5th Lesson Achievement' => 5,
                '10th Lesson Achievement' => 10,
                '25th Lesson Achievement' => 25,
                '50th Lesson Achievement' => 50,
        ],
        'Lessons' => [
                0 => 0,
                1 => 1,
                2 => 5,
                3 => 10,
                4 => 25,
                5 => 50,
        ],

        /**
         ****************************************************
         * Comments heading and comments count value
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