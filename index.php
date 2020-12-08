<!DOCTYPE HTML><html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  </head>
<body>

<!-- This code is derived from the implementation on the ESP32 - On the ESP32 the CAT functions 
are implemented by an ad-hoc ESP32 library. On the Raspberry Pi the CAT functions are implemented by the HAMLIB library (rigctld and rigctl programs) --> 

<!-- It is the FT-857D image. Clickable zones and actions on click (call of a Javascript function)  are defined with the map item -->

<div class="DFT857">
 <img src="FT857D2.jpg" alt="FT857" usemap="#FT857">
 <map name="FT857">
    <area shape= "rect" coords= "390,40,469,78" onclick="openModeForm()">
    <area shape= "rect" coords= "522,40,603,78" onclick="openModeForm()">
    <area shape= "rect" coords= "785,40,865,78" onclick="togglefast()">
    <area shape= "rect" coords= "1050,10,1200,50" onclick="openFreqForm()">
    <area shape= "rect" coords= "380,360,510,420" onclick="toggleVFO()">
    <area shape= "rect" coords= "550,360,680,420" onclick="vfoAeqB()">
    <area shape= "rect" coords= "730,360,860,420" onclick="togglesplit()">
    <area shape= "rect" coords= "160,240,260,285" onclick="toggleclar()">
 </map>
 </div>

<! This button is to manage the PTT  function on the FT-857 -->

<div class="xmit">
  <p> <button class="button2" type="button" onclick="togglePTT()">PTT</button> </p>
  </div>

<!-- This is the image of the red LED which is only displayed when Tx is ON.
The div display parameters are defined in the CSS file -->

 <div class="red-led" id="redimg">
 <img src="redLED.jpg" alt="Tx">
 </div>

<!-- The "fond_affichage" div display parameters are defined in the CSS file.
  "fond_affichage" is an an orange rectangle with rounded corners -->

 <div class="fond_affichage"> </div>

 <!-- The various radio parameters are displayed in lines on top of the "fond d'affichage" div.
 Each line is a table.
 The parameter name (temlate placehoder) which is updated by the GET request is defined between %
 The related div display parameters are defined in the CSS file -->

 <div class="afpremligne">
 <table>
 <colgroup>
 <col style="width:80px;text-align: center;">
 <col style="width:56px;text-align: center;">
 <col style="width:56px;text-align: center;">
 <col style="width:56px;text-align: center;">
 <col style="width:56px;text-align: center;">
 <col style="width:56px;text-align: center;">
 <col style="width:36px;text-align: center;">
 <col style="width:30px;text-align: center;">
 </colgroup>
 <tr>
<td id="smeter"></td>
<td id="split"></td>
<td id="dnf"></td>
<td id="dnr"></td>
<td id="dbf"></td>
<td id="kyr"></td>
<td id="bk"></td>
<td id="rxtx"></td>
 </tr>
 </table>

 </div>

 <div class="afdeuxligne">
 <table>
 <colgroup>
 <col style="width:55px;text-align: right;">
 <col style="width:65px;text-align: left;">
 <col style="width:55px;text-align: left;">
 </colgroup>
 <tr>
<td>VFO</td>
<td id="vfo"></td>
<td id="mode"></td>
</tr>
</table>

 </div>

 <div class="affreq">
 <table>
 <colgroup>
 <col style="width:100px;text-align: right;">
 <col style="width:200px;text-align: right;">
 <col style="width:25px;text-align: center;">
 </colgroup>
 <tr>
<td>   </td>
<td id="freq"></td>
<td id="clar"></td>
</tr>
</table>

 </div>

 <div class="afdernligne">
    <table>
 <colgroup>
 <col style="width:170px;text-align: center;">
 <col style="width:170px;text-align: center;">
 <col style="width:70px;text-align: center;">
 <col style="width:20px;text-align: right;">
 </colgroup>
 <tr>
<td>A/B</td>
<td>A=B</td>
<td>SPL</td>
<td id=fast></td>
</tr>
</table>
 </div>
 <div id="freq1"> </div>
 </div>

 <!-- Form to select the mode (radio button).
 An invisible window invis-iframe is activated.
 The div display parameters are defined in the CSS file -->

