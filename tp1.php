<?php

//print ('Your IP is: '.$_SERVER['REMOTE_ADDR'].'.');
$ip = $_SERVER['REMOTE_ADDR'];
$id = "123";
?>

<HTML>
<HEAD>

<!-- To be removed -> Coursera already has jquery -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~- -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

<script type="text/javascript">
	var id = <?= $id ?>;
	//alert(id);
</script>
	<!-- If using couchdb.js, it should be above collector.js -->
    <!--<script type="text/javascript" src="http://localhost:5984/_utils/script/json2.js"></script>-->
    <!--<script type="text/javascript" src="http://localhost:5984/_utils/script/sha1.js"></script>-->
    <!--<script type="text/javascript" src="http://localhost:5984/_utils/script/jquery.js"></script>-->
    <!--<script type="text/javascript" src="http://localhost:5984/_utils/script/jquery.couch.js"></script>
    <script type="text/javascript" src="http://localhost:5984/_utils/script/jquery.dialog.js"></script>
    <script type="text/javascript" src="http://localhost:5984/_utils/script/couch.js"></script>-->

	<script type="text/javascript" src="collector.js"></script>
</HEAD>

<BODY>

<p> Test IP : <?php echo $ip ?> </p>
<button id="refresh" value="Refresh DB" >Refresh DB</button>
<h2 id="status2">
0, 0
</h2>
<div style="width: 500px; height: 500px; background:#ccc;" id="hover">
</div>

<div id="txt">
	<input id ="testbox" type="text" value=""></input>
</div>

<div id="msg"></div>
</BODY>

</HTML>