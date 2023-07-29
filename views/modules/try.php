<?php 


$weekfrom = '2023-06-01';
$weekto =  '2023-06-05';

$startDate = new DateTime($weekfrom);
$endDate = new DateTime($weekto);

$currentDate = clone $startDate;

$date = date('Y-m', strtotime($weekfrom));

$month = date('F', strtotime($weekfrom));
$dateRange = array();

while ($currentDate <= $endDate) {
    $dateRange[] = $currentDate->format('Y-m-d');
    $currentDate->modify('+1 day');
 }
    $day1 = $dateRange[0];
    $day2 = $dateRange[1];
    $day3 = $dateRange[2];
    $day4 = $dateRange[3];
    $day5 = $dateRange[4];

    $formatted_day1 = (new DateTime($day1))->format('F d');
    $formatted_day2 = (new DateTime($day2))->format('F d');
    $formatted_day3 = (new DateTime($day3))->format('F d');
    $formatted_day4 = (new DateTime($day4))->format('F d');
    $formatted_day5 = (new DateTime($day5))->format('F d');

    $dataRange = $dateRange;

        $minDate = min($dataRange);
        $yearMonth = substr($minDate, 0, 7); // Extract the year and month from the minimum date

        $startDate = new DateTime($yearMonth . '-01'); // Set the start date to the first day of the same year and month as the minimum date
        $endDate = new DateTime($minDate);
        $endDate->modify('-1 day'); // Set the end date to 1 day before the minimum date

        $Range = array();


        while ($startDate <= $endDate) {
            $formattedDate = $startDate->format('Y-m-d');
            if (!in_array($formattedDate, $dataRange)) {
                $Range[] = $formattedDate;
            }
            $startDate->modify('+1 day'); // Increment the start date by 1 day
        }

        if (empty($Range)) {

           $timestamp = strtotime($weekfrom . ' -1 month');

              // Get the first day of the previous month
              $minRange = date('Y-m-01', $timestamp);

              // Get the last day of the previous month
            $maxRange = date('Y-m-t', $timestamp);
         
      }else{

        $minRange = min($Range);
        $maxRange = max($Range);
      }


        $date1 = date('F j', strtotime($minRange));
        $date2 = date('j', strtotime($maxRange));
        $combinedDates = $date1 . '-' . $date2;

        echo $combinedDates;


    
     