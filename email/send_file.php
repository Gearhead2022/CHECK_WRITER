
<?php

require_once "../controllers/backup.controller.php";


class connections {

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "emb_appform";
  
  
    public function connect(){
  
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
  
    }
  
  }

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../vendor/PHPmailer/PHPmailer/src/Exception.php';
require '../vendor/PHPmailer/PHPmailer/src/PHPMailer.php';
require '../vendor/PHPmailer/PHPmailer/src/SMTP.php';

// Load Composer's autoloader
require '../vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$backup_id = $_REQUEST["backup_id"];
$branch_name = $_REQUEST["branch_name"];
$new_date = $_REQUEST["new_date"];
$mail = new PHPMailer(true);

    try {

        $connection = new connections;
        $connection->connect();
     
        $sql = "SELECT * FROM backup_files WHERE backup_id ='$backup_id'";
        $stmt = $connection->connect()->query($sql);
        while($clients = $stmt->fetch()){
            $data[] = $clients['file_name'];
        }

        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'layawta2000@gmail.com'; // SMTP username
        $mail->Password = 'hueqwknbobmlledg'; // SMTP password
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPAutoTLS = false;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


        //Recipients
        $mail->setFrom('layawta2000@gmail.com', 'LayawTa');
        $mail->addAddress('fernadezjoshua0@gmail.com', 'XYZTABC'); // Add a recipient // Name is optional


        // // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = ''.$branch_name.'  '.$new_date.'';
        $mail->Body = 'Daily Backup.';

        $files_all = $data;

     
			$year = date('Y', strtotime($new_date));
			$month = date('F', strtotime($new_date));

     
        for ($i=0; $i < count($files_all); $i++) {
                    
            $file_to_send =  '../views/files/Backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$new_date.'/'.$files_all[$i];
            $attachments[] = $file_to_send;
        }
     
        foreach($attachments as $attachments) {
            $mail->addAttachment($attachments);
        }

        $mail->send();

       echo "<script> window.location.href ='../index.php?route=backups&answer=ok&backup_id=$backup_id';</script>";  
        // echo "<script>alert('Files sent to your E-Mail. Please check your email!');</script>";
    } catch (Exception $e) {
        echo "<script> window.location.href ='../index.php?route=backups&answer=error';</script>";
    }

?>