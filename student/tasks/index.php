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

if(isset($_GET["task"]) && ((bool) $_GET["task"]["answer_submit"] === true)) {
    $user->submitTaskEntry($_GET);
    redirectTo("student/tasks");
}


$is_answering_task = (isset($_GET["answer_task_entry_id"]) && $user->isTaskEntryExisting($_GET["answer_task_entry_id"]) && (!$user->isTaskEntrySubmitted($_GET["answer_task_entry_id"])));
if($is_answering_task) {
    $task_entry_id = $_GET["answer_task_entry_id"];
    $task = $user->getTaskEntryDetails($task_entry_id);
    if($user->shouldBeClosed($task["deadline_date"]) || !$user->shouldBeDisseminated($task["dissemination_date"])) {
        redirectTo("student/tasks");
    }
    $user_ = new STMSEducator(array("user_id" => $task["handler_username"], "user_type" => "educator"), $server);
    $user_->fetchAllDetails();
    $task["task_creator"] = ($user_->gender == "Male" ? "Mr. " : "Ms. ") . ($user_->full_name);
}

setPageInternalDetails(
    "Student | " . $user->full_name,
    getRelativePath("_css/style.css"),
    getRelativePath("_js/script.js")
);
// if()
// $course_code = $is_viewing_course ? "{$_GET['course_category']} {$_GET['course_suffix']}" : null;
// if($is_viewing_course) {
//     $course = $user->getCourses($course_code)["courses"][$course_code];
// }

// $options = isset($_GET["options"]) ? isset($_GET["options"]) : null;
// $sorting = !empty($options["sorting"]) ? empty($options["sorting"]) : "alphabetical_a-z";
// $course_type = !empty($options["course_type"]) ? empty($options["course_type"]) : "all";


setActiveLink("tasks-link");
include_once(getRelativePath("header_student.php"));
?>

