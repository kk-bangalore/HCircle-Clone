<?php
include('tabgen_php_functions.php');
include('connect_db.php');

	if(empty($_POST['user_id'])){
		echo json_encode(array("status"=>false,"message"=>"Please pass user id"));
	}
	else{
		$user_id = $_POST['user_id'];
		if(isValidUser($conn,$user_id)){
			if(isAdmin($conn,$user_id)){
				if(!empty($_POST['file_id'])){
					$file_id = $_POST['file_id'];
					$article_id = $_POST['article_id'];
					$file_name = get_filename($conn,$file_id);
					if($file_name!=null){
						if(delete_a_file($file_name)){
							$query = "delete from ArticleFiles where Id='$file_id'";
							if($conn->query($query)){
								echo json_encode(array("status"=>true,"message"=>"File deleted",
								"file_lists"=>getFiles($conn,$article_id)));	
							}else{
								echo json_encode(array("status"=>false,"message"=>"Sorry, 
								unable to delete the file record from database."));
							}
						}
						else{
							echo json_encode(array("status"=>false,"message"=>"Sorry, unable to delete the file."));
						}
					}
					else{
						echo json_encode(array("status"=>false,"message"=>"File record not found in database"));
					}
				}
				else{
					echo json_encode(array("status"=>false,"message"=>"Please pass the file id"));
				}
			}
			else{
				echo json_encode(array("status"=>false,"message"=>"You do not have sufficient permission"));
			}
		}
		else{
			echo json_encode(array("status"=>false,"message"=>"Sorry, the user id does not exist."));
		}
	}
?>
