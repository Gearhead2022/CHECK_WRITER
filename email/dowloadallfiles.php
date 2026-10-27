<?php

require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
$branch_DTR = new ControllerDTR();

ob_start(); // Start output buffering

if (isset($_GET["entry_date"])) {
    $entry_date = $_GET['entry_date'];
    $has_data = (new ModelDTR)->mdlGetBranchDailyDTRUploadList($entry_date);

    $entry_date_folder = date('Y-m-d', strtotime($entry_date));

    if ($has_data === 'yes') {
        $zip = new ZipArchive();

        $zipFileName = $entry_date_folder . '.zip';
        // Add this before the if statement where the ZIP archive is created
        echo 'Debug: Creating ZIP archive<br>';

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $branchFolders = array(
                'EMB MAIN BRANCH',
                'EMB CADIZ',
                'EMB LA CARLOTA',
                'EMB KABANKALAN',
                'EMB ILOILO',
                'EMB DUMAGUETE',
                'EMB SAN CARLOS',
                'EMB TAGBILARAN',
                'EMB MANDAUE',
                'EMB ROXAS',
                'EMB SAGAY',
                'EMB VICTORIAS',
                'EMB BAYAWAN',
                'EMB BAIS',
                'EMB LA CASTELLANA',
                'EMB PASSI',
                'EMB SARA',
                'EMB SIPALAY',
                'EMB CEBU',
                'EMB TALISAY',
                'EMB TOLEDO',
                'EMB MIAG AO',
                'EMB TUBIGON',
                'EMB MAMBUSAO',
                'EMB DANAO',
                'FCH BACOLOD',
                'FCH SILAY',
                'FCH BAGO',
                'FCH MURCIA',
                'FCH BINALBAGAN',
                'FCH HINIGARAN',
                'FCH PARANAQUE',
                'FCH MUNTINLUPA',
                'RLC KALIBO',
                'RLC BURGOS',
                'RLC ANTIQUE',
                'RLC SINGCANG',
                'ELC BULACAN',
            );

            foreach ($branchFolders as $branch_name) {
                $entry_date_format_folder = date('Y-M-d', strtotime($_GET['entry_date']));
                // $file_info = (new ModelDTR)->mdlGetFileInfo($branch_name, $entry_date);

                // $entry_file = $file_info[0]["entry_file"];
                $folder = '../views/files/branchdtr/' . $branch_name . '/' . $entry_date_format_folder . '/';

                if (is_dir($folder)) {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
                    foreach ($files as $file) {
                        if (!$file->isDir()) {
                            $filePath = $file->getRealPath();
                            // $zip->addFile($filePath, basename($filePath));

                            $relativePath = substr($filePath, 46 + $cn_branch_name);
                                 // Calculate the relative path by removing the common root path
                            // $relativePath = substr($filePath, strlen($commonRootPath));
                            $zip->addFile($filePath, $relativePath);
                        }
                    }

                    echo 'Debug: Added files to ZIP - ' . $folder . '<br>';
                } else {
                    echo 'Debug: Directory does not exist - ' . $folder . '<br>';
                }

                // if (file_exists($source_path)) {
                //     // Add the file to the ZIP archive
                //     $zip->addFile($source_path . $entry_file);  

                //     // Update the database, if needed
                //     $table = "branch_dtr_upload";
                //     $entry_date_format = date('Y-m-d', strtotime($entry_date));
                //     $data = array(
                //         "id" => $file_info[0]["id"],
                //         "branch_name" => $branch_name,
                //         "entry_date" => $entry_date_format
                //     );
                //     (new ModelDTR)->mdlUpdateDTRStatus($table, $data);
                // }else{
                //     continue;
                // }
            }

            echo 'Debug: Added file to ZIP - ' . $source_path . '<br>';

            $zip->close();

            // Set headers for file download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            header('Content-Length: ' . filesize($zipFileName));

            // Read and output the file contents
           // read the zip file and output to the browser
            readfile(__DIR__ . '/' . $zipFileName);

            // delete the zip file
            unlink(__DIR__ . '/' . $zipFileName);
            ob_end_flush();

            exit();
        }
    } else {
        echo '<script>
            swal.close();
            swal({
                type: "info",
                title: "No records have been found in the specified date!",
                showConfirmButton: true,
                confirmButtonText: "Ok"
            }).then(function(result){
                if (result.value) {
                    window.location = "hrDTRDownload";
                }
            });
        </script>';
    }

    ob_end_flush();
    exit();
}
?>
