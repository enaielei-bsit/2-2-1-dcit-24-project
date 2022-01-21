<?php

class STMSAsset {
    function yieldLogo($size="small") {
        echo "
            <div class='stms-logos {$size} pointables'>
                <div class='left-divs'>
                    <div class='acro-bgs'><strong class='acros'>STMS</strong></div>
                </div><div class='right-divs'>
                    <div class='title-paths'><em class='titles'>Subject's</em></div>
                    <div class='title-paths'><em class='titles'>Task</em></div>
                    <div class='title-paths'><em class='titles'>Management</em></div>
                    <div class='title-paths'><em class='titles'>System</em></div>
                </div>
            </div>
        ";
    }
}

class STMSServer {
    private $database_name;
    private $database_user;
    private $database_password;
    public $table_name;
    public $has_result;
    public $result = array();
    public $bridge;

    function __construct($database_name, $database_user = "root", $database_password = "") {
        $this->database_name = $database_name;
        $this->database_user = $database_user;
        $this->database_password = $database_password;
        $this->performHandShake();
    }

    function performHandShake() {
        $this->bridge = new PDO("mysql:host=localhost;dbname={$this->database_name};charset=utf8", $this->database_user, $this->database_password);
        $this->bridge->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function runQuery($query, $parameters=array()) {
        $this->result = array();

        
        $query_return = $this->bridge->prepare("SET FOREIGN_KEY_CHECKS = 0");
        $query_return->execute($parameters);

        // for($i = 0; $i < strlen($query); $i++) {
        //     $char = $query[$i];
        //     if($char == '"') {
        //         $query[$i] = '\"';
        //     } elseif($char == "'") {
        //         if($i != (strlen($query) - 1)) {
        //             if($query[$i-2] != "=") {
        //                 $query[$i] = "\'";
        //             }
        //         }
        //     }
        //     $i++;
        // } var_dump($query);
        $query_return = $this->bridge->prepare($query);
        $query_return->execute($parameters);
        $this->has_result = $query_return->rowCount() > 0 ? true : false;
        if(strpos($query, "INSERT INTO") === false && strpos($query, "UPDATE") === false && strpos($query, "DELETE") === false) {
            if($this->has_result) {
                while($entity_instance = $query_return->fetch(PDO::FETCH_ASSOC)) {
                    array_push($this->result, $entity_instance);
                }
                // $this->result = $this->result[0];
            }
        }
    }

    function getLastInsertedID() {
        return $this->bridge->lastInsertID();
    }
    
}

class STMSUser {
    public $given_name;
    public $middle_name;
    public $family_name;
    public $full_name;
    public $block_number;
    public $lot_number;
    public $street;
    public $subdivision;
    public $barangay;
    public $city;
    public $province;
    public $address;
    public $birth_month;
    public $birth_day;
    public $birth_year;
    public $birthdate;
    public $gender;
    public $contact_number;
    public $email;
    public $user_type;
    public $user_id;
    public $is_remembered;
    public $has_accepted_TAC;
    public $password;
    public $password_hashed;
    public $server;

    function __construct() {
        var_dump($s = "asfasfd");
    }

    // function isLoggedIn() {
    //     return isset($this->current_user) ? $this->current_user : false;
    // }

