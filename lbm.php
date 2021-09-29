<!-- This page is using Bootstrap 4 CSS Style -->
<!-- MUHAMAD ASHRAFF BIN OTHMAN -->
<!-- 52213120560 -->
<!-- ISB42503 - INTERNET PROGRAMMING -->
<!-- UNIVERSITI KUALA LUMPUR -->
<html>
    <head>
        <title>Lean Body Mass Calculator</title>
        <?php
        include ('includes/header.html');
        ?>
    </head>

    <body>
        <!-- Background Animation -->
        <div id="tsparticles"></div>
        <script src='includes/tsparticles.min.js'></script><script  src="includes/script.js"></script>
        <br>

        <?php

            //CREATE DECLARE ARRAY TO STORE LBM INFORMATION
            $lbmCat = "NULL";
            $rangeCat = array("Essential Fat", "Athletes", "Fitness", "Average", "Obese");
            $rangeMale = array(range(2,5), range(6,13), range(14,17), range(18,25));
            $rangeFemale = array(range(10,13), range(14,20), range(21,24), range(25,31));
 
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                //HANDLE

                //VALIDATE NAME / WEIGHT / HEIGHT / AGE / GENDER
                if (empty($_POST['name']) || empty($_POST['weight']) || empty($_POST['height']) || empty($_POST['age']) || empty($_POST['gender']) ){
                    
                    cardHeader();   
                    echo '<div class="alert alert-danger shadow-lg" role="alert">                
                    <h4 class="alert-heading">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-emoji-dizzy" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M9.146 5.146a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 1 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 0-.708zm-5 0a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 1 1 .708.708l-.647.646.647.646a.5.5 0 1 1-.708.708L5.5 7.207l-.646.647a.5.5 0 1 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 0-.708zM10 11a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                    </svg>
                    Oopss!</h4>
                    <p class="mb-0">It looks like there is an error occurred while we are trying to get your information to be processed.</p>
                    <hr>';
                
                    //SHOW ERROR MESSAGE FOR NAME
                    if (empty($_POST['name'])) {
                        $S_name = NULL;
                        errorMessage('You forgot to enter your name !');
                    }//END IF

                    //SHOW ERROR MESSAGE FOR WEIGHT
                    if (empty($_POST['weight'])) {
                        $S_weight= NULL;
                        errorMessage('You forgot to enter your weight !');
                    }//END IF

                    //SHOW ERROR MESSAGE FOR HEIGHT
                    if (empty($_POST['height'])) {
                        $S_height= NULL;
                        errorMessage('You forgot to enter your height !');
                    }//END IF

                    //SHOW ERROR MESSAGE FOR AGE
                    if (empty($_POST['age'])) {
                        $S_age = NULL;
                        errorMessage('You forgot to enter your age !');
                    }//END IF
                    
                    //SHOW ERROR MESSAGE FOR GENDER
                    if (empty($_POST['gender'])) {
                        $S_gender= NULL;
                        errorMessage('You forgot to select your gender!');
                    }//END IF

                    echo '<!-- Warning Message -->
                    <hr>
                    <div class="alert alert-danger" role="alert">
                    <center>Please go back and fill out the form again.</center>
                    </div>';
                    echo '<center><button class="btn btn-danger type="button" onclick="history.back();">< Back</button></center>';
                    echo '</div>';
                    cardFooter();

                    //IF ELSE NO ERROR, THEN PROCEED
                }else {

                    //ASSIGN VALUE TO VARIABLE 
                    $S_name = $_POST['name'];
                    $S_weight = $_POST['weight'];
                    $S_height = $_POST['height'];
                    $S_age = $_POST['age'];
                    $S_gender = $_POST['gender'];
   
                    //IF EVERYTHING IS OK AND VARIABLE HAS BEEN ASSIGNED, THEN DISPLAY OUTPUT
                    if($S_name && $S_weight && $S_height && $S_age && $S_gender){
                        cardHeader();
                        echo '<div class="alert alert-success shadow" role="alert"><center>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg> Result has been successfully generated !</center></div>';

                        //CALCULATE BMI & LBM
                            //INVOKE FUNCTION AND PASS ARGUMENT
                        $bmi = calculateBMI($S_height, $S_weight); //TO CALCULATE BMI BASED ON VALUE OF HEIGHT AND WEIGHT
                        $lbm = calculateLBM($S_gender, $S_age, $bmi); //TO CALCULATE LBM BASED ON VALUE OF BMI, AGE AND GENDER
                        $lbmCat = getLBMCat(number_format($lbm), $S_gender); //TO DETERMINE LBM CATEGORY BASED ON LBM PERCENTAGE CALCULATED

                        //TO SET GENDER OUTPUT
                        $setGender = "NULL";
                        if ($S_gender == "M"){
                            $setGender = "Male";
                        } else if ($S_gender == "F"){
                            $setGender = "Female";
                        }//END IF

                        //DISPLAY OUTPUT
                        echo "Name : <strong>".$S_name."</strong><br>";
                        echo "Weight : <strong>".$S_weight."kg</strong><br>";
                        echo "Height : <strong>".$S_height."m</strong><br>";
                        echo "Gender : <strong>".$setGender."</strong><br>";
                        echo "Age : <strong>".$S_age." years old</strong><br>";
                        echo "BMI  : <strong>".number_format($bmi, 2)."kg/m² </strong><br>";
                        echo progressLBM($lbm, $S_gender, $lbmCat);
                        echo "<center>LBM  : <strong>".number_format($lbm)."%</strong><br>";
                        echo "LBM Category : <strong>".$lbmCat."</strong><br></center><p>";

                        echo '<!-- BUTTON TO SHOW LBM TABLE --> 
                        <center> <button class="btn-sm btn-primary btn shadow-lg" type="button" data-toggle="collapse" data-target="#tablePrice" aria-expanded="false" aria-controls="tablePrice"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
                        </svg>
                        Show LBM table
                        </button>

                        <!-- BUTTON TO GO BACK TO INPUT PAGE -->
                        <button class="btn-sm btn-success btn shadow-lg type="button" onclick="history.back();"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                        <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                        </svg>
                        OK</button></center>

                        <div class="collapse" id="tablePrice"><br>';
                        //INVOKE FUNCTION TO GET AND DISPLAY LBM CATEGORY TABLE LIST
                        echo getlbmTable();
                        echo '</div>';

                        cardFooter();
                    }//END IF
                }//END IF    

                //IF NO SUBMIT ACTION IS PERFORMED, THEN SHOW INPUT FORM
            }else {
                //SHOW FORM
                cardHeader();
                echo '<!-- Bootstrap Alert -->
                <div id="alert" class="alert alert-info alert-dismissible mb-200 pb-200 shadow">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg> Please input all of the information below.</center>
                </div>

                <!-- Using Post Method -->
                <form method="post" action="lbm.php">
                
                <!-- Name Input -->
                <p><label>Name : </label> <input type="text" class="form-control shadow-sm" name="name" placeholder="Enter your name" value="';
                if(isset($_POST['name'])) echo $_POST['name']; //STICKY FORM FOR NAME
                echo'"/></p>

                <!-- Weight Input -->
                <label>Weight : </label>
                <div class="input-group mb-3">
                <input type="number" class="form-control shadow-sm" placeholder="Enter your weight in kg" name="weight" value = "';
                if(isset($_POST['weight'])) echo $_POST['weight']; //STICKY FORM FOR WEIGHT
                echo'">
                <span class="input-group-text shadow-sm">Kilogram (kg)</span>
                </div>
    
                <!-- Height Input -->
                <label>Height : </label>
                <div class="input-group mb-3">
                <input type="number" step="any" class="form-control shadow-sm" placeholder="Enter your height meter" name="height" value = "';
                if(isset($_POST['height'])) echo $_POST['height']; //STICKY FORM FOR HEIGHT
                echo'">
                <span class="input-group-text shadow-sm">&nbsp;&nbsp;&nbsp;Meter (m)&nbsp;&nbsp;&nbsp;</span>
                </div>
                
                <!-- Age Input -->
                <label>Age : </label>
                <div class="input-group mb-3">
                <input type="number" class="form-control shadow-sm" placeholder="Enter your age" name="age" value = "';
                if(isset($_POST['age'])) echo $_POST['age']; //STICKY FORM FOR AGE
                echo'">
                <span class="input-group-text shadow-sm">&nbsp;&nbsp;&nbsp;&nbsp;Years Old&nbsp;&nbsp;&nbsp;</span>
                </div>

                <!-- Gender Input -->
                <label>Gender : </label>
                <select class="form-control shadow-sm" name="gender">
                <option disabled selected value=0>-- Select your gender --</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                </select>
                <br>

                <br>
                
                <!-- Submit Button -->
                <div align="center">
                <input type="submit" name="submit" value="  Calculate > " class="btn btn-success shadow-lg" />
                </div>
               </form>';
                cardFooter(); 
            }//END IF
        
        //FUNCTION TO CALCULATE BMI VALUE
        function calculateBMI($S_height, $S_weight){
            $bmi = $S_weight / ($S_height*$S_height);
            return $bmi; //RETURN VALUE OF BMI CALCULATED
        }//END FUNCTION

        //FUNCTION TO CALCULATE LBM VALUE
        function calculateLBM($S_gender, $S_age, $bmi){
            //CALCULATION OF LBM BASED ON GENDER
            if ($S_gender == 'M'){ //IF MALE IS SELECTED
                $lbm = (1.20 * $bmi) + (0.23 * $S_age - 16.2);
            } else if ($S_gender == 'F'){ //IF FEMALE IS SELECTED
                $lbm = (1.20 * $bmi) + (0.23 * $S_age - 5.4);
            }//END IF
            return $lbm; //RETURN VALUE OF LBM CALCULATED           
        }//END FUNCTION

        //FUNCTION TO SHOW LBM CATEGORY TABLE LIST
        function getlbmTable(){
            echo '<table class="table table-hover shadow-lg">
                        <thead>
                          <tr>
                            <th scope="col"><small><strong>Description</th>
                            <th scope="col"><small><strong>Female</th>
                            <th scope="col"><small><strong>Male</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="table-info">
                            <th scope="row"><small>Essential Fat</th>
                            <td><small>10 - 13%</td>
                            <td><small>2 – 5%</td>
                          </tr>
                          <tr class="table-success">
                            <th scope="row"><small>Athletes</th>
                            <td><small>14 – 20%</td>
                            <td><small>6 - 13%</td>
                          </tr>
                          <tr class="table-success">
                            <th scope="row"><small>Fitness</th>
                            <td><small>21 – 24%</td>
                            <td><small>14 – 17%</td>
                          </tr>
                          <tr class="table-warning">
                            <th scope="row"><small>Average</th>
                            <td><small>25 – 31%</td>
                            <td><small>18 - 25%</td>
                          </tr>
                          <tr class="table-danger">
                            <th scope="row"><small>Obese</th>
                            <td><small>>32%</td>
                            <td><small>>25%</td>
                         </tr>
                        </tbody>
                      </table>';
        }//END FUCNTION

        //FUNCTION TO CALCULATE AND SHOW PROGRESS BAR OF LBM AND THE CATEGORY
        function progressLBM($lbm, $S_gender, $lbmCat){
            
            //SETTING COLOUR FOR PROGRESS BAR
            $progbarColor = "bg-info";

            if ($lbmCat == "Essential Fat"){
                $progbarColor = "bg-info";
            }//END IF

            if ($lbmCat == "Athletes" || $lbmCat == "Fitness"){
                $progbarColor = "bg-success";
            }//END IF

            if ($lbmCat == "Average"){
                $progbarColor = "bg-warning";
            }//END IF

            if ($lbmCat == "Obese"){
                $progbarColor = "bg-danger";
            }//END IF
            
            //CALCULATE PERCENTAGE FOR PROGRESS BAR
            $percentProg = (number_format($lbm) / 25)*100;

            if($S_gender == 'M'){
                echo '<div class="row">
                <div class="col-sm"><small>2%</small></div>
                <div class="col-sm text-right"><small>25%</small></div>
                </div>';

                echo '<div class="progress">
                <div class="progress-bar ';
                echo $progbarColor;
                echo'"role="progressbar" style="width: ';
                echo $percentProg;
                echo '%">LBM : '.number_format($lbm).'%</div>
                </div>';
            }else
            if($S_gender == 'F'){
                echo '<div class="row">
                <div class="col-sm"><small>10%</small></div>
                <div class="col-sm text-right"><small>32%</small></div>
                </div>';

                echo '<div class="progress">
                <div class="progress-bar ';
                echo $progbarColor;
                echo'"role="progressbar" style="width: ';
                echo $percentProg;
                echo '%">LBM : '.number_format($lbm).'%</div>
                </div>';                
            }//END IF

        }//END FUNCTION

        //FUNCTION TO DETERMINE LBM CATEGORY
        function getLBMCat($lbm, $S_gender){
            //DECLARE GLOBAL VARIABLES
            global $lbmCat, $rangeCat, $rangeMale, $rangeFemale;

            //IF GENDER IS MALE
            if ($S_gender == 'M'){
                for($i=0; $i<4; $i++){
                    switch($lbm){
                        case in_array($lbm, $rangeMale[$i]):
                        $lbmCat = $rangeCat[$i];
                        break;
                    }//END SWITCH
                }//END FOR LOOP
                
                if ($lbm > 25){
                    $lbmCat = $rangeCat[4];
                }//END IF

            }else
            //IF GENDER IS FEMALE
            if ($S_gender == 'F'){
                for($i=0; $i<4; $i++){
                    switch($lbm){
                        case in_array($lbm, $rangeFemale[$i]):
                        $lbmCat = $rangeCat[$i];
                        break;
                    }//END SWITCH
                }//END FOR LOOP

                if ($lbm > 32){
                    $lbmCat = $rangeCat[4];
                }//END IF

            }//END IF

            return $lbmCat; //RETURN STRING VALUE OF LBM CATEGORY
        }//END FUNCTION

        //FUNCTION TO DISPLAY ERROR MESSAGE
        function errorMessage(String $message){
            echo '<p>';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>';
            echo $message;
            echo '</p>';
        }//END FUNCTION

        //FUNCTION TO CALL BOOTSTRAP CARD HEADER
        function cardHeader(){
            echo '<!-- Bootstrap Card -->
            <div class="container">
            <div class="card mx-auto shadow-lg" style="width: 30rem;">
            <h5 class="card-header lead shadow-sm"><center><img src="includes\imageres\icon_lbm.png" class="float">  Lean Body Mass Calculator</center></h5>
            <div class="card-body ">';
        }//END FUNCTION

        //FUNCTION TO CALL BOOTSTRAP CARD FOOTER
        function cardFooter(){
        echo'</div>
             </div>
             </div>';
        }//END FUNCTION

        ?>

    <?php
    include ('includes/footer.html');
    ?>
    </body>
</html>