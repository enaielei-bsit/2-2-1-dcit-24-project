<?php

require_once("../_php/initializations.php");

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

setActiveLink("home-link");

include_once(getRelativePath("header_educator.php"));
?>

<div  id="container-inbetween-viewport" class="ui fluid container">
    <div id="segment-page-view" class="ui basic segment">
        <div class="ui three column doubling stackable grid container center aligned">
            <div class="ui raised segment">
                <div class="row">
                    <div class="ui container">
                        <div class="ui segments">
                            <div class="ui very padded segment">
                                <h2 class="ui center aligned green icon header">
                                    <i class="circular user inverted green icon"></i>
                                    <div class="content">
                                        <?= $user->full_name ?>
                                        <div class="sub header"><?= $departments[$user->department_id]["department_title"] ?></div>
                                    </div>
                                </h2>
                                <div class="ui divider"></div>
                                <?php if(!empty($user->email) || !empty($user->email)) { ?>
                                    <div class="ui left aligned selection horizontal list">
                                        <?php if(!empty($user->email)) { ?>
                                            <div class="item">
                                                <h5 class="ui left aligned header">
                                                    <i class="paper plane icon"></i>
                                                    <div class="content">
                                                        Email
                                                        <div class="sub header"><?= $user->email?></div>
                                                    </div>
                                                </h5>
                                            </div>
                                        <?php } ?>
                                        
                                        <?php if(!empty($user->contact_number)) { ?>
                                            <div class="item">
                                                <h5 class="ui left aligned header">
                                                    <i class="phone icon"></i>
                                                    <div class="content">
                                                        Phone Number
                                                        <div class="sub header"><?= '0' . $user->contact_number ?></div>
                                                    </div>
                                                </h5>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="ui horizontal segments">
                                <div class="ui segment">
                                    <p></p>
                                </div>
                                <div class="ui segment">
                                    <p></p>
                                </div>
                                <div class="ui segment">
                                    <p></p>
                                </div>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include_once(getRelativePath("footer.php"));

?>