    function register() {
        if(!$this->isExisting()) {
            if($this->isAStudent()) {

                $this->server->runQuery("SELECT `Section ID` FROM tbl_sections WHERE `Section ID` = ?", [$this->section_id]);
                if(!$this->server->has_result) {
                    $this->server->runQuery("INSERT INTO tbl_sections VALUES(
                        ?,
                        ?,
                        ?,
                        ?
                    )",
                    [
                        $this->section_id,
                        $this->program_id,
                        $this->year_level_id,
                        $this->block_section
                    ]);
                }

                $this->server->runQuery("INSERT INTO tbl_{$this->user_type}s VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                    )"
                ,[
                    $this->student_number,
                    $this->given_name,
                    $this->middle_name,
                    $this->family_name,
                    $this->address,
                    $this->birthdate,
                    $this->gender,
                    $this->contact_number,
                    $this->email,
                    $this->section_id,
                    $this->password_hashed
                ]);
            } else if($this->isAnEducator()) {
                $this->server->runQuery("INSERT INTO tbl_{$this->user_type}s(
                    `Username`,
                    `Given Name`,
                    `Middle Name`,
                    `Family Name`,
                    `Address`,
                    `Birthdate`,
                    `Gender`,
                    `Contact Number`,
                    `Email`,
                    `Department ID`,
                    `Password`) 
                    VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                    )"
                ,[
                    $this->username,
                    $this->given_name,
                    $this->middle_name,
                    $this->family_name,
                    $this->address,
                    $this->birthdate,
                    $this->gender,
                    $this->contact_number,
                    $this->email,
                    $this->department_id,
                    $this->password_hashed
                ]);
            }
        }
    }

    function logIn($page_to_redirect) {
        // var_dump(getRelativePath($page_to_redirect));
        // var_dump($this->hasCorrectPassword());
        if($this->hasCorrectPassword()) {
            if(!isset($_COOKIE["user_id"])) {
                if($this->is_remembered) {
                    setcookie("user_id", $this->user_id, strtotime('+30 days'));
                    setcookie("user_type", $this->user_type, strtotime('+30 days'));
                } else {
                    setcookie("user_id", $this->user_id);
                    setcookie("user_type", $this->user_type);
                }
            }
            header("Location: " . getRelativePath($page_to_redirect));
        } else {

        }
    }

    function fetchAllDetails() {
        $class = null;
        if($this->isAStudent()) {
            $class = "STMSStudent";
            $this->server->runQuery("SELECT * FROM tbl_students WHERE `Student Number` = ?", [$this->user_id]);
        } else if($this->isAnEducator()) {
            $class = "STMSEducator";
            $this->server->runQuery("SELECT * FROM tbl_educators WHERE BINARY `Username` = ?", [$this->user_id]);
        }

        foreach($this->server->result as $entity_instance) {
            foreach($entity_instance as $detail_type => $detail_desc) {
                $detail_type = strtolower(str_replace(" ", "_", $detail_type));
                // var_dump($detail_desc);
                eval("
                    if(property_exists('$class', '$detail_type')) {
                        \$this->{$detail_type} = '$detail_desc';
                    }
                ");
            }
        }

        if($this->isAStudent()) {
            $this->server->runQuery("SELECT `Program ID`, `Year Level ID`, `Section Number` FROM tbl_sections WHERE `Section ID` = ?", [$this->section_id]);
            $this->program_id = $this->server->result[0]["Program ID"];
            $this->year_level_id = (int) $this->server->result[0]["Year Level ID"];
            $this->block_section = $this->server->result[0]["Section Number"];
            
            $this->server->runQuery("SELECT `Student Description`, `Year Level Description` FROM tbl_year_levels WHERE `Year Level ID` = ?", [$this->year_level_id]);
            $this->year_level_title = $this->server->result[0]["Student Description"];
            $this->year_level_description = $this->server->result[0]["Year Level Description"];
        }

        $this->full_name = trim("{$this->given_name} {$this->middle_name}") . " {$this->family_name}";
    }

    function hasCorrectPassword() {
        // var_dump($this->user_id);
        if($this->isExisting()) {
            // $id = $this->isAStudent() ? "Student Number" : ($this->isAnEducator() ? "Username" : null);
            // $this->server->runQuery("SELECT * FROM tbl_{$this->user_type}s WHERE BINARY `{$id}` = $this->user_id");
            // var_dump($this->password);
            // var_dump($this->server->result);
            if($this->isAStudent()) {
                $this->server->runQuery("SELECT * FROM tbl_students WHERE `Student Number` = ?", [$this->user_id]);
            } else {
                $this->server->runQuery("SELECT * FROM tbl_educators WHERE BINARY `Username` = ?", [$this->user_id]);
            }
            return password_verify($this->password, $this->server->result[0]["Password"]);
        }
        return false;
    }

    function isExisting() {
        // $col_name = $this->isAStudent() ? "Student Number" : ($this->isAnEducator() ? "Username" : null);
        if($this->isAStudent()) {
            $this->server->runQuery(
                "SELECT * FROM tbl_students WHERE `Student Number` = ?"
            , [$this->user_id]);
        } else {
            $this->server->runQuery(
                "SELECT * FROM tbl_educators WHERE BINARY `Username` = ?"
            , [$this->user_id]);
        }
        // $this->server->runQuery("SELECT * FROM tbl_{$this->user_type}s WHERE BINARY `{$col_name}` = $this->user_id");
        // var_dump($this->server->has_result);
        return ($this->server->has_result);
    }

    function isAStudent() {
        return $this->user_type == "student" ? true : false;
    }

    function isAnEducator() {
        return $this->user_type == "educator" ? true : false;
    }

    function isStudentAccepted($notification_entry_id) {
        $this->server->runQuery("SELECT `Accepted` FROM tbl_notification_entries WHERE `Entry ID` = ?", [$notification_entry_id]);
        $result = (bool) ((int) $this->server->result[0]["Accepted"]);
        return $result;
    }


    function getCourses($course=null) {
        // $course = $course == null ? null : " WHERE `Course Code` = $course";
        $courses = array(
            "success" => true,
            "courses" => array()
        );
        if(!is_null($course)) {
            $this->server->runQuery("SELECT * FROM tbl_courses WHERE `Course Code` = ? ORDER BY `Course Category`", [$course]);
        } else {
            $this->server->runQuery("SELECT * FROM tbl_courses ORDER BY `Course Category`");
        }
        if($this->server->has_result) {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($courses["courses"][$entity_instance["Course Code"]])) {
                        $courses["courses"][$entity_instance["Course Code"]] = array();
                    }
                    $courses["courses"][$entity_instance["Course Code"]][$attribute_name] = $attribute_value;
                    if($attribute_name == "course_creator") {
                        $creator = new STMSEducator(null, $this->server);
                        $creator->user_type = "educator";
                        $creator->user_id = $courses["courses"][$entity_instance["Course Code"]][$attribute_name];
                        $creator->fetchAllDetails();
                        if($creator->gender == "Male") {
                            $prefix = "Mr. ";
                        } elseif($creator->gender == "Female") {
                            $prefix = "Ms. ";
                        }
                        $courses["courses"][$entity_instance["Course Code"]]["course_creator_full_name"] = $prefix . $creator->full_name;
                        unset($creator);
                    }
                }
            }
        } else {
            $courses["success"] = false;
        }
        return $courses;
    }

    function getTaskCategories($task_id=null) {
        $categories = array(
            "success" => true,
            "categories" => array()
        );
        $this->server->runQuery(
            "SELECT * FROM tbl_categories ORDER BY `Category Title`"
        );
        if($this->server->has_result) {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($categories["categories"][$entity_instance["Category ID"]])) {
                        $categories["categories"][$entity_instance["Category ID"]] = array();
                    }
                    $categories["categories"][$entity_instance["Category ID"]][$attribute_name] = $attribute_value;
                }
            }
        } else {
            $categories["success"] = false;
        }
        return $categories;
    }

    function hasCourses() {
        $this->server->runQuery("SELECT * FROM tbl_courses");
        return $this->server->has_result;
    }

    function isCourseExisting($course) {
        $this->server->runQuery("SELECT * FROM tbl_courses WHERE `Course Code` = ?", [$course]);
        return $this->server->has_result;
    }

    function isTaskEntryExisting($task_entry_id) {
        $this->server->runQuery("SELECT * FROM tbl_task_entries WHERE `Task Entry ID` = ?", [$task_entry_id]);
        return $this->server->has_result;
    }

    function isHandledCourseExisting($handled_course_id) {
        $this->server->runQuery("SELECT * FROM tbl_handled_courses WHERE `Handled Course ID` = ?", [$handled_course_id]);
        return $this->server->has_result;
    }

    function isClassExisting($course, $section, $class_id=null, $handled_course_id=null) {
        if(is_null($class_id) && is_null($handled_course_id)) {
            $this->server->runQuery("SELECT * FROM tbl_classes INNER JOIN tbl_handled_courses ON tbl_classes.`Handled Course ID` = tbl_handled_courses.`Handled Course ID` WHERE tbl_handled_courses.`Course Code` = ? AND tbl_classes.`Section ID` = ? AND BINARY tbl_handled_courses.`Handler Username` = ?", [$course, $section, $this->user_id]);
            return $this->server->has_result;
        } else {
            $this->server->runQuery(
                "SELECT * FROM
                tbl_classes AS c
                INNER JOIN
                tbl_handled_courses AS hc
                ON c.`Handled Course ID` = hc.`Handled Course ID`
                WHERE hc.`Handled Course ID` = ? AND c.`Class ID` = ?"
            , [$handled_course_id, $class_id]);
            return $this->server->has_result;
        }
    }

    function isEducatorExisting($username) {
        $this->server->runQuery(
            "SELECT * FROM
            tbl_educators
            WHERE `Username` = ?"
        , [$username]);
        return $this->server->has_result;
    }

    function shouldBeDisseminated($date_time) {
        $diss_dt = $this->dateTimeToNumber($date_time);
        $curr_dt = $this->dateTimeToNumber($this->getDateTimeNow());
        $result = ($diss_dt <= $curr_dt) ? true : false;
        return (empty($date_time)) ? false :  $result;
    }

    function shouldBeClosed($date_time) {
        return $this->shouldBeDisseminated($date_time);
    }

    function dateTimeToNumber($date_time) {
        $date_time = str_replace("-", "", $date_time);
        $date_time = str_replace(" ", "", $date_time);
        $date_time = str_replace(":", "", $date_time);
        return $date_time;
    }

    function getDateTimeNow() {
        $date_time = date("Y-m-d H:i:00");
        return $date_time;
    }

    function createNotification($handled_course_id, $task_id=null, $type="task", $class_id=null, $receiver_id=null) {
        // $this->server->runQuery(
        //     "SELECT n.`Handled Course ID`, n.`Task ID` FROM
        //     tbl_notifications AS n"
        // );
        // $exclude = $this->server->result;
        $task_id = is_null($task_id);
        $this->server->runQuery(
            "INSERT INTO
            tbl_notifications
            (`Handled Course ID`,
            `Task ID`,
            `Notification Type`,
            `Sender ID`)
            VALUES
            (?,
            ?,
            ?,
            ?)", [
                $handled_course_id,
                $task_id,
                $type,
                $this->user_id
            ]); 
        // var_dump("aha");
        $notififcation_id = $this->server->getLastInsertedID();
        $this->createNotificationEntries($type, $notififcation_id, $class_id, $receiver_id);
    }

    function createNotificationEntries($type="task", $notification_id=null, $class_id=null, $receiver_id=null) {
        if($type == "task") {
            $this->server->runQuery(
                "SELECT n.`Notification ID`, ne.`Receiver ID` FROM
                tbl_notifications AS n
                INNER JOIN
                tbl_notification_entries AS ne
                ON n.`Notification ID` = ne.`Notification ID`"
            );
            $has_result = $this->server->has_result;
            $exclude = $this->server->result;
            $this->server->runQuery(
                "SELECT * FROM
                tbl_class_students AS cs
                INNER JOIN
                tbl_classes AS c
                ON cs.`Class ID` = c.`Class ID`
                INNER JOIN
                tbl_handled_courses AS hc
                ON c.`Handled Course ID` = hc.`Handled Course ID`
                INNER JOIN
                tbl_notifications AS n
                ON n.`Handled Course ID` = hc.`Handled Course ID`
                WHERE n.`Notification Type` = 'task'"
            );
            
            foreach($this->server->result as $user) {
                $notif_type = $user["Notification Type"];
                $notif_id = $user["Notification ID"];
                $notif_rec = $user["Student Number"];
                $notif_cid = $user["Class ID"];
                $notif_acc = 0;
                $notif_seen = 0;
                $is_valid = true;
                foreach($exclude as $ex) {
                    if($has_result) {
                        if($ex["Receiver ID"] == $notif_rec && $ex["Notification ID"] == $notif_id) {
                            $is_valid = false;
                            break;
                        }
                    }
                }
                if($is_valid) {
                    $this->server->runQuery(
                        "INSERT INTO
                        tbl_notification_entries
                        (`Notification ID`,
                        `Class ID`,
                        `Receiver ID`,
                        `Seen`,
                        `Accepted`)
                        VALUES
                        (?,
                        ?,
                        ?,
                        ?,
                        ?)"
                    , [
                        $notif_id,
                        $notif_cid,
                        $notif_rec,
                        $notif_seen,
                        $notif_acc
                    ]);
                }
            }
        } else if($type == "join") {
            $notif_acc = 0;
            $notif_seen = 0;
            $this->server->runQuery(
                "INSERT INTO
                tbl_notification_entries
                (`Notification ID`,
                `Class ID`,
                `Receiver ID`,
                `Seen`,
                `Accepted`)
                VALUES
                (?,
                ?,
                ?,
                ?,
                ?)"
            , [
                $notification_id,
                $class_id,
                $receiver_id,
                $notif_seen,
                $notif_acc
            ]);
        }
        
        // $this->server->runQuery(
        //     "SELECT n.`Notification ID`, ne.`Receiver ID` FROM
        //     tbl_notifications AS n
        //     INNER JOIN
        //     tbl_notification_entries AS ne
        //     ON n.`Notification ID` = ne.`Notification ID`"
        // );
        // $has_result = $this->server->has_result;
        // $exclude = $this->server->result;
        // $this->server->runQuery(
        //     "SELECT * FROM
        //     tbl_educators AS e
        //     INNER JOIN
        //     tbl_handled_courses AS hc
        //     ON e.`Username` = hc.`Handler Username`
        //     INNER JOIN
        //     tbl_classes AS c
        //     ON hc.`Handled Course ID` = c.`Handled Course ID`
        //     INNER JOIN tbl_notifications AS n
        //     ON n.`Handled Course ID` = hc.`Handled Course ID`
        //     WHERE n.`Notification Type` = 'join'"
        // );
        // foreach($this->server->result as $user) {
        //     $notif_type = $user["Notification Type"];
        //     $notif_id = $user["Notification ID"];
        //     $notif_rec = $user["Username"];
        //     $notif_cid = $user["Class ID"];
        //     $notif_acc = 0;
        //     $notif_seen = 0;
        //     $is_valid = true;
        //     foreach($exclude as $ex) {
        //         if($has_result) {
        //             if($ex["Receiver ID"] == $notif_rec && $ex["Notification ID"] == $notif_id) {
        //                 $is_valid = false;
        //                 break;
        //             }
        //         }
        //     }
        //     if($is_valid) {
        //         $this->server->runQuery(
        //             "INSERT INTO
        //             tbl_notification_entries
        //             (`Notification ID`,
        //             `Class ID`,
        //             `Receiver ID`,
        //             `Seen`,
        //             `Accepted`)
        //             VALUES
        //             ($notif_id,
        //             $notif_cid,
        //             $notif_rec,
        //             $notif_seen,
        //             $notif_acc)"
        //         );
        //     }
        // }
    }


    function getClasses($course, $limit=true) {
        $classes = array(
            "success" => true,
            "classes" => array()
        );
        // $cond = $limit ? "WHERE hc.`Course Code` = $course AND hc.`Handler Username` = $this->user_id" : null;
        if($this->hasClasses($course, $limit)) {
            // var_dump("afasf");
            if($limit) {
                $this->server->runQuery
                ("  SELECT * FROM
                    tbl_classes AS c
                    INNER JOIN tbl_handled_courses AS hc
                    ON c.`Handled Course ID` = hc.`Handled Course ID`
                    INNER JOIN tbl_courses AS cs
                    ON cs.`Course Code` = hc.`Course Code`
                    INNER JOIN tbl_sections AS s
                    ON s.`Section ID` = c.`Section ID`
                    INNER JOIN tbl_programs AS p
                    ON p.`Program ID` = s.`Program ID`
                    WHERE hc.`Course Code` = ? AND BINARY hc.`Handler Username` = ?
                ", [$course, $this->user_id]);
                
            } else {
                $this->server->runQuery
                ("  SELECT * FROM
                    tbl_classes AS c
                    INNER JOIN tbl_handled_courses AS hc
                    ON c.`Handled Course ID` = hc.`Handled Course ID`
                    INNER JOIN tbl_courses AS cs
                    ON cs.`Course Code` = hc.`Course Code`
                    INNER JOIN tbl_sections AS s
                    ON s.`Section ID` = c.`Section ID`
                    INNER JOIN tbl_programs AS p
                    ON p.`Program ID` = s.`Program ID`
                    WHERE hc.`Course Code` = ?", [$course]);
            }
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($classes["classes"][$entity_instance["Class ID"]])) {
                        $classes["classes"][$entity_instance["Class ID"]] = array();
                    }
                    $classes["classes"][$entity_instance["Class ID"]][$attribute_name] = $attribute_value;
                }
            }
        } else {
            $classess["success"] = false;
        }
        return $classes;
    }

    function getClassStudents($class_id) {
        $students = array();
        $this->server->runQuery(
            "SELECT * FROM
            tbl_class_students AS cs
            INNER JOIN
            tbl_students AS s
            ON cs.`Student Number` = s.`Student Number`
            WHERE cs.`Class ID` = ?"
        , [$class_id]);
        if($this->server->has_result) {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($students[$entity_instance["Student Number"]])) {
                        $students[$entity_instance["Student Number"]] = array();
                    }
                    $students[$entity_instance["Student Number"]][$attribute_name] = $attribute_value;
                }
            }
        }
        return $students;
    }

    function hasClasses($course, $limit=true) {
        // $cond = $limit ? "AND BINARY tbl_handled_courses.`Handler Username` = $this->user_id" : null;
        if(!$limit) {
            $this->server->runQuery("SELECT * FROM tbl_handled_courses INNER JOIN tbl_classes ON tbl_handled_courses.`Handled Course ID` = tbl_classes.`Handled Course ID` WHERE tbl_handled_courses.`Course Code` = ?", [$course]);
        } else {
            $this->server->runQuery("SELECT * FROM tbl_handled_courses INNER JOIN tbl_classes ON tbl_handled_courses.`Handled Course ID` = tbl_classes.`Handled Course ID` WHERE tbl_handled_courses.`Course Code` = ? AND BINARY tbl_handled_courses.`Handler Username` = ?", [$course, $this->user_id]);
        }
        return $this->server->has_result;
    }


    function getTasks($course_code=null) {
        $tasks = array(
            "success" => true,
            "tasks" => array()
        );
        if($this->isAnEducator()) {
            $this->server->runQuery(
                "SELECT * FROM
                tbl_tasks AS t
                INNER JOIN tbl_handled_courses AS hc
                ON t.`Handled Course ID` = hc.`Handled Course ID`
                INNER JOIN tbl_courses AS c
                ON hc.`Course Code` = c.`Course Code`
                WHERE BINARY hc.`Handler Username` = ?
                "
            , [$this->user_id]);
        } else {
            if(is_null($course_code)) {
                $this->server->runQuery(
                    "SELECT * FROM
                    tbl_task_entries as te
                    INNER JOIN
                    tbl_class_students as cs
                    ON cs.`Class Student ID` = te.`Class Student ID`
                    INNER JOIN
                    tbl_tasks as t
                    ON te.`Task ID` = t.`Task ID`
                    INNER JOIN
                    tbl_handled_courses AS hc
                    ON t.`Handled Course ID` = hc.`Handled Course ID`
                    INNER JOIN tbl_courses AS c
                    ON hc.`Course Code` = c.`Course Code`
                    WHERE cs.`Student Number` = ?
                    "
                , [$this->user_id]);
            } else {
                $this->server->runQuery(
                    "SELECT * FROM
                    tbl_task_entries as te
                    INNER JOIN
                    tbl_class_students as cs
                    ON cs.`Class Student ID` = te.`Class Student ID`
                    INNER JOIN
                    tbl_tasks as t
                    ON te.`Task ID` = t.`Task ID`
                    INNER JOIN
                    tbl_handled_courses AS hc
                    ON t.`Handled Course ID` = hc.`Handled Course ID`
                    INNER JOIN tbl_courses AS c
                    ON hc.`Course Code` = c.`Course Code`
                    WHERE cs.`Student Number` = ? AND hc.`Course Code` = ?
                    "
                , [$this->user_id, $course_code]);
            }

        }
        if($this->server->has_result) {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($tasks["tasks"][$entity_instance["Task ID"]])) {
                        $tasks["tasks"][$entity_instance["Task ID"]] = array();
                    }
                    $tasks["tasks"][$entity_instance["Task ID"]][$attribute_name] = $attribute_value;
                }
            }
        } else {
            $tasks["success"] = false;
        }
        return $tasks;
    }

    function getTaskEntryDetails($task_entry_id) {
        $task = array();
        $this->server->runQuery(
            "SELECT * FROM
            tbl_task_entries as te
            INNER JOIN
            tbl_class_students as cs
            ON cs.`Class Student ID` = te.`Class Student ID`
            INNER JOIN
            tbl_tasks as t
            ON te.`Task ID` = t.`Task ID`
            INNER JOIN
            tbl_handled_courses AS hc
            ON t.`Handled Course ID` = hc.`Handled Course ID`
            INNER JOIN tbl_courses AS c
            ON hc.`Course Code` = c.`Course Code`
            WHERE cs.`Student Number` = ? AND
            te.`Task Entry ID` = ?
            "
        , [$this->user_id, $task_entry_id]);
        foreach($this->server->result as $entity_instance) {
            foreach($entity_instance as $attribute_name => $attribute_value) {
                $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                $task[$attribute_name] = $attribute_value;
            }
        }
        return $task;
    }

    function createTaskEntries() {
        $this->server->runQuery(
            "SELECT * FROM
            tbl_tasks"
        );
        if($this->server->has_result) {
            $tasks = $this->server->result;
            $this->server->runQuery(
                "SELECT * FROM
                tbl_class_students as cs
                INNER JOIN
                tbl_classes as c
                ON cs.`Class ID` = c.`Class ID`
                INNER JOIN
                tbl_handled_courses AS hc
                ON hc.`Handled Course ID` = c.`Handled Course ID`
                "
            );
            if($this->server->has_result) {
                $students = $this->server->result;
                $this->server->runQuery(
                    "SELECT * FROM
                    tbl_task_entries"
                );

                $existing_studs = $this->server->has_result ? $this->server->result : array();

                foreach($tasks as $task) {
                    foreach($students as $student) {
                        $is_existing = false;
                        foreach($existing_studs as $ex_stud) {
                            if($ex_stud["Class Student ID"] == $student["Class Student ID"] && $task["Task ID"] == $ex_stud["Task ID"]) {
                                $is_existing = true;
                                break;
                            }
                        }
                        if(!$is_existing && ($task["Handled Course ID"] == $student["Handled Course ID"])) {
                            $this->server->runQuery(
                                "INSERT INTO
                                tbl_task_entries
                                (`Task ID`, `Class Student ID`)
                                VALUES
                                (?, ?)"
                            , [
                                $task["Task ID"],
                                $student["Class Student ID"]
                            ]);
                        }
                    }
                }
            }
        }
    }

    function getSpecificTaskCategories($task_id) {
        $categories = array();
        $this->server->runQuery(
            "SELECT * FROM
            tbl_categorized_tasks AS ct
            INNER JOIN
            tbl_categories AS c
            ON
            ct.`Category ID` = c.`Category ID`
            WHERE
            ct.`Task ID` = ?
            ORDER BY c.`Category Title`"
        , [$task_id]);
        if($this->server->has_result) {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    if($attribute_name == "Category Title") {
                        array_push($categories, $entity_instance["Category Title"]);   
                    }
                }
            }
        }
        return $categories;
    }
}

