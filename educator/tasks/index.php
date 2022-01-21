<?php

require_once("../../_php/initializations.php");

if(!isset($_COOKIE["user_id"]) && !isset($_COOKIE["user_type"])) {
    header("Location: " . getRelativePath("stms/index.php"));
} elseif(isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"]) && $_COOKIE["user_type"] == "student") {
    header("Location: " . getRelativePath("student/index.php"));
}

$user = new STMSEducator($_COOKIE, $server);
$user->fetchAllDetails();

if(isset($_GET["task_submit"])) {
    // var_dump($_GET);
    $user->createTask($_GET);
    header("Location: " . getRelativePath("educator/tasks"));
}

$is_creating_task = (isset($_GET["is_creating_task"]) && ((bool) $_GET["is_creating_task"] === true) && $_SERVER["QUERY_STRING"] == "is_creating_task=true") ? true : false;
$is_editing_task = false;
if(isset($_GET["edit_task_id"])) {
    $id = $_GET["edit_task_id"];
    $is_existing = isset($user->getTasks()["tasks"][$id]);
    $is_editing_task = $is_existing;
    if(!$is_editing_task) {
        header("Location: " . getRelativePath("educator/tasks"));
    }
} else if(isset($_GET["delete_task_id"])) {
    $id = $_GET["delete_task_id"];
    $is_existing = isset($user->getTasks()["tasks"][$id]);
    $is_deleting_task = $is_existing;
    if(!$is_deleting_task) {
        header("Location: " . getRelativePath("educator/tasks"));
    } else {
        $user->removeTask($id);
        header("Location: " . getRelativePath("educator/tasks"));
    }
}
// var_dump($_SERVER);

setPageInternalDetails(
    "Educator | " . $user->full_name,
    getRelativePath("_css/style.css"),
    getRelativePath("_js/script.js")
);

setActiveLink("tasks-link");
include_once(getRelativePath("header_educator.php"));

// var_dump(date("h:i:s A e"));
// $samp_date = "2019-12-07 11:50:00";
// $samp_date = str_replace("-", "", $samp_date);
// $samp_date = str_replace(" ", "", $samp_date);
// $samp_date = str_replace(":", "", $samp_date);
// var_dump((float) $samp_date);
// var_dump(date("YmdHi00"));
?>

