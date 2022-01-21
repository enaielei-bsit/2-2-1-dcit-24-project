<?php

require_once("_php/initializations.php");


if(isset($_GET["has_logged_out"]) && (bool) $_GET["has_logged_out"] === true) {
    if(isset($_COOKIE["user_id"]) && isset($_COOKIE["user_type"])) {
        setcookie("user_id", null, time() - 3600);
        setcookie("user_type", null, time() - 3600);
        header("Location: " . getRelativePath("stms/index.php"));
    }
}

if(isset($_COOKIE["user_id"])) {
    //    var_dump($_COOKIE["user_type"]);
    if(isset($_COOKIE["user_type"]) && $_COOKIE["user_type"] == "student") {
        header("Location: " . getRelativePath("student/index.php"));
    } elseif(isset($_COOKIE["user_type"]) && $_COOKIE["user_type"] == "educator") {
        header("Location: " . getRelativePath("educator/index.php"));
    }
} else {
    
}
    
setPageInternalDetails(
    "STMS",
    getRelativePath("_css/style.css"),
    getRelativePath("_js/script.js")
);
require_once(getRelativePath("header.php"));

// $server = new STMSServer("db_stms");
// $asset = new STMSAsset();
$date_gen = new DateGenerator();
if(isset($_POST["user"]["user_type"])) {
    $user_type = $_POST["user"]["user_type"];
    $user = null;
    if($user_type == "student") {
        $user = new STMSStudent($_POST["user"], $server);
    } else if($user_type == "educator") {
        $user = new STMSEducator($_POST["user"], $server);
    }

    if((isset($_POST["action"]) && $_POST["action"] == "sign_in")) {
        if($user->user_type == "student") {
            // var_dump("syccces");
            var_dump($_POST);
            $user->logIn("student/index.php");    
        } elseif($user->user_type == "educator") {
            $user->logIn("educator/index.php");    
        }
        
    } elseif((isset($_POST["action"]) && $_POST["action"] == "sign_up")) {
        $user->register();
    }
}
// var_dump($STMSServer->runQuery("SELECT * FROM tbl_programs"));

$is_signing_up = isset($_GET["form_type"]) && $_GET["form_type"] == "sign_up" ? true : false;
$is_an_educator = isset($_GET["user_type"]) && $_GET["user_type"] == "educator" ? true : false;

