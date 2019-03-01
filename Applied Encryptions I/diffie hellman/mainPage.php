<html>
<style>
input[type = submit]{
   width:20%;
   background-color: #39b1fd;
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
   background-color: #39b1fd;
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
  background-color: #027fce;
}
input[type=reset]:hover{
  background-color: #027fce;
}
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

<div class="header">
<title> Diffie Hellman</title>
<h1> Introduction to Diffie Hellman</h1>
<body>
  <h2> What is Diffie Hellman</h2>
</div>

<div class="general">
<p> <h3>Introduction</h3>
  Diffie Hellman is a security method of exchanging key between two parties without sharing information directly (Techopedia).
  After the encryption, in the unsecured communicating environment,
  one party can use their shared key to decrypt and read the information sent from the other party.</p>

<h3>Example</h3>
<p>Alice and Bob represnt two parties. They agree on using the public numbers 'p' (assume as a prime number) and 'g' (base).
  Alice chooses her secret key 'a' and Bob also chooses his secret key 'b'. Then, Alice calculates her public key A = g^a (mod p) while Bob calculate his public key B = g^b (mod p).
  After that, they exchange their public key A and B to each other. Alice and Bob use their own secret keys to calculate their shared key:
  Alice: B^a (mod p) and Bob: A^b (mod p). </p>
<div>

<div class="header">
<img src="DH.png" alt="Diffie Hellman Example">

<form action = "pageTwoDH.php" method = "POST">
<h4>Let's have a try!</h4>
<p>Please enter the public variable g and p: </p>
<p>The public 'g': </p>
<input type = "text" name = "public_g"> <br/>
<p>The public 'p': </p>
<input type = "text" name = "public_p"> <br/>
</div>

<div class="row">

<div class="Acol">
<p> Suppose you are Alice, you need to create a secret key.<br/> <br/>
    Please create your secret key (as Alice): </p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
  <input type = "text" name = "secretKeyA" > <br/><br/>
</div>

<div class="Bcol">
<p> Suppose you are Bob, you also need to create another secret key.<br/><br/>
    Please create your secret key (as Bob): </p>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
  <input type = "text" name = "secretKeyB" > <br/><br/>
</div>
</div>

<div style="text-align:center">
  <input type= "submit" name = "submit" value="Submit" >
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
  <input type = "reset" name = "Reset" >
</div>
</form>
</body>
</html>
<!-- credit: https://www.techopedia.com/definition/16085/diffie-hellman-key-exchange -->
