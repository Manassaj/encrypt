<?php 
 require 'libs/auto.php';
 $Auth = new Auth;
 switch (@$_POST['route']) {
 	case 'upload':
 		$Auth->upload();
 		break;
 	
 	default:
 		# code...
 		break;
 }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style type="text/css">
	li
	{
		margin: 5px 0px;
		font-size: 13px;
	}

	.bar
	{
		position: fixed;
		left: 0px;
		height: auto;
		height: 100%;
		background: #eee;
	}

	.bars2
	{
		position: fixed;
		right: 0px;
		height: auto;
		height: 100%;
		overflow-y: auto;
		

	}
</style>
<body>

   <div class="container">
   	 <div class="row">
   	 	 <div class="col-md-3 bar">
   	 	 	<div class="card-header">
   	 	 		<h4>Book List 
   	 	 			<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#upload">
   	 	 		 <i class="fa fa-cloud-upload"></i>	upload</button></h4>
   	 	 	</div>
   	 	 		<?php 
   	 	 		$files = glob('docs/*.{txt,encrypted,pdf}', GLOB_BRACE);
				foreach($files as $file) {
				  //do your work here
					$file = explode("docs/", $file);
   	 	 			print '<li style=" cursor:pointer;"><a onclick="showBook(\''.base64_encode(@$file[1]).'\')" >'.@$file[1].'  </a></li>';
				}
   	 	 		?> 
   	 	 		<hr style="background: #333; border:solid 1px #ccc;" />
   	 	 	 	<h4>Keys List</h4>
   	 	 		<?php 
   	 	 		$files = glob('keys/*.{txt,encrypted,key}', GLOB_BRACE);
				foreach($files as $file) {
				  //do your work here
					$file = explode("keys/", $file);
					$data = file_get_contents('keys/'.@$file[1]);
   	 	 			print '<li style=" cursor:pointer;"><a onclick="showKey(\''.base64_encode(@$data).'\',\''.base64_encode(@$file[1]).'\')" >'.@$file[1].'  </a></li>';
				}
   	 	 		?> 
   	 	 </div>
   	 	 <div class="col-md-9 bg-primary bars2">
   	 	 	<div class="card-header">
   	 	 		<h3>Book Reader</h3>
   	 	 	</div>
   	 	 	<div  style="min-height: 400px; background: #eee; padding: 50px; color: #222; margin-bottom: 20px;">
   	 	 	 
   	 	 		<?php 
   	 	 			if(isset($_POST['key']) && isset($_POST['book']))
   	 	 			{
   	 	 				$getBook =  $Auth->loadFile($_POST['book'],$_POST['key']);

   	 	 				if(!$getBook):
   	 	 					print "<h2>403 Permission Denied Invalid Prvate Key</h2>";
   	 	 				else:
   	 	 					print $getBook;
   	 	 				endif;
   	 	 			}else{
   	 	 				print "<p>Select Book to read</p>";
   	 	 			}
   	 	 		?>
   	 	 	 	
   	 	 	</div>
   	 	 	
   	 	 </div>
   	 </div>
   </div>



<!-- Modal -->
<div id="upload" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Book</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="" enctype="multipart/form-data">
        <label style="cursor: pointer;">
        	<h4><i class="fa fa-cloud-upload"> </i> Select File</h4>
        	<input type="file" name="book" style="opacity: 0;" onchange="$('.fx').html(this.files[0].name);" />
        </label>
        <p class="fx">&nbsp;</p>
        <div class="form-group">
        	<label><i class="fa fa-key"></i> Enter private Key</label>
        	<textarea class="form-control" name="key" style="height: 100px; resize: none;"></textarea>
        	<input type="hidden" name="route" value="upload">
        </div>
      </div>
      <div class="modal-footer">
        <button  class="btn btn-primary btn-lg" >Upload</button>
      </div>
  		</form>
    </div>

  </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Open Book - <b class="bname"></b></h4>
      </div>
      	<form method="POST" action=""  >
      <div class="modal-body">
        <p><i class="fa fa-key"></i> Enter private Key</p>
        <div class="form-group">
        	<textarea class="form-control" name="key" style="height: 150px; resize: none;"></textarea>
        	<input type="hidden" name="book" class="book-name">
        </div>
      </div>
      <div class="modal-footer">
        <button  class="btn btn-primary btn-lg"  >Open</button>
      </div>
  	</form>
    </div>

  </div>
</div>

<div id="keys" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b class="f-name"></b></h4>
      </div>
      
      <div class="modal-body">
        
        <div class="form-group">
        	<pre class="form-control f-key" style="height: 300px; font-size: 12px; resize: none; padding: 10px;"></pre>
        </div>
      </div>
     
   
    </div>

  </div>
</div>
	
	<script type="text/javascript">
		function showBook(data) {
			$('.bname').html(atob(data))
			$('.book-name').val(atob(data))
			$('#myModal').modal();
		}

		function showKey(data , $name) {
			$('.f-name').html(atob($name))
			$('.f-key').html(atob(data))
			$('.book-name').val(atob(data))
			$('#keys').modal();
		}
	</script>

	<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
