<?php
if (isset($_POST['image_url'])) {
  $image_url = $_POST['image_url'];

  // get image data
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $image_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $image_data = curl_exec($ch);
  curl_close($ch);

  // send image as file download
  header('Content-Type: application/octet-stream');
  header('Content-Transfer-Encoding: Binary');
  header('Content-disposition: attachment; filename="image.jpg"');
  echo $image_data;
}