<?php

    // Including a functions file
    //require 'core/functions.php';

    if (count($_POST) != 0) {
        $pcode=$_POST['personalcode'];

        // 1 Check if the field is empty
        if ( isset($pcode) ) {
            //Check if 11 characters have been entered
            if ( mb_strlen($pcode) != 11 ) {
                $errors[] = 'Asmens kodo ilgis turi būti 11 simbolių !';
            }

            //Check if the entered field consists only of numbers
            //if ( is_int($pcode) == false ) {
            if ( is_numeric($pcode) == false ) {
                $errors[] = 'Asmens kodas susideda tik iš skaičių !';
            }

            //Check if the first number of entered field is 1,2,3,4,5 or 6
            if ( $pcode[0]==0 OR $pcode[0] >6) {
                $errors[] = 'Asmens kodo pradžia turi būti 1,2,3,4,5 arba 6 !';
            }

            //1-st check for control code
            $controlNumber = 0;
            for ($i = 0; $i < 10; $i++) {
                $controlNumber += $i == 9 ? $pcode[$i] : $pcode[$i] * ($i + 1);                
            }
            $controlNumber = $controlNumber % 11;
            //echo 'Kontrolinis skaičius 1 yra ' . $controlNumber;
            
            if ( $controlNumber != 10 AND $controlNumber != $pcode[10] ) {
                $errors[] = 'Asmens kodo nesutapimas su kontroliniu skaičium pagal 1 formulę!';
            }

            //2-nd check for control code
            if ( $controlNumber == 10 ) {
                $controlNumber = 0;
                for ($i = 0; $i < 10; $i++) {
                    $controlNumber += $i >= 7 ? $pcode[$i] * ($i-6) : $pcode[$i] * ($i + 3);
                }
                $controlNumber = $controlNumber % 11;
                //echo 'Kontrolinis skaičius 2 yra ' . $controlNumber;             
                
                if ( $controlNumber != 10 AND $controlNumber != $pcode[10] ) {
                    $errors[] = 'Asmens kodo nesutapimas su kontroliniu skaičium pagal 2 formulę!';
                }
            }

            // 3: if the form is valid
            if(!isset($errors)){

                // Create a success message to display below in HTML (form data is protected to avoid XSS)
                $successMsg1 = 'Kontrolinis skaičius yra  ' . htmlspecialchars($pcode[10]) . ' !';

                // Create a success message to display a sex of the person
                if ( $pcode[0] % 2 == 0) {
                    $successMsg2 = 'Tai yra moteris !';
                }else{
                    $successMsg2 = 'Tai yra vyras ! !';
                }

                // Create a success message to display a birthdate of the person
                if($pcode[0]==5 OR $pcode[0]==6 ){
                    $successMsg3 = 'Gimimo data formate dd-mm-yyyy yra  ' 
                    . htmlspecialchars($pcode[5]) 
                    . htmlspecialchars($pcode[6])
                    . '-' . htmlspecialchars($pcode[3]) . htmlspecialchars($pcode[4]) 
                    . '-' . 2000 + 10 * ($pcode[1]) + ($pcode[2]);
                    $birthYear=2000 + 10 * ($pcode[1]) + ($pcode[2]);

                    if ( $birthYear % 4 != 0) {
                        echo "Gimimo metai nėra keliamieji metai";
                        $successMsg4 = 'Gimimo metai  ' . $birthYear . ' nėra keliamieji metai!';
                    }else if ( $birthYear % 100 != 0) {
                            echo "Gimimo metai yra keliamieji metai";
                            $successMsg4 = 'Gimimo metai  ' . $birthYear . ' yra keliamieji metai!';
                    }else if ( $birthYear % 400 != 0) {
                            echo "Gimimo metai nėra keliamieji metai";
                            $successMsg4 = 'Gimimo metai  ' . $birthYear . ' nėra keliamieji metai!';
                    }else {
                        echo $birthYear;
                        ?>
                        </br>
                        <?php
                        echo 'Gimimo metai '
                        . $birthYear . 
                        ' yra keliamieji metai';
                        $successMsg4 = 'Gimimo metai  ' . $birthYear . ' yra keliamieji metai!';
                    }  

                }else if($pcode[0]==1 OR $pcode[0]==2 ){
                    $successMsg3 = 'Gimimo data formate dd-mm-yyyy yra  ' 
                    . htmlspecialchars($pcode[5]) 
                    . htmlspecialchars($pcode[6]) 
                    . '-' . htmlspecialchars($pcode[3]) . htmlspecialchars($pcode[4]) 
                    . '-' . 1800 + 10 * ($pcode[1]) + ($pcode[2]);
                    $birthYear=1800 + 10 * ($pcode[1]) + ($pcode[2]);

                    if ( $birthYear % 4 != 0) {
                        echo "Gimimo metai nėra keliamieji metai";
                    }else if ( $birthYear % 100 != 0) {
                            echo "Gimimo metai yra keliamieji metai";
                    }else if ( $birthYear % 400 != 0) {
                            echo "Gimimo metai nėra keliamieji metai";
                    }else {
                        echo $birthYear;
                        ?>
                        </br>
                        <?php
                        echo 'Gimimo metai '
                        . $birthYear . 
                        ' yra keliamieji metai';
                    }  

                }else{
                    $successMsg3 = 'Gimimo data formate dd-mm-yyyy yra  ' 
                    . htmlspecialchars($pcode[5]) 
                    . htmlspecialchars($pcode[6]) 
                    . '-' . htmlspecialchars($pcode[3]) . htmlspecialchars($pcode[4]) 
                    . '-' . (1900 + 10 * ($pcode[1]) + ($pcode[2]));
                    $birthYear=1900 + 10 * ($pcode[1]) + ($pcode[2]);

                    // Calculating whether a year is a leap year
                    //function isleap( $birthYear );
       
                    if ( $birthYear % 4 != 0) {
                        echo "Gimimo metai nėra keliamieji metai";
                    }else if ( $birthYear % 100 != 0) {
                        echo "Gimimo metai yra keliamieji metai";
                    }else if ( $birthYear % 400 != 0) {
                        echo "Gimimo metai nėra keliamieji metai";
                    }else {
                        echo $birthYear;
                        ?>
                        </br>
                        <?php
                        echo 'Gimimo metai '
                        . $birthYear . 
                        ' yra keliamieji metai';
                    }  
                    // Calculating whether a year is a leap year
                //function isleap( $birthYear ){
                //    $birthYear=1900 + 10 * ($pcode[1]) + ($pcode[2]);
                //    var_dump($birthYear);
                //    if ( $birthYear % 4 != 0) {
                        //echo "Gimimo metai nėra keliamieji metai";
                    //}else if ( $birthYear % 100 != 0) {
                            //echo "Gimimo metai yra keliamieji metai";
                    //}else if ( $birthYear % 400 != 0) {
                            //echo "Gimimo metai nėra keliamieji metai";
                    //}else {
                        //echo "Gimimo metai yra keliamieji metai";
                    //}  
                //}
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal code</title>
</head>
<body>

    <?php

        // If the success messages exist, we display it, otherwise we display the form
        //var_dump($successMsg1);
        if(isset($successMsg1)){
            echo '<p style="color:green;">' . $successMsg1 . '</p>';
        }  
        if(isset($successMsg2)){
            echo '<p style="color:green;">' . $successMsg2 . '</p>';
        }
        if(isset($successMsg3)){
            echo '<p style="color:green;">' . $successMsg3 . '</p>';
        } 
        if(isset($successMsg4)){
            echo '<p style="color:green;">' . $successMsg4 . '</p>';
        }   
        // If the error table exists
        if(isset($errors)){
            // Loop through the error table and display each error in the HTML paragraph
            foreach($errors as $error){
                echo '<p style="color:red;">' . $error . '</p>';
            }
        }
                
    ?>

        <!-- HTML form in POST method -->
        <form action="form.php" method="POST">
            <input type="text" name="personalcode" placeholder="Asmens kodas">
            <input type="submit" value="Pateikti info">
        </form>
</body>
</html>