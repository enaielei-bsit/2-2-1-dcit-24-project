<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
define("PROJECT_NAME", "stms");

define('CURRENT_YEAR', (int) getdate()['year']);

define('MONTHS',
    array(
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    )
);

$days = array();
for($i = 1; $i <= 31; $i++) {
    array_push($days, $i);
}

define('DAYS', $days);
unset($days);

// $regexs = array(
//     "given_name" => "/.{1,}/",
//     "middle_name" => "/.{1,}/",
//     "family_name" => "/.{1,}/",
//     "block_number" => "/^\d{1,}$/",
//     "lot_number" => "/^\d{1,}$/",
//     "street" => "/.{1,}/",
//     "subdivision" => "/.{1,}/",
//     "barangay" => "/.{1,}/",
//     "city" => "/.{1,}/",
//     "province" => "/.{1,}/",
//     "contact_number" => "/^\d{1,10}$/",
//     "email" => "	
//     /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD",
//     "student_number" => "/^\d{8}$/",
//     "block_section" => "/^\d{1,}$/",
//     "password" => "/.{4,}/",
//     "username" => "/^[^ ]{1,}$/"
// );

?>