<div id="container-inbetween-viewport" class="ui fluid container">

    <div id="segment-page-title-header" class="ui basic green inverted very padded segment">
        <h1 class="ui header">
            <i class="tasks icon"></i>
            <div class="content">
                Tasks
                <div class="sub header">Create and Develop Tasks for your Handled Courses</div>
            </div>
        </h1>
        <a href="<?= getRelativePath('educator/tasks') . "?is_creating_task=true" ?>" id="button-add-task" class="ui right secondary big button">
            <i class="icons">
                <i class="tasks green icon"></i>
                <i class="bottom right corner add green inverted icon"></i>
            </i>
            Create a New Task</a>
        <!-- <button id="button-delete-task" type="button" class="ui right secondary big button">
            <i class="icons">
                <i class="tasks red icon"></i>
                <i class="bottom right corner times red inverted icon"></i>
            </i>
            Delete Tasks</button> -->
    </div>

    <?php if($is_creating_task) { ?>
        
        <div id="segment-page-view" class="ui basic segment">
            <div class="ui container">
                <div class="ui basic very padded segment">
                    
                    <button id="button-submit-task" name="task_submit" class="ui green right ribbon label huge cursor-pointer" data-title="Submit this Task" form="form-create-task" type="submit">
                        Create a New Task
                    </button>
                    <h1 class="ui left aligned header">
                        <i class="icon tasks"></i>
                        <div class="content">
                            Task Creation
                            <div class="sub header">
                                Create a Task by filling up the fields below.
                            </div>
                        </div>
                    </h1>
                    <div class="ui divider"></div>
                    <form id="form-create-task" action="<?= getRelativePath("educator/tasks") ?>" method="get" class="ui form" novalidate>
                        <div class="ui basic very padded segment">
                            <div class="ui two column doubling stackable divided grid container">
                                <div class="row">
                                    <div class="ten wide column">
                                        <div class="field">
                                            <label>Title</label>
                                            <div class="ui input">
                                                <input type="text" name="task[title]" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label>Short Description</label>
                                            <textarea class="textarea-with-counter textarea-auto-height" maxlength="100" name="task[description]" placeholder="Description"></textarea>
                                            <small class="textarea-counter"></small>
                                        </div>
                                        <!-- <div class="field">
                                            <label>Handled Course</label>
                                            <select id="task-creation-handled-courses" name="task[handled_course]" class="ui fluid search selection dropdown">
                                                <option value="">Select a Handled Course</option>
                                            </select>
                                        </div> -->
                                        <div class="field">
                                            <label>Handled Course</label>
                                            <select id="task-creation-handled-courses" name="task[handled_course]" class="ui search selection dropdown fluid">
                                                <option value="">Select a Handled Course</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>Category</label>
                                            <select id="task-creation-category" name="task_categories[]" class="ui search selection dropdown fluid" multiple="">
                                                <option value="">Search or Create Categories</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="six wide column">
                                        <div class="ui very padded segment">
                                            <div class="field">
                                                <label>Dissemination Date</label>
                                                <input id="hidden-dissemination-date" type="hidden" name="task[dissemination_date]">
                                                <div class="ui calendar" id="calendar-dissemination-date">
                                                    <div class="ui input right icon">
                                                        <i class="calendar icon"></i>
                                                        <input id="input-dissemination-date" type="text" placeholder="Dissemination Date">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="field">
                                                <label>Deadline Date</label>
                                                <input id="hidden-dissemination-date" type="hidden" name="task[deadline_date]">
                                                <div class="ui calendar" id="calendar-deadline-date">
                                                    <div class="ui input right icon">
                                                        <i class="calendar icon"></i>
                                                        <input id="input-deadline-date" type="text" placeholder="Deadline Date">
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <!-- <div class="field">
                                                <div class="ui toggle checkbox">
                                                    <input id="checkbox-set-up-t" type="checkbox" data-title="Specify a Time Limit for the Task" name="task[is_timed]" value="true" tabindex="0" class="hidden">
                                                    <label for="checkbox-set-up-t">Setup a Timer</label>
                                                </div>
                                            </div>
                                            <div class="field disabled">
                                                <label>Time Limit in Minutes</label>
                                                <div id="slider-time-limit" class="ui labeled black slider">
                                                    <input type="hidden" name="task[time_limit]">
                                                </div>
                                                <div class="ui input right icon">
                                                    <i class="time icon"></i>
                                                    <input type="number" name="task[time_limit]" min="1" max="120" placeholder="Time in Minutes">
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui hidden divider"></div>
                        <!-- <div class="ui basic horizontal segments"> -->
                            <!-- <div class="ui center aligned segment"> -->
                                <label id="label-total-items" class="ui green basic large horizontal label" data-title="The total number of items on this Task">
                                    <i class="ui bars icon"></i>
                                    Total Items
                                    <div class="detail">0</div>
                                </label>
                            <!-- </div> -->
                            <!-- <div class="ui center aligned segment"> -->
                                <label id="label-total-points" class="ui green basic large horizontal label" data-title="The total points on this Task">
                                    <i class="ui fire icon"></i>
                                    Total Points
                                    <div class="detail">0</div>
                                </label>
                            <!-- </div> -->
                        <!-- </div> -->
                        <div class="ui divider"></div>
                        <div id="segment-task-items-collection" class="ui segments" data-task-item-count="0">
                            <input id="hidden-task-item-count" type="hidden" name="task[item_count]">
                            <input id="hidden-task-total-points" type="hidden" name="task[total_points]">
                            <div class="ui green segment very padded segment-task-item segment-task-item-basis"  data-task-item-choice-count="1" data-task-item-number="1" style="display: none">
                                <input type="hidden" class="hidden-task-item-correct-choice">
                                <button type="button" class="ui top right attached red large label cursor-pointer button-task-item-remove" data-title="Remove this Item from your List of Questions">
                                    <i class="ui times icon"></i>
                                    Remove Item
                                </button>
                                <h2 class="ui green header">
                                    <i class="question circle icon"></i>
                                    <div class="content content-question-number">
                                        Question #<span></span>
                                        <div class="ui hidden fitted divider"></div>
                                        <div class="ui hidden fitted divider"></div>
                                        <div class="ui hidden fitted divider"></div>
                                        <div class="sub header">
                                            <div class="inline field">
                                                <div class="ui small left labeled transparent input input-item-point">
                                                    <label class="ui basic label">
                                                        Points
                                                    </label>
                                                    <input type="number" class="input-task-item-point" min="1" value="1" placeholder="Point">
                                                </div>
                                            </div>
                                            <!-- <label class="ui small basic label">
                                                Points
                                                <div class="detail">5</div>
                                            </label> -->
                                        </div>
                                    </div>
                                </h2>
                                <div class="field field-task-question">
                                    <div class="ui input">
                                        <textarea class="textarea-auto-height transparent textarea-task-question" data-title="Question" placeholder="Enter your Question here..." spellcheck="false" required></textarea>
                                    </div>
                                </div>
                                <div class="ui grid stackable doubling">
                                    <div class="column eight wide column-add-choice">
                                        <div class="field">
                                            <div class="ui input">
                                                <button class="ui green fluid labeled icon large button button-task-add-choice" data-title="Add a Choice" type="button">
                                                    <i class="add icon"></i>
                                                    Create a New Choice
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column eight wide column-task-choice column-task-choice-basis" data-task-choice-number="1" style="display: none;">
                                <div class="field">
                                    <div class="ui input">
                                        <textarea class="textarea-auto-height textarea-task-choice" data-title="Answer" placeholder="Enter the Details of the Choice here..." spellcheck="false" required></textarea>
                                    </div>
                                    <div class="ui horizontal basic fluid bottom attached tiny buttons buttons-task-choice-options">
                                        <buttons class="ui icon inverted button button-task-remove-button" type="button" data-title="Remove this Choice">
                                            <i class="times red icon"></i>
                                            Remove
                                        </buttons>
                                        <buttons class="ui icon inverted button button-task-mark-button" type="button" data-title="Mark this Choice as the Correct Answer">
                                            <i class="check square outline green icon"></i>
                                            Mark
                                        </buttons>
                                    </div>
                                </div>
                            </div>
                            <button class="ui labeled icon green bottom attached button huge fluid button-task-add-item" type="button" data-title="Create a New Item">
                                <i class="add icon"></i>
                                Add a New Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php } else if($is_editing_task) {?>

        <div id="segment-page-view" class="ui basic segment">
            <div class="ui container">
                <div class="ui basic very padded segment">
                    
                    <button id="button-submit-task" name="task_submit" class="ui green right ribbon label huge cursor-pointer" data-title="Submit this Task" form="form-create-task" type="submit">
                        Create a New Task
                    </button>
                    <h1 class="ui left aligned header">
                        <i class="icon tasks"></i>
                        <div class="content">
                            Task Creation
                            <div class="sub header">
                                Create a Task by filling up the fields below.
                            </div>
                        </div>
                    </h1>
                    <div class="ui divider"></div>
                    <form id="form-create-task" action="<?= getRelativePath("educator/tasks") ?>" method="get" class="ui form" novalidate>
                        <div class="ui basic very padded segment">
                            <div class="ui two column doubling stackable divided grid container">
                                <div class="row">
                                    <div class="ten wide column">
                                        <div class="field">
                                            <label>Title</label>
                                            <div class="ui input">
                                                <input type="text" name="task[title]" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label>Short Description</label>
                                            <textarea class="textarea-with-counter textarea-auto-height" maxlength="100" name="task[description]" placeholder="Description"></textarea>
                                            <small class="textarea-counter"></small>
                                        </div>
                                        <!-- <div class="field">
                                            <label>Handled Course</label>
                                            <select id="task-creation-handled-courses" name="task[handled_course]" class="ui fluid search selection dropdown">
                                                <option value="">Select a Handled Course</option>
                                            </select>
                                        </div> -->
                                        <div class="field">
                                            <label>Handled Course</label>
                                            <select id="task-creation-handled-courses" name="task[handled_course]" class="ui search selection dropdown fluid">
                                                <option value="">Select a Handled Course</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>Category</label>
                                            <select id="task-creation-category" name="task_categories[]" class="ui search selection dropdown fluid" multiple="">
                                                <option value="">Search or Create Categories</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="six wide column">
                                        <div class="ui very padded segment">
                                            <div class="field">
                                                <label>Dissemination Date</label>
                                                <input id="hidden-dissemination-date" type="hidden" name="task[dissemination_date]">
                                                <div class="ui calendar" id="calendar-dissemination-date">
                                                    <div class="ui input right icon">
                                                        <i class="calendar icon"></i>
                                                        <input id="input-dissemination-date" type="text" placeholder="Dissemination Date">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="field">
                                                <label>Deadline Date</label>
                                                <input id="hidden-dissemination-date" type="hidden" name="task[deadline_date]">
                                                <div class="ui calendar" id="calendar-deadline-date">
                                                    <div class="ui input right icon">
                                                        <i class="calendar icon"></i>
                                                        <input id="input-deadline-date" type="text" placeholder="Deadline Date">
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="field" style="display: none">
                                                <div class="ui toggle checkbox">
                                                    <input id="checkbox-set-up-t" type="checkbox" data-title="Specify a Time Limit for the Task" name="task[is_timed]" value="true" tabindex="0" class="hidden">
                                                    <label for="checkbox-set-up-t">Setup a Timer</label>
                                                </div>
                                            </div>
                                            <div class="field disabled">
                                                <!-- <label>Time Limit in Minutes</label>
                                                <div id="slider-time-limit" class="ui labeled black slider">
                                                    <input type="hidden" name="task[time_limit]">
                                                </div> -->
                                                <div class="ui input right icon">
                                                    <i class="time icon"></i>
                                                    <input type="number" name="task[time_limit]" min="1" max="120" placeholder="Time in Minutes">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui hidden divider"></div>
                        <!-- <div class="ui basic horizontal segments"> -->
                            <!-- <div class="ui center aligned segment"> -->
                                <label id="label-total-items" class="ui green basic large horizontal label" data-title="The total number of items on this Task">
                                    <i class="ui bars icon"></i>
                                    Total Items
                                    <div class="detail">0</div>
                                </label>
                            <!-- </div> -->
                            <!-- <div class="ui center aligned segment"> -->
                                <label id="label-total-points" class="ui green basic large horizontal label" data-title="The total points on this Task">
                                    <i class="ui fire icon"></i>
                                    Total Points
                                    <div class="detail">0</div>
                                </label>
                            <!-- </div> -->
                        <!-- </div> -->
                        <div class="ui divider"></div>
                        <div id="segment-task-items-collection" class="ui segments" data-task-item-count="0">
                            <input id="hidden-task-item-count" type="hidden" name="task[item_count]">
                            <input id="hidden-task-total-points" type="hidden" name="task[total_points]">
                            <div class="ui green segment very padded segment-task-item segment-task-item-basis"  data-task-item-choice-count="1" data-task-item-number="1" style="display: none">
                                <input type="hidden" class="hidden-task-item-correct-choice">
                                <button type="button" class="ui top right attached red large label cursor-pointer button-task-item-remove" data-title="Remove this Item from your List of Questions">
                                    <i class="ui times icon"></i>
                                    Remove Item
                                </button>
                                <h2 class="ui green header">
                                    <i class="question circle icon"></i>
                                    <div class="content content-question-number">
                                        Question #<span></span>
                                        <div class="ui hidden fitted divider"></div>
                                        <div class="ui hidden fitted divider"></div>
                                        <div class="ui hidden fitted divider"></div>
                                        <div class="sub header">
                                            <div class="inline field">
                                                <div class="ui small left labeled transparent input input-item-point">
                                                    <label class="ui basic label">
                                                        Points
                                                    </label>
                                                    <input type="number" class="input-task-item-point" min="1" value="1" placeholder="Point">
                                                </div>
                                            </div>
                                            <!-- <label class="ui small basic label">
                                                Points
                                                <div class="detail">5</div>
                                            </label> -->
                                        </div>
                                    </div>
                                </h2>
                                <div class="field field-task-question">
                                    <div class="ui input">
                                        <textarea class="textarea-auto-height transparent textarea-task-question" data-title="Question" placeholder="Enter your Question here..." spellcheck="false" required></textarea>
                                    </div>
                                </div>
                                <div class="ui grid stackable doubling">
                                    <div class="column eight wide column-add-choice">
                                        <div class="field">
                                            <div class="ui input">
                                                <button class="ui green fluid labeled icon large button button-task-add-choice" data-title="Add a Choice" type="button">
                                                    <i class="add icon"></i>
                                                    Create a New Choice
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column eight wide column-task-choice column-task-choice-basis" data-task-choice-number="1" style="display: none;">
                                <div class="field">
                                    <div class="ui input">
                                        <textarea class="textarea-auto-height textarea-task-choice" data-title="Answer" placeholder="Enter the Details of the Choice here..." spellcheck="false" required></textarea>
                                    </div>
                                    <div class="ui horizontal basic fluid bottom attached tiny buttons buttons-task-choice-options">
                                        <buttons class="ui icon inverted button button-task-remove-button" type="button" data-title="Remove this Choice">
                                            <i class="times red icon"></i>
                                            Remove
                                        </buttons>
                                        <buttons class="ui icon inverted button button-task-mark-button" type="button" data-title="Mark this Choice as the Correct Answer">
                                            <i class="check square outline green icon"></i>
                                            Mark
                                        </buttons>
                                    </div>
                                </div>
                            </div>
                            <button class="ui labeled icon green bottom attached button huge fluid button-task-add-item" type="button" data-title="Create a New Item">
                                <i class="add icon"></i>
                                Add a New Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php } else { ?>

        <?php if($user->getTasks()["success"]) { ?>

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
                                                        $id = $task["task_id"];
                                                        $title = empty($task["title"]) ? "Untitled" : $task["title"];
                                                        $desc = empty($task["title"]) ? "No Description." : $task["description"];
                                                        $link_edit = getRelativePath('educator/tasks') . "?edit_task_id=" . $id;
                                                        $link_delete = getRelativePath('educator/tasks') . "?delete_task_id=" . $id;
                                                        $diss_dt = $task["dissemination_date"];
                                                        $dead_dt = $task["deadline_date"];
                                                        $dissem = $user->shouldBeDisseminated($diss_dt);
                                                        $closed = $user->shouldBeClosed($dead_dt);
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
                                                                <a href="<?= $link_delete ?>" class="ui red top left attached label" data-title="Delete this Task">
                                                                    <i class="times icon"></i>
                                                                </a>
                                                                <div class="header"><?= $title ?></div>
                                                                <div class="meta">
                                                                    <span class="category" data-title="<?= $task["course_title"] ?>">
                                                                        <?= $task["course_code"] ?>
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
                            Hold up! You haven't made any task yet.
                            <div class="sub header">Get Started by Creating a Task above.</div>
                            </div>
                        </h1>
                    </div>
                </div>
            </div>

        <?php } ?>

    <?php } ?>
</div>


<div id="modal-edit-course" class="ui left very wide sidebar">
            <div class="ui basic black inverted padded center aligned segment">
                <h2 id="header-edit-course-title" class="ui header">
                    Modify Course
                </h2>
            </div>
        <div class="ui basic segment">
        <div class="scrolling content">
            <!-- <?php var_dump($_SERVER); ?> -->
            <form id="form-edit-course" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" class="ui form" novalidate>
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
                    <textarea class="textarea-with-counter textarea-auto-height" name="course_edit[course_description]" rows="3" placeholder="Course Description" maxlength="500"></textarea>
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

<?php

include_once(getRelativePath("footer.php"));

?>