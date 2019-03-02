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
div.scroll
{
  background-color: #FFFAC7;
  width: 1220px;
  height: 320px;
  padding: 20px;
  text-align: center;
  font-family: sans-serif;
  overflow:scroll;
  position: relative;
}
img
  {
    max-width:200px;
    height: auto;
    margin: 10px 5%;
  }
</style>

<?php
print<<<PAGE
  <html>
  <div class = "header">
  <head>
  <title>Select Images</title>
  </head>
  <h1>Please select the images you would like to choose: </h1><br/>
  </div>
  <div class = "scroll">
  <body>
PAGE;

  include 'config.php';

  $idNumber = 0;
  if(isset($_POST['idNumber'])){
    $idNumber = (int)$_POST['idNumber'];
    if($idNumber > 673){
      print("Your cluster id $idNumber is out of range! It should be no more than 673.<br/><br/>");
      print<<<PAGE
      <img src="SBv4T.gif"/>
      </div>
      <div class = "general">
      <form action = "pageOne.php" method = "POST">
      <input type="submit" name = "Back" value="Back to Main Page">
PAGE;
    }
    else{
      $filter = ['clusters_r37_mcs100.clusterId' => $idNumber];
      $options = ['projection'=>['file.anonPath' => 1, '_id' => 0,'clusters_r37_mcs100.algorithm'=> 2,
                    'clusters_r37_mcs100.clusterId'=> 3,'clusters_r37_mcs100.textLabel'=>4]];
      $query = new MongoDB\Driver\Query($filter, $options);
      #print_r($query);

      $executeQuery = $manager->executeQuery('Transcription.meetingWords', $query);

      $images = array();
      $textRecords = array();
      foreach ($executeQuery as $document)
      {
          $image = json_decode(json_encode($document),true);
          array_push($images, $image['file']['anonPath']);
          array_push($textRecords,$image['clusters_r37_mcs100']['textLabel']);
      }
      //print_r($textRecord);
    print<<<PAGE
    <form action = "pageThree.php" method = "POST">
PAGE;

    if (isset($idNumber)){
      echo "The Cluster Id you choose:  ".$idNumber."<br/>";
    }

    foreach (array_combine($images, $textRecords) as $imageInfo => $textRecord)
    {
     $imageFileName = basename($imageInfo);
     echo "<img src='images/$imageFileName'/>";
     print("<br/>");
     if($textRecord == NULL){
       print("textual label already in the database: null");
     }
     else{
       print("textual label already in the database: $textRecord\n");
     }
     echo " <p>
           <input type = 'checkbox' name = 'checkbox[]' value = $imageFileName />
           </p>";
    }

    print<<<PAGE
    </div>
      <div class = "general">
      <p>Type the textual label for the above images you checked: </p>
      <input type = "text" name = "textLabel">
      <br/>
      <input type="submit" name = "submit" value="Submit">
      &nbsp; &nbsp; &nbsp; &nbsp;
      <input type = "reset" name= "Cancel" value = "Reset">
      </form>
      </body>
      </div>
      </html>
PAGE;
    }
  }

?>
