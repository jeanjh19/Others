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
div
{
  border-radius:5px;
}
.header{
    background-color: #e8ffc7;
    padding: 20px;
    text-align: center;
    font-family:serif;
    font-size: 18px;
}
.general{
    background-color: #e8ffc7;
    padding: 30px;
    text-align: center;
    font-size: 18px;
    font-family: sans-serif;
}
.scroll
{
  background-color: #FFFAC7;
  width: 1220px;
  height: 320px;
  padding: 20px;
  overflow:scroll;
  position: relative;
}
.text
{
  float:left;
  padding: 5px;
  /*text-align: left;*/
  font-family: sans-serif;
  margin-right: 50px;
  word-break: break-all;
}
</style>
<div class="header">
<head>
  <title>Main Page</title>
</head>
<h1>Choose the Cluster Id</h1>
<h2>Current Reference:</h2>
</div>
<div class="scroll">
<body>
  <?php

  include 'config.php';

  $connection = new MongoDB\Driver\Command(
    ['aggregate'=> 'meetingMinuteWords',
      'pipeline'=>[['$group'=>['_id'=> '$clusters_r37_mcs100.clusterId',
                                'total'=> ['$sum'=>1]]]
    ]]);


  $cursor = $manager->executeCommand('Transcription',$connection);


  $clusters = "";

  foreach ($cursor as $result){
    $clusters = json_decode(json_encode($result),true);
  }
  //print_r($clusters);
  $clusters = $clusters['result'];
//上面自定义函数中，$a<$b如果正确返回1，说明$a"大于"$b，则按照顺序$b->$a来排序，以$a为基准，降序；如果错误返回-1，说明说明$a"小于"$b，则按照顺序$a->$b来排序,以$a为基准，升序。//
  function id_cmp($a, $b){
      if ($a["_id"] == $b["_id"]) {
          return 0;
      }
      else if ($a["_id"] < $b["_id"]){
          return -1;
      }
      else{
          return 1;
      }
  }
  $newClusters = usort($clusters, "id_cmp");


  foreach ($clusters as $clusterInfo){
  print("<div class = 'text'>");
  print("Cluster Id: " . $clusterInfo['_id'] ."  "."Count: " . $clusterInfo['total'] ."<br/>");
  print("</div>");
  }

  ?>
</div>
<div class="general">
<p>Please enter the cluster id:  </p>
<form action = "pageTwo.php" method = "post">
  <input id = "idNumber" type = "number" name = "idNumber"> <br/> <br/>
  <input type = "submit" name = "Submit" value = "Submit"> &nbsp; &nbsp; &nbsp; &nbsp;
  <input type = "reset" name = "Reset">
</form>
<div>
</body>
</html>
