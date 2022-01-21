<?php

function setPageInternalDetails($page_title, $page_stylesheet, $page_script) {
    $GLOBALS["page_url"] = $_SERVER["PHP_SELF"];
    $GLOBALS["page_title"] = $page_title;
    $GLOBALS["page_stylesheet"] = $page_stylesheet;
    $GLOBALS["page_script"] = $page_script;
}

function sendGETData($parameters, $url=null) {
    global $page_url;
    $url = $url == null ? $page_url : $url;
    return "{$url}?{$parameters}";
}

function isUserRemembered() {
    
}

function prompt($header_message, $message, $onApprove) {
    $script = "
        <script id='temp_script'>
            var modal_notify = \"\
                <div id='modal_prompt_continuation' class='ui tiny modal modal_prompt_continuation'>\
                    <div class='ui segment inverted'>\
                        <div class='ui segments'>\
                            <div class='ui inverted segment header'>\
                                <div class='ui green inverted header'>\
                                    <i class='question circle icon'></i>\
                                    <div class='content'>\
                                        $header_message\
                                    </div>\
                                </div>\
                            </div>\
                            <div class='ui divider content'></div>\
                            <div class='ui inverted segment'>\
                                <small>\
                                    $message\
                                </small>\
                            </div>\
                            <div class='ui inverted right aligned segment actions'>\
                                <button id='button-prompt-approve' type='button' class='ui green left labeled icon button approve'>\
                                    <i class='check circle outline icon'></i>\
                                    Continue\
                                </button>\
                                <button type='button' class='ui red left labeled icon button deny'>\
                                    <i class='ban icon'></i>\
                                    Cancel\
                                </button>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            \";
            
            $(modal_notify).appendTo('body');
            $('#modal_prompt_continuation').modal({
                blurring: true,
                closable: false,
                onApprove: {$onApprove},
                onHidden: function() {
                    $('#modal_prompt_continuation').remove();
                }
            });
            $('#modal_prompt_continuation').modal('show');

            // alert('You have Classes in this Handled Course');
            $('#temp_script').remove();
        </script>
    ";
    return $script;
}

function isUserLoggedIn() {
    if(isset($_COOKIE)) {
        return isset($_COOKIE["user"]);
    }
}

function getLoggedInUserType() {
    return $_SESSION["user_type"];
}

function redirectTo($url, $parameters=null) {
    header("Location: " . getRelativePath($url) . $parameters);
}



function ignoreEmpty($entity) {
    return $entity != "" ? $entity : false;
}

function getRelativePath($file_name, $from_directory=null) {

    // if(!strpos($file_name, ".")) {
    //     return null;
    // }

    $dir = $_SERVER["DOCUMENT_ROOT"] . '/' . PROJECT_NAME;
    $from_directory = $from_directory != null ? $from_directory : $_SERVER["PHP_SELF"];
    $document_root = str_replace("/", "\\", $_SERVER["DOCUMENT_ROOT"]);
    $project_dir = array();
    $current_dir = new RecursiveDirectoryIterator($dir);

    foreach(new RecursiveIteratorIterator($current_dir) as $file_path => $null) {
        $file_path = str_replace($document_root, "", realpath($file_path));
        $file_path = str_replace("\\", "/", $file_path);

        $file_path != "" ? array_push($project_dir, $file_path) : null;
        $project_dir = array_unique($project_dir);
    }

    foreach($project_dir as $path) {
        if(!isset($target_path) && strpos($path, $file_name)) {
            $target_path = explode("/", $path);
            $target_path = array_filter($target_path, "ignoreEmpty");
            $target_path = array_values($target_path);
        }
        if(!isset($source_path) && $from_directory == $path) {
            $source_path = explode("/", $path);
            $source_path = array_filter($source_path, "ignoreEmpty");
            $source_path = array_values($source_path);
        }
        if(isset($target_path) && isset($source_path)) { break; };
        if(!isset($target_path) && array_search($path, $project_dir) == count($project_dir) - 1) {
            return null;
        }
    }

    $match = null;
    $relative_path = "";

    foreach(($source_path) as $index => $value) {
        foreach(($target_path) as $index_ => $value_) {
            if($index == $index_ && $value == $value_) {
                $match = array();
                array_push($match, $index, $value);
            }
            if(isset($match)) { break; }
        }
        if(isset($match)) { break; }
    }

    for($i = count($source_path) - 2; $i >= 0; $i--) {
        if($i != $match[0]) {
            $relative_path .= "../";
        } else {
            $sliced = array_slice($target_path, $match[0] + 1, count($target_path));
            foreach($sliced as $path) {
                $relative_path .= $path;
                $relative_path .= array_search($path, $sliced) != (count($sliced) - 1) ? "/" : "";
            }
        }
    }

    return $relative_path;
}

function importExternalCSS($exceptions = array()) {
    $stylesheets = array_values(array_diff(scandir(getRelativePath("_css_compilation")), array(".", "..")));

    foreach($stylesheets as $stylesheet) {
        $path = getRelativePath($stylesheet);
        if(!array_search($path, $exceptions)) {
            echo "<link rel='stylesheet' href='{$path}'/>";
        }
    }

    $stylesheets = array_values(array_diff(scandir(getRelativePath("_css")), array(".", "..")));

    foreach($stylesheets as $stylesheet) {
        $path = getRelativePath($stylesheet);
        if(!array_search($path, $exceptions)) {
            echo "<link rel='stylesheet' href='{$path}'/>";
        }
    }
}

function importExternalJS($exceptions = array()) {
    $scripts = array_values(array_diff(scandir(getRelativePath("_js_compilation")), array(".", "..")));

    foreach($scripts as $script) {
        $path = getRelativePath($script);
        if(!array_search($path, $exceptions) && !strpos($path, ".map")) {
            echo "<script src='{$path}' defer></script>";
        }
    }

    $scripts = array_values(array_diff(scandir(getRelativePath("_js")), array(".", "..")));

    foreach($scripts as $script) {
        $path = getRelativePath($script);
        if(!array_search($path, $exceptions) && !strpos($path, ".map")) {
            echo "<script src='{$path}' defer></script>";
        }
    }
}

function setActiveLink($link_id) {
    $GLOBALS["top_bar_active_link"] = $link_id;
}

?>