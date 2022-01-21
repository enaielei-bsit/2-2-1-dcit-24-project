<?php

$server = new STMSServer("db_stms");

$server->runQuery("SELECT * FROM tbl_programs");
$programs = array();
foreach($server->result as $entity_instance) {
    $programs[$entity_instance["Program ID"]] = array(
        "program_title" => $entity_instance["Program Title"]
    );
}

$server->runQuery("SELECT * FROM tbl_departments");
$departments = array();
foreach($server->result as $entity_instance) {
    $departments[$entity_instance["Department ID"]] = array(
        "department_title" => $entity_instance["Department Title"]
    );
}

?>