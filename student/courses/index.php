<?php

require_once("../../_php/initializations.php");

if(!isset($_COOKIE["user_id"]) && !isset($_COOKIE["user_type"])) {
    header("Location: " . getRelativePath("stms"));
} elseif(isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"]) && $_COOKIE["user_type"] == "educator") {
    header("Location: " . getRelativePath("stms/educator"));
}

$user = new STMSStudent($_COOKIE, $server);
$user->fetchAllDetails();
$user->createTaskEntries();

$is_joining = (isset($_GET["join"]) && isset($_GET["handled_course_id"]) && isset($_GET["class_id"]) && isset($_GET["educator_id"])) && ($user->isHandledCourseExisting($_GET["handled_course_id"]) && ((bool) $_GET["join"] === true) && ($user->isClassExisting(null, null, $_GET["class_id"], $_GET["handled_course_id"])) && ($user->isEducatorExisting($_GET["educator_id"])));

if($is_joining) {
    $user->joinClass($_GET["handled_course_id"], $_GET["class_id"], $_GET["educator_id"]);
    redirectTo("student/courses");
}

setPageInternalDetails(
    "Student | " . $user->full_name,
    getRelativePath("_css/style.css"),
    getRelativePath("_js/script.js")
);

// if(isset($_POST)) {
//     foreach($_POST as $post => $val) {
//         if(is_string($val)) {
//             $_POST[$post] = str_replace('"', "", $val);
//             $_POST[$post] = str_replace("'", "", $val);
//         }
//     }
// }

// if(isset($_GET)) {
//     foreach($_GET as $get => $val) {
//         if(is_string($val)) {
//             $_GET[$get] = str_replace('"', "", $val);
//             $_GET[$get] = str_replace("'", "", $val);
//         }
//     }
// }

// $has_added_course = isset($_GET["course"]) ? true : false;
// $has_edited_course = isset($_GET["course_edit"]) ? true : false;
// if($has_added_course) {
//     $course = $_GET["course"];
//     $course["course_type"] = isset($_GET["course_type"]) ? json_encode($_GET["course_type"]) : "";
//     $course["auto_add"] = isset($course["auto_add"]) ? (bool) $course["auto_add"] : false;
//     $course["course_prerequisites"] = isset($_GET["course_prerequisites"]) ? json_encode($_GET["course_prerequisites"]) : "";
//     $user->registerCourse(
//         $course["course_category"],
//         $course["course_suffix"],
//         $course["course_title"],
//         $course["course_description"],
//         $course["course_type"],
//         $course["course_units"],
//         $course["course_prerequisites"],
//         $course["course_creator"],
//         $course["auto_add"]
//     );
// } elseif($has_edited_course) {
//     $course = $_GET["course_edit"];
//     $course["course_type"] = isset($_GET["course_type"]) ? json_encode($_GET["course_type"]) : "";
//     $course["course_prerequisites"] = isset($_GET["course_prerequisites"]) ? json_encode($_GET["course_prerequisites"]) : "";
//     $user->updateCourse(
//         $course["course_code"],
//         $course["course_title"],
//         $course["course_description"],
//         $course["course_type"],
//         $course["course_units"],
//         $course["course_prerequisites"]
//     );
// }

$is_viewing_course = (isset($_GET["course_category"]) && isset($_GET["course_suffix"])) && ($user->isCourseExisting("{$_GET['course_category']} {$_GET['course_suffix']}"));
$course_code = $is_viewing_course ? "{$_GET['course_category']} {$_GET['course_suffix']}" : null;
if($is_viewing_course) {
    $course = $user->getCourses($course_code)["courses"][$course_code];
}

$options = isset($_GET["options"]) ? isset($_GET["options"]) : null;
$sorting = !empty($options["sorting"]) ? empty($options["sorting"]) : "alphabetical_a-z";
$course_type = !empty($options["course_type"]) ? empty($options["course_type"]) : "all";


setActiveLink("courses-link");
include_once(getRelativePath("header_student.php"));
?>

