<?php
/**
 * Dice100 Controller.
 */
return [
    // Path where to mount the routes
    "routes" => [
        [
            "info" => "Content Management System.",
            "mount" => "cms",
            "handler" => "\liba19\CMS\CMSController",
        ],
    ]
];
