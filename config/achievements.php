<?php
return [
        /**
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         *
         */
        'CommentsHeading' => [
                'First Comment' => 1,
                '3th Comment' => 3,
                '5th Comment' => 5,
                '10th Comment' => 10,
                '20th Comment' => 20,
        ],
        'Comments' => [
                0 => 1,
                1 => 3,
                2 => 5,
                3 => 10,
                4 => 20,
        ],

        /**
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         *
         * Notes regarding fonts:
         * Additional .afm font metrics can be added by executing load_font.php from command line.
         *
         */
        'LessonsHeading' => [
                'First Lesson' => 1,
                '5th Lesson' => 5,
                '10th Lesson' => 10,
                '25th Lesson' => 25,
                '50th Lesson' => 50,
        ],
        'Lessons' => [
                0 => 1,
                1 => 5,
                2 => 10,
                3 => 25,
                4 => 50,
        ],

        /**
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         *
         * Notes regarding fonts:
         * Additional .afm font metrics can be added by executing load_font.php from command line.
         *
         */
        'BadgesHeading' => [
                'Intermediate' => 4,
                'Advanced' => 8,
                'Master' => 10,
        ],
        'Badges' => [
                0 => 4,
                1 => 8,
                2 => 10,
        ],

];