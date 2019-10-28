<?php
$conn=mysqli_connect('localhost','root',"",'crudoperation');

/*extract function is used to import variables from an array into the current symbol table*/

extract($_POST);

if(isset($_POST['readrecord'])){
	
$data='<table class="table table-bordered table-striped">
	
	<tr>
	
	<th>No.</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Email</th>
	<th>Mobile</th>
	<th>Edit Action</th>
	<th>Delete Action</th>
	
	
	
	
	</tr>';
	
	$display="SELECT * FROM `crud`";
	
	$result=mysqli_query($conn,$display);
	
	if(mysqli_num_rows($result) > 0){
		$number =1;
		while($row=mysqli_fetch_array($result)){
			
			$data.='<tr>
			<td>'.$number.'</td>
			<td>'.$row['first'].'</td>
			<td>'.$row['last'].'</td>
			<td>'.$row['email'].'</td>
			<td>'.$row['mobile'].'</td>
			<td>
			<button onclick="getuserdetail('.$row['id'].')" class="btn btn-warning">Update</button>
			</td>
			
			<td>
			
			<button onclick="removedetail('.$row['id'].')" class="btn btn-danger">Delete</button>
			
			
			</td>
			
			</tr>';
			$number++;
		
		}
		
		
	}
	$data.='</table>';
	echo $data;
	
	
}

if(isset($_POST['first']) && isset($_POST['last'])&& isset($_POST['email'])&& isset($_POST['mobile']))

{
	
	$query="INSERT INTO `crud`(`first`, `last`, `email`, `mobile`) VALUES ('$first','$last','$email','$mobile')";
	
 mysqli_query($conn,$query);
}
//delete user record
if(isset($_POST['deleteid'])){
	
	$userid=$_POST['deleteid'];
	$deletequery="delete from crud where id='$userid'";
	mysqli_query($conn,$deletequery);
}

//get userid for update
if(isset($_POST['id'])&&isset($_POST['id'])!="")
{
	
	$user_id=$_POST['id'];
	$query="select*from crud where id='$user_id'";
	if(!$result=mysqli_query($conn,$query))
	{
		exit(mysqli_error());
		
	}
	$response=array();
	
	if(mysqli_num_rows($result) > 0){
		while($row=mysqli_fetch_assoc($result)){
			$response=$row;
			
			
		}
		
	}
	else
	{
		$response['status']=200;
		$response['message']="Data Not Found";
		
	}
	//php has some inbuilt function to handle json
	//objects in php can be converted into json by using the php function json_encode()
	echo json_encode($response);
	
	
}
else{
	$response['status']=200;
		$response['message']="Invalid Request";
}
///update table
if(isset($_POST['hidden_user_id']))
{
	$hidden_user_id=$_POST['hidden_user_id'];
	$first=$_POST['first'];
	$last=$_POST['last'];
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];
	
	$query="UPDATE `crud` SET `first`='$first',`last`='$last',`email`='$email',`mobile`='$mobile' WHERE id='$hidden_user_id'";

mysqli_query($conn,$query);

}
?>