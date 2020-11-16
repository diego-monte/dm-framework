<?php
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.1.0.0
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */

// Checks whether the install.php file exists
if(file_exists("install.php")) {
    // If it exists redirects to it
    header("location: install.php");
} else {
    // If not, redirect to the index
    header("location: index");
} 