<?php
//application constant
define("TOKEN_EXPIRED_AFTER", "+15 min");
define("PIN_EXPIRED_AFTER", "+10 min");
define("APP_DEFAULT_LANGUAGE", "en_US");
define("TRUE_CODE", "1");
define("FALSE_CODE", "0");
define("SUCCESS_CODE", "+000");
define("FAIL_CODE", "-1");
define("TOKEN_CHAR_NO", "8");
define("BULK_ACTION_DELETE", "1");
define('PROFILE_PIC_UPLOAD_DIR', 'profileImages/');
define("APP_DEFAULT_IMAGE_PATH", "default/default_image.png");
define("APP_REG_EMAIL_TEMPLATE_NAME", "registration/email");
define("APP_FORGOT_PASS_EMAIL_TEMPLATE_NAME", "forgotpass/forgot_password");
define("REGISTRATION_EMAIL_SCHEDULE_TRACKING_FILE", "registration_email_schedule.txt");
define("APP_EMAIL_FROM", "no-reply@ygtimes.com");
define("APP_EMAIL_FROM_DISPLAY_NAME", "Zeerow");

define("FA_CONFEDERATION", json_encode(['AFC','UEFA','CAF','CONCACAF','CONMEBOL','OFC']));


define('LANGUAGE_CODE_ENGLISH', 'en');
define('LANGUAGE_CODE_KOREAN', 'ko');

define('STATUS_ACTIVE', 1);
define('STATUS_NOT_ACTIVE', 0);
define('SUPER_SUPER_ADMIN_ID', 1);


define("RANDOM_KEY_LENGTH", 4); // key lenght for generating sharing key.
define("WIDTH_OF_IMAGE", 100);  // Set the width of thumbnail image
define("MAX_FILE_SIZE",1288490190); // Set Maximum File size for content page. 1.2 GB

define('MANDRILL_TEMPLATE_USER_CREATION', 'user-creation-cms-en');
define('MANDRILL_TEMPLATE_FORGOT_PASSWORD', 'forgot-password-api-en-us');
?>