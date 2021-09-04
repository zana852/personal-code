// Calculating whether a year is a leap year
function isleap( $birthYear ){
    if ( $birthYear % 4 != 0) {
        echo "Gimimo Metai nėra keliamieji metai";
    }else if ( $birthYear % 100 != 0) {
        echo "Gimimo Metai yra keliamieji metai";
    }else if ( $birthYear % 400 != 0) {
        echo "Gimimo Metai nėra keliamieji metai";
    }else {
        echo "Gimimo Metai yra keliamieji metai";
    }             
}