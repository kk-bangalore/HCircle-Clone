<?php 
	$user_id = $_GET['user_id'];
	include('connect_db.php');
	include('tabgen_php_functions.php');
	//$query="select TabTemplate.Name as Template_Name,TABS.Name as Tab_Name,RoleName from TabTemplate,TABS where RoleName='$role' AND Tab.TabTemplate=TabTemplate.Id";
			
	if($conn){
		$role_id = findRoleIdByUser_id($conn,$user_id);
		/*if(isUserUniversalAccessRight($conn,$user_id)){// if the user has universal access right
			//$role = getRoleByUserId($conn,$user_id);
			//$role_type = getRoleType($conn,$role);
			//$tabs = findTabsByRoleType($conn,$role_type);
			$associated_tabs = findAssociatedTabsByRoleId($conn,$role_id);
			//print json_encode(concate_array($tabs,$associated_tabs));
			print json_encode($associated_tabs);
			
		}else{
			$role = getRoleByUserId($conn,$user_id);
			//$ou_id =getOuIdByUserId($conn,$user_id);
			//$parent_ou_id = getParentOuId($conn,$ou_id);
			
			//$own_tabs=findTabs($conn,$role,$ou_id);
			//$parent_tabs=findTabs($conn,$role,$parent_ou_id);
			//echo "Parent OU id: ".$parent_ou_id;
			//print json_encode($own_tabs);
			$associated_tabs = findAssociatedTabsByRoleId($conn,$role_id);
			//print json_encode(concate_array($own_tabs,$associated_tabs));
			print json_encode($associated_tabs);
		}*/
		$associated_tabs = findAssociatedTabsByRoleId($conn,$role_id);
		print json_encode($associated_tabs);
		
	}
//function to find tabs specific to roles
function findTabs($conn,$role,$ou_id){
	$query = "select TabTemplate.Name as Template_Name,Tab.Name as Tab_Name,Tab.RoleName,OrganisationUnit
			  from TabTemplate,Tab,Role
			  where Tab.TabTemplate=TabTemplate.Id
			  and Tab.RoleName='$role' 
			  and Tab.RoleId=Role.Id
			  order by Tab_Name";
	$output = null;
	$res = $conn->query($query);
	if($res){
		while($row=$res->fetch(PDO::FETCH_ASSOC)){
			$output[]=$row;
		}	
	}
	return ($output);
}

//function to find tabs specific to roles types
function findTabsByRoleType($conn,$role_type){
	$query = "select TabTemplate.Name as Template_Name,Tab.Name as Tab_Name,Tab.RoleName,RoleType,OrganisationUnit
			  from TabTemplate,Tab,Role
			  where Tab.TabTemplate=TabTemplate.Id
			  and Role.RoleType='$role_type'
			  and Tab.RoleId=Role.Id
			  order by Tab_Name";
	$output = null;
	$res = $conn->query($query);
	if($res){
		while($row=$res->fetch(PDO::FETCH_ASSOC)){
			$output[]=$row;
		}	
	}
	return ($output);
}
//function to find the associated tabs according to Role Id
function findAssociatedTabsByRoleId($conn,$role_id){
	$query = "select TabTemplate.Name as Template_Name,Tab.Name as Tab_Name,Tab.RoleName,OrganisationUnit
			  from TabTemplate,Tab,RoleTabAsson
			  where Tab.TabTemplate=TabTemplate.Id
              and Tab.Id=RoleTabAsson.TabId
              and RoleTabAsson.RoleId='$role_id'";
	
	/*"select TabTemplate.Name as Template_Name,Tab.Name as Tab_Name,Tab.RoleName,OrganisationUnit
			  from TabTemplate,Tab,Role,RoleTabAsson
			  where Tab.TabTemplate=TabTemplate.Id
              and Tab.Id=RoleTabAsson.TabId
              and Role.Id=RoleTabAsson.RoleId
              and RoleTabAsson.RoleId='$role_id'";*/
    $output = null;
	$res = $conn->query($query);
	if($res){
		while($row=$res->fetch(PDO::FETCH_ASSOC)){
			$output[]=$row;
		}	
	}
	return ($output);
}
?>