<!-- <button id="sampBtn" type="button" onclick="$('#temp_mod').modal('toggle')">Sample Button</button>
<div id="temp_mod" class='ui tiny modal active modal_prompt_continuation'>
    <div class="ui segment inverted">
        <div class="ui segments">
            <div class="ui inverted segment header">
                <div class='ui green inverted header'>
                    <i class="question circle icon"></i>
                    <div class="content">
                        REMOVE FROM HANDLED SUBJECTS
                    </div>
                </div>

            </div>
            <div class="ui divider content"></div>
            <div class='ui inverted segment'>
                <small>It looks like you're trying to remove a Handled Course with Classes in it. Doing so will also remove your Classes in this Course. Do you want to still remove this from your Handled Courses?</small>
            </div>
            <div class='ui inverted right aligned segment actions'>
                <button type="button" class='ui green left labeled icon button approve'>
                    <i class='check circle outline icon'></i>
                    Continue
                </button>
                <button type="button" class='ui red left labeled icon button deny'>
                    <i class='ban icon'></i>
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div> -->


<div id="container-inbetween-viewport" class="ui fluid container">

    <div id="segment-page-title-header" class="ui basic green inverted very padded segment">
        <h1 class="ui header">
            <i class="book icon"></i>
            <div class="content">
                Courses
                <div class="sub header">Browse for Courses and Join Classes</div>
            </div>
        </h1>
        <!-- <button id="button-add-course" type="button" class="ui right secondary big button">
            
            <i class="icons">
                <i class="book green icon"></i>
                <i class="bottom right corner add green inverted icon"></i>
            </i>
            Register a New Course</button>
        <button id="button-delete-course" type="button" class="ui right secondary big button">
            <i class="icons">
                <i class="book red icon"></i>
                <i class="bottom right corner times red inverted icon"></i>
            </i>
            Delete Courses</button> -->
    </div>

    <?php if(!$is_viewing_course) { ?>
        <?php if($user->getCourses()["success"]) { ?>

            <div id="segment-page-view" class="ui basic segment">
                <div class="ui container">
                    <div class="ui two column doubling stackable grid center aligned">
                        <!-- <div class="ui basic segment"> -->
                            <div class="five wide column">
                                <div class="ui basic segment">
                                    <div class="ui raised segments">
                                        <div class="ui secondary black segment">
                                            <!-- <div class="ui action fluid input">
                                                <input type="text" placeholder="Search for a Subject...">
                                                <button class="ui icon green button">
                                                    <i class="search icon"></i>
                                                </button>
                                            </div>
                                            <div class="ui divider"></div> -->
                                            
                                            <div class="ui fluid left aligned container">
                                                <div class="ui form">
                                                    <div id="accordion-sidebar-options" class="ui vertical accordion fluid menu">

                                                        <div class="item">
                                                            <a class="title active">
                                                                <i class="dropdown icon"></i>
                                                                Sorting
                                                            </a>
                                                            <div class="content active">
                                                                <!-- <div class="ui basic segment"> -->
                                                                    <div class="ui horizontal divider">Arrangement</div>
                                                                    <div class="grouped fields">
                                                                        <!-- <label>Arrangement</label> -->
                                                                        <div class="field">
                                                                            <div class="ui radio checkbox">
                                                                                <input id="sorting-a-z" type="radio" value="alphabetical_a-z" name="sorting" checked>
                                                                                <label for="sorting-a-z">Aphabetical <i>(A-Z)</i></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="field">
                                                                            <div class="ui radio checkbox">
                                                                                <input id="sorting-z-a" type="radio" value="alphabetical_z-a" name="sorting">
                                                                                <label for="sorting-z-a">Aphabetical <i>(Z-A)</i></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!-- </div> -->
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <a class="title active">
                                                                <i class="dropdown icon"></i>
                                                                Filter
                                                            </a>
                                                            <div class="content active">
                                                                <!-- <div class="ui basic segment"> -->
                                                                    
                                                                    <div class="ui horizontal divider">Course Category</div>
                                                                    <div class="grouped fields">
                                                                        <!-- <label>Course Category</label> -->
                                                                        <div class="field">
                                                                            <select id="dropdown-filter-course-category" class="ui fluid search dropdown" multiple="">
                                                                                <option value="">Course Category</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="eleven wide column">
                                <div class="row">
                                    <div class="ui basic very padded segment">
                                        
                                        <h3 id="header-no-result-course" class="ui icon black header" style="display: none">
                                            <i class="search minus circular icon"></i>
                                            <div class="content">
                                            No Results!
                                            <div class="sub header">Apparently your specified filters returned nothing.</div>
                                            <div class="sub header">Try tweaking your filters.</div>
                                            </div>
                                        </h3>
                                        <div id="cards-link" class="ui doubling stackable two cards" data-cards-sorting="a-z">
                                                
                                                <?php 
                                                    $i = 0;
                                                    foreach($user->getCourses()["courses"] as $course) { 
                                                        $i += 1;
                                                        // $course_type = $user->isCourseHandled($course['course_code']) ? "handled" : "not_handled";
                                                        $course_link = getRelativePath("student/courses") . "?" . "course_category={$course['course_category']}&course_suffix={$course['course_suffix']}";
                                                ?>

                                                    <div class="ui raised link card card-link" href="#" data-course-category="<?= $course['course_category'] ?>" data-course-category-visibility="visible" data-course-type-visibility="visible">
                                                        <div class="content">
                                                            <a href="<?= $course_link ?>" class="ui top attached huge black label" data-title="View more details about <?= $course['course_code']; ?>">
                                                                <?= $course["course_code"]; ?>
                                                            </a>
                                                            <div class="ui hidden divider"></div>
                                                            <div class="ui hidden divider"></div>
                                                            <h3 class="ui left green aligned header" data-title="Course Title"><?= $course["course_title"]; ?></h3>
                                                            <div class="left aligned meta" data-title="Course Creator">
                                                                <i class="user circle icon"></i>
                                                                <?= $course["course_creator_full_name"]; ?>
                                                            </div>
                                                            <div class="left aligned description" data-title="Course Description">
                                                                <?php 
                                                                    if(strlen($course["course_description"]) > 200) {
                                                                        $course_description = $course["course_description"];
                                                                        $last_space_char = strrpos(substr($course_description, 0, 200), " ");
                                                                        $course_description = substr_replace($course_description, "", $last_space_char);
                                                                        $course["course_description"] = $course_description . "... <a href='$course_link'>Learn More</a>";
                                                                    }
                                                                    echo $course["course_description"];
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="extra content">

                                                                <a href="<?= $course_link; ?>" class="ui green inverted fluid button" data-course-id="<?= ($course['course_code']); ?>" data-title="View the Classes registered in this Course">
                                                                    <i class="bookmark icon"></i>
                                                                    View Classes
                                                                </a>

                                                        </div>
                                                    </div>

                                                <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
                                
        <?php } else { ?>
                                
            <div id="segment-page-view" class="ui basic segment">
                <div class="ui container">
                    <div id="segment-page-view" class="ui basic very padded placeholder segment">
                        <h1 class="ui icon yellow header">
                            <i class="frown icon"></i>
                            <div class="content">
                            Oops! Looks like there are no available Courses yet.
                            <div class="sub header">Wait until an Educator add one.</div>
                            </div>
                        </h1>
                    </div>
                </div>
            </div>

        <?php } ?>
    <?php } else { ?>
        <div id="segment-page-view" class="ui basic segment">
            <div class="ui three column doubling stackable grid container center aligned">
                <div class="ui basic segment">
                    <div class="row">
                        <div class="ui container">
                            <div class="ui basic segment">
                                <div class="ui two column doubling stackable grid container center aligned">
                                    <div class="three wide column">
                                        <div id="circular-segment-course-code" class="ui raised circular green segment">
                                            <h1 class="ui green header">
                                                <div class="content">
                                                <?= $course["course_code"] ?>
                                                </div>
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="thirteen wide left aligned column">
                                        <div class="ui basic segment">
                                            <h1 id="header-course-detailed-info" class="ui header">
                                                <div class="content">
                                                    <?= $course["course_title"] ?>
                                                    <div class="sub header">
                                                        <i>Curated By <b><?= $course["course_creator_full_name"]; ?></b></i>
                                                        <div class="ui hidden fitted divider"></div>
                                                        <label class="ui green horizontal large label" data-title="Course Units"><i class="clone icon"></i><?= $course["course_units"] . " " . (((int) ($course["course_units"]) == 1) ? "Unit" : "Units") ?></label>
                                                        <label class="ui horizontal large label label-separator">⚈</label>
                                                        <?php foreach(json_decode($course["course_type"]) as $type) { ?>
                                                            <label class="ui green horizontal large label" data-title="Course Type"><i class="flag icon"></i><?= $type ?></label>
                                                        <?php } ?>
                                                        <?php if(!empty($course["course_prerequisites"])) { ?>
                                                            <label class="ui horizontal large label label-separator">⚈</label>
                                                            <?php foreach(json_decode($course["course_prerequisites"]) as $prerequisite) {
                                                                $prerequisite_comp = explode(" ", $prerequisite);
                                                                $course_link = getRelativePath("student/courses") . "?" . "course_category={$prerequisite_comp[0]}&course_suffix={$prerequisite_comp[1]}";
                                                                ?>
                                                                <a href="<?= $course_link ?>" class="ui green horizontal large label" data-title="Course Prerequisite"><i class="certificate icon"></i><?= $prerequisite ?></a>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </h1>
                                                </div>
                                            </div>
                                        <!-- <div class="three wide column"> -->
                                        <!-- <div class="four ui vertical tiny buttons"> -->
                                            <!-- <button id="button-add-to" type="button" class="ui green inverted fluid large vertical animated button card-add-to-button button-class-getter" data-title="Add this to your Handled Courses" data-course-id="<?= ($course['course_code']); ?>" <?= $add_btn_display ?>>
                                                <div class="visible content">HANDLE</div>
                                                <div class="hidden content">
                                                    <i class="bookmark icon"></i>
                                                </div>
                                            </button> -->

                                                            
                                            <!-- <button id="button-remove-from" type="button" class="ui red fluid large vertical animated button card-remove-from-button" data-title="Join a Class " data-course-id="<?= $course['course_code']; ?>" <?= $remove_btn_display ?>>
                                                <div class="visible content">JOIN</div>
                                                <div class="hidden content">
                                                    <i class="bookmark outline icon"></i>
                                                </div>
                                            </button> -->

                                            <!-- <div class="ui fitted hidden divider"></div>
                                            <div class="ui fitted hidden divider"></div>
                                            <div class="ui fitted hidden divider"></div>

                                            <button id="button-add-class" type="button" class="ui basic fluid tiny button" data-title="Make a New Class with this Course" <?= $new_class_btn_display ?>>
                                                <i class="graduation cap icon"></i>
                                                NEW CLASS
                                            </button>
                                            <div class="ui fitted hidden divider"></div>
                                            <button id="button-remove-class" type="button" class="ui basic fluid tiny button" data-title="Remove a Class with this Course" <?= $remove_class_btn_display ?>>
                                                <i class="times icon"></i>
                                                REMOVE CLASS
                                            </button>

                                            <div class="ui fitted hidden divider"></div>
                                            <?php if($course["course_creator"] == $user->user_id) { ?>
                                                
                                                <button id="button-edit-course" type="button" class="ui basic fluid tiny button" data-title="Edit the details of this Course" data-course-id="<?= ($course['course_code']); ?>">
                                                    <i class="edit icon"></i>
                                                    MODIFY
                                                </button>
                                            <?php } ?> -->
                                        <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="ui segments">
                                <div class="ui basic segment">
                                    <!-- <div class="ui horizontal segments"> -->
                                        <div class="ui basic segment">
                                            <h3 class="ui icon left aligned header">
                                                <div class="content">
                                                    Course Description
                                                    <div class="sub header">
                                                        <?= $course["course_description"] ?>
                                                    </div>
                                                </div>
                                            </h3>
                                        </div>

                                        <?php 
                                            $user->server->runQuery(
                                                "SELECT COUNT(`Course Code`) AS total_handlers FROM tbl_handled_courses WHERE `Course Code` = ?", [$course_code]
                                            );
                                            $total_handlers = $user->server->result[0]["total_handlers"];
                                            
                                            $user->server->runQuery(
                                                "SELECT COUNT(hc.`Course Code`) AS total_classes
                                                FROM tbl_classes AS c
                                                INNER JOIN tbl_handled_courses AS hc
                                                ON c.`Handled Course ID` = hc.`Handled Course ID`
                                                WHERE hc.`Course Code` = ?", [$course_code]
                                            );
                                            $total_classes = $user->server->result[0]["total_classes"];
                                        ?>
                                        
                                        <div class="ui divider"></div>
                                        
                                        <!-- <div class="ui divider"></div> -->

                                        <?php
                                            $classes = $user->getClasses($course_code, false);
                                            if(!$classes["success"]) {
                                        ?>
                                                <div class='ui basic very padded placeholder segment'>
                                                    <h3 class='ui icon green header'>
                                                        <i class='graduation cap icon'></i>
                                                        <div class='content'>
                                                        No Classes in this Course
                                                        <div class='sub header'>There were no Classes yet created by the Educators.</div>
                                                        </div>
                                                    </h3>
                                                </div>
                                                
                                        <?php } else { ?>
                                                <?php if($total_classes > 0) {?>

                                                    <div  class="ui basic compact segment" data-course-id="<?= $course_code ?>">
                                                        <h3 class="ui center aligned green icon header">
                                                            <i class="circular graduation cap inverted green icon"></i>
                                                            <div class="content">
                                                                Classes
                                                                <div class="sub header">Below are the Classes in this Course</div>
                                                            </div>
                                                        </h3>
                                                        <label class="ui green basic large horizontal label" data-title="This is the total number of Educators who already handled this Course">
                                                            <i class="ui glasses icon"></i>
                                                            Educators who are Handling this Course
                                                            <div class="detail"><?= $total_handlers ?></div>
                                                        </label>
                                                        <label id="label-total-classes" class="ui green basic large horizontal label" data-title="The number of Classes that were already added into this Course">
                                                            <i class="ui graduation cap icon"></i>
                                                            Number of Classes in this Course
                                                            <div class="detail"><?= $total_classes ?></div>
                                                        </label>

                                                        
                                                        <div class="ui segments">
                                                            <!-- <label for="" class="top attached large green ui label">
                                                                <i class="ui icon"></i>
                                                                Classes
                                                            </label> -->

                                                            <?php foreach($classes["classes"] as $class) { ?>
                                                                <div class="ui green basic left aligned segment">
                                                                    <label class="ui horizontal top left attached small green label">
                                                                        <?php
                                                                            $user->server->runQuery(
                                                                                "SELECT *, COUNT(`Student Number`) as total_students FROM
                                                                                tbl_class_students AS cs
                                                                                WHERE cs.`Class ID` = ?", [$class["class_id"]]
                                                                            );
                                                                            
                                                                            if($user->server->has_result) {
                                                                                $total_students = $user->server->result[0]["total_students"];
                                                                            } else {
                                                                                $total_students = 0;
                                                                            }
                                                                            $user->server->runQuery(
                                                                                "SELECT * FROM
                                                                                tbl_classes AS c
                                                                                INNER JOIN
                                                                                tbl_handled_courses AS hc
                                                                                ON hc.`Handled Course ID` = c.`Handled Course ID`
                                                                                WHERE c.`Class ID` = ?", [$class["class_id"]]
                                                                            );
                                                                            if($user->server->has_result) {
                                                                                $handled_course_id = $user->server->result[0]["Handled Course ID"];
                                                                                $handler_username = $user->server->result[0]["Handler Username"];
                                                                            } else {
                                                                                $handled_course_id = null;
                                                                                $handler_username = null;
                                                                            }
                                                                            echo (((int) $total_students) < 1) ? "NO STUDENT" : (((((int) $total_students) == 1)) ? $total_students . " STUDENT" : $total_students . " STUDENTS");
                                                                        ?>
                                                                    </label>
                                                                    <h4 class='ui green header accordion-header-main'>
                                                                        <?php
                                                                            $join_link = getRelativePath("student/courses") . "?join=true&class_id=" . $class["class_id"] . "&handled_course_id=" . $handled_course_id . "&educator_id=" . $handler_username;
                                                                            $button_type = "";
                                                                            $pending_class_id = null;
                                                                            if($user->hasSentJoinRequest($class["class_id"])) {
                                                                                $button_type = "pending";
                                                                                $pending_class_id = $class["class_id"];
                                                                            } else {
                                                                                $button_type = "join";
                                                                            }
                                                                            if($user->hasJoinedAClass($course_code) || ($user->hasSentJoinRequest(null, $course_code) && $class["class_id"] != $pending_class_id)) {
                                                                                $button_type = "none";
                                                                            }
                                                                            if($user->isInClass($class["class_id"])) {
                                                                                $button_type = "joined";
                                                                            }
                                                                        ?>
                                                                        <?php if($button_type == "join") { ?>
                                                                            <a href='<?= $join_link ?>' class="ui button inverted green right floated" data-title="Request a Permission to Join this Class" data-class-id="<?= $class["class_id"] ?>" data-handled-course-id="<?= $class["handled_course_id"] ?>" data-receiver-id="<?= $class["course_creator"] ?>">
                                                                                <span class="button-join-class-text">Join</span>
                                                                                <i class="right arrow icon"></i>
                                                                            </a>
                                                                        <?php } else if($button_type == "joined") { ?>
                                                                            <div class="ui button green right floated disabled" data-title="You are already in this Class" data-class-id="<?= $class["class_id"] ?>" data-handled-course-id="<?= $class["handled_course_id"] ?>" data-receiver-id="<?= $class["course_creator"] ?>">
                                                                                <span class="button-join-class-text">Joined</span>
                                                                                <i class="right check icon"></i>
                                                                            </div>
                                                                        <?php } else if($button_type == "pending") { ?>
                                                                            <div class="ui button yellow right floated disabled" data-title="You must wait for the Educator's Confirmation" data-class-id="<?= $class["class_id"] ?>" data-handled-course-id="<?= $class["handled_course_id"] ?>" data-receiver-id="<?= $class["course_creator"] ?>">
                                                                                <span class="button-join-class-text">Pending</span>
                                                                                <i class="right check icon"></i>
                                                                            </div>
                                                                        <?php } else if($button_type == "none") { ?>

                                                                        <?php } ?>
                                                                        <i class='graduation cap icon'></i>
                                                                        <div class='content'>
                                                                            <span  data-title="<?= $class["program_title"] . " " . $class["year_level_id"] . "-" . $class["section_number"]?>"><?= $class["section_id"] ?></span>
                                                                            <div class='sub header' data-title="Class Educator">
                                                                                <?php
                                                                                    $creator = $class["course_creator"];
                                                                                    $user_ = new STMSEducator(array("user_id" => $creator, "user_type" => "educator"), $server);
                                                                                    $user_->fetchAllDetails();
                                                                                    $full_name = (($user->gender == "Male") ? "Mr. " : "Ms. ") . $user_->full_name;
                                                                                    unset($user_);
                                                                                    echo $full_name;
                                                                                ?>
                                                                            </div>
                                                                            <div class="ui fitted hidden divider"></div>
                                                                            <div class="ui fitted hidden divider"></div>
                                                                            <div class="ui fitted hidden divider"></div>
                                                                        </div>
                                                                    </h4>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                    <?php } else { ?>
                                                        <div class='ui basic very padded placeholder segment'>
                                                            <h3 class='ui icon yellow header'>
                                                                <i class='graduation cap icon'></i>
                                                                <div class='content'>
                                                                No Classes.
                                                                <?php
                                                                    if($total_handlers == 0) {
                                                                        $sub_header = "No Educator handles this Course yet, so no Classes have been made yet.";
                                                                    } else if($total_handlers == 1) {
                                                                        $sub_header = "The only Educator who handles this Course has not made any Class yet.";
                                                                    } else {
                                                                        $sub_header = "None from the $total_handlers Educators who are handling this Course have made a Class yet.";
                                                                    }
                                                                ?>
                                                                <div class='sub header'><?= $sub_header ?></div>
                                                                </div>
                                                            </h3>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

<div id="modal-add-course" class="ui left very wide sidebar">
        <div class="ui basic black inverted padded center aligned segment">
            <h2 class="ui header">
                Register a Course
            </h2>
        </div>
    <div class="ui basic segment">
    <!-- <div class="ui container center aligned">
    </div> -->
    <div class="scrolling content">
        <form id="form-add-course" action="<?= $_SERVER['REQUEST_URI'] ?>" method="get" class="ui form" novalidate>
            <div class="field">
                <label>Course Code</label>
                <div class="two fields">
                    <div class="ten wide field">
                        <select id="dropdown-course-category" class="ui fluid search selection dropdown" name="course[course_category]" required>
                            <option value="">Course Prefix</option>
                        </select>
                    </div>
                    <div class="six wide field">
                        <div id="input-course-suffix" class="ui icon input">
                            <input id="course-course-suffix" type="text" name="course[course_suffix]" placeholder="Course Suffix" maxlength="5" required>
                            <i id="icon-course-suffix" class="icon"></i>
                        </div>
                        <!-- <input type="text" name="course[course_suffix]" placeholder="Course Suffix" required> -->
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Course Title</label>
                <input id="input-course-title" type="text" name="course[course_title]" placeholder="Course Title" maxlength="100" required>
            </div>
            <div class="field">
                <label>Course Description</label>
                <textarea class="textarea-with-counter textarea-auto-height" name="course[course_description]" placeholder="Course Description" maxlength="500"></textarea>
                <small class="textarea-counter"></small>
            </div>
            
            <div class="field">
                <div class="two fields">
                    <div class="ten wide field">
                        <label>Course Type</label>
                        <select id="dropdown-type" class="ui fluid selection dropdown" name="course_type[]" multiple required>
                            <option value="">Course Type</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Lecture">Lecture</option>
                        </select>
                    </div>
                    <div class="six wide field">
                        <label>Course Units</label>
                        <input type="number" name="course[course_units]" placeholder="Course Units" min="1" max="10" required>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Course Prerequisites</label>
                <select id="dropdown-prerequisites" name="course_prerequisites[]" class="ui search selection dropdown fluid" multiple="">
                    <option value="">Filter Courses by Code or Title</option>
                </select>
            </div>

            <div class="ui hidden divider"></div>
            <div class="field field-form">
                <div class="ui toggle checkbox checkbox-block">
                    <input id="auto-add" type="checkbox" name="course[auto_add]" class="hidden" value="true">
                    <label for="auto-add">Automatically Add to Handled Courses</label>
                </div>
            </div>
            <div class="ui hidden divider"></div>
            
            <div class="ui basic segment right aligned">
                <button id="button-submit-add-course" class="ui large primary button" name="course[course_creator]" value="<?= $user->username ?>" type="submit">Register New Course</button>
                <!-- <div id="button-reset-add-course" class="ui button reset" type="button"></div> -->
            </div>
        </form>
    </div>
    </div>
</div>


<?php if($is_viewing_course) { ?>
    <div id="modal-edit-course" class="ui left very wide sidebar">
            <div class="ui basic black inverted padded center aligned segment">
                <h2 id="header-edit-course-title" class="ui header">
                    Modify Course
                </h2>
            </div>
        <div class="ui basic segment">
        <!-- <div class="ui container center aligned">
        </div> -->
        <div class="scrolling content">
            <!-- <?php var_dump($_SERVER); ?> -->
            <form id="form-edit-course" action="<?= $_SERVER['REQUEST_URI'] ?>" method="get" class="ui form" novalidate>
                <small><i class="lock icon"></i>Fields with this Indicator are Locked and Unchangeable</small>
                <div class="ui hidden divider"></div>
                <div class="field">
                    <label>Course Code</label>
                    <div class="two fields">
                        <div class="ten wide field">
                            <div class="ui icon input">
                                <input type="text" name="course_edit[course_category]" placeholder="Course Category" readonly>
                                <i class="lock icon"></i>
                            </div>
                        </div>
                        <div class="six wide field">
                            <div class="ui icon input">
                                <input type="text" name="course_edit[course_suffix]" placeholder="Course Suffix" readonly>
                                <i class="lock icon"></i>
                            </div>
                            <!-- <input type="text" name="course[course_suffix]" placeholder="Course Suffix" required> -->
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Course Title</label>
                    <input id="edit-input-course-title" type="text" name="course_edit[course_title]" placeholder="Course Title" maxlength="100" required>
                </div>
                <div class="field">
                    <label>Course Description</label>
                    <textarea class="textarea-with-counter textarea-auto-height" name="course_edit[course_description]" placeholder="Course Description" maxlength="500"></textarea>
                    <small class="textarea-counter"></small>
                </div>
                
                <div class="field">
                    <div class="two fields">
                        <div class="ten wide field">
                            <label>Course Type</label>
                            <select id="edit-dropdown-type" class="ui fluid selection dropdown" name="course_type[]" multiple required>
                                <option value="">Course Type</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="Lecture">Lecture</option>
                            </select>
                        </div>
                        <div class="six wide field">
                            <label>Course Units</label>
                            <input type="number" name="course_edit[course_units]" placeholder="Course Units" min="1" max="10" required>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Course Prerequisites</label>
                    <select id="edit-dropdown-prerequisites" name="course_prerequisites[]" class="ui search selection dropdown fluid" multiple="">
                        <option value="">Filter Courses by Code or Title</option>
                    </select>
                </div>

                <div class="ui hidden divider"></div>
                
                <div class="ui basic segment right aligned">
                    <button id="button-submit-edit-course" class="ui large primary button" name="course_edit[course_code]" value="" type="submit">Save Changes</button>
                    <!-- <div id="button-reset-add-course" class="ui button reset" type="button"></div> -->
                </div>
            </form>
        </div>
        </div>
    </div>

    <div id="modal-add-class" class="ui tiny modal">
    <!-- <div class="header"> -->
        
        <div class="ui container center aligned">
            <div class="ui basic black inverted segment">
                <h3 class="ui header">
                    Create a New Class
                </h3>
            </div>
        </div>
        <!-- </div> -->
        <div class="content">
            <div id="form-add-class" class="ui form">
                <div class="field">
                    <label>Class Section</label>
                    <div class="three fields">
                        <div class="six wide field">
                            <select id="class-dropdown-program" class="ui fluid search selection dropdown" name="class[program_id]" required>
                                <option value="">Course</option>
                            </select>
                        </div>
                        <div class="five wide field">
                            <select id="class-dropdown-year-level" class="ui fluid search selection dropdown" name="class[year_level_id]" required>
                                <option value="">Year Level</option>
                            </select>
                        </div>
                        <div class="five wide field">
                            <div class="ui input">
                                <input id="class-block-section" type="number" name="class[block_section]" placeholder="Block Section" min="1" max="10" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button id="button-submit-add-class" class="ui primary fluid button" data-course-id="<?= $course_code ?>" type="button">Add this Section to your Classes</button>
            </div>
        </div>
    </div>

    <div id="modal-remove-class" class="ui tiny modal">
    <!-- <div class="header"> -->
        
        <div class="ui container center aligned">
            <div class="ui basic black inverted segment">
                <h3 class="ui header">
                    Remove Classes
                </h3>
            </div>
        </div>
        <!-- </div> -->
        <div class="content">
            <div id="form-remove-class" class="ui form">
                <div class="field">
                    <label>Class Section</label>
                    <select id="class-sections" name="class_sections[]" class="ui fluid search selection dropdown" data-course-id="<?= $course_code ?>" multiple="" required>
                        <option value="">Select Classes to Remove</option>
                    </select>
                </div>
                
                <button id="button-submit-remove-class" class="ui red fluid button" data-course-id="<?= $course_code ?>" type="button">Remove these Classes</button>
            </div>
        </div>
    </div>
<?php } ?>

<?php

include_once(getRelativePath("footer.php"));

?>