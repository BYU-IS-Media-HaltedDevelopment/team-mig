<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
	<link rel="stylesheet" type="text/css" href="migration-styles.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script type="text/javascript">
	    /*
	     * The user's dashboard tasks
	     */
	    var dashTasks = [];
	    
	    /**
	     * Loads the dashboard tasks into the page
	     */
	    function getTasks()
	    {
		var dashUsername = $("#dashboard-username-input").val();
		
		$.post("dash_tasks.php", 
		    {dash_user: dashUsername}, 
		    function(data){
			dashTasks = eval("(" + data + ")");
			for(i = 0; i < dashTasks.length; i++)
			{
			    newRow = "<tr><td id='descrip" + dashTasks[i]["external_id"] + "'>" + dashTasks[i]["external_id"] +"</td><td>"
			    if(!dashTasks[i]["description"])
				newRow += "None";
			    else
				newRow += dashTasks[i]["description"];
			    newRow += "</td>"
			    newRow += "<td><button onclick='migrateTask(" + 
				dashTasks[i]["external_id"] + 
				")' type=button>Migrate</button></td>";
			    newRow += "</tr>";
			    $("#task-list").append(newRow);
			}
			//migrateTasks();
		    });
	    }
	    
	    /**
	    * Migrates the task with the given external id
	    */
	    function migrateTask(externalId)
	    {
		alert($("#descrip" + externalId).text());
	    }
	    
	    function migrateTasks()
	    {
		// migrate each task
		for(i = 0; i < dashTasks.length; i++)
		{
		    console.log(dashTasks[i]["external_id"]);
		    
		    // get the matching teamwork project id
		    $.post("matching_tw_proj.php?externalId="+dashTasks[i]["external_id"],   
			function(data){
			    matchingTwProj = eval("(" + data + ")");
			    
			    if(matchingTwProj.matchingTwProjId == "none")
			    {
				// tell user that the task doesn't match anything
				return;
			    }
			
			    
			    getMatchingTaskList(matchingTwProj.matchingTwProjId, 
				dashTasks[i]["description"]);
			});
			
		  //if(i > 35)
		   // break;
		}
	    }
	    
	    /*
	     * @pre projId != null
	     */
	    function getMatchingTaskList(projId, taskDesc)
	    {
		$.post("matching_tw_task_list.php", {
		    taskDescription : taskDesc,
		    twProjId : projId
		}, function(data){
		    
		});
	    }
	    
	    function destroySession()
	    {
		$.post("destroy_session.php", {}, function(data){});
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
		<button onclick="getTasks();" type="button">Get My Tasks</button>
		<button onclick="destroySession();" type="button">Destroy Session</button>
	    </div>   
	
	<div>
	    <table id="task-list">
		<tr><th>External Id</th><th>Description</th></tr>
	    </table>
	</div>
    </body>
</html>
