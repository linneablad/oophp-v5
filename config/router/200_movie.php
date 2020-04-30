<?php
/**
 * Movie Controller.
 */
return [
    // Path where to mount the routes
    "routes" => [
        [
            "info" => "Movie database.",
            "mount" => "movie",
            "handler" => "\liba19\Movie\MovieController",
        ],

    ]
];
