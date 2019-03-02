<html>
<style>
input[type = submit]{
   width:20%;
   background-color: #37b679;
   color: white;
   padding:20px 30px;
   margin: 20px 0;
   border: none;
   border-radius:20px;
   cursor: pointer;
   font-size: 16px;
   font-weight: bold;
}
input[type = reset]{
   width:20%;
   background-color: #37b679;
   color: white;
   padding:20px 30px;
   margin: 20px 0;
   border: none;
   border-radius:20px;
   cursor: pointer;
   font-size: 16px;
   font-weight: bold;
}
input[type=submit]:hover{
  background-color: #2d825a;
}
input[type=reset]:hover{
  background-color: #2d825a;
}
div{
  border-radius:5px;
}
div.header{
    background-color: #e8ffc7;
    padding: 20px;
    text-align: center;
    font-family:serif;
    font-size: 18px;
}
div.general{
    background-color: #e8ffc7;
    padding: 30px;
    text-align: center;
    font-size: 18px;
    font-family: sans-serif;
}

</style>


<?php

print<<<PAGE
<html>
<div class = "general">
<head>
<title>Update Information</title>
</head>
<h1>Update Information</h1><br/>
<body>
PAGE;

include 'config.php';

$selectedImages = array();
if(isset($_POST['checkbox']))
  {
    $checkbox = $_POST['checkbox'];
    if(empty($checkbox))
      {
        print("You didn't select any image.");
      }
    else
    {
      print("Checkbox is receivable from pageTwo: \n");
      $N = count($checkbox);
      print("you selected $N images.<br/>");
      foreach ($checkbox as $i)
      {
        $checkboxId =$i;
        #print("<br/> check type of checkboxId<br/>");
        #print(gettype($checkboxId));
        print("<br/>");
        array_push($selectedImages, $checkboxId);
      }
      #print("checkboxPath: \n <br/>");
      #print_r($selectedImages);
      #print("<br/>check type of selectedImages: <br/> ");
      #print(gettype($selectedImages));
    }
  }
if(isset($_POST['textLabel']))
  {
    $textLabel = $_POST['textLabel'];
    if(empty($textLabel))
    {
      print("You didn't type any textual label!<br/>");
      print<<<PAGE
      <img src="SBv4T.gif"/>
      </div>
      <div class = "general">
      <form action = "pageOne.php" method = "POST">
      <input type="submit" name = "Back" value="Back to Main Page">
      </form>
      </body>
      </div>
      </html>
PAGE;
    }
    elseif (empty($checkbox)) {
      print("You didn't select any checkbox!<br/>");
      print<<<PAGE
      <img src="SBv4T.gif"/>
      </div>
      <div class = "general">
      <form action = "pageOne.php" method = "POST">
      <input type="submit" name = "Back" value="Back to Main Page">
      </form>
      </body>
      </div>
      </html>
PAGE;
    }
    else
    {
      print("Textual label is receivable from pageTwo: \n");
      print($textLabel."<br/>");
      $bulk = new MongoDB\Driver\BulkWrite();
      #print_r($bulk);
      #print("<br/><br/>");
      #print_r($manager);
      #print("<br/><br/>");
      $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
      #print_r($writeConcern);
      #print("<br/><br/>");

      $i = 0;
      foreach($selectedImages as $partialPath){
        #print("The image you choose: " . $partialPath);
        print("<br/><br/>");
        $bulk->update(['file.anonPath' =>  array('$regex' => $partialPath)], ['$set' => ['clusters_r37_mcs100.textLabel' => $textLabel]], ['multi' => false, 'upsert' => false]);
        $result = $manager->executeBulkWrite('CSHTranscription.meetingMinuteWords', $bulk, $writeConcern);
        $i++;
      }
      printf("Total matched %d document(s)\n", $result->getMatchedCount());

      print("<br/> '$textLabel' has added to the $i images you selected.<br/>");

      print<<<PAGE
      </div>
      <div class = "general">
      <form action = "pageOne.php" method = "POST">
      <input type="submit" name = "Back" value="Back to Main Page">
      </form>
      </body>
      </div>
      </html>
PAGE;
    }
  }
?>
