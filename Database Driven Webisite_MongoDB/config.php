<?php
  $manager = new MongoDB\Driver\Manager('mongodb://username:password@localhost:27017/Transcription?authSource=Transcription') or die( "Could not connect to database");

?>