<div class="form-popup">
  <form id="SelectMode" action="setmode.php" target="invis-iframe">
  <p> <input type="radio" name="Fmode" value="1" checked id="USB">
  <label for="USB">USB</label>
  <input type="radio" name="Fmode" value="2" id="LSB">
  <label for="LSB">LSB</label>
  <input type="radio" name="Fmode" value="3" id="FM">
  <label for="FM">FM</label>
  <input type="radio" name="Fmode" value="4" id="CW">
  <label for="CW">CW</label>
  <input type="radio" name="Fmode" value="5" id="CWR">
  <label for="CWR">CWR</label>
  <input type="radio" name="Fmode" value="6"  id="AM">
  <label for="AM">AM</label>
  <input type="radio" name="Fmode" value="7" id="DIG">
  <label for="DIG">DIG</label> </p>
  <p> <button class="button1" type="submit" onclick="setmode()" >Valider</button>
  <button class="button2" type="button" onclick="closeModeForm()">Annuler</button>
  </p>

  </form>
  </div>

  <!-- Form to input the new frequency in kHz between 150 kHz and 460 MHz.
  An invisible window invis-iframe is activated.
  The div display parameters are defined in the CSS file -->

  <div class="form-popup-freq">
  <form id="InputFreq" action="setfreq.php" target="invis-iframe">
  <p> <input type="number" name="FFreq" id="rfreq" min="150" max="460000"> </p>
  <p> <label for="rfreq">Entrer la fréquence en kHz <br>Exemple 14250 pour 14250 kHz</label> </p>

  <p> <button class="button1" type="submit" onclick="setfreq()" >Valider</button>
  <button class="button2" type="button" onclick="closeFreqForm()">Annuler</button>
  </p>

  </form>
  </div>

  <!-- A target window is compulsory in a form. The two above forms activate this
  invisible window invis-iframe.
  The div display parameters are defined in the CSS file -->

  <iframe class="invis" name="invis-iframe"></iframe>

  <!-- Inclusion of the Javascript function to manage the VFO dial -->

<script src="jogDial.js" type="text/javascript"> </script>


<script>

var SPLIT=false;
var CLAR=" ";
var RxTx =0;
var curfreq=0;
var updfreq=0;
var curmode="";
var dispcurmode="";

function displayfreq(Str_frequency) {
    var Formatted_freq = "";
    var length =  Str_frequency.length;
    var MHz =  "";
    var kHz = Str_frequency.slice(length-7,length-4);
    var dHz = Str_frequency.slice(length-4,length-2);
    if (length > 7) {
    MHz = Str_frequency.slice(0,length-7);
    Formatted_freq = MHz + "." + kHz + "." + dHz;
    }
    else {
    Formatted_freq = kHz + "." + dHz;}
    return Formatted_freq;
}

 function displaySmeter(S_value) {
var Smeter_val = "";
var level = Number(S_value) + 20;
var smeter = [
   {db:00, txt:"S0"},
   {db:06, txt:"S1"},
   {db:12, txt:"S2"},
   {db:18, txt:"S3"},
   {db:24, txt:"S4"},
   {db:30, txt:"S5"},
   {db:36, txt:"S6"},
   {db:42, txt:"S7"},
   {db:48, txt:"S8"},
   {db:54, txt:"S9"},
   {db:60, txt:"S9+5"},
   {db:66, txt:"S9+10"},
   {db:72, txt:"S9+20"},
   {db:78, txt:"S9+25"},
   {db:84, txt:"S9+30"},
   {db:90, txt:"S9+35"},
   {db:96, txt:"S9+40"},
   {db:102, txt:"S9+50"},
   {db:108, txt:"S9+55"},
];
if (level < 6) {Smeter_val = smeter[0].txt;}
if (level >= 6 && level < 12) {Smeter_val = smeter[1].txt;}
if (level >= 12 && level < 18) {Smeter_val = smeter[2].txt;}
if (level >= 18 && level < 24) {Smeter_val = smeter[3].txt;}
if (level >= 24 && level < 30) {Smeter_val = smeter[4].txt;}
if (level >= 30 && level < 36) {Smeter_val = smeter[5].txt;}
if (level >= 36 && level < 42) {Smeter_val = smeter[6].txt;}
if (level >= 42 && level < 48) {Smeter_val = smeter[7].txt;}
if (level >= 48 && level < 54) {Smeter_val = smeter[8].txt;}
if (level >= 54 && level < 60) {Smeter_val = smeter[9].txt;}
if (level >= 60 && level < 66) {Smeter_val = smeter[10].txt;}
if (level >= 66 && level < 72) {Smeter_val = smeter[11].txt;}
if (level >= 72 && level < 78) {Smeter_val = smeter[12].txt;}
if (level >= 78 && level < 84) {Smeter_val = smeter[13].txt;}
if (level >= 84 && level < 90) {Smeter_val = smeter[14].txt;}
if (level >= 90 && level < 96) {Smeter_val = smeter[15].txt;}
if (level >= 96 && level < 102) {Smeter_val = smeter[16].txt;}
if (level >= 102 && level < 108) {Smeter_val = smeter[17].txt;}
if (level == 108) {Smeter_val = smeter[18].txt;}
if (level > 108) {Smeter_val = "S9+60";}


   return Smeter_val;
} 