?>
<div id="container-main" class="container fluid">
<?php if(!$is_signing_up) {?>
    <div class="ui three column doubling stackable grid container center aligned">
        <div class="column">
            <div id="segment-form-header" class="ui basic inverted segment">
                <h1 class="ui center aligned inverted green header">
                    <i class="user circle icon"></i>
                    <div class="content">
                        Sign In
                        <div class="sub header">
                            as <?= $is_an_educator ? "an Educator" : "a Student" ?>
                        </div>
                    </div>
                </h1>
                <div class="ui container">
                    <a href="<?= sendGETData("form_type=sign_in&user_type=student")?>" id="button-user-type-student" class="ui inverted <?= !$is_an_educator ? 'active' : null ?> button button-user-type">STUDENT</a>
                    <a href="<?= sendGETData("form_type=sign_in&user_type=educator")?>" id="button-user-type-educator" class="ui inverted <?= $is_an_educator ? 'active' : null ?> button button-user-type">EDUCATOR</a>
                </div>
            </div>
            <div id="segment-main" class="ui raised very padded segment left aligned">
                <!-- <div class="ui basic segment center aligned">
                    <div class="ui small buttons">
                        <a href="<?= sendGETData("form_type=sign_in&user_type=student")?>" id="button-user-type-student" class="ui yellow <?= !$is_an_educator ? 'active' : null ?> button button-user-type">STUDENT</a>
                        <div class="or" data-text="OR"></div>
                        <a href="<?= sendGETData("form_type=sign_in&user_type=educator")?>" id="button-user-type-educator" class="ui teal <?= $is_an_educator ? 'active' : null ?> button button-user-type">EDUCATOR</a>
                    </div>
                </div>
                <div class="ui divider"></div> -->

                <form id="form-sign-in-<?= $is_an_educator ? "educator" : "student" ?>" action="<?= $_SERVER["PHP_SELF"] . ("?form_type=sign_in&" . "user_type=" . ($is_an_educator ? "educator" : "student")) ?>" method="post" class="ui form" novalidate>
                    <input type="hidden" name="action" value="sign_in"/>
                    <?php if(!$is_an_educator) { ?>
                        <div class="field">
                            <label for="student-number">Student Number</label>
                            <div id="input-user-id" class="ui icon input" data-sign-in>
                                <input id="user-id" type="number" name="user[student_number]" placeholder="Student Number" required>
                                <i id="icon-user-id" class="icon"></i>
                            </div>
                            <!-- <input id="student-number" type="number" name="user[student_number]" placeholder="Student Number" required> -->
                        </div>
                    <?php } ?>
                    <?php if($is_an_educator) { ?>
                        <div class="field">
                            <label for="username">Username</label>
                            <div id="input-user-id" class="ui icon input" data-sign-in>
                                <input id="user-id" type="text" name="user[username]" placeholder="Username" required>
                                <i id="icon-user-id" class="icon"></i>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="user[password]" placeholder="Password" required>
                    </div>
                
                    <div class="ui hidden divider"></div>
                    <div class="field field-form">
                        <div class="ui toggle checkbox checkbox-block">
                            <input id="remember-me" type="checkbox" name="user[is_remembered]" class="hidden" value="true">
                            <label for="remember-me">Remember Me</label>
                        </div>
                    </div>
                    <div class="ui hidden divider"></div>
                    
                    <div class="ui basic segment right aligned">
                        <button id="button-submit" class="ui large primary button" name="user[user_type]"  value="<?= ($is_an_educator ? "educator" : "student") ?>" type="submit">Log-in</button>
                    </div>
                </form>
                
                <div class="ui divider"></div>
                <div class="ui basic segment center aligned">
                    <small>A new User? Try <a href="<?= sendGETData("form_type=sign_up&user_type=student") ?>">registering</a> instead.</small>
                </div>
            </div>
        </h1>
    </div>
<?php } else { ?>
    <div class="ui one column doubling stackable grid container center aligned">
        <div class="column">
            <div id="segment-form-header" class="ui basic inverted segment">
                <h1 class="ui center aligned inverted green header">
                    <i class="user circle icon"></i>
                    <div class="content">
                        Sign Up
                        <div class="sub header">
                            as <?= $is_an_educator ? "an Educator" : "a Student" ?>
                        </div>
                    </div>
                </h1>
                <div class="ui container">
                    <a href="<?= sendGETData("form_type=sign_up&user_type=student")?>" id="button-user-type-student" class="ui inverted <?= !$is_an_educator ? 'active' : null ?> button button-user-type">STUDENT</a>
                    <a href="<?= sendGETData("form_type=sign_up&user_type=educator")?>" id="button-user-type-educator" class="ui inverted <?= $is_an_educator ? 'active' : null ?> button button-user-type">EDUCATOR</a>
                </div>
            </div>
            <div id="segment-main" class="ui raised very padded segment left aligned">
                <!-- <div class="ui basic segment center aligned">
                    <div class="ui small buttons">
                        <a href="<?= sendGETData("form_type=sign_up&user_type=student")?>" id="button-user-type-student" class="ui yellow <?= !$is_an_educator ? 'active' : null ?> button button-user-type">STUDENT</a>
                        <div class="or" data-text="OR"></div>
                        <a href="<?= sendGETData("form_type=sign_up&user_type=educator")?>" id="button-user-type-educator" class="ui teal <?= $is_an_educator ? 'active' : null ?> button button-user-type">EDUCATOR</a>
                    </div>
                </div>
                <div class="ui divider"></div> -->

                <form id="form-sign-up-<?= $is_an_educator ? "educator" : "student" ?>" action="<?= $_SERVER["PHP_SELF"] ?>" method="post" id="form-sign-up" class="ui form" novalidate>
                    <input type="hidden" name="action" value="sign_up"/>
                    <h4 class="ui dividing header header-section-title"><span>Personal Details</span></h4>
                    <div class="field">
                        <label>Name</label>
                        <div class="three fields">
                            <div class="field">
                                <input type="text" name="user[given_name]" placeholder="Given Name" required>
                            </div>
                            <div class="field">
                                <input type="text" name="user[middle_name]" placeholder="Middle Name">
                            </div>
                            <div class="field">
                                <input type="text" name="user[family_name]" placeholder="Family Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Home Address</label>
                        <div class="four fields">
                            <div class="four wide field">
                                <div class="ui labeled input">
                                    <div class="ui basic label">
                                        Block
                                    </div>
                                    <input type="number" name="user[block_number]" placeholder="Block Number">
                                </div>
                            </div>
                            <div class="four wide field">
                                <div class="ui labeled input">
                                    <div class="ui basic label">
                                        Lot
                                    </div>
                                    <input type="number" name="user[lot_number]" placeholder="Block Number">
                                </div>
                            </div>
                            <div class="four wide field">
                                <div class="ui right labeled input">
                                    <input type="text" name="user[street]" placeholder="Street Name">
                                    <div class="ui basic label">
                                        Street
                                    </div>
                                </div>
                            </div>
                            <div class="four wide field">
                                <input type="text" name="user[subdivision]" placeholder="Subdivision">
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui basic label">
                                        Barangay
                                    </div>
                                    <input type="text" name="user[barangay]" placeholder="Barangay Name" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui right labeled input">
                                    <input type="text" name="user[city]" placeholder="City Name" required>
                                    <div class="ui basic label">
                                        City
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui right labeled input">
                                    <input type="text" name="user[province]" placeholder="Province Name" required>
                                    <div class="ui basic label">
                                        Province
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Birthdate</label>
                        <div class="three fields">
                            <div class="field">
                                <select class="ui search selection fluid dropdown" name="user[birth_month]" required>
                                    <option value="">Birth Month</option>
                                    <?php
                                        $i = 1;
                                        foreach($date_gen->generateMonths() as $value) {
                                            echo "<option value={$i}>{$value}</option>";
                                            $i++;
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="field">
                                <input type="number" name="user[birth_day]" placeholder="Birth Day" required>
                            </div>
                            <div class="field">
                                <input type="number" name="user[birth_year]" placeholder="Birth Year" required>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="three fields">
                            <div class="three wide field">
                                <label>Gender</label>
                                <select class="ui fluid dropdown" name="user[gender]" required>
                                    <option value="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="six wide field">
                                <label>Contact Number</label>
                                <div class="ui labeled input">
                                    <div class="ui basic label">
                                        +63
                                    </div>
                                    <input type="tel" name="user[contact_number]" placeholder="Mobile Number">
                                </div>
                            </div>
                            <div class="seven wide field">
                                <label>Email</label>
                                <input type="email" name="user[email]" placeholder="Email">
                            </div>
                        </div>
                    </div>

                    <?php if(!$is_an_educator) { ?>
                        <h4 class="ui dividing header header-section-title"><span>Scholarly Details</span></h4>
                        <div class="field">
                            <div class="four fields">
                                <div class="three wide field">
                                    <label>Student Number</label>
                                    <div id="input-user-id" class="ui icon input" data-sign-up>
                                        <input id="user-id" type="number" name="user[student_number]" placeholder="Student Number" required>
                                        <i id="icon-user-id" class="icon"></i>
                                    </div>
                                </div>
                                <div class="six wide field">
                                    <label>Program</label>
                                    <select id="dropdown-program" class="ui fluid search selection dropdown" name="user[program_id]" required>
                                        <option value="">Course</option>
                                    </select>
                                </div>
                                <div class="four wide field">
                                    <label>Year Level</label>
                                    <select id="dropdown-year-level" class="ui fluid search selection dropdown" name="user[year_level_id]" required>
                                        <option value="">Year Level</option>
                                    </select>
                                </div>
                                <div class="three wide field">
                                    <label>Block Section</label>
                                    <input type="number" name="user[block_section]" placeholder="Block Section" required>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <h4 class="ui dividing header header-section-title"><span>School-Based Details</span></h4>
                        <div class="field">
                            <div class="one fields">
                                <div class="sixteen wide field">
                                    <label>Department</label>
                                    <select id="dropdown-department" class="ui fluid search selection dropdown" name="user[department_id]" required>
                                        <option value="">Department</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <h4 class="ui dividing header header-section-title"><span>Account Details</span></h4>
                    <div class="field">
                        <div class="<?= $is_an_educator ? "three" : "two" ?> fields">
                            <?php if($is_an_educator) { ?>
                                <input id="hidden-user-id" type="hidden" name="user[username]">
                                <div class="field disabled">
                                    <label>Username</label>
                                    <div id="input-user-id" class="ui icon left labeled input" data-sign-up>
                                        <label class="ui green label" data-title="This is your Department Prefix. Always include this when you log in.">
                                            DEPT-
                                        </label>
                                        <input id="user-id" type="number" name="user[dummy_username]" placeholder="Username" required>
                                        <i id="icon-user-id" class="icon"></i>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="field">
                                <label>Password</label>
                                <input id="su-password" type="password" name="user[password]" placeholder="Password" required>
                            </div>
                            <div class="field">
                                <label>Password Confirmation</label>
                                <input id="su-password-confirmation" type="password" name="user[password_confirmation]" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ui hidden divider"></div>
                    <div class="field field-form">
                        <div class="ui toggle checkbox checkbox-block">
                            <input id="remember-me" type="checkbox" name="user[has_accepted_TAC]" class="hidden" value="true" required>
                            <!-- <label for="remember-me">I accept the <a id="">Terms and Conditions</a> of STMS</label> -->
                            <label for="remember-me">I allow STMS to use these Information for my Account</label>
                        </div>
                    </div>
                    <div class="ui hidden divider"></div>

                    <!-- <div class="ui error message">
                        <i class="close icon"></i>
                    </div> -->

                    <div class="ui basic segment right aligned">
                        <button id="button-submit" class="ui large submit primary button" name="user[user_type]" value="<?= ($is_an_educator ? "educator" : "student") ?>" type="submit">Register</button>
                    </div>
                </form>
                    
                <div class="ui divider"></div>
                <div class="ui basic segment center aligned">
                    <small>An existing User? Try <a href="<?= sendGETData("form_type=sign_in&user_type=student") ?>">logging-in back</a> instead.</small>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<!-- <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" novalidate>


    <button class="ui button" name="submit" type="submit" value="Sign-In">Sign-In</button>

</form> -->


<div id="modal-TAC" class="ui tiny modal">
    <div class="header">
        
        <div class="ui container center aligned">
        STMS's Terms and Conditions
        </div>
    </div>
    <div class="scrolling content">
        <h4>Students</h4>
        <h4>Educators</h4>
    </div>
</div>
<?php

require_once(getRelativePath("footer.php"));

?>