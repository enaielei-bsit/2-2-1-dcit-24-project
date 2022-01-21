<?php

header("Content-type: application/json; charset=utf-8");
require_once("initializations.php");

$api_results = array(
    "success" => true,
    "results" => array()
);

if(isset($_GET["fetch"])) {
    if($_GET["fetch"] == "programs") {
        $server->runQuery("SELECT * FROM tbl_programs ORDER BY `Program Title`");
        // $api_results["results"] = $server->result;
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["Program Title"],
                    "value" => $entity_instance["Program ID"]
                    // "text" => $entity_instance["Program Title"],
                    // "disabled" => false
                ));
            }
            echo (json_encode($api_results));
            return;
        }
    } elseif($_GET["fetch"] == "year_levels") {
        $server->runQuery("SELECT * FROM tbl_year_levels ORDER BY `Year Level ID`");
        // $api_results["results"] = $server->result;
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["Student Description"] . " / " . $entity_instance["Year Level Description"],
                    "value" => $entity_instance["Year Level ID"]
                    // "text" => $entity_instance["Program Title"],
                    // "disabled" => false
                ));
            }
            echo (json_encode($api_results));
            return;
        }
    } elseif($_GET["fetch"] == "class_programs") {
        $server->runQuery("SELECT * FROM tbl_programs ORDER BY `Program Title`");
        // $api_results["results"] = $server->result;
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["Program ID"],
                    "value" => $entity_instance["Program ID"]
                    // "text" => $entity_instance["Program Title"],
                    // "disabled" => false
                ));
            }
            echo (json_encode($api_results));
            return;
        }
    } elseif($_GET["fetch"] == "class_year_levels") {
        $server->runQuery("SELECT * FROM tbl_year_levels ORDER BY `Year Level ID`");
        // $api_results["results"] = $server->result;
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["Year Level Description"],
                    "value" => $entity_instance["Year Level ID"]
                    // "text" => $entity_instance["Program Title"],
                    // "disabled" => false
                ));
            }
            echo (json_encode($api_results));
            return;
        }
    } elseif ($_GET["fetch"] == "departments") {
        $server->runQuery("SELECT * FROM tbl_departments ORDER BY `Department Title`");
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["Department Title"],
                    "value" => $entity_instance["Department ID"]
                    // "text" => $entity_instance["Program Title"],
                    // "disabled" => false
                ));
            }
            echo (json_encode($api_results));
            return;
        }
    } elseif (strpos($_GET["fetch"], "checkUserID") !== false && strpos($_GET["fetch"], "student") !== false && isset($_GET["query"])) {
        $query = $_GET["query"];
        $server->runQuery("SELECT * FROM tbl_students WHERE `Student Number` = ?", [$query]);
        if($server->has_result) {
            echo (json_encode($api_results));
            return;
        }
    } elseif (strpos($_GET["fetch"], "checkUserID") !== false && strpos($_GET["fetch"], "educator") !== false && isset($_GET["query"])) {
        $query = $_GET["query"];
        $server->runQuery("SELECT * FROM tbl_educators WHERE BINARY `Username` = ?", [$query]);
        if(!$server->has_result) {
            $api_results["success"] = false;
        }
        echo (json_encode($api_results));
        return;
    } elseif (strpos($_GET["fetch"], "checkPassword") !== false && strpos($_GET["fetch"], "student") !== false && isset($_GET["query"])) {
        $query = $_GET["query"];
        $pass = $_GET["pass"];
        $server->runQuery("SELECT `Password` FROM tbl_students WHERE `Student Number` = ?", [$query]);
        $result = password_verify($pass, $server->result[0]['Password']);
        if(!$result) {
            $api_results["success"] = false;
            // echo (json_encode($api_results));
            // return;
        }
        echo (json_encode($api_results));
        return;
    } elseif (strpos($_GET["fetch"], "checkPassword") !== false && strpos($_GET["fetch"], "educator") !== false && isset($_GET["query"])) {
        $query = $_GET["query"];
        $pass = $_GET["pass"];
        $server->runQuery("SELECT `Password` FROM tbl_educators WHERE BINARY `Username` = ?", [$query]);
        $result = password_verify($pass, $server->result[0]['Password']);
        if(!$result) {
            $api_results["success"] = false;
            // echo (json_encode($api_results));
            // return;
        }
        echo (json_encode($api_results));
        return;
    } elseif ($_GET["fetch"] == "courses") {
        $exclude = isset($_GET["query"]) ? $_GET["query"] : null;
        // var_dump($exclude);
        $server->runQuery("SELECT * FROM tbl_courses ORDER BY `Course Title`");
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                if($entity_instance["Course Code"] != $exclude) {
                    array_push($api_results["results"], array(
                        "name" => $entity_instance["Course Title"],
                        "value" => $entity_instance["Course Code"]
                        // "text" => $entity_instance["Program Title"],
                        // "disabled" => false
                    ));
                }
            }
            echo (json_encode($api_results));
            return;
        }
    } elseif (($_GET["fetch"] == "addToHandledCourses") && (isset($_GET["query"]))) {
        $course = $_GET["query"];
        // var_dump($course);
        $user = new STMSEducator($_COOKIE, $server);
        $user->fetchAllDetails();
        $is_success = $user->addToHandledCourses($course);
        if(!$is_success) {
            $api_results["success"] = false;
        }
        echo (json_encode($api_results));
        return;
    } elseif (($_GET["fetch"] == "removeFromHandledCourses") && (isset($_GET["query"]))) {
        $force = $_GET["force"] == "yes" ? true : ($_GET["force"] == "no" ? false : null);
        $btn_id = $_GET["btn_id"];
        $course = $_GET["query"];
        $user = new STMSEducator($_COOKIE, $server);
        if(!$user->hasClasses($course) || $force) {
            $user->fetchAllDetails();
            $is_success = $user->removeFromHandledCourses($course);
            if(!$is_success) {
                $api_results["success"] = false;
            }
            echo (json_encode($api_results));
            return;
        } else {
            $api_results["success"] = false;
            $script = prompt('Remove from Handled Courses', "It looks like you're trying to remove a Handled Course with Classes in it. Doing so will also remove your Classes in this Course. Do you want to still remove this from your Handled Courses?", "function() {
                console.log(this);
                $.force = 'yes';
                $('#{$btn_id}').click();
                $('#label-total-classes > .detail').text('0');
                $.force = 'no';
                return true;
            }");
            array_push($api_results["results"], $script);
            echo (json_encode($api_results));
            return;
        }
    } elseif (($_GET["fetch"] == "getCourseCategories")) {
        $server->runQuery("SELECT DISTINCT `Course Category` FROM tbl_courses ORDER BY `Course Category`");
        if($server->has_result) {
            foreach($server->result as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["Course Category"],
                    "value" => $entity_instance["Course Category"]
                ));
            }
        } else {
            // $api_results["success"] = false;
            // echo (json_encode($api_results));
            // return;
        }
        echo (json_encode($api_results));
        return;
    } elseif (($_GET["fetch"] == "getTaskCategories")) {
        $user = new STMSEducator($_COOKIE, $server);
        $result = $user->getTaskCategories();
        if($result["success"]) {
            foreach($result["categories"] as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["category_title"],
                    "value" => $entity_instance["category_title"]
                ));
            }
        }
        echo (json_encode($api_results));
        return;
    } elseif (($_GET["fetch"] == "getHandledCourses")) {
        $user = new STMSEducator($_COOKIE, $server);
        $result = $user->getHandledCourses();
        // var_dump($result["handled_courses"]);
        // var_dump($result);
        if($result["success"]) {
            foreach($result["handled_courses"] as $entity_instance) {
                array_push($api_results["results"], array(
                    "name" => $entity_instance["course_code"] . " - " . $entity_instance["course_title"],
                    "value" => $entity_instance["handled_course_id"]
                ));
            }
            echo (json_encode($api_results));
            return;
        } else {

        }
    } elseif ($_GET["fetch"] == "checkCourseCode" && isset($_GET["query"])) {
        $query = $_GET["query"];
        $server->runQuery("SELECT * FROM tbl_courses WHERE `Course Code` = ?", [$query]);
        if($server->has_result) {
            echo (json_encode($api_results));
            return;
        }
    } elseif($_GET["fetch"] == "getCourseInfo" && isset($_GET["query"])) {
        $course = $_GET["query"];
        $user = new STMSEducator($_COOKIE, $server);
        $user->server->runQuery("SELECT * FROM tbl_courses WHERE BINARY `Course Creator` = ? AND `Course Code` = ?", [$user->user_id, $course]);
        if($user->server->has_result) {
            foreach($server->result[0] as $attribute_name => $attribute_value) {
                $api_results["results"][$attribute_name] = $user->server->result[0][$attribute_name];
            }
            echo (json_encode($api_results));
            return;
        }

    } elseif($_GET["fetch"] == "getClasses" && isset($_GET["query"])) {
        $course = $_GET["query"];
        $user = new STMSEducator($_COOKIE, $server);
        foreach($user->getClasses($course)["classes"] as $class) {
            array_push($api_results["results"], array(
                "name" => $class["section_id"],
                "value" => $class["class_id"]
            ));
        }
        echo (json_encode($api_results));
        return;

    } elseif($_GET["fetch"] == "getHandledCourseClasses" && isset($_GET["query"])) {
        $course = $_GET["query"];
        $user = new STMSEducator($_COOKIE, $server);
        if(!$user->isHandlingCourse($course)) {
            $html = "
                <div class='ui basic very padded placeholder segment'>
                    <h3 class='ui icon red header'>
                        <i class='graduation cap icon'></i>
                        <div class='content'>
                        You are not handling this course.
                        <div class='sub header'>Start making Classes by handling this Course first.</div>
                        </div>
                    </h3>
                </div>
                    
                <script id='temp_script'>
                    $('#button-remove-class').hide();
                    $('#temp_script').remove();
                </script>
            ";
            array_push($api_results["results"], $html);
            echo (json_encode($api_results));
            return;
        } else {
            if(!$user->hasClasses($course)) {
                $i = 0;
                $html = "
                    <div class='ui basic very padded placeholder segment'>
                        <h3 class='ui icon green header'>
                            <i class='graduation cap icon'></i>
                            <div class='content'>
                            You are handling this Course.
                            <div class='sub header'>Start making Classes by clicking the New Class Button above.</div>
                            </div>
                        </h3>
                    </div>
                    
                    <script id='temp_script'>
                        $('#button-remove-class').hide();
                        $('#modal-remove-class').modal('hide');
                        $('#label-total-classes > .detail').text('$i');
                        $('#temp_script').remove();
                    </script>
                ";
                array_push($api_results["results"], $html);
                echo (json_encode($api_results));
                return;
            } else {
                $html = "
                    <table class='ui very basic celled sortable table'>
                        <thead>
                            <tr>
                                <th class='center aligned'>
                                    Classes
                                </th>
                                <th class='center aligned'>
                                    Students
                                </th>
                                <th class='center aligned'>
                                    Year Level
                                </th>
                                <th class='center aligned'>
                                    Block Number
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                // var_dump($user->getClasses($course)["classes"]);
                $classes = $user->getClasses($course)["classes"];
                $class_count = count($classes);
                foreach($classes as $class) {
                    $students = $user->getClassStudents($class["class_id"]);
                    $student_count = count($students);
                    if($student_count == 1) {
                        $stud_text = "<div class='ui basic label'><i class='user icon'></i>{$student_count} Student</div>";
                    } else if($student_count > 1) {
                        $stud_text = "<div class='ui basic label'><i class='user icon'></i>{$student_count} Students</div>";
                    } else {
                        $stud_text = "<div class='ui basic label'><i class='user icon'></i>No Student</div>";
                    }
                    $html .= "
                        <tr>
                            <td>
                                <!--<h3 class='ui green header'>
                                    <i class='graduation cap icon'></i>
                                    <div class='content'>
                                        {$class['section_id']}
                                        <div class='sub header'>
                                            {$class['program_title']}
                                        </div>
                                    </div>
                                </h3>-->

                                <!--<h4 class='ui green header accordion-header-main'>
                                    <i class='graduation cap icon'></i>
                                    <div class='content'>
                                        {$class['section_id']}
                                        <div class='sub header'>
                                            {$class['program_title']}
                                        </div>
                                    </div>
                                </h4>-->

                                
                                <div class='ui fluid styled accordion accordion-class'>
                                <div class='title'>

                                    <h4 class='ui green header accordion-header-main'>
                                        <i class='graduation cap icon'></i>
                                        <div class='content'>
                                            {$class['section_id']}
                                            <div class='sub header'>
                                                {$class['program_title']}
                                            </div>
                                        </div>
                                    </h4>

                                </div>
                                <div class='content'>
                                    {$stud_text}
                    ";

                                    foreach($students as $student) {
                                        $stud = new STMSStudent(array("user_id" => $student["student_number"], "user_type" => "student"), $server);
                                        $stud->fetchAllDetails();
                                        $tasks = $stud->getTasks($course)["tasks"];
                                        $task_count = count($tasks);
                                        if($task_count == 1) {
                                            $task_text = "<div class='ui basic label'><i class='tasks icon'></i>{$task_count} Task</div>";
                                        } else if($task_count > 1) {
                                            $task_text = "<div class='ui basic label'><i class='tasks icon'></i>{$task_count} Tasks</div>";
                                        } else {
                                            $task_text = "<div class='ui basic label'><i class='tasks icon'></i>No Student</div>";
                                        }
                                        $html .= "
                                        <div class='accordion transition hidden'>
                                            <div class='title'>
                                                <i class='dropdown icon'></i>
                                                {$stud->full_name}
                                            </div>
                                            <div class='content'>
                                                <p class='transition hidden'>
                                                    {$task_text}
                                                </p>";

                                                foreach($tasks as $task) {
                                                    $diss_dt = $task["dissemination_date"];
                                                    $dead_dt = $task["deadline_date"];
                                                    $dissem = $stud->shouldBeDisseminated($diss_dt);
                                                    $closed = $stud->shouldBeClosed($dead_dt);
                                                    $submitted = (bool) ((int) $stud->isTaskEntrySubmitted($task["task_entry_id"]));
                                                    $html .= "
                                                        <div class='accordion transition hidden'>
                                                            <div class='title'>
                                                                <i class='dropdown icon'></i>
                                                                {$task['title']}
                                                            </div>
                                                            <div class='content'>
                                                                {$task['score']} / {$task['total_points']}
                                                            </div>
                                                        </div>
                                                    ";
                                                }
                                        $html .= "
                                            </div>
                                        </div>
                                        ";
                                    }


                $html .= "
                                </div>
                            </div>
                            </td>
                            <td class='center aligned'>
                                {$student_count}
                            </td>
                            <td class='center aligned'>
                                {$class['year_level_id']}
                            </td>
                            <td class='center aligned'>
                                {$class['section_number']}
                            </td>
                        </tr>
                    ";
                }
                $html .= "
                        </tbody>
                    </table>
                    <script id='temp_script'>
                        $('.ui.accordion').accordion();
                        $('table').tablesort();
                        $('#button-remove-class').show();
                        $('#label-total-classes > .detail').text('$class_count');
                        $('#temp_script').remove();
                    </script>
                ";
                array_push($api_results["results"], $html);
                echo (json_encode($api_results));
                return;
            }
        }
    } elseif($_GET["fetch"] == "addClass" && isset($_GET["query"])) {
        $program_id = $_GET["query"];
        $year_level_id = $_GET["year_level"];
        $block_section = $_GET["block_section"];
        $course_code = $_GET["course_code"];
        $section_id = "{$program_id} {$year_level_id}-{$block_section}";

        
        $user = new STMSEducator($_COOKIE, $server);
        $user->server->runQuery("SELECT `Section ID` FROM tbl_sections WHERE `Section ID` = ?", [$section_id]);
        if(!$user->server->has_result) {
            $user->server->runQuery("INSERT INTO tbl_sections VALUES(
                ?,
                ?,
                ?,
                ?
            )", [
                $section_id,
                $program_id,
                $year_level_id,
                $block_section
            ]);
        }
        // $class_id = "{$course_code}-{$user->user_id}-{$section_id}";
        if(!$user->isClassExisting($course_code, $section_id)) {
            $user->registerClass($course_code, $section_id);
            array_push($api_results["results"], $section_id);
            echo (json_encode($api_results));
            return;
        } else {
            $api_results["success"] = false;
            array_push($api_results["results"], $section_id);
            echo (json_encode($api_results));
            return;
        }
    } elseif($_GET["fetch"] == "removeClass" && isset($_GET["query"])) {
        $class_ids = (explode(",", $_GET["query"]));
        $course_code = $_GET["course_code"];
        $class_id_formatted = "";
        $user = new STMSEducator($_COOKIE, $server);
        $i = 1;
        foreach($class_ids as $class_id) {
            $user->removeClass($class_id);
            $suffix = ", ";
            if($i == count($class_ids)) {
                $suffix = "";
            }
            $class_id_formatted .= $class_id . $suffix;
            $i++;
        }
        // $class_id = "{$course_code}-{$user->user_id}-{$section_id}";
        array_push($api_results["results"], $class_id_formatted);
        echo (json_encode($api_results));
        return;
    } elseif($_GET["fetch"] == "getJoinNotifications") {
        $user = new STMSEducator($_COOKIE, $server);
        $notifs = $user->getJoinNotifications();
        // var_dump($notifs["success"]);
        $api_results["count"] = 0;
        if($notifs["success"]) {
            $html = "<div class='ui segments'>";
            foreach($notifs["join_notifs"] as $join_notif) {
                if($user->isStudentAccepted($join_notif["Entry ID"])) {
                    continue;
                } else {
                    $api_results["count"]++;
                }
                $user_ = new STMSStudent(array("user_id" => $join_notif["Sender ID"], "user_type" => "student"), $server);
                $user_->fetchAllDetails();
                $html .= "
                    <!--<div class='ui icon mini message'>
                        <i class='right green arrow icon'></i>
                        <div class='content'>
                            <div class='header'>
                            Join Request
                            </div>
                            <p>
                                {$user_->full_name} wants to join your Class {$join_notif['requested_section']} in {$join_notif['Course Title']}.
                            </p>
                            <div class='ui two mini buttons'>
                                <button class='ui green inverted button button-join-confirm'>
                                    Confirm
                                </button>
                                <button class='ui red inverted button button-join-decline'>
                                    Decline
                                </button>
                            </div>
                        </div>
                    </div>-->

                    
                        <div class='ui basic segment modal-bulletin-notif-entry'>
                            <h6 class='ui green header'>
                                <i class='right arrow circle icon'></i>
                                <div class='content'>
                                    Join Request
                                    <div class='sub header'>
                                        <small><b>{$user_->full_name}</b> wants to join your Class <b>{$join_notif['requested_section']}</b> in <b>{$join_notif['Course Title']}</b>.</small>
                                    </div>
                                </div>
                            </h6>
                            <div class='ui fitted divider'></div>
                            <div class='ui right aligned container'>
                                <button class='ui mini compact green button button-join-confirm' data-nofication-entry-id='{$join_notif['Entry ID']}' data-class-id='{$join_notif['Class ID']}' data-student-number='{$user_->student_number}'>
                                    Confirm
                                </button>
                                <button class='ui mini compact red button button-join-decline' data-nofication-entry-id='{$join_notif['Entry ID']}' data-class-id='{$join_notif['Class ID']}' data-student-number='{$user_->student_number}'>
                                    Decline
                                </button>
                            </div>
                        </div>
                        <div class='ui fitted divider'></div>
                    
                ";
            }
            $html .= "</div>";
            $api_results["success"] = true;
            $api_results["results"] = $html;
        }
        if(!$notifs["success"] || $api_results["count"] <= 0) {
            $html = "
                <div class='ui icon header'>
                    <i class='bullhorn icon'></i>
                    No Messages
                    <div class='sub header'>
                        No new join requests from Students.
                    </div>
                </div>
            ";
            $api_results["success"] = false;
            $api_results["results"] = $html;
        }

        echo (json_encode($api_results));
        return;
        
    } elseif($_GET["fetch"] == "getJoinNotificationCount") {
        $user = new STMSEducator($_COOKIE, $server);
        $notifs = $user->getJoinNotifications();
        // var_dump($notifs["success"]);
        $api_results["count"] = 0;
        if($notifs["success"]) {
            $html = 0;
            foreach($notifs["join_notifs"] as $join_notif) {
                if($user->isStudentAccepted($join_notif["Entry ID"])) {
                    continue;
                } else {
                    $html++;
                    $api_results["count"]++;
                }
            }
            $api_results["success"] = true;
            $api_results["results"] = $html;
        }
        if (!$notifs["success"] || $api_results["count"] <= 0) {
            $api_results["success"] = false;
            $api_results["results"] = 0;
        }
        echo (json_encode($api_results));
        return;
        
    } elseif($_GET["fetch"] == "joinClass" && isset($_GET["query"])) {
        $user = new STMSStudent($_COOKIE, $server);
        $handled_course_id = $_GET["query"];
        $class_id = $_GET["class_id"];
        $receiver_id = $_GET["receiver_id"];
        if($user->hasSentJoinRequest($class_id)) {
            $api_results["success"] = false;
        } else {
            $user->joinClass($handled_course_id, $class_id, $receiver_id);
        }

        if($user->isJoinRequestAccepted($class_id)) {
            // array_push($api_results["results"], ["accepted" => true]);
            $api_results["results"]["accepted"] = true;
        } else {
            // array_push($api_results["results"], ["accepted" => false]);
            $api_results["results"]["accepted"] = false;
        }

        if($user->isJoinRequestSeen($class_id)) {
            // array_push($api_results["results"], ["seen" => true]);
            $api_results["results"]["seen"] = true;
        } else {
            // array_push($api_results["results"], ["seen" => false]);
            $api_results["results"]["seen"] = false;
        }
        
        echo (json_encode($api_results));
        return;
    } else if($_GET["fetch"] == "acceptStudent" && isset($_GET["query"])) {
        $notif_entry_id = $_GET["query"];
        $class_id = $_GET['class'];
        $student_number = $_GET['stud'];
        $user = new STMSEducator($_COOKIE, $server);
        $user->acceptStudent($notif_entry_id, $student_number, $class_id);
        
        echo (json_encode($api_results));
        return;
    } else if($_GET["fetch"] == "declineStudent" && isset($_GET["query"])) {
        $notif_entry_id = $_GET["query"];
        $user = new STMSEducator($_COOKIE, $server);
        $user->declineStudent($notif_entry_id);
        
        echo (json_encode($api_results));
        return;
    }
    
    
    // elseif($_GET["fetch"] == "fetchCourses") {
    //     $user = new STMSEducator($_COOKIE, $server);
    //     $i = 0;
    //     foreach($user->getCourses()["courses"] as $course) { 
    //         $i += 1;
    //         $course_type = $user->isCourseHandled($course['course_code']) ? "handled" : "not_handled";
    //         $course_link = getRelativePath("educator/courses") . "?" . "course_category={$course['course_category']}&course_suffix={$course['course_suffix']}";
    //         if(strlen($course['course_description']) > 200) {
    //             $course['course_description'] = substr($course['course_description'], 0, 200) . "<a href='$course_link'>... Learn More</a>";
    //         }
    //         $add_btn_display = $user->isCourseHandled($course['course_code']) ? "style='display:none'" : null;
    //         $remove_btn_display = $user->isCourseHandled($course['course_code']) ? null : "style='display:none'";
    //         $card = "
    //             <div class='ui raised link card card-link' href='#' data-course-type='$course_type' data-course-category=$course['course_category'] data-course-category-visibility='visible' data-course-type-visibility='visible'>
    //                 <div class='content'>
    //                     <a href='$course_link' class='ui top attached huge black inverted label' data-title='View more details about {$course['course_code']>
    //                         {$course['course_code']}
    //                     </a>
    //                     <div class='ui hidden divider'></div>
    //                     <div class='ui hidden divider'></div>
    //                     <h3 class='ui left green aligned header' data-title='Course Title'>{$course['course_title']}</h3>
    //                     <div class='left aligned meta' data-title='Course Creator'>
    //                         <i class='user circle icon'></i>
    //                         {$course['course_creator_full_name']}
    //                     </div>
    //                     <div class='left aligned description' data-title='Course Description'>
    //                         {$course['course_description']}
    //                     </div>
    //                 </div>
    //                 <div class='extra content'>
    //                     <button type='button' class='ui green inverted fluid button card-add-to-button' data-course-id=$course['course_code'] $add_btn_display>
    //                         <i class='bookmark icon'></i>
    //                         Add To Handled Courses
    //                     </button>

    //                     <button id='button-remove-from-$i' type='button' class='ui red fluid button card-remove-from-button' data-course-id=$course['course_code'] $remove_btn_display>
    //                         <i class='bookmark outline icon'></i>
    //                         Remove From Handled Courses
    //                     </button>
    //                 </div>
    //             </div>
    //         ";
    //         array_push($api_results["results"], $card);
    //     }
    //     echo (json_encode($api_results));
    //     return;
    // }
}
// elseif ($_GET["fetch"] == "student numbers" && isset($_GET["query"])) {
//     $query = $_GET["query"];
//     $server->runQuery("SELECT `Student Number` FROM tbl_students WHERE `Student Number` = $query");
//     if($server->has_result) {
//         $api_results["success"] = true;
//         foreach($server->result as $entity_instance) {
//             array_push($api_results["results"], array(
//                 "student_number" => $entity_instance["Student Number"]
//             ));
//         }
//         echo (json_encode($api_results));
//         return;
//     }
// } elseif ($_GET["fetch"] == "usernames" && isset($_GET["query"])) {
//     $query = $_GET["query"];
//     $server->runQuery("SELECT `Username` FROM tbl_educators WHERE `Username` = $query");
//     if($server->has_result) {
//         $api_results["success"] = true;
//         foreach($server->result as $entity_instance) {
//             array_push($api_results["results"], array(
//                 "username" => $entity_instance["Username"]
//             ));
//         }
//         echo (json_encode($api_results));
//         return;
//     }
// }

?>