<div id="container-inbetween-viewport" class="ui fluid container">

    <?php if(!$is_answering_task) { ?>

        <div id="segment-page-title-header" class="ui basic green inverted very padded segment">
            <h1 class="ui header">
                <i class="tasks icon"></i>
                <div class="content">
                    Tasks
                    <div class="sub header">Answer Tasks from your Joined Classes</div>
                </div>
            </h1>
        </div>

    <?php } else { ?>

        <div id="segment-page-title-header" class="ui basic green inverted segment">
            <div class="ui massive inverted breadcrumb">
                <a class="section">
                    <h5 class="ui header">
                        <i class="tasks icon"></i>
                        <div class="content">
                            Tasks
                        </div>
                    </h5>
                    <!-- <label class="ui big inverted horizontal label">
                        <i class="icon tasks"></i>
                        Tasks
                    </label> -->
                </a>
                <i class="right chevron icon divider"></i>
                <div class="active section">
                    <h5 class="ui inverted header">
                        <i class="edit icon"></i>
                        <div class="content">
                            <?= $task["title"] . " - " . $task['course_code'] . ": " . $task['course_title'] . "" ?>
                        </div>
                    </h5>
                    <!-- <label class="ui big inverted horizontal label">
                        <i class="icon tasks"></i>
                        Answering a Task
                    </label> -->
                </div>
            </div>
            <!-- <h5 class="ui header">
                <i class="tasks icon"></i>
                <div class="content">
                    Tasks
                </div>
            </h5> -->
        </div>
        <div class="ui basic black inverted very padded center aligned segment">
            <h1 class="ui icon inverted header">
                <i class="circle tasks icon"></i>
                <div class="content">
                    <?php
                        $title = empty($task["title"]) ? "Untitled" : $task["title"];
                        echo $title;
                    ?>
                    <div class="sub header">
                        <?= $task["description"] ?>
                        <div class="ui hidden fitted divider"></div>
                        <div class="ui hidden fitted divider"></div>
                        <div class="ui hidden fitted divider"></div>
                        <div class="ui fluid container">
                            <?php
                                $categs = $user->getSpecificTaskCategories($task["task_id"]);
                                if(count($categs) >= 1) {
                                    foreach($user->getSpecificTaskCategories($task["task_id"]) as $cat) { ?>
                                        <label class="ui medium green horizontal label">
                                            <?= $cat ?>
                                        </label>
                            <?php
                                    }
                                } else {
                            ?>
                                    <label class="ui medium green horizontal label">
                                        Uncategorized
                                    </label>
                            <?php } ?>
                        </div>
                        <div class="ui divider"></div>
                    </div>
                </div>
            </h1>
            <div class="ui container">
                <div class="ui container">
                    <div class="ui small relaxed horizontal inverted divided list">
                        <div class="item">
                            <!--<i class="icon user"></i>
                            --><div class="content">
                                <div class="header"><?= $task["task_creator"] ?></div>
                                <div class="description"><?= $task['course_code'] . ": " . $task['course_title'] ?></div>
                            </div>
                        </div>
                        <div class="item">
                            <!--<i class="icon bars"></i>
                            --><div class="content">
                                <div class="header"><?= $task["item_count"] . (((int) $task["item_count"]) == 1 ? " Item" : " Items") ?></div>
                                <div class="description"><?= $task["total_points"] . (((int) $task["total_points"]) == 1 ? " Point" : " Points") ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- <h4 class="ui left aligned header">
                        <i class="tasks icon"></i>
                        <div class="content">
                            Tasks
                            <div class="sub header">Answer Tasks from your Joined Classes</div>
                        </div>
                    </h4> -->
                </div>
            </div>
        </div>

    <?php } ?>

    <?php if($user->getTasks()["success"]) { ?>

        <?php if(!$is_answering_task) { ?>

            <div id="segment-page-view" class="ui basic segment">
                <div class="ui container">
                    <div class="ui one column doubling stackable grid center aligned">
                        
                            <div class="sixteen wide column">
                                <div class="row">
                                    <div class="ui basic segment">
                                        
                                        <h3 id="header-no-result-course" class="ui icon black header" style="display: none">
                                            <i class="search minus circular icon"></i>
                                            <div class="content">
                                            No Results!
                                            <div class="sub header">Apparently your specified filters returned nothing.</div>
                                            <div class="sub header">Try tweaking your filters.</div>
                                            </div>
                                        </h3>
                                        <div id="cards-link" class="ui doubling stackable three cards" data-cards-sorting="a-z">
                                                
                                                <?php 
                                                    $i = 0;
                                                    foreach($user->getTasks()["tasks"] as $task) { 
                                                        $i += 1;
                                                        $id = $task["task_entry_id"];
                                                        $title = empty($task["title"]) ? "Untitled" : $task["title"];
                                                        $desc = empty($task["title"]) ? "No Description." : $task["description"];
                                                        $link_edit = getRelativePath('educator/tasks') . "?edit_task_id=" . $id;
                                                        $link_answer = getRelativePath('student/tasks') . "?answer_task_entry_id=" . $id;
                                                        $diss_dt = $task["dissemination_date"];
                                                        $dead_dt = $task["deadline_date"];
                                                        $dissem = $user->shouldBeDisseminated($diss_dt);
                                                        $closed = $user->shouldBeClosed($dead_dt);
                                                        // var_dump($task["task_entry_id"]);
                                                        $submitted = (bool) ((int) $user->isTaskEntrySubmitted($task["task_entry_id"]));
                                                        $user_ = new STMSEducator(array("user_id" => $task["handler_username"], "user_type" => "educator"), $server);
                                                        $user_->fetchAllDetails();
                                                        $course_handler_full_name = (($user_->gender == "Male") ? "Mr. " : "Ms. ") . $user_->full_name;
                                                        $score = (int) $task["score"];
                                                        $total_points = (int) $task["total_points"];
                                                ?>

                                                        <div class="ui raised link card card-task">
                                                            <div class="content">
                                                                
                                                                <!-- <?php if($dissem) { ?>
                                                                    <div class="ui green top right attached label disabled" data-title="This Task is already Disseminated. No further changes can be made.">
                                                                        <i class="highlighter icon"></i>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <a href="<?= $link_edit ?>" class="ui green top right attached label" data-title="Edit this Task">
                                                                        <i class="highlighter icon"></i>
                                                                    </a>
                                                                <?php } ?> -->


                                                                <?php if(!$closed && !$submitted && $dissem) { ?>

                                                                    <a href="<?= $link_answer ?>" class="ui green top attached label" data-title="Start answering this Task">
                                                                        <i class="tasks icon"></i>
                                                                        Answer This Task
                                                                    </a>

                                                                <?php } else { ?>
                                                                        
                                                                    <div class="ui green disabled top attached label" data-title="This Task has reached its Deadline or has been submitted already or not yet ready for Distribution">
                                                                        <i class="tasks icon"></i>
                                                                        <?php
                                                                            if($submitted) {
                                                                                echo "Submitted Task";
                                                                            } else if($closed) {
                                                                                echo "Closed Task";
                                                                            } else if(!$dissem) {
                                                                                echo "Deferred Task";
                                                                            }
                                                                        ?>
                                                                    </div>


                                                                <?php } ?>
                                                                <div class="header"><?= $title ?></div>
                                                                <div class="meta">
                                                                    <span class="category" data-title="<?= $task["course_title"] ?>">
                                                                        <?= $task["course_code"] . ' - ' . $course_handler_full_name ?>
                                                                        <!-- <label class="ui yellow small label">
                                                                            <i class="calendar check icon"></i>
                                                                            Pending
                                                                        </label>
                                                                        <label class="ui green small label">
                                                                            <i class="calendar times icon"></i>
                                                                            Open
                                                                        </label> -->
                                                                    </span>
                                                                </div>
                                                                <div class="description">
                                                                    <p>
                                                                        <?= $desc ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="extra content">
                                                                <div class="ui left aligned fluid container">
                                                                    <!-- <label class="ui yellow small label">
                                                                        <i class="calendar check icon"></i>
                                                                        Pending
                                                                    </label>
                                                                    <label class="ui green small label">
                                                                        <i class="calendar times icon"></i>
                                                                        Open
                                                                    </label> -->
                                                                    <div class="ui mini horizontal divided list">
                                                                        <div class="item" data-title="This Task will be available on <?= date('l, j F Y g:s A', strtotime($task['dissemination_date'])) ?>">
                                                                            <i class="calendar green check icon"></i><!--
                                                                            --><div class="content">
                                                                                <div class="header">
                                                                                    <?php 
                                                                                        if($user->shouldBeDisseminated($task["dissemination_date"])) {
                                                                                            echo "<span style='color: var(--green)'>Disseminated</span>";
                                                                                        } else {
                                                                                            echo "<span style='color: var(--yellow)'>Waiting</span>";
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="description">
                                                                                    <?= date("M-j g:s A", strtotime($task["dissemination_date"])) ?>
                                                                                </div>
                                                                            </div>
                                                                        </div><!--
                                                                        --><div class="item" data-title="This Task will be closed on <?= date('l, j F Y g:s A', strtotime($task['deadline_date'])) ?>">
                                                                            <i class="calendar green times icon"></i><!--
                                                                            --><div class="content">
                                                                                <div class="header">
                                                                                    <?php 
                                                                                        if($user->shouldBeClosed($task["deadline_date"])) {
                                                                                            echo "<span style='color: var(--green)'>Closed</span>";
                                                                                        } else {
                                                                                            echo "<span style='color: var(--yellow)'>Open</span>";
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="description">
                                                                                    <?= date("M-j g:s A", strtotime($task["deadline_date"])) ?>
                                                                                </div>
                                                                            </div>
                                                                        </div><!--
                                                                        --><?php if((bool) $task["timed"] && 1 > 2) { ?>
                                                                            <div class="item" data-title="This Task has a Time Limit of <?= $task["time_limit"] . (((int) $task["time_limit"]) == 1 ? " Minute" : " Minutes") ?>">
                                                                                <i class="history green icon"></i><!--
                                                                                --><div class="content">
                                                                                    <div class="header">
                                                                                        <span style='color: var(--green)'>Timed</span>
                                                                                    </div>
                                                                                    <div class="description">
                                                                                        <?= $task["time_limit"] . (((int) $task["time_limit"]) == 1 ? " Min" : " Mins") ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>

                                                                    <div class="ui left aligned fluid container" data-title="Task Categories">
                                                                        <?php
                                                                            $categs = $user->getSpecificTaskCategories($task["task_id"]);
                                                                            if(count($categs) >= 1) {
                                                                                foreach($user->getSpecificTaskCategories($task["task_id"]) as $cat) { ?>
                                                                                    <label class="ui small secondary horizontal label">
                                                                                        <?= $cat ?>
                                                                                    </label>
                                                                        <?php
                                                                                }
                                                                            } else {
                                                                        ?>
                                                                                <label class="ui small secondary horizontal label">
                                                                                    Uncategorized
                                                                                </label>
                                                                        <?php } ?>
                                                                    </div>

                                                                    <?php if($closed || $submitted) { ?>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>
                                                                    <div class="ui hidden fitted divider"></div>

                                                                    <div class="ui fluid container">
                                                                        <div class="ui mini horizontal divided list">
                                                                            <div class="item" data-title="">
                                                                                <div class="content">
                                                                                    <?php
                                                                                        if(!$submitted) {
                                                                                            echo "<b style='color: var(--red)'>UNATTENDED</b>";
                                                                                        } else {
                                                                                            $rating = ($score * 10) / $total_points;
                                                                                            if($rating >= 0 && $rating <= 3) {
                                                                                                $rating_color = "orange";
                                                                                                $rating_title = "Better Luck Next Time!";
                                                                                            } else if($rating > 3 && $rating <= 7) {
                                                                                                $rating_color = "yellow";
                                                                                                $rating_title = "Not Bad!";
                                                                                            } else if($rating > 7 && $rating <= 10) {
                                                                                                $rating_color = "blue";
                                                                                                $rating_title = "Outrageous!";
                                                                                            }
                                                                                    ?>

                                                                                            <div class="ui <?= $rating_color ?> rating" data-icon="fire alternate" data-title="<?= $rating_title ?>"  data-rating="<?= $rating ?>"></div>

                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="item" data-title="">
                                                                                <div class="content">
                                                                                    <h5 class="ui header"><?= $score ?> / <?= $total_points ?></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                        <!-- <div class="ui center aligned fluid container">
                                                                            <div class="ui accordion styled">
                                                                                <div class="title">
                                                                                    <?php
                                                                                        if(!$submitted) {
                                                                                            echo "Unattended";
                                                                                        } else {
                                                                                        $score = (int) $task["score"];
                                                                                        $total_points = (int) $task["total_points"];
                                                                                        $rating = ($score * 10) / $total_points;
                                                                                    ?>

                                                                                        <div class="ui yellow rating" data-icon="star" data-rating="<?= $rating ?>"></div>

                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="content">
                                                                                    <div class="ui hidden fitted divider"></div>
                                                                                    <div class="ui fitted divider"></div>
                                                                                    <div class="ui hidden fitted divider"></div>
                                                                                    <?php
                                                                                        if(!$submitted) {
                                                                                            echo "You did not submit a set of Answers for this Task";
                                                                                        } else {

                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div> -->
                                                                    <?php } ?>
                                                    
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
                    <div class="ui basic very padded segment">

                        <form action="<?= getRelativePath("student/tasks") . "?is_submitting_task=true" ?>" method="get" class="ui form" novalidate>
                            <div id="segment-task-items-collection" class="ui segments">
                                <!-- <input id="hidden-task-item-count" type="hidden" name="task[item_count]" value="<?= $task['item_count'] ?>"> -->
                                <input type="hidden" name="task[task_entry_id]" value="<?= $task["task_entry_id"] ?>">
                                <input type="hidden" name="task[item_count]" value="<?= $task["item_count"] ?>">
                                <?php
                                    $content = json_decode($task["content"], true);
                                    $count = 0;
                                    foreach($content as $item) {
                                        $count++;
                                ?>
                                        <div class="ui green segment very padded segment-task-answer-item">
                                            <input type="hidden" class="hidden-task-answer-item-correct-choice" name="item_<?= $count ?>[answered_choice]" value="none">
                                            <h2 class="ui green header">
                                                <i class="question circle icon"></i>
                                                <div class="content">
                                                    Question #<span><?= $count ?></span>
                                                    <div class="ui hidden fitted divider"></div>
                                                    <div class="ui hidden fitted divider"></div>
                                                    <div class="ui hidden fitted divider"></div>
                                                    <div class="sub header">
                                                        <div class="inline field">
                                                            <div class="ui small left labeled input input-item-point">
                                                                <label class="ui basic label">
                                                                    Points
                                                                </label>
                                                                <input type="text" placeholder="Point" readonly="" value="<?= $item['point'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </h2>
                                            <div class="field field-task-question">
                                                <div class="ui input">
                                                    <textarea class="textarea-auto-height transparent textarea-task-question" data-title="Question" spellcheck="false" readonly><?= $item['question'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="ui grid stackable doubling grid-task-answer-choices">
                                                <?php
                                                    $keys = array_keys($item);
                                                    // var_dump($item);
                                                    $choice_count = 0;
                                                    foreach($keys as $key) {
                                                        if(strpos($key, "choice_") !== false) {
                                                            $choice_count++;
                                                        }
                                                    }
                                                    for($i = 1; $i <= $choice_count; $i++) {
                                                ?>
                                                    <div class="column eight wide column-task-answer-choice">
                                                        <div class="field">
                                                            <buttons class="ui basic fluid button button-task-answer-choice-button" type="button" data-title="Mark this Choice as the Correct Answer" data-choice-name="<?= 'choice_' . $i ?>">
                                                                <?= $item["choice_" . $i] ?>
                                                            </buttons>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                <?php } ?>
                                <button class="ui green bottom attached button huge fluid button-task-answer-submit" type="submit" name="task[answer_submit]" value="true" data-title="Submit your Answers">
                                    <i class="pen icon"></i>
                                    Pen's Up
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php } ?>

    <?php } else { ?>

        <div id="segment-page-view" class="ui basic segment">
            <div class="ui container">
                <div id="segment-page-view" class="ui basic very padded placeholder segment">
                    <h1 class="ui icon yellow header">
                        <i class="frown icon"></i>
                        <div class="content">
                        Hold up! No Task has been created yet.
                        <div class="sub header">No Task has been created yet for your joined Classes.</div>
                        </div>
                    </h1>
                </div>
            </div>
        </div>

    <?php } ?>

</div>

<?php

include_once(getRelativePath("footer.php"));

?>