<?php

function convertToWords($number) {
    // Array containing words for numbers up to nineteen
    $ones = array(
        0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
        6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
        11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
        15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'
    );

    // Array containing words for tens
    $tens = array(
        20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
        60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );

    // Array containing words for larger denominations
    $thousands = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion');

    // Splitting the number into dollars and cents
   $separetor = explode('.', $number);
   $num_elements = count($separetor);
   if($num_elements >1){
    list($dollars, $cents) = explode('.', $number);
   }else{
    list($dollars) = explode('.', $number);
    $cents =0;
   }

    // Converting dollars part to words
    $dollars_in_words = '';

    if ($dollars == 0) {
        $dollars_in_words = 'zero dollars';
    } else {
        $dollars_in_words = convertNumberToWords($dollars, $ones, $tens, $thousands);
    }

    // Converting cents part to words
    $cents_in_words = '';

    if ($cents == 0) {
        $cents_in_words = 'ONLY';
    } else {
        $cents_in_words = '& ' . $cents . '/100';
    }

    return ucwords($dollars_in_words . ' ' . $cents_in_words);
}

function convertNumberToWords($number, $ones, $tens, $thousands) {
    $result = '';

    $number_length = strlen($number);

    // Loop through the number in groups of three digits
    $group_count = ceil($number_length / 3);
    $number_chunks = str_split(str_pad($number, $group_count * 3, '0', STR_PAD_LEFT), 3);

    // Process each group of three digits
    foreach ($number_chunks as $key => $chunk) {
        $chunk_number = (int)$chunk;
        if ($chunk_number != 0) {
            $result .= convertThreeDigitNumberToWords($chunk_number, $ones, $tens, $thousands[$group_count - $key - 1]);
            if ($key < $group_count - 1) {
                $result .= ' ' . $thousands[$group_count - $key - 1];
            }
            $result .= ' ';
        }
    }

    return trim($result);
}

function convertThreeDigitNumberToWords($number, $ones, $tens, $thousands) {
    $result = '';

    // Extracting hundreds
    $hundreds = floor($number / 100);
    if ($hundreds > 0) {
        $result .= $ones[$hundreds] . ' hundred';
    }

    // Extracting tens and ones
    $remainder = $number % 100;
  
    if ($remainder > 0) {
        if ($hundreds > 0) {
            $result .= ' ';
        }

        if ($remainder < 20) {
            $result .= $ones[$remainder];
        } else {
            $tens_digit = floor($remainder / 10) * 10;
            $result .= $tens[$tens_digit];
          
            if (isset($ones[$remainder % 10])) {
                if($remainder % 10 == 0){
                    $result .= ' ' . $ones[$remainder % 10];
                }else{
                    $result .= '-' . $ones[$remainder % 10];
                    
                }
                
            }
        }
    }

    return $result;
}

// Example usage
$amount = 342333.50;
echo convertToWords($amount);
?>
