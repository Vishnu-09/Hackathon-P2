<!DOCTYPE html>
<?php 
include('func1.php');
$con=mysqli_connect("localhost","root","","myhmsdb");
$doctor = $_SESSION['dname'];
if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update appointmenttb set doctorStatus='0' where ID = '".$_GET['ID']."'");
    if($query)
    {
      echo "<script>alert('Your appointment successfully cancelled');</script>";
    }
  }

  // if(isset($_GET['prescribe'])){
    
  //   $pid = $_GET['pid'];
  //   $ID = $_GET['ID'];
  //   $appdate = $_GET['appdate'];
  //   $apptime = $_GET['apptime'];
  //   $disease = $_GET['disease'];
  //   $allergy = $_GET['allergy'];
  //   $prescription = $_GET['prescription'];
  //   $query=mysqli_query($con,"insert into prestb(doctor,pid,ID,appdate,apptime,disease,allergy,prescription) values ('$doctor',$pid,$ID,'$appdate','$apptime','$disease','$allergy','$prescription');");
  //   if($query)
  //   {
  //     echo "<script>alert('Prescribed successfully!');</script>";
  //   }
  //   else{
  //     echo "<script>alert('Unable to process your request. Try again!');</script>";
  //   }
  // }


?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> LifeSync </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <style >
      .btn-outline-light:hover{
        color: #25bef7;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
      }
    </style>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #342ac1;
    border-color: #007bff;
}
.text-primary {
    color: #342ac1!important;
}
  </style>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Enter contact number" aria-label="Search" name="contact">
      <input type="submit" class="btn btn-outline-light" id="inputbtn" name="search_submit" value="Search">
    </form>
  </div>