class STMSEducator extends STMSUser {
    public $department_id;
    public $username;

    function __construct($user_details, $server) {
        $this->server = $server;
        if($user_details != null) {
            foreach($user_details as $detail_type => $detail_desc) {
                eval("
                    if(property_exists('STMSEducator', '$detail_type')) {
                        \$this->{$detail_type} = '$detail_desc';
                    }
                ");
            }
            $this->full_name = trim("{$this->given_name} {$this->middle_name}") . " {$this->family_name}";
            $blk = empty($this->block_number) ? null : "Block {$this->block_number}";
            $lt = empty($this->lot_number) ? null : " Lot {$this->lot_number}";
            $st = empty($this->street) ? null : ", {$this->street} Street";
            $subd = empty($this->subdivision) ? null : ", {$this->subdivision}";
            $bar = ($blk == null && $lt == null && $st == null && $subd == null) ? "{$this->barangay}" : ", Barangay {$this->barangay}";
            $cty = ", {$this->city} City";
            $prov = ", {$this->province} Province";
            $this->address = "{$blk}{$lt}{$st}{$subd}{$bar}{$cty}{$prov}";
            $this->birthdate = "{$this->birth_year}-{$this->birth_month}-{$this->birth_day}";
            $this->user_id = !isset($this->user_id) ? $this->username : $this->user_id;
            $this->password_hashed = password_hash($this->password, PASSWORD_DEFAULT);
        }
        $this->createNotificationEntries();
    }

    function registerClass($course, $section) {
        $course     = trim($course);
        $section    = trim($section);
        // $class_id   = "{$course}-{$this->user_id}-{$section}";

        $this->server->runQuery("SELECT `Handled Course ID` FROM tbl_handled_courses WHERE `Course Code` = ? AND BINARY `Handler Username` = ?", [$course, $this->user_id]);
        $handled_course_id = $this->server->result[0]["Handled Course ID"];

        if(!$this->isClassExisting($course, $section)) {
            $this->server->runQuery("INSERT INTO tbl_classes(`Handled Course ID`, `Section ID`) VALUES(
                ?,
                ?
            )", [
                $handled_course_id,
                $section
            ]);
        }
    }

    function createTaskCategoryEntry($task_id, $category) {
        $this->server->runQuery("SELECT * FROM tbl_categories WHERE `Category Title` = ?", [$category]);
        if(!$this->server->has_result) {
            $this->server->runQuery("INSERT INTO tbl_categories(`Category Title`) VALUES(?)", [$category]);
        }
        $old_categories = $this->getSpecificTaskCategories($task_id);
        $this->server->runQuery("SELECT `Category ID` FROM tbl_categories WHERE `Category Title` = ?", [$category]);
        $cat_id = $this->server->result[0]["Category ID"];
        $this->server->runQuery("INSERT INTO tbl_categorized_tasks(`Category ID`, `Task ID`) VALUES(?, ?)", [$cat_id, $task_id]);
        $new_categories = $this->getSpecificTaskCategories($task_id);
        $cat_diff = array_diff($old_categories, $new_categories);
        foreach($cat_diff as $cat) {
            $this->server->runQuery("SELECT `Category ID` FROM tbl_categories WHERE `Category Title` = ?", [$category]);
            $cat_id = $this->server->result[0]["Category ID"];
            $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 0;'");
            $this->server->runQuery("DELETE FROM tbl_categorized_tasks WHERE `Task ID` = $task_id AND `Category ID` = ?", [$cat_id]);
            $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 1;'");
        }
    }

    function createTask($post) {
        $task       = $post["task"];
        $title      = $task["title"];
        $desc       = $task["description"];
        $course     = $task["handled_course"];
        $diss_dt    = $task["dissemination_date"];
        $dead_dt    = $task["deadline_date"];
        $timed      = isset($task["is_timed"]) ? ((bool) $task["is_timed"]) : false;
        $time       = $task["time_limit"];
        $item       = $task["item_count"];
        $pnt        = $task["total_points"];
        $cat        = $post["task_categories"];
        $cont       = array();

        $time = $timed ? $time : null;

        $dissem       = $this->shouldBeDisseminated($diss_dt) ? 1 : 0;
        $closed       = $this->shouldBeClosed($dead_dt) ? 1 : 0;

        for($i = 1; $i <= $item; $i++) {
            eval("\$cont['item_$i'] = \$post['task_item_$i'];");
        }
        $cont = json_encode($cont);
        $this->server->runQuery(
            "INSERT INTO tbl_tasks
            (`Handled Course ID`,
            `Title`,
            `Description`,
            `Item Count`,
            `Total Points`,
            `Content`,
            `Disseminated`,
            `Closed`,
            `Timed`,
            `Dissemination Date`,
            `Deadline Date`,
            `Time Limit`)
            VALUES
            (?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)"
        , [
            $course,
            $title,
            $desc,
            $item,
            $pnt,
            $cont,
            $dissem,
            $closed,
            $timed,
            $diss_dt,
            $dead_dt,
            $time
        ]);
        $inserted_id = $this->server->getLastInsertedID();
        foreach($cat as $cat_) {
            $this->createTaskCategoryEntry($inserted_id, $cat_);
        }
        $this->createNotification($course, $inserted_id);
        // $this->createNotificationEntries();
    }

    function registerCourse($cat, $suff, $title, $desc, $type, $units, $prereq, $creator, $auto_add) {
        $cat    = trim($cat);
        $suff   = trim($suff);
        $code   = "$cat $suff";
        $title  = trim($title);
        $type   = trim($type);
        $units  = trim($units);
        $desc   = trim($desc);
        $prereq   = trim($prereq);

        if(!$this->isCourseExisting($code)) {
            $auto_add = (bool) $auto_add;
            if(!$this->isCourseExisting($code)) {
                $this->server->runQuery("INSERT INTO tbl_courses VALUES(
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )", [
                    $code,
                    $cat,
                    $suff,
                    $title,
                    $desc,
                    $type,
                    $units,
                    $prereq,
                    $creator
                ]);
                
                if($auto_add) {
                    $this->addToHandledCourses($code);
                }
            }
        }
    }

    function acceptStudent($notification_entry_id, $student_number, $class_id) {
        $this->server->runQuery(
            "UPDATE tbl_notification_entries
            SET `Accepted` = 1
            WHERE `Entry ID` = ?"
        , [
            $notification_entry_id
        ]);
        $this->server->runQuery(
            "INSERT INTO tbl_class_students
            (`Class ID`, `Student Number`)
            VALUES(?, ?)"
        , [
            $class_id,
            $student_number
        ]);
    }

    function declineStudent($notification_entry_id) {
        $this->server->runQuery(
            "DELETE FROM tbl_notification_entries
            WHERE `Entry ID` = ?"
        , [
            $notification_entry_id
        ]);
    }

    function updateCourse($code, $title, $desc, $type, $units, $prereq) {
        $code   = trim($code);
        $title  = trim($title);
        $type   = trim($type);
        $units  = trim($units);
        $desc   = trim($desc);
        $prereq   = trim($prereq);

        if($this->hasCreatedACourse($code)) {
            $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 0;'");
            $this->server->runQuery("UPDATE tbl_courses SET
                `Course Title` = ?,
                `Course Type` = ?,
                `Course Units` = ?,
                `Course Description` = ?,
                `Course Prerequisites` = ?
            WHERE `Course Code` = ?", [
                $title, $type, $units, $desc, $prereq, $code
            ]);
            $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 1;'");
        }
    }

    function getTasksForHandledCourse($course_code) {
        $handled_tasks = array(
            "success" => true,
            "handled_tasks" => array()
        );
        $this->server->runQuery(
            "SELECT *, COUNT(t.`Task ID`) AS `Total Tasks` FROM
            tbl_tasks AS t
            INNER JOIN
            tbl_handled_courses AS hc
            ON t.`Handled Course ID` = hc.`Handled Course ID`
            WHERE hc.`Course Code` = ? AND BINARY hc.`Handler Username` = ?"
        , [$course_code, $this->user_id]);
        if($this->server->has_result) {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($handled_tasks["handled_tasks"][$entity_instance["Task ID"]])) {
                        $handled_tasks["handled_tasks"][$entity_instance["Task ID"]] = array();
                    }
                    $handled_tasks["handled_tasks"][$entity_instance["Task ID"]][$attribute_name] = $attribute_value;
                }
            }
        } else {
            $handled_tasks["success"] = false;
        }
        return $handled_tasks;
    }

    function getHandledCourses() {
        $handled_courses = array(
            "success" => true,
            "handled_courses" => array()
        );
        $this->server->runQuery(
            "SELECT * FROM
            tbl_handled_courses AS hc
            INNER JOIN tbl_courses AS c
            ON hc.`Course Code` = c.`Course Code`
            WHERE BINARY hc.`Handler Username` = ?
            ORDER BY c.`Course Title`"
        , [$this->user_id]);
        // var_dump($this->server->result);
        if(!$this->server->has_result) {
            $handled_courses["success"] = false;
        } else {
            foreach($this->server->result as $entity_instance) {
                foreach($entity_instance as $attribute_name => $attribute_value) {
                    $attribute_name = strtolower(str_replace(" ", "_", $attribute_name));
                    if(!isset($handled_courses["handled_courses"][$entity_instance["Course Code"]])) {
                        $handled_courses["handled_courses"][$entity_instance["Course Code"]] = array();
                    }
                    $handled_courses["handled_courses"][$entity_instance["Course Code"]][$attribute_name] = $attribute_value;
                }
            }
        }
        return $handled_courses;
    }

    function removeClass($class_id) {
        $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 0;'");
        $this->server->runQuery("DELETE FROM tbl_classes WHERE `Class ID` = ?", [$class_id]);
        $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 1;'");
    } 

    function removeTask($task_id) {
        $this->server->runQuery(
            "DELETE t, ct FROM
            tbl_tasks AS t
            INNER JOIN
            tbl_categorized_tasks AS ct
            ON t.`Task ID` = ct.`Task ID`
            WHERE t.`Task ID` = ?"
        , [$task_id]);
    } 

    function hasCreatedACourse($course) {
        $this->server->runQuery("SELECT * FROM tbl_courses WHERE `Course Code` = ? AND BINARY `Course Creator` = ?", [$course, $this->user_id]);
        return $this->server->has_result;
    }

    function isHandlingCourse($course) {
        $this->server->runQuery("SELECT * FROM tbl_handled_courses WHERE BINARY `Handler Username` = ? AND `Course Code` = ?", [$this->user_id, $course]);
        return $this->server->has_result;
    }

    function hasHandledCourses() {
        $this->server->runQuery("SELECT * FROM tbl_handled_courses WHERE BINARY `Handler Username` = ?", [$this->user_id]);
        return $this->server->has_result;
    }

    function addToHandledCourses($course) {
        if(!$this->isCourseHandled($course)) {
            $this->server->runQuery("INSERT INTO tbl_handled_courses(`Course Code`, `Handler Username`) VALUES(
                ?,
                ?
            )", [
                $course,
                $this->user_id
            ]);
            return true;
        } else {
            return false;
        }
    }

    function removeFromHandledCourses($handled_course) {
        if($this->isCourseHandled($handled_course)) {
            $this->server->runQuery("SELECT `Handled Course ID` FROM tbl_handled_courses WHERE `Course Code` = ? AND BINARY `Handler Username` = ?", [$handled_course, $this->user_id]);
            $handled_course_id = $this->server->result[0]["Handled Course ID"];
            $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 0;'");
            $this->server->runQuery(
                "DELETE FROM tbl_classes WHERE `Handled Course ID` = ?"
            , [$handled_course_id]);
            $this->server->runQuery(
                "DELETE FROM tbl_notifications WHERE `Handled Course ID` = ?"
            , [$handled_course_id]);
            $this->server->runQuery(
                "DELETE ct, t FROM tbl_tasks AS t
                INNER JOIN tbl_categorized_tasks AS ct
                ON t.`Task ID` = ct.`Task ID`
                WHERE t.`Handled Course ID` = ?"
            , [$handled_course_id]);
            $this->server->runQuery(
                "DELETE FROM tbl_handled_courses WHERE `Handled Course ID` = ?"
            , [$handled_course_id]);
            $this->server->runQuery("SET FOREIGN_KEY_CHECKS = 1;'");
            return true;
        } else {
            return false;
        }
    }

    function removeCourses($course) {

    }

    // function isCourseFirstEntry($course) {
    //     $this->server->runQuery("SELECT `Courses` FROM tbl_educators WHERE BINARY `Username` = $this->username");
    //     if(($this->server->result[0]["Courses"]) == "null") {
    //         $this->server->runQuery("UPDATE tbl_educators SET `Courses` = '[]' WHERE BINARY `Username` = $this->username");
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    function isCourseHandled($course) {
        $this->server->runQuery("SELECT * FROM tbl_handled_courses WHERE BINARY `Handler Username` = ? AND `Course Code` = ?", [$this->user_id, $course]);
        return $this->server->has_result;
    }

    function getJoinNotifications() {
        $join_notifs = array(
            "success" => true,
            "join_notifs" => array()
        );
        $this->server->runQuery(
            "SELECT *, c.`Section ID` AS requested_section FROM
            tbl_notification_entries AS ne
            INNER JOIN
            tbl_notifications AS n
            ON ne.`Notification ID` = n.`Notification ID`
            INNER JOIN
            tbl_handled_courses AS hc
            ON hc.`Handled Course ID` = n.`Handled Course ID`
            LEFT JOIN
            tbl_tasks AS t
            ON t.`Task ID` = n.`Task ID`
            INNER JOIN
            tbl_classes AS c
            ON c.`Class ID` = ne.`Class ID`
            LEFT JOIN
            tbl_students AS stud
            ON stud.`Student Number` = n.`Sender ID`
            INNER JOIN
            tbl_courses AS cs
            ON hc.`Course Code` = cs.`Course Code`
            WHERE BINARY ne.`Receiver ID` = ?
            AND n.`Notification Type` = 'join'"
        , [$this->user_id]);
        if(!$this->server->has_result) {
            $join_notifs["success"] = false;
        } else {
            $join_notifs["join_notifs"] = $this->server->result;
        }
        return $join_notifs;
    }
}

