<?php include '../includes/session.php' ?>
<?php 

  $conn = $pdo->open();

if((isset($_POST['submit'])))
{
$Name = ($_POST['name']);
$Email = ($_POST['email']);
$comments = ($_POST['text']);

$stmt = $conn->prepare("INSERT INTO contactus (name, email, comments) VALUES ('".$Name."','".$Email."', '".$comments."')");

if(!$result = $stmt->execute()){
die('Error occured [' . $conn->error . ']');
}
else
   echo "Mulțumim pentru contactare! Vă vom trimtie un e-mail cu răspunsul.";
}

?>

