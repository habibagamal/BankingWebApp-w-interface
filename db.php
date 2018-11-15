<?php
	
	$conn = mysqli_connect('localhost', 'root', 'root', 'Bank');

// Check connection
	if (mysqli_connect_errno()) 
	{
    	//echo "failed to connect";
	} 
	else 
	{
		//echo "Connected successfully";	
	}