/* The forms become visible when the corresponding button is clicked. The property display is then set to block.
When the input is validated or cancelled the form display property is set to none */


function openModeForm() {
  var form1 = document.getElementsByClassName("form-popup")
  form1[0].style.display = "block";}

function closeModeForm() {
  var form2 = document.getElementsByClassName("form-popup")
  form2[0].style.display = "none";}

function openFreqForm() {
  var form1 = document.getElementsByClassName("form-popup-freq")
  form1[0].style.display = "block";}

function closeFreqForm() {
  var form2 = document.getElementsByClassName("form-popup-freq")
  form2[0].style.display = "none";}


function setmode () {

  closeModeForm();
  }

function setfreq () {

  closeFreqForm();
  }

  /* the FAST management is done locally in the client application.
  The rotation number obtained from jogdial.js is either multiply by 0.8 or by 3.
  If FAST is active an animated GIF is visible on the last line of the display.
  To do that the HTML of the table item "fast" is modified by inserting the GIF */

  function togglefast () {

  if (fast == true) {fast = false;mult = 0.8;
                     document.getElementById("fast").innerHTML = "";}
  else
  	{fast = true;mult = 3;
        document.getElementById("fast").innerHTML = "<img src=\"run.gif\" alt=\"fast\">";}

}

/* The request to toggle the VFO is sent to the server.
No response is awaited. As the HAMLIB library is bugged a work around is done by a .bat file
Due to another HAMLIB bug the VFO status can not be read */

function toggleVFO () {
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "cmdtogglevfo.php", true);
  xhttp.send();
}

/* the request to set VFO A = VFO B is sent to the server :
data of current VFO are copied to the other VFO */

function  vfoAeqB () {
var xhttp = new XMLHttpRequest();
xhttp.open("GET", "rigctl.php?q=I+" + curfreq * 10 , true);
xhttp.send();
var xhttp1 = new XMLHttpRequest();
xhttp1.open("GET", "rigctl.php?q=X+" + curmode + "+0", true);
xhttp1.send();
}

/* The request to toggle SPLIT is sent to the server.
No response is awaited. The clarifier status will be updated by the setInterval function */

function togglesplit () {
  var xhttp = new XMLHttpRequest();
  if (SPLIT == false) {
  xhttp.open("GET", "riggetstate.php?q=S 1 VFO", true);
  SPLIT = true;}
  else
  {xhttp.open("GET", "riggetstate.php?q=S 0 VFO", true);
  SPLIT = false;}
  xhttp.send();
}

/* The request to toggle the clarifier is sent to the server.
No response is awaited.  */

function toggleclar () {
  var xhttp = new XMLHttpRequest();
  if (CLAR == " ") {
  xhttp.open("GET", "riggetstate.php?q=J 1", true);
  document.getElementById("clar").innerHTML = "-"; 
  CLAR = "-";}
  else
   {xhttp.open("GET", "riggetstate.php?q=J 0", true);
   CLAR  = " ";
   document.getElementById("clar").innerHTML = " ";}
  xhttp.send();
   }
/* the request to set On or OFF the PTT is sent to the server; no response is awaited
   the status Rx/Tx is updated by the periodic polling */

function togglePTT () {
  var xhttp = new XMLHttpRequest();
  if (RxTx ==  0) {
  xhttp.open("GET", "rigctl.php?q=T 1", true);
  }
  else {
  xhttp.open("GET", "rigctl.php?q=T 0", true);
  }
  xhttp.send();
}

