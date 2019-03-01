<html>
<style>
div
{
  border-radius:5px;
}
.header{
    background-color: #d0edff;
    padding: 30px;
    text-align: center;
    font-size: 18px;
    font-family: sans-serif;
}
.general{
    background-color: #d0edff;
    padding: 30px;
    font-size: 18px;
    font-family: sans-serif;
    text-align: center;

}
.row {
  display: flex; /* equal height of the children */
}
.Acol {
  flex: 10; /* additionally, equal width */
  padding: 1em;
  border: solid;
  border-width: 2px;;
  background-color: #e6a4fb;
}
.Bcol {
  flex: 10; /* additionally, equal width */
  padding: 1em;
  border: solid;
  border-width: 2px;
  background-color: #989afe;
}
</style>

<div class="general">
<title>pageTwo</title>
<body>
<?php
if(isset($_POST['public_g'])){
  $g = (int)$_POST['public_g'];
}

if(isset($_POST['public_p'])){
  $p = (int)$_POST['public_p'];
}

#fast power alogrithm
function fastPower($g,$A,$N){
    $a = $g;
    $b =1;
    while ($A > 0){
      if ($A%2 == 1){
        $b = ($b*$a)%$N;
      }
      $a = ($a*$a)%$N;
      $A = floor($A/2);
    }
    return $b;
}

#use xorbit to produce the encryption
function xorbit($binary,$key){
    $ciphertext = "";
    #foreach(range(1,strlen($binary)) as $i){
    for ($i=0; $i < strlen($binary); $i++){
      $binary[$i] = (int)$binary[$i]^(int)$key[$i % strlen($key)];
      $binary[$i] = (string)$binary[$i];
      $ciphertext = $ciphertext.$binary[$i];
    }
    return $ciphertext;
  }

$secretKeyA = 0;
if(isset($_POST['secretKeyA'])){
  $secretKeyA = (int)$_POST['secretKeyA'];
}
print<<<PAGE
<div class="row">
<div class="Acol">
PAGE;
print("Alice's secret key 'a' (entered in the previous page): $secretKeyA <br/>");
print("The public variable 'g': $g <br/>");
print("To calculate Alice's public key, take the public variable 'g' and raise it to the power of her secret key 'a' modulo p:<br/>");
$A = fastPower($g,$secretKeyA,$p);
print("Alice's public key 'A': $g^$secretKeyA = $A (mod $p) <br/><br/> ");
print<<<PAGE
</div>
PAGE;

$secretKeyB = 0;
if(isset($_POST['secretKeyB'])){
  $secretKeyB = (int)$_POST['secretKeyB'];
}
print<<<PAGE
<div class="Bcol">
PAGE;
print("Bob's secret key 'b' (entered in the previous page): $secretKeyB <br/>");
print("The public variable 'g': $g <br/>");
print("To calculate Bob's public key, take the public variable 'g' and raise it to the power of his secret key 'b' modulo p:<br/>");
$B = fastPower($g,$secretKeyB,$p);
print("Bob's public key 'B': $g^$secretKeyB = $B (mod $p) <br/><br/> ");
print<<<PAGE
</div>
</div>
PAGE;

print("<br/>");
print("After getting their public keys 'A' and 'B', calculate shared keys.<br/><br/>");

print<<<PAGE
<div class="row">
<div class="Acol">
PAGE;
print("When Alice calculates her shared key, she needs to use Bob's public key 'B' and raise it to the power of her secret key 'a' modulo p:<br/>");
print("Bob's public key 'B': $B <br/>");
print("Alice's secret key 'a': $secretKeyA <br/>");
$shared_key_fromA = fastPower($B,$secretKeyA,$p);
print("Alice's shared key: $B^$secretKeyA = $shared_key_fromA (mod $p) <br/><br/>");
print<<<PAGE
</div>
PAGE;

print<<<PAGE
<div class="Bcol">
PAGE;
print("When Bob calculates his shared key, he needs to use Alice's public key 'A' and raise it to the power of his secret key 'b' modulo p:<br/>");
print("Alice's public key 'A': $A <br/>");
print("Bob's secret key 'b': $secretKeyB <br/>");
$shared_key_fromB = fastPower($A,$secretKeyB,$p);
print("Bob's shared key: $A^$secretKeyB = $shared_key_fromB (mod $p) <br/><br/>");
print<<<PAGE
</div>
</div>
PAGE;

print("<br/>");
print("<b>Their shared keys should have the same values.</b><br/><br/>");


print("<b> Application: Encrypt message using XOR cipher</b><br/><br/>");
print("We are going to use the shared key $shared_key_fromB to encrypt the message.<br/>");
$zero = "0";
$binString = decbin($shared_key_fromB);
while (strlen($binString) % 8 != 0){
    $binString = $zero.$binString;
  }
print("Firstly, covert the shared key from the decimal format to the binary format.<br/>");
print("The binary format of the shared key: $binString <br/><br/>");

$messageString = "Thanks";
print("The message we are going to encrypt: <b>$messageString</b>.<br/>");
$messageString = array("T","h","a","n","k","s");
$messageBinary = "";

print("Secondly, convert the message into the binary format.<br/>");
foreach ($messageString as $i){
 $messageBin = decbin(ord($i));
 while (strlen($messageBin) % 8 != 0){
     $messageBin = $zero.$messageBin;
     $messageBinary = $messageBinary.$messageBin;
   }
}
print("The binary format of the mesaage: $messageBinary<br/><br/>");

print("Finally, we use XOR cipher to encrypt the message by using the shared key.<br/>");
$xor_binary = xorbit($messageBinary,$binString);
print("The XOR cipher binary: $xor_binary<br/><br/>");
print<<<PAGE
<img src="https://media.giphy.com/media/13qctMBrrgbwJi/giphy.gif" title="thank you" width="300" height="300" />
<h4> By Jean Huang<h4/>
PAGE;
?>
</div>
</body>
</html>
<!-- credit: https://media.giphy.com/media/13qctMBrrgbwJi/giphy.gif -->
<!--<img src="http://i.stack.imgur.com/SBv4T.gif" title="this slowpoke moves" /> -->