class STMSStudent extends STMSUser {
    public $program_id;
    public $year_level_id;
    public $year_level_title;
    public $year_level_description;
    public $block_section;
    public $section_id;
    public $student_number;

    function __construct($user_details, $server) {
        $this->server = $server;

        if($user_details != null) {
            foreach($user_details as $detail_type => $detail_desc) {
                eval("
                    if(property_exists('STMSStudent', '$detail_type')) {
                        \$this->{$detail_type} = '$detail_desc';
                    }
                ");
            }
            $this->full_name = trim("{$this->given_name} {$this->middle_name}") . " {$this->family_name}";
            $blk = empty($this->block_number) ? null : "Block {$this->block_number}";
            $lt = empty($this->lot_number) ? null : " Lot {$this->lot_number}";
            $st = empty($this->street) ? null : ", {$this->street} Street";
            $subd = empty($this->subdivision) ? null : ", {$this->subdivision}";
            $bar = ($blk == null && $lt == null && $st == null && $subd == null) ? "{$this->barangay}" : ", Barangay {$this->barangay}";
            $cty = ", {$this->city} City";
            $prov = ", {$this->province} Province";
            $this->address = "{$blk}{$lt}{$st}{$subd}{$bar}{$cty}{$prov}";
            $this->birthdate = "{$this->birth_year}-{$this->birth_month}-{$this->birth_day}";
            // $this->student_number = $this->user_id;
            // $this->user_id = $this->student_number;
            
            $this->user_id = !isset($this->user_id) ? $this->student_number : $this->user_id;
            $this->password_hashed = password_hash($this->password, PASSWORD_DEFAULT);

            $this->section_id = "{$this->program_id} {$this->year_level_id}-{$this->block_section}";
        }
        $this->createNotificationEntries();
    }

    function joinClass($handled_course_id, $class_id, $receiver_id) {
        $this->createNotification($handled_course_id, null, "join", $class_id, $receiver_id);
        // $this->createNotificationEntries();
    }

    function hasSentJoinRequest($class_id, $course_code=null) {
        if(is_null($course_code)) {
            $this->server->runQuery(
                "SELECT * FROM
                tbl_notification_entries AS ne
                INNER JOIN
                tbl_notifications AS n
                ON ne.`Notification ID` = n.`Notification ID`
                WHERE ne.`Class ID` = ?
                AND n.`Sender ID` = ?
                AND n.`Notification Type` = 'join'"
            , [$class_id, $this->user_id]);
            return $this->server->has_result;
        } else {
            $this->server->runQuery(
                "SELECT * FROM
                tbl_notification_entries AS ne
                INNER JOIN
                tbl_notifications AS n
                ON ne.`Notification ID` = n.`Notification ID`
                INNER JOIN
                tbl_handled_courses AS hc
                ON hc.`Handled Course ID` =  n.`Handled Course ID`
                WHERE hc.`Course Code` = ?
                AND n.`Sender ID` = ?
                AND n.`Notification Type` = 'join'"
            , [$course_code, $this->user_id]);
            return $this->server->has_result;
        }
    }

    function isJoinRequestAccepted($class_id) {
        $this->server->runQuery(
            "SELECT * FROM
            tbl_notification_entries AS ne
            INNER JOIN
            tbl_notifications AS n
            ON ne.`Notification ID` = n.`Notification ID`
            WHERE ne.`Class ID` = ?
            AND n.`Sender ID` = ?
            AND n.`Notification Type` = 'join'"
        , [$class_id, $this->user_id]);
        $result = $this->server->result[0];
        if(((int) $result["Accepted"]) == 0) {
            return false;
        } else if(((int) $result["Accepted"]) == 1) {
            return true;
        }
        
    }

    function isJoinRequestSeen($class_id) {
        $this->server->runQuery(
            "SELECT * FROM
            tbl_notification_entries AS ne
            INNER JOIN
            tbl_notifications AS n
            ON ne.`Notification ID` = n.`Notification ID`
            WHERE ne.`Class ID` = ?
            AND n.`Sender ID` = ?
            AND n.`Notification Type` = 'join'"
        , [$class_id, $this->user_id]);
        $result = $this->server->result[0];
        if(((int) $result["Seen"]) == 0) {
            return false;
        } else if(((int) $result["Seen"]) == 1) {
            return true;
        }
    }

    function isInClass($class_id) {
        $this->server->runQuery(
            "SELECT * FROM
            tbl_class_students
            WHERE `Class ID` = ?
            AND `Student Number` = ?"
        , [
            $class_id,
            $this->user_id
        ]);
        return $this->server->has_result;
    }

    function hasJoinedAClass($course_code) {
        $this->server->runQuery(
            "SELECT * FROM
            tbl_class_students AS cs
            INNER JOIN
            tbl_classes AS c
            ON cs.`Class ID` = c.`Class ID`
            INNER JOIN tbl_handled_courses AS hc
            ON hc.`Handled Course ID` = c.`Handled Course ID`
            WHERE hc.`Course Code` = ? AND cs.`Student Number` = ?"
        , [
            $course_code, $this->user_id
        ]);
        return $this->server->has_result;
    }

    function submitTaskEntry($get) {
        $item_count = $get["task"]["item_count"];
        $task_entry_id = $get["task"]["task_entry_id"];
        $task_answers = array();
        for($i = 1; $i <= $item_count; $i++) {
            $task_answers["item_" . $i] = array();
            $task_answers["item_" . $i]["answered_choice"] = $get["item_" . $i]["answered_choice"];
        }
        $task_details = $this->getTaskEntryDetails($task_entry_id);
        $task_basis = json_decode($task_details["content"], true);
        $i = 0;
        $correct_answers = 0;
        $wrong_answers = 0;
        $score = 0;
        $submitted = 1;
        foreach($task_basis as $item) {
            $i++;
            $item_name = "item_" . $i;
            // var_dump($item["correct_choice"]);
            // var_dump($task_answers);
            if($item["correct_choice"] == $task_answers[$item_name]["answered_choice"]) {
                $correct_answers++;
                $score += (int) $item["point"];
            } else {
                $wrong_answers++;
            }
        }
        $task_answers = json_encode($task_answers);
        $this->server->runQuery(
            "UPDATE tbl_task_entries
            SET `Answer Content` = ?,
            `Right Answers` = ?,
            `Wrong Answers` = ?,
            `Submitted` = ?,
            `Score` = ?
            WHERE `Task Entry ID` = ?"
        , [
            $task_answers,
            $correct_answers,
            $wrong_answers,
            $submitted,
            $score,
            $task_entry_id
        ]);
    }

    function isTaskEntrySubmitted($task_entry_id) {
        $this->server->runQuery(
            "SELECT `Submitted` FROM tbl_task_entries WHERE `Task Entry ID` = ?",
            [$task_entry_id]
        );
        // echo($this->server->has_result);
        return $this->server->result[0]["Submitted"];
    }
}

class DateGenerator {

