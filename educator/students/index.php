<?php

require_once("../../_php/initializations.php");

if(!isset($_COOKIE["user_id"]) && !isset($_COOKIE["user_type"])) {
    header("Location: " . getRelativePath("stms/index.php"));
} elseif(isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"]) && $_COOKIE["user_type"] == "student") {
    header("Location: " . getRelativePath("student/index.php"));
}

$user = new STMSEducator($_COOKIE, $server);
$user->fetchAllDetails();

setPageInternalDetails(
    "Educator | " . $user->full_name,
    getRelativePath("_css/style.css"),
    getRelativePath("_js/script.js")
);

$has_added_course = isset($_POST["course"]) ? true : false;
if($has_added_course) {
    $course = $_POST["course"];
    $course["course_type"] = isset($_POST["course_type"]) ? json_encode($_POST["course_type"]) : "";
    $course["auto_add"] = isset($course["auto_add"]) ? (bool) $course["auto_add"] : false;
    $course["course_prerequisites"] = isset($_POST["course_prerequisites"]) ? json_encode($_POST["course_prerequisites"]) : "";
    $user->registerCourse(
        $course["course_code"],
        $course["course_title"],
        $course["course_description"],
        $course["course_type"],
        $course["course_units"],
        $course["course_prerequisites"],
        $course["course_creator"],
        $course["auto_add"]
    );
}

$options = isset($_GET["options"]) ? isset($_GET["options"]) : null;
$sorting = !empty($options["sorting"]) ? empty($options["sorting"]) : "alphabetical_a-z";
$course_type = !empty($options["course_type"]) ? empty($options["course_type"]) : "all";


setActiveLink("students-link");
include_once(getRelativePath("header_educator.php"));
?>