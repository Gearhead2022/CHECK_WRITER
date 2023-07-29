<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('log_errors', 'On');
ini_set('error_log', 'log.txt');

// Set the maximum file size for the error log
ini_set('log_errors_max_size', '10M');

// Set the error log file permissions
chmod('log.txt', 0644);

// Your PHP code here


// specify the folder path and name
if(isset($_GET['branch_name']) && isset($_GET['new_date'])){
    
$branch_name = $_GET['branch_name'];
$new_date = $_GET['new_date'];


$date_now = date('F j, Y', strtotime($new_date));
                $month = date('F', strtotime($new_date));
                $year = date('Y', strtotime($new_date));

                $cn_branch_name = strlen($branch_name)+1 + strlen($year)+1 + strlen($month)+1;
                
$folder = '../views/files/backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$date_now.'';

// create a new zip archive
$zip = new ZipArchive();
$zipname = ''.$branch_name.' '.$date_now.'.zip';

// open the archive and add files to it
if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
    
    for ($i=0; $i <2 ; $i++) { 
        # code...

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
    foreach ($files as $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, 43 + $cn_branch_name);
            $zip->addFile($filePath, $relativePath);
        }
        
    }
}
    $zip->close();

    // set the appropriate headers for file download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($zipname).'"');
    header('Content-Length: ' . filesize($zipname));

    // read the zip file and output to the browser
    readfile(__DIR__ . '/' . $zipname);

    // delete the zip file
    unlink(__DIR__ . '/' . $zipname);
} else {
    echo 'Error creating zip archive';
}
}else{
    echo "ERROR";
}
?>
