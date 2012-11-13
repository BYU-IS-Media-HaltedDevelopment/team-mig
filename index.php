<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script type="text/javascript">
	    /*
	     * The user's dashboard tasks
	     */
	    var dashTasks = [];
	    
	    /**
	     * Loads the dashboard tasks
	     */
	    function getTasks()
	    {
		var dashUsername = $("#dashboard-username-input").val();
		
		$.post("dash_tasks.php", 
		    {dash_user: dashUsername}, 
		    function(data){
			dashTasks = eval("(" + data + ")");
			migrateTasks();
		    });
	    }
	    
	    function migrateTasks()
	    {
		// migrate each task
		for(i = 0; i < dashTasks.length; i++)
		{
		    //alert(dashTasks[i]["external_id"]);
		    
		    // get the matching teamwork project id
		    $.post("matching_tw_proj.php", 
			{externalId : dashTasks[i]["external_id"]},
			function(data){
			   dashTasks[i]
			});
		    break;
		}
	    }
	    
	</script>
    </head>
    <body>
	    <div id="user_info_view">
		<table>
		    <tr><td>Dashboard username:</td><td><input id="dashboard-username-input" value="mp239" type="text" /></td></tr>
		    <!---
		 	Scott: 
		        Suzy: sg99 cut527march
		     Marga: mp239 bluff861cod
		    --->
		    <tr><td>Teamwork API Key:</td><td><input id="api-key-input" value="bluff861cod" type="text" /></td></tr>
		</table>
		<button onclick="getTasks();" type="button">Get Tasks</button>
	    </div>   
    </body>
</html>
