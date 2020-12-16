<?php
include("config.php");
session_start();
require __DIR__ . '/vendor/autoload.php';
use \CloudConvert\Api;
 $ip = $_SERVER['REMOTE_ADDR'];

$api = new Api("YyVgMF1O6TUKbzHWgX6sDpPlQpAptr6Kq7tVkj5H2HJG09S5kpshWhTnfKJfkU5P");
 if(isset($_POST['btnsubmit'])){

    $target_dir = "uploads/"; //directory to store category images
		$target_file = basename($_FILES["file"]["name"]);
		$uploadOk = 1;
		
		if(empty($target_file)){
					$_SESSION['error'] = "Please Upload a File";
					header("location: index.php");
					exit();
			}else{
                $random = rand(0,999999999);
				$name_new = ($random.$target_file);
				$iFileType = strtolower(pathinfo($name_new,PATHINFO_EXTENSION));
					
				if($iFileType != "docx") {
					$_SESSION['error'] = "Sorry, only DOCX files are allowed.";
					$uploadOk = 0;
					header("location: index.php");
					exit();
				}
				if ($uploadOk == 0) {
					$_SESSION['error'] = "Sorry, your Document was not uploaded! Contact Admin.";
					header("location: index.php");
					exit();
				} else {
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$name_new)) {
						$_SESSION['succcess'] = "Document was Successfully Uploaded";
					} else {
						$_SESSION['error'] = "Sorry, there was an error uploading your Document.";
						header("location: index.php");
						exit();
					}
				}
				$documentname = $name_new;
            }
            
		

    
$api->convert([
    "inputformat" => "docx",
    "outputformat" => "pdf",
    "input" => "upload",
    "file" => fopen('uploads/'.$name_new, 'r'),
])
->wait()
->download();

$pdfile = pathinfo($name_new, PATHINFO_FILENAME);
$ext = '.pdf';
$pdffile = $pdfile.$ext;
$sql = "INSERT INTO convert_logs(userip, docxfile, pdffile, time_log) VALUES ('$ip', '$name_new', '$pdffile', NOW())";
if($con->query($sql) == TRUE){




    $_SESSION['success'] = "Document Converted Successfully";
    header("location: index.php");
}else{




    $_SESION['error'] = "Something went wrong!";
    header("location: index.php");
}

 }
?>
<html>
    <head>
        <title>Task1</title>
    </head>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
<body>
<?php
        if(isset($_SESSION['error'])){
          echo "
           <script type='text/javascript'>
		   new Noty({
			    theme: 'sunset',
				type: 'error',
				layout: 'topRight',
				text: '".$_SESSION['error']."',
				timeout: 3000
			}).show();
		   </script>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <script type='text/javascript'>
		   new Noty({
			    theme: 'sunset',
				type: 'success',
				layout: 'topRight',
				text: '".$_SESSION['success']."',
				timeout: 3000
			}).show();
		   </script>
          ";
          unset($_SESSION['success']);
        }
      ?>
 <div class="container">
    <div class="row">
        <div class="col-12">
            <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="docxfile" class="form-label">Upload File</label>
                <input type="file" class="form-control" name="file" id="docxfile">
            </div>
            <input type="submit" name="btnsubmit" class="btn btn-primary" value="convert">
            </form>
        </div>
        <div class="col-12">
        <?php
            $getfiles = $con->query("SELECT * FROM convert_logs WHERE userip = '$ip'");
            $count = 1;
            while($row = $getfiles->fetch_assoc()){
        ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Converted File <?php echo $count++; ?></h5>
                    <p class="card-text">Converted: <?php echo date('d F, Y', strtotime($row['time_log'])); ?> at <?php echo date('H:i:s', strtotime($row['time_log'])); ?></p>
                    <a href="<?php echo $row['pdffile'];?>" style="font-size: 10px;" target="_blank" class="btn btn-danger">Download PDF</a>
                    <a href="uploads/<?php echo $row['docxfile'];?>" style="font-size: 10px;" target="_blank" class="btn btn-primary">Download DOCX</a>
                    <a class="sendmail btn btn-success" data-id="<?php echo $row['logid']; ?>" style="font-size: 10px; margin-top: 3px;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Get on Email
                    </a>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
 </div>
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Your Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="sendmail.php">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="enter your email">
                <input type="hidden" class="logid form-control" name="logid">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script>
$(function(){
  $('.sendmail').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    $('.logid').val(id);
  });

});
</script>
</body>
</html>
