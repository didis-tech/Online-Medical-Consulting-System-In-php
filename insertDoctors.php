<?php 
$servername = "localhost";
$database = "ediagnosis";
$username = "root";
$password = "";

    // Create connection

$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
if(isset($_POST['name'])){
    
        $pass=password_hash(123456, PASSWORD_BCRYPT);
        $name=ucwords($_POST['name']);
        $sql = "INSERT INTO `doctors`( `doc_name`, `doc_tel`, `doc_email`, `doc_password`, `doc_state`, `doc_dept`, `doc_address`, `doc_role`) 
        VALUES ('".$name."','".$_POST['tel']."','".$_POST['email']."','".$pass."','".$_POST['state']."','".$_POST['dept']."','".$_POST['address']."','".$_POST['role']."')";

if ($conn->query($sql) === TRUE) {
    echo "<script> alert('New record created successfully'); window.location='insertDoctors.php';</script>";
  
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
       

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
    />
  
</head>
<body>

<div class="container">
  <h2>Hover Rows</h2>
  <div class="row"> 
      <div class="col-6">
      <div class="table-responsive">
      <table class="table table-hover">
    <thead>
      <tr>
          <th></th>
        <th>Name</th>
        <th>Phone number</th>
        <th>Email</th>
        <th>PASSWORD</th>
        <th>State</th>
        <th>Dept</th>
        <th>Address</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
        <?php $getDocs=$conn->query("SELECT * FROM `doctors` order by doc_id desc"); ?>
        <?php $getDept=$conn->query("SELECT * FROM `departments`  order by dept_name"); ?>
        <?php foreach ($getDocs as $key => $doc): ?>
            <tr>
                <td> <?php echo $doc['doc_id']; ?> </td>
                <td> <?php echo $doc['doc_name']; ?> </td>
                <td> <?php echo $doc['doc_tel']; ?> </td>
                <td> <?php echo $doc['doc_email']; ?> </td>
                <td> <?php echo $doc['doc_password']; ?> </td>
                <td> <?php echo $doc['doc_state']; ?> </td>
                <td> <?php echo $doc['doc_dept']; ?> </td>
                <td> <?php echo $doc['doc_address']; ?> </td>
                <td> <?php echo $doc['doc_role']; ?> </td>
            </tr>
        <?php endforeach; ?>
      
    </tbody>
  </table>
  </div> </div> 
      <div class="col-6">
      <form action="insertDoctors.php" method="post">
  <div class="form-group">
    <label for="email">Name:</label>
    <input type="text" name="name" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">Phone:</label>
    <input type="text" name="tel" class="form-control" id="pwd">
  </div>
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" name="email" class="form-control" id="email">
  </div>
  <div class="form-group">
                <label class="control-label">State of Origin</label>
                <select
                  onchange="toggleLGA(this);"
                  name="state"
                  id="state"
                  class="form-control"
                >
                  <option value="" selected="selected">- Select -</option>
                  <option value="Abia">Abia</option>
                  <option value="Adamawa">Adamawa</option>
                  <option value="AkwaIbom">AkwaIbom</option>
                  <option value="Anambra">Anambra</option>
                  <option value="Bauchi">Bauchi</option>
                  <option value="Bayelsa">Bayelsa</option>
                  <option value="Benue">Benue</option>
                  <option value="Borno">Borno</option>
                  <option value="Cross River">Cross River</option>
                  <option value="Delta">Delta</option>
                  <option value="Ebonyi">Ebonyi</option>
                  <option value="Edo">Edo</option>
                  <option value="Ekiti">Ekiti</option>
                  <option value="Enugu">Enugu</option>
                  <option value="FCT">FCT</option>
                  <option value="Gombe">Gombe</option>
                  <option value="Imo">Imo</option>
                  <option value="Jigawa">Jigawa</option>
                  <option value="Kaduna">Kaduna</option>
                  <option value="Kano">Kano</option>
                  <option value="Katsina">Katsina</option>
                  <option value="Kebbi">Kebbi</option>
                  <option value="Kogi">Kogi</option>
                  <option value="Kwara">Kwara</option>
                  <option value="Lagos">Lagos</option>
                  <option value="Nasarawa">Nasarawa</option>
                  <option value="Niger">Niger</option>
                  <option value="Ogun">Ogun</option>
                  <option value="Ondo">Ondo</option>
                  <option value="Osun">Osun</option>
                  <option value="Oyo">Oyo</option>
                  <option value="Plateau">Plateau</option>
                  <option value="Rivers">Rivers</option>
                  <option value="Sokoto">Sokoto</option>
                  <option value="Taraba">Taraba</option>
                  <option value="Yobe">Yobe</option>
                  <option value="Zamfara">Zamafara</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label">LGA of Origin</label>
                <select
                  name="lga"
                  id="lga"
                  class="form-control select-lga"
                  required
                >
                </select>
              </div>
  <div class="form-group">
    <label for="pwd">Dept:</label>
    <select class="form-control" id="sel1" name="dept">
    <?php foreach ($getDept as $key => $dept): ?>
        <option value="<?php echo $dept['dept_id'] ?>"><?php echo $dept['dept_name'] ?></option>
     <?php endforeach; ?>
      </select>
  </div>
  <div class="form-group">
    <label for="email">Address:</label>
    <input type="text" name='address' class="form-control" id="email" >
  </div>
  <div class="form-group">
    <label for="email">Role:</label>
  <?php
$enum_sql="SHOW COLUMNS FROM doctors LIKE 'doc_role'";
$result_id=$conn->query($enum_sql);
while($row = $result_id->fetch_assoc()) {
	$type = $row["Type"];
}

// format the values
// $type currently has the value of: enum('Equipment','Set','Show')

// ouput will be: Equipment','Set','Show')
$output = str_replace("enum('", "", $type);

 // $output will now be: Equipment','Set','Show
$output = str_replace("')", "", $output);

// array $results contains the ENUM values
$results = explode("','", $output);

// create HTML select object
echo"<select class='select form-control floating' id='menuType' name='role' required>
<option disabled selected>Select Role</option>
";
	foreach ($results as $key => $value) {
			echo "<option value='$value'>$value</option>";
			continue;
		}

// close HTML select object
echo"</select>";
?>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
      </div> </div>           
  
  
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="js/lga.min.js"></script>
</body>
</html>
