Marketing Mavens CodeIgniter Template
=====================================

CodeIgniter 2.1.4

Includes Basic Infusionsoft Library

Twitter Bootstrap 3.0

jQuery 1.10.2

jQuery UI 1.10.3

jQuery UI CSS flick

general_helper functions

basic database model called db_model with basic functions


Blank or template standard files
--------------------------------

    /application/view/inc/header.php
    /application/view/inc/footer.php
    /application/view/pages/home_page.php
    /js/scripts.js
    /js/ajax.js
    /css/style.css




PhpStorm Settings
-----------------

This includes files for PhpStorm code auto complete
for CodeIgniter. All located in CI_code_completion folder,
if you don't use PhpStorm you can remove these and
you don't need this files on the live/production server.


If you use PhpStorm you'll need to mark the following
files as Plain Text in PhpStorm. This is done by locating
the files and right click and select 'Mark as Plain Text'

    /system/core/Controller.php
    /system/core/Controller.php
    /system/database/DB_active_rec.php




Files to Update for each project
--------------------------------

    /index.php (Might not need to do anything here)
    Line 21 - 31 depending on the testing and development IPs

    /application/config/config.php
    Line 17 - 28 update base_url to be correct based on ENVIRONMENT


If you have any questions contact me at dustin@marketingmavens.com