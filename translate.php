<?php
function t($t,$l){
  include('config.inc');
  require_once('lib/bing.translate.php');
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "SELECT * FROM mv_translations WHERE language = '".$l."' AND english = '".mysqli_real_escape_string($conn,$t)."'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $translation = $row["translation"];
    }
  } else {
    $BingTranslator = new BingTranslator($bing_app_id, $bing_secret);
    $translation = $BingTranslator->getTranslation($default_lang, $l, $t);
    $sql = "INSERT INTO mv_translations (language, english, translation) VALUES ('".$l."','".mysqli_real_escape_string($conn,$t)."','".mysqli_real_escape_string($conn,$translation)."')";
    $conn->query($sql);
  }
  $conn->close();
  return $translation;
}
?>