/* This function activated every 600 ms will send requests to the server to get each of
the FT-857 parameters. Each parameter is updated once a valid response received.
It also sends the frequency modifications done through the VFO dial (jogDial.js) */

/* This implementation is straightforward : one parameter - one request.
May-be it could be optimized as it generates many requests */

setInterval(function ( ) {

  /* calculation of the frequency variation done by the VFO dial.
  If not 0 sends a request to the server */

var xhttp12 = new XMLHttpRequest();
  if ((current_rotation-prev_rotation) != 0) {frequpdate = (current_rotation-prev_rotation) * mult;
  prev_rotation = current_rotation;
  curfreq = (curfreq + Math.round(frequpdate));
  frequpdate = 0;
  updfreq = curfreq * 10;
  xhttp12.open("GET", "rigctl.php?q=F+" + updfreq, true);
  xhttp12.send();
   }

  var xhttp1 = new XMLHttpRequest();

/* processing of the response : the actual value sent by the server is processed
if the response has a valid status (radio mode in this case) */

  xhttp1.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    var modelength = this.responseText.length;
    curmode  = this.responseText.slice(0,modelength-3);
    if (curmode == "PKTUSB" || curmode == "PKTLSB") {
    dispcurmode = "DIG";}
    else
   {dispcurmode = curmode;}
   document.getElementById("mode").innerHTML = dispcurmode;
    }
  };
  xhttp1.open("GET", "riggetstate.php?q=m", true);
  xhttp1.send();

  var xhttp2 = new XMLHttpRequest();
  xhttp2.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("vfo").innerHTML = this.responseText;
    }
  };
/*  xhttp2.open("GET", "/vfo", true); 
  xhttp2.send(); */

  var xhttp3 = new XMLHttpRequest();
  xhttp3.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("smeter").innerHTML = displaySmeter(this.responseText);
    }
  };
  xhttp3.open("GET", "riggetstate.php?q=l"+ "+STRENGTH", true);
  xhttp3.send();

  /* When Tx is ON the red LED image is shown on top of the FT-857 image.
  When OFF the image is hidden to display the original image with a green LED  */

  var xhttp4 = new XMLHttpRequest();
  xhttp4.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText != 0) {document.getElementById("redimg").style.display = "block";
                                   RxTx = 1;
                                   document.getElementById("rxtx").innerHTML = "Tx";}
      else
      {document.getElementById("redimg").style.display = "none";
      document.getElementById("rxtx").innerHTML = "Rx";
      RxTx = 0;}
    }
  };
  xhttp4.open("GET", "riggetstate.php?q=t", true);
  xhttp4.send(); 

  var xhttp5 = new XMLHttpRequest();
  xhttp5.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var split;
      split = this.responseText.charAt(0);
      if (split != "0") {
      document.getElementById("split").innerHTML = "SPL";}
      else {document.getElementById("split").innerHTML = "";}
    }
  };
  xhttp5.open("GET", "riggetstate.php?q=s VFO", true); 
  xhttp5.send(); 

  var xhttp6 = new XMLHttpRequest();
  xhttp6.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dbf").innerHTML = this.responseText;
    }
  };
  /* xhttp6.open("GET", "/dbf", true);
  xhttp6.send(); */

  var xhttp7 = new XMLHttpRequest();
  xhttp7.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dnr").innerHTML = this.responseText;
    }
  };
  /* xhttp7.open("GET", "/dnr", true);
  xhttp7.send(); */

  var xhttp8 = new XMLHttpRequest();
  xhttp8.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dnf").innerHTML = this.responseText;
    }
  };
 /* xhttp8.open("GET", "/dnf", true);
  xhttp8.send(); */

  var xhttp9 = new XMLHttpRequest();
  xhttp9.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("kyr").innerHTML = this.responseText;
    }
  };
  /* xhttp9.open("GET", "/kyr", true);
  xhttp9.send(); */

  var xhttp10 = new XMLHttpRequest();
  xhttp10.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("bk").innerHTML = this.responseText;
    }
  };
/*  xhttp10.open("GET", "/bk", true);
  xhttp10.send(); */


  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      curfreq = Number(this.responseText)/10;
      document.getElementById("freq").innerHTML = displayfreq(this.responseText);
    }
  };
  xhttp.open("GET", "riggetstate.php?q=f", true);
  xhttp.send();

}, 600 ) ;

</script>
</body>
</html>