</nav>
  </head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>
  <body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%; padding-bottom: 20px;font-family:'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $_SESSION['dname'] ?>  </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:18%;margin-top: 3%;">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" aria-controls="home" data-toggle="list">Dashboard</a>
      <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointments</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home"> Prescription List</a>
      <a class="list-group-item list-group-item-action" href="#list-qr" id="list-qr-list" role="tab" data-toggle="list" aria-controls="home">Patient QR Scanner</a>
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">
      <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        
              <div class="container-fluid container-fullw bg-white" >
              <div class="row">

               <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> View Appointments</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-app" onclick="clickDiv('#list-app-list')">
                          Appointment List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-4" style="left: 15%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Prescriptions</h4>
                        
                      <p class="links cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>    

             </div>
           </div>
         </div>
         <div class="tab-pane fade" id="list-qr" role="tabpanel" aria-labelledby="list-qr-list">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <center><h4>Scan Patient Medical QR Code</h4></center><br>
          
          <!-- QR Scanner Interface -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Scan QR Code</label>
                <div id="reader"></div>
                <textarea id="qrResult" class="form-control mt-3" placeholder="QR Code Result" rows="2"></textarea>
              </div>
              <button class="btn btn-primary" onclick="startScanner()">Start Scanner</button>
              <button class="btn btn-secondary" onclick="stopScanner()">Stop Scanner</button>
            </div>

            <!-- Patient Information Display -->
            <div class="col-md-6">
              <div id="patientInfo" style="display: none;">
                <h5>Patient Information</h5>
                <div class="card">
                  <div class="card-body">
                    <div class="text-center mb-3">
                      <img id="patientPhoto" class="img-fluid rounded" style="max-width: 200px;">
                    </div>
                    <table class="table">
                      <tr>
                        <th>Name:</th>
                        <td id="patientName"></td>
                      </tr>
                      <tr>
                        <th>Gender:</th>
                        <td id="patientGender"></td>
                      </tr>
                      <tr>
                        <th>Phone:</th>
                        <td id="patientPhone"></td>
                      </tr>
                      <tr>
                        <th>Emergency Contact:</th>
                        <td id="emergencyContact"></td>
                      </tr>
                      <tr>
                        <th>Medical Conditions:</th>
                        <td id="medicalConditions"></td>
                      </tr>
                      <tr>
                        <th>Disabilities:</th>
                        <td id="disabilities"></td>
                      </tr>
                    </table>

                    <!-- Medical Documents Sections -->
                    <div class="mt-3">
                      <h6>Prescriptions</h6>
                      <div id="prescriptionImages" class="row"></div>
                    </div>

                    <div class="mt-3">
                      <h6>Medical Documents</h6>
                      <div id="scanningDocs" class="row"></div>
                    </div>

                    <div class="mt-3" id="insuranceSection">
                      <h6>Insurance Information</h6>
                      <div id="insuranceDoc"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


    <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-home-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                    <th scope="col">Prescribe</th>

                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;
                    $dname = $_SESSION['dname'];
                    $query = "select pid,ID,fname,lname,gender,email,contact,appdate,apptime,userStatus,doctorStatus from appointmenttb where doctor='$dname';";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                      ?>
                      <tr>
                      <td><?php echo $row['pid'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['gender'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        <td>
                    <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                    {
                      echo "Active";
                    }
                    if(($row['userStatus']==0) && ($row['doctorStatus']==1))  
                    {
                      echo "Cancelled by Patient";
                    }

                    if(($row['userStatus']==1) && ($row['doctorStatus']==0))  
                    {
                      echo "Cancelled by You";
                    }
                        ?></td>

                     <td>
                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                        { ?>

													
	                        <a href="doctor-panel.php?ID=<?php echo $row['ID']?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
	                        <?php } else {

                                echo "Cancelled";
                                } ?>
                        
                        </td>

                        <td>

                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                        { ?>

                        <a href="prescribe.php?pid=<?php echo $row['pid']?>&ID=<?php echo $row['ID']?>&fname=<?php echo $row['fname']?>&lname=<?php echo $row['lname']?>&appdate=<?php echo $row['appdate']?>&apptime=<?php echo $row['apptime']?>"
                        tooltip-placement="top" tooltip="Remove" title="prescribe">
                        <button class="btn btn-success">Prescibe</button></a>
                        <?php } else {

                            echo "-";
                            } ?>
                        
                        </td>


                      </tr></a>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>

      

      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Patient ID</th>
                    
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergy</th>
                    <th scope="col">Prescribe</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select pid,fname,lname,ID,appdate,apptime,disease,allergy,prescription from prestb where doctor='$doctor';";
                    
                    $result = mysqli_query($con,$query);
                    if(!$result){
                      echo mysqli_error($con);
                    }
                    

                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['pid'];?></td>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        <td><?php echo $row['disease'];?></td>
                        <td><?php echo $row['allergy'];?></td>
                        <td><?php echo $row['prescription'];?></td>
                    
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
      </div>




      <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-pat-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select * from appointmenttb;";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
              
                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
                        <td><?php echo $row['doctor'];?></td>
                        <td><?php echo $row['docFees'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>





      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="admin-panel1.php">
          <div class="row">
                  <div class="col-md-4"><label>Doctor Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control" name="doctor" required></div><br><br>
                  <div class="col-md-4"><label>Password:</label></div>
                  <div class="col-md-8"><input type="password" class="form-control"  name="dpassword" required></div><br><br>
                  <div class="col-md-4"><label>Email ID:</label></div>
                  <div class="col-md-8"><input type="email"  class="form-control" name="demail" required></div><br><br>
                  <div class="col-md-4"><label>Consultancy Fees:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="docFees" required></div><br><br>
                </div>
          <input type="submit" name="docsub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>
   <script src="https://unpkg.com/html5-qrcode"></script>
<script>
function onScanSuccess(decodedText, decodedResult) {
    // Stop scanner after successful scan
    html5QrcodeScanner.clear();
    
    // Send encrypted data to server for decryption
    fetch('decrypt_qr.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'encrypted_data=' + encodeURIComponent(decodedText)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            displayPatientData(data.decrypted_data);
        } else {
            document.getElementById('patientInfo').innerHTML = 
                '<div class="alert alert-danger">Error decrypting QR code</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('patientInfo').innerHTML = 
            '<div class="alert alert-danger">Error processing QR code</div>';
    });
}

function displayPatientData(data) {
    const patientInfo = document.getElementById('patientInfo');
    patientInfo.innerHTML = `
        <table class="table">
            <tr>
                <th>Patient ID</th>
                <td>${data.pid}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>${data.fname} ${data.lname}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>${data.email}</td>
            </tr>
            <tr>
                <th>Contact</th>
                <td>${data.contact}</td>
            </tr>
            <tr>
                <th>Doctor</th>
                <td>${data.doctor}</td>
            </tr>
            <tr>
                <th>Appointment Date</th>
                <td>${data.appdate}</td>
            </tr>
            <tr>
                <th>Appointment Time</th>
                <td>${data.apptime}</td>
            </tr>
        </table>
    `;
}

// Initialize QR Scanner
function initializeScanner() {
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { 
            fps: 10,
            qrbox: {width: 250, height: 250},
            aspectRatio: 1.0
        }
    );
    html5QrcodeScanner.render(onScanSuccess);
}

// Initialize scanner when decrypt tab is shown
document.getElementById('list-decrypt-list').addEventListener('click', initializeScanner);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
  <script>
    let html5QrcodeScanner = null;

    function startScanner() {
      if (html5QrcodeScanner === null) {
        html5QrcodeScanner = new Html5Qrcode("reader");
      }
      
      html5QrcodeScanner.start(
        { facingMode: "environment" },
        {
          fps: 10,
          qrbox: { width: 250, height: 250 }
        },
        onScanSuccess,
        onScanFailure
      );
    }

    function stopScanner() {
      if (html5QrcodeScanner) {
        html5QrcodeScanner.stop().then(() => {
          html5QrcodeScanner = null;
        });
      }
    }

    function onScanSuccess(qrCodeMessage) {
      document.getElementById('qrResult').value = qrCodeMessage;
      stopScanner();
      decryptAndDisplayData(qrCodeMessage);
    }

    function onScanFailure(error) {
      // console.error(QR Code scanning failed: ${error});
    }

    function decryptAndDisplayData(qrKey) {
      try {
        const data = JSON.parse(localStorage.getItem(qrKey));
        if (!data) {
          alert("Invalid or expired QR code");
          return;
        }

        // Display patient information
        document.getElementById('patientInfo').style.display = 'block';
        document.getElementById('patientPhoto').src = data.photo;
        document.getElementById('patientName').textContent = data.name;
        document.getElementById('patientGender').textContent = data.gender;
        document.getElementById('patientPhone').textContent = data.phone;
        document.getElementById('emergencyContact').textContent = data.emergencyPhone;

        // Display medical conditions
        let conditions = [];
        if (data.bloodPressure) conditions.push('Blood Pressure');
        if (data.diabetes) conditions.push('Diabetes');
        document.getElementById('medicalConditions').textContent = conditions.join(', ') || 'None';
        
        document.getElementById('disabilities').textContent = data.disabilities;

        // Display prescriptions
        const prescriptionDiv = document.getElementById('prescriptionImages');
        prescriptionDiv.innerHTML = '';
        data.prescriptions.forEach((img, index) => {
          const col = document.createElement('div');
          col.className = 'col-md-6 mb-2';
          const imgElement = document.createElement('img');
          imgElement.src = img;
          imgElement.className = 'img-fluid';
          imgElement.style.cursor = 'pointer';
          imgElement.onclick = () => window.open(img);
          col.appendChild(imgElement);
          prescriptionDiv.appendChild(col);
        });

        // Display medical documents
        const docsDiv = document.getElementById('scanningDocs');
        docsDiv.innerHTML = '';
        data.scanningDocs.forEach((img, index) => {
          const col = document.createElement('div');
          col.className = 'col-md-6 mb-2';
          const imgElement = document.createElement('img');
          imgElement.src = img;
          imgElement.className = 'img-fluid';
          imgElement.style.cursor = 'pointer';
          imgElement.onclick = () => window.open(img);
          col.appendChild(imgElement);
          docsDiv.appendChild(col);
        });

        // Display insurance information
        const insuranceSection = document.getElementById('insuranceSection');
        if (data.lifeInsurance === 'No') {
          insuranceSection.style.display = 'none';
        } else {
          insuranceSection.style.display = 'block';
          const insuranceDiv = document.getElementById('insuranceDoc');
          insuranceDiv.innerHTML = '';
          const imgElement = document.createElement('img');
          imgElement.src = data.lifeInsurance;
          imgElement.className = 'img-fluid';
          imgElement.style.cursor = 'pointer';
          imgElement.onclick = () => window.open(data.lifeInsurance);
          insuranceDiv.appendChild(imgElement);
        }

      } catch (error) {
        console.error(error);
        alert("Error decoding QR data");
      }
    }
  </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
  </body>
</html>