    public $year;
    public $months;
    public $is_leap_year;

    function __construct($year = CURRENT_YEAR) {
        $this->year = $year;
        $this->is_leap_year = $year % 4 == 0 ? true : false;
        $this->months = MONTHS;
    }
    
    function getMonthsAndDays($year = null) {
        $year = $year == null ? $this->year : $year;
        foreach(MONTHS as $month => $null) {
            $days = array();
            if($month == 0 || $month == 2 || $month == 4 || $month == 6 || $month == 7 || $month == 9 || $month == 11) {
                foreach(DAYS as $day) {
                    array_push($days, $day);
                }
            } else if($month == 1) {
                foreach(DAYS as $day) {
                    array_push($days, $day);
                    if($year % 4 == 0) {
                        if($day == 29) { break; }
                    } else {
                        if($day == 28) { break; }
                    }
                }
            } else if($month == 3 || $month == 5 || $month == 8 || $month == 10) {
                foreach(DAYS as $day) {
                    array_push($days, $day);
                    if($day == 30) { break; }
                }
            }
            $months_and_days[MONTHS[$month]] = $days;
        }

        return $months_and_days;
    }

    function generateYears($base_year = null, $year_offset = 18, $total_count = 120, $is_asc = false) {
        $year = $base_year == null ? $this->year - $year_offset : $base_year - $year_offset;
        $years = array();
        for($i = 1; $i <= $total_count; $i++) {
            array_push($years, $year);
            $year--;
        }
        $years = array_combine(range($years[count($years) - count($years)], $years[count($years) - 1]), array_values($years));
        // var_dump(range($years[count($years) - count($years)], $years[count($years) - 1]));

        return $is_asc ? array_reverse($years) : $years;
    }

    function generateMonths() {
        $months = array();
        foreach(MONTHS as $month) {
            $months[$month] = $month;
        }
        
        return $months;
    }

    function generateDays($month, $year = null, $is_asc = true) {
        $year = $year == null ? $this->year : $year;
        $days = array();
        foreach($this->getMonthsAndDays($year)[$month] as $day) {
            array_push($days, $day);
        }
        $days = array_combine(range(1, count($days)), array_values($days));
        
        return $is_asc ? $days : array_reverse($days);
    }

    function isLeapYear($year = null) {
        $year = $year == null ? $this->year : $year;

        return $year % 4 == 0 ? true : false;
    }
    
    function isDayValid($day, $month, $year = null) {
        $year = $year == null ? $this->year : $year;

        return array_search($day, $this->generateDays($month, $year)) ? true : false;
    }
}

?>