<!DOCTYPE html>
<?php 
include('func.php');  
include('newfunc.php');
$con=mysqli_connect("localhost","root","","myhmsdb");


  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $gender = $_SESSION['gender'];
  $lname = $_SESSION['lname'];
  $contact = $_SESSION['contact'];



if(isset($_POST['app-submit']))
{
  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];
  $doctor=$_POST['doctor'];
  $email=$_SESSION['email'];
  # $fees=$_POST['fees'];
  $docFees=$_POST['docFees'];

  $appdate=$_POST['appdate'];
  $apptime=$_POST['apptime'];
  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $apptime1 = strtotime($apptime);
  $appdate1 = strtotime($appdate);
	
  if(date("Y-m-d",$appdate1)>=$cur_date){
    if((date("Y-m-d",$appdate1)==$cur_date and date("H:i:s",$apptime1)>$cur_time) or date("Y-m-d",$appdate1)>$cur_date) {
      $check_query = mysqli_query($con,"select apptime from appointmenttb where doctor='$doctor' and appdate='$appdate' and apptime='$apptime'");

        if(mysqli_num_rows($check_query)==0){
          $query=mysqli_query($con,"insert into appointmenttb(pid,fname,lname,gender,email,contact,doctor,docFees,appdate,apptime,userStatus,doctorStatus) values($pid,'$fname','$lname','$gender','$email','$contact','$doctor','$docFees','$appdate','$apptime','1','1')");

          if($query)
          {
            echo "<script>alert('Your appointment successfully booked');</script>";
          }
          else{
            echo "<script>alert('Unable to process your request. Please try again!');</script>";
          }
      }
      else{
        echo "<script>alert('We are sorry to inform that the doctor is not available in this time or date. Please choose different time or date!');</script>";
      }
    }
    else{
      echo "<script>alert('Select a time or date in the future!');</script>";
    }
  }
  else{
      echo "<script>alert('Select a time or date in the future!');</script>";
  }
  
}

if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update appointmenttb set userStatus='0' where ID = '".$_GET['ID']."'");
    if($query)
    {
      echo "<script>alert('Your appointment successfully cancelled');</script>";
    }
  }





function generate_bill(){
  $con=mysqli_connect("localhost","root","","myhmsdb");
  $pid = $_SESSION['pid'];
  $output='';
  $query=mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.doctor,p.appdate,p.apptime,p.disease,p.allergy,p.prescription,a.docFees from prestb p inner join appointmenttb a on p.ID=a.ID and p.pid = '$pid' and p.ID = '".$_GET['ID']."'");
  while($row = mysqli_fetch_array($query)){
    $output .= '
    <label> Patient ID : </label>'.$row["pid"].'<br/><br/>
    <label> Appointment ID : </label>'.$row["ID"].'<br/><br/>
    <label> Patient Name : </label>'.$row["fname"].' '.$row["lname"].'<br/><br/>
    <label> Doctor Name : </label>'.$row["doctor"].'<br/><br/>
    <label> Appointment Date : </label>'.$row["appdate"].'<br/><br/>
    <label> Appointment Time : </label>'.$row["apptime"].'<br/><br/>
    <label> Disease : </label>'.$row["disease"].'<br/><br/>
    <label> Allergies : </label>'.$row["allergy"].'<br/><br/>
    <label> Prescription : </label>'.$row["prescription"].'<br/><br/>
    <label> Fees Paid : </label>'.$row["docFees"].'<br/>
    
    ';

  }
  
  return $output;
}


if(isset($_GET["generate_bill"])){
  require_once("TCPDF/tcpdf.php");
  $obj_pdf = new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
  $obj_pdf -> SetCreator(PDF_CREATOR);
  $obj_pdf -> SetTitle("Generate Bill");
  $obj_pdf -> SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
  $obj_pdf -> SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf -> SetFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf -> SetDefaultMonospacedFont('helvetica');
  $obj_pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);
  $obj_pdf -> SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
  $obj_pdf -> SetPrintHeader(false);
  $obj_pdf -> SetPrintFooter(false);
  $obj_pdf -> SetAutoPageBreak(TRUE, 10);
  $obj_pdf -> SetFont('helvetica','',12);
  $obj_pdf -> AddPage();

  $content = '';

  $content .= '
      <br/>
      <h2 align ="center"> Global Hospitals</h2></br>
      <h3 align ="center"> Bill</h3>
      

  ';
 
  $content .= generate_bill();
  $obj_pdf -> writeHTML($content);
  ob_end_clean();
  $obj_pdf -> Output("bill.pdf",'I');

}

function get_specs(){
  $con=mysqli_connect("localhost","root","","myhmsdb");
  $query=mysqli_query($con,"select username,spec from doctb");
  $docarray = array();
    while($row =mysqli_fetch_assoc($query))
    {
        $docarray[] = $row;
    }
    return json_encode($docarray);
}

?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    
  
    
    



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> LifeSync </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

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

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
  </div>
</nav>
  </head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>
  <body style="padding-top:50px;">
  
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $username ?> 
   </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:25%; margin-top: 3%">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Appointment</a>
      <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Appointment History</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescriptions</a>
      <a class="list-group-item list-group-item-action" href="#list-qr" id="list-qr-list" role="tab" data-toggle="list" aria-controls="home">QR Code Activate</a>
      <a class="list-group-item list-group-item-action" href="#list-ai" id="list-ai-list" role="tab" data-toggle="list" aria-controls="home">AI Diagnosis</a>

    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">


      <div class="tab-pane fade  show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white" >
              <div class="row">
               <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Book My Appointment</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-home-list')">
                          Book Appointment
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">My Appointments</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                          View Appointment History
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                </div>

                <div class="col-sm-4" style="left: 20%;margin-top:5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          View Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4" style="left: 15%">
                <div class="panel panel-white no-radius text-center">
                  <div class="panel-body">
                    <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-qrcode fa-stack-1x fa-inverse"></i> </span>
                    <h4 class="StepTitle" style="margin-top: 5%;">Create QR Code</h4>
                    <p class="links cl-effect-1">
                      <a href="#list-qr" onclick="clickDiv('#list-qr-list')">
                        Generate QR Code
                      </a>
                    </p>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="list-ai" role="tabpanel" aria-labelledby="list-ai-list">
              <div class="container">
        <!-- Navigation Link -->
        <div class="list-group">
            <a class="list-group-item list-group-item-action" href="#ai-diagnosis" id="list-ai-list" role="tab" data-toggle="list" aria-controls="home">AI Diagnosis</a>
        </div>

        
        <h1 id="ai-diagnosis" class="title">AI DIAGNOSIS</h1>

        <!-- Symptom Input Form -->
        <div id="symptoms-form">
            <h2>Enter Your Symptoms</h2>
            <label>Tiredness: <input type="text" id="tiredness"></label><br>
            <label>Dry Cough: <input type="text" id="dry_cough"></label><br>
            <label>Difficulty Breathing: <input type="text" id="difficulty_breathing"></label><br>
            <label>Sore Throat: <input type="text" id="sore_throat"></label><br>
            <label>Body Pains: <input type="text" id="body_pains"></label><br>
            <button id="get-advice">Get Advice</button>
        </div>

        <!-- Advice and Chat Section -->
        <div id="advice-section" style="display:none;">
            <div class="advice-container">
                <h2>Precautions and Suggested Tablets</h2>
                <div id="advice-text" class="formatted-text"></div>
            </div>

            <!-- Chatbot Interaction Section -->
            <div class="chat-container">
                <h3>Chat with AI</h3>
                <input type="text" id="user-question" placeholder="Type your question..." class="input-field">
                <button id="ask-question" class="button">Ask</button>
                <button id="stop-chat" class="button stop">Stop Chat</button>
                <div id="chat-responses" class="chat-box"></div>
            </div>
        </div>
        
    </div>
                        
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isChatting = true;

            document.getElementById('get-advice').addEventListener('click', function() {
                const symptoms = {
                    tiredness: document.getElementById('tiredness').value,
                    dry_cough: document.getElementById('dry_cough').value,
                    difficulty_breathing: document.getElementById('difficulty_breathing').value,
                    sore_throat: document.getElementById('sore_throat').value,
                    body_pains: document.getElementById('body_pains').value
                };

                fetch('/get_advice', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(symptoms)
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('advice-text').textContent = data.advice;
                    document.getElementById('advice-section').style.display = 'block';
                });
            });

            document.getElementById('ask-question').addEventListener('click', function() {
                if (isChatting) {
                    const question = document.getElementById('user-question').value;
                    const precautions = document.getElementById('advice-text').textContent;

                    fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ question: question, precautions: precautions })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const chatResponses = document.getElementById('chat-responses');
                        chatResponses.innerHTML += <p><strong>You:</strong> ${question}</p><p><strong>AI:</strong> ${data.response}</p>;
                        document.getElementById('user-question').value = '';
                    });
                }
            });

            document.getElementById('stop-chat').addEventListener('click', function() {
                isChatting = false;
                document.getElementById('chat-responses').innerHTML += "<p><strong>Chat ended.</strong> Thank you for using the AI Health Assistant!</p>";
            });
        });
    </script>
         
            </div>
          </div>




  <div class="tab-pane fade" id="list-qr" role="tabpanel" aria-labelledby="list-qr-list">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <center><h4>Create Medical Information QR Code</h4></center><br>
        <form class="form-group" id="qrForm">
          <div class="row">
            <div class="col-md-4">
              <label>Photo:</label>
            </div>
            <div class="col-md-8">
              <input type="file" class="form-control" id="photo" accept="image/*" required>
            </div><br><br>

            <div class="col-md-4">
              <label>Name:</label>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control" id="qrName" required>
            </div><br><br>

            <div class="col-md-4">
              <label>Gender:</label>
            </div>
            <div class="col-md-8">
              <select class="form-control" id="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div><br><br>

            <div class="col-md-4">
              <label>Phone Number:</label>
            </div>
            <div class="col-md-8">
              <input type="tel" class="form-control" id="phone" required>
            </div><br><br>

            <div class="col-md-4">
              <label>Emergency Contact:</label>
            </div>
            <div class="col-md-8">
              <input type="tel" class="form-control" id="emergencyPhone" required>
            </div><br><br>

            <div class="col-md-4">
              <label>Medical Conditions:</label>
            </div>
            <div class="col-md-8">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="bloodPressure">
                <label class="form-check-label">Blood Pressure</label>
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="diabetes">
                <label class="form-check-label">Diabetes</label>
              </div>
            </div><br><br>

            <div class="col-md-4">
              <label>Physical Disabilities:</label>
            </div>
            <div class="col-md-8">
              <select class="form-control" id="disabilities" onchange="toggleDisabilityDetails(this)">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              </select>
              <textarea class="form-control mt-2" id="disabilityDetails" style="display: none;"></textarea>
            </div><br><br>

            <div class="col-md-4">
              <label>Prescriptions:</label>
            </div>
            <div class="col-md-8">
              <input type="file" class="form-control" id="prescriptionImages" accept="image/*" multiple>
            </div><br><br>

            <div class="col-md-4">
              <label>Medical Documents:</label>
            </div>
            <div class="col-md-8">
              <input type="file" class="form-control" id="scanningDocs" accept="image/*" multiple>
            </div><br><br>

            <div class="col-md-4">
              <label>Life Insurance:</label>
            </div>
            <div class="col-md-8">
              <select class="form-control" id="lifeInsurance" onchange="toggleInsuranceUpload(this)">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              </select>
              <input type="file" class="form-control mt-2" id="insuranceFile" accept="image/*" style="display: none;">
            </div><br><br>

            <div class="col-md-4">
              <button type="button" class="btn btn-primary" onclick="generateQRCode()">Generate QR Code</button>
            </div>
            <div class="col-md-8"></div>
          </div>
        </form>
        <div class="text-center mt-4">
          <h5>Generated QR Code:</h5>
          <div id="qrCode"></div>
        </div>
      </div>
    </div>
  </div>
</div>
      <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Create an appointment</h4></center><br>
              <form class="form-group" method="post" action="admin-panel.php">
                <div class="row">
                  
                  <!-- <?php

                        $con=mysqli_connect("localhost","root","","myhmsdb");
                        $query=mysqli_query($con,"select username,spec from doctb");
                        $docarray = array();
                          while($row =mysqli_fetch_assoc($query))
                          {
                              $docarray[] = $row;
                          }
                          echo json_encode($docarray);

                  ?> -->
        

                    <div class="col-md-4">
                          <label for="spec">Specialization:</label>
                        </div>
                        <div class="col-md-8">
                          <select name="spec" class="form-control" id="spec">
                              <option value="" disabled selected>Select Specialization</option>
                              <?php 
                              display_specs();
                              ?>
                          </select>
                        </div>

                        <br><br>

                        <script>
                      document.getElementById('spec').onchange = function foo() {
                        let spec = this.value;   
                        console.log(spec)
                        let docs = [...document.getElementById('doctor').options];
                        
                        docs.forEach((el, ind, arr)=>{
                          arr[ind].setAttribute("style","");
                          if (el.getAttribute("data-spec") != spec ) {
                            arr[ind].setAttribute("style","display: none");
                          }
                        });
                      };

                  </script>

              <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                <div class="col-md-8">
                    <select name="doctor" class="form-control" id="doctor" required="required">
                      <option value="" disabled selected>Select Doctor</option>
                
                      <?php display_docs(); ?>
                    </select>
                  </div><br/><br/> 


                        <script>
              document.getElementById('doctor').onchange = function updateFees(e) {
                var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                document.getElementById('docFees').value = selection;
              };
            </script>

                  
                  

                  
                        <!-- <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                                <div class="col-md-8">
                                    <select name="doctor" class="form-control" id="doctor1" required="required">
                                      <option value="" disabled selected>Select Doctor</option>
                                      
                                    </select>
                                </div>
                                <br><br> -->

                                <!-- <script>
                                  document.getElementById("spec").onchange = function updateSpecs(event) {
                                      var selected = document.querySelector(`[data-value=${this.value}]`).getAttribute("value");
                                      console.log(selected);

                                      var options = document.getElementById("doctor1").querySelectorAll("option");

                                      for (i = 0; i < options.length; i++) {
                                        var currentOption = options[i];
                                        var category = options[i].getAttribute("data-spec");

                                        if (category == selected) {
                                          currentOption.style.display = "block";
                                        } else {
                                          currentOption.style.display = "none";
                                        }
                                      }
                                    }
                                </script> -->

                        
                    <!-- <script>
                    let data = 
                
              document.getElementById('spec').onchange = function updateSpecs(e) {
                let values = data.filter(obj => obj.spec == this.value).map(o => o.username);   
                document.getElementById('doctor1').value = document.querySelector(`[value=${values}]`).getAttribute('data-value');
              };
            </script> -->


                  
                  <div class="col-md-4"><label for="consultancyfees">
                                Consultancy Fees
                              </label></div>
                              <div class="col-md-8">
                              <!-- <div id="docFees">Select a doctor</div> -->
                              <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly"/>
                  </div><br><br>

                  <div class="col-md-4"><label>Appointment Date</label></div>
                  <div class="col-md-8"><input type="date" class="form-control datepicker" name="appdate"></div><br><br>

                  <div class="col-md-4"><label>Appointment Time</label></div>
                  <div class="col-md-8">
                    <!-- <input type="time" class="form-control" name="apptime"> -->
                    <select name="apptime" class="form-control" id="apptime" required="required">
                      <option value="" disabled selected>Select Time</option>
                      <option value="08:00:00">8:00 AM</option>
                      <option value="10:00:00">10:00 AM</option>
                      <option value="12:00:00">12:00 PM</option>
                      <option value="14:00:00">2:00 PM</option>
                      <option value="16:00:00">4:00 PM</option>
                    </select>

                  </div><br><br>

                  <div class="col-md-4">
                    <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>
      
<div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select ID,doctor,docFees,appdate,apptime,userStatus,doctorStatus from appointmenttb where fname ='$fname' and lname='$lname';";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
              
                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $row['doctor'];?></td>
                        <td><?php echo $row['docFees'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        
                          <td>
                    <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                    {
                      echo "Active";
                    }
                    if(($row['userStatus']==0) && ($row['doctorStatus']==1))  
                    {
                      echo "Cancelled by You";
                    }

                    if(($row['userStatus']==1) && ($row['doctorStatus']==0))  
                    {
                      echo "Cancelled by Doctor";
                    }
                        ?></td>

                        <td>
                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                        { ?>

													
	                        <a href="admin-panel.php?ID=<?php echo $row['ID']?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
	                        <?php } else {

                                echo "Cancelled";
                                } ?>
                        
                        </td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>



      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Diseases</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescriptions</th>
                    <th scope="col">Bill Payment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select doctor,ID,appdate,apptime,disease,allergy,prescription from prestb where pid='$pid';";
                    
                    $result = mysqli_query($con,$query);
                    if(!$result){
                      echo mysqli_error($con);
                    }
                    

                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['doctor'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        <td><?php echo $row['disease'];?></td>
                        <td><?php echo $row['allergy'];?></td>
                        <td><?php echo $row['prescription'];?></td>
                        <td>
                          <form method="get">
                          <!-- <a href="admin-panel.php?ID=" 
                              onClick=""
                              title="Pay Bill" tooltip-placement="top" tooltip="Remove"><button class="btn btn-success">Pay</button>
                              </a></td> -->

                              <a href="admin-panel.php?ID=<?php echo $row['ID']?>">
                              <input type ="hidden" name="ID" value="<?php echo $row['ID']?>"/>
                              <input type = "submit" onclick="alert('Bill Paid Successfully');" name ="generate_bill" class = "btn btn-success" value="Pay Bill"/>
                              </a>
                              </td>
                              </form>

                    
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
        <br>
      </div>




      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
function toggleDisabilityDetails(select) {
    document.getElementById('disabilityDetails').style.display = 
        select.value === 'Yes' ? 'block' : 'none';
}

function toggleInsuranceUpload(select) {
    document.getElementById('insuranceFile').style.display = 
        select.value === 'Yes' ? 'block' : 'none';
}

async function getImageBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

async function generateQRCode() {
    try {
        const photo = await getImageBase64(document.getElementById('photo').files[0]);
        const prescriptions = [];
        for (let file of document.getElementById('prescriptionImages').files) {
            prescriptions.push(await getImageBase64(file));
        }
        const scanningDocs = [];
        for (let file of document.getElementById('scanningDocs').files) {
            scanningDocs.push(await getImageBase64(file));
        }
        const insuranceFile = document.getElementById('insuranceFile').files.length > 0 ? 
            await getImageBase64(document.getElementById('insuranceFile').files[0]) : null;

        const data = {
            photo,
            name: document.getElementById('qrName').value,
            gender: document.getElementById('gender').value,
            phone: document.getElementById('phone').value,
            emergencyPhone: document.getElementById('emergencyPhone').value,
            bloodPressure: document.getElementById('bloodPressure').checked,
            diabetes: document.getElementById('diabetes').checked,
            disabilities: document.getElementById('disabilities').value === 'Yes' ? 
                document.getElementById('disabilityDetails').value : 'No',
            prescriptions,
            scanningDocs,
            lifeInsurance: document.getElementById('lifeInsurance').value === 'Yes' ? 
                insuranceFile : 'No'
        };

        const uniqueKey = Date.now().toString();
        localStorage.setItem(uniqueKey, JSON.stringify(data));
        
        const qrDiv = document.getElementById("qrCode");
        qrDiv.innerHTML = '';
        new QRCode(qrDiv, uniqueKey);
        
        alert("QR Code generated successfully!");
    } catch (error) {
        alert("Error generating QR Code. Please try again.");
        console.error(error);
    }
}
</script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
   </script>
 <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #e7f6f2;
            padding: 20px;
            scroll-behavior: smooth; /* Smooth scroll effect */
        }

        .container {
            width: 70%;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 100, 63, 0.2);
        }

        .title {
            text-align: center;
            font-size: 1.8em;
            color: #00663f;
            margin-bottom: 20px;
        }

        #symptoms-form, .advice-container, .chat-container {
            margin-bottom: 20px;
        }

        #symptoms-form h2, .advice-container h2, .chat-container h3 {
            color: #00663f;
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 1em;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #b5e3d8;
            border-radius: 6px;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        #get-advice {
            background-color: #2ebaae;
            color: #fff;
        }

        .stop {
            background-color: #ff7373;
            color: #fff;
        }

        button:hover {
            opacity: 0.9;
        }

        .advice-container, .chat-container {
            border-top: 1px solid #b5e3d8;
            padding-top: 15px;
        }

        #advice-text {
            background-color: #f2fdfb;
            padding: 15px;
            border-radius: 8px;
            color: #444;
            line-height: 1.6;
        }

        .chat-box {
            margin-top: 15px;
            padding: 10px;
            background-color: #e7f6f2;
            border-radius: 8px;
            max-height: 300px;
            overflow-y: auto;
        }

        .chat-box p {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #d1efe8;
            border-radius: 5px;
        }

        .input-field {
            width: 80%;
            margin-right: 10px;
            padding: 8px;
            border: 1px solid #b5e3d8;
            border-radius: 5px;
        }

        .formatted-text {
            white-space: pre-wrap;
            font-size: 1.05em;
            font-weight: 400;
            color: #00663f;
        }

        .list-group {
            margin-bottom: 20px;
        }

        .list-group-item {
            padding: 10px;
            cursor: pointer;
            color: #2ebaae;
            text-decoration: none;
        }

        .list-group-item:hover {
            background-color: #d1efe8;
        }
    </style>


  </body>
</html>
