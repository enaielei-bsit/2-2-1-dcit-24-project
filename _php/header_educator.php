<?php

include_once(getRelativePath("header.php"));
?>
<div id="modal-bulletin" class="ui mini modal">
    <i class="close icon"></i>
    
    <div class="ui container center aligned">
        <div class="ui basic black inverted segment">
            <h3 class="ui header">
                Bulletin
            </h3>
        </div>
    </div>
    <div class="scrolling content">
        <div id="modal-bulletin-segment-display" class="ui basic center aligned segment">
            
        </div>
    </div>
    <!-- <div class="actions">
        <div class="ui black deny button">
            Nope
        </div>
        <div class="ui positive right labeled icon button">
            Yep, that's me
            <i class="checkmark icon"></i>
        </div>
    </div> -->
</div>

<div id="segment-menu-main" class="ui inverted very padded segment">
    <div class="ui inverted two column doubling stackable grid container">
        <div class="column">
            <div id="menu-main" class="ui inverted secondary stackable five item menu">
                <div class="header item">
                    <span class="menu-main-logo">STMS</span>
                </div>
                <a class="<?= $top_bar_active_link == 'home-link' ? 'active' : null; ?> item" href="<?= getRelativePath('stms/educator'); ?>">
                    Home
                </a>
                <a class="<?= $top_bar_active_link == 'courses-link' ? 'active' : null; ?> item" href="<?= getRelativePath('educator/courses'); ?>">
                    Courses
                </a>
                <a class="<?= $top_bar_active_link == 'tasks-link' ? 'active' : null; ?> item" href="<?= getRelativePath('educator/tasks'); ?>">
                    Tasks
                </a>
                <!-- <a class="<?= $top_bar_active_link == 'students-link' ? 'active' : null; ?> item" href="<?= getRelativePath('educator/students'); ?>">
                    Students
                </a> -->
            </div>
        </div>
        
        <div class="column">
            <div id="menu-main" class="ui inverted secondary menu">
                    <!-- <div id="search-main" class="ui category fluid search item">
                        <div class="ui icon input">
                            <input class="prompt" type="text" placeholder="Search for Tasks, Subjects and Students...">
                            <i class="search link icon"></i>
                        </div>
                        <div class="results"></div>
                    </div> -->
                    
                <div class="right menu">
                    <button id="button-bulletin" type="button" class="ui link item item-menu-item" data-title="Bulletin">
                        <i class="bullhorn icon"></i>
                        <div class="floating ui green circular label" style="display: none;">0</div>
                    </button>
                    <button  type="button" class="ui link item item-menu-item"
                    
                    data-html="
                        <div id='menu-topbar-account-menu' class='ui vertical menu'>
                            <!--<a class='item'>
                                <i class='sliders horizontal icon'></i>
                                Preferences
                            </a>-->
                            <a href='<?= getRelativePath('stms/index.php') . '?has_logged_out=true'; ?>' class='item'>
                                <i class='sign out alternate icon'></i>
                                Log Out
                            </a>
                        </div>
                    ">
                        <i class="user circle icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>