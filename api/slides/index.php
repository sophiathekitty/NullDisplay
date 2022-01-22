<?php
require_once("../../../../includes/main.php");
$data = [];
$data['sections'] = SlideSections::Sections();
OutputJson($data);
?>