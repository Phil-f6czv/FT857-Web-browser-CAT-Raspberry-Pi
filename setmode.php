<script>
var mode ="PKTUSB";
var reqmode = <?php echo $_REQUEST['Fmode'];  ?>;
switch(reqmode) {
    case 1:
    mode = "USB";
    break;
    case 2:
    mode = "LSB";
    break;
    case 3:
    mode = "FM";
    break;
    case 4:
    mode = "CW";
    break;
    case 5:
    mode = "CWR";
    break;
    case 6:
    mode = "AM";
    break;
    case 7:
    mode = "PKTUSB";
    break;
    default:
    mode = "PKTUSB";
    break; 
}
mode = mode + "+0";
var xhttp = new XMLHttpRequest(); 
 xhttp.open("GET", "riggetstate.php?q=M+" + mode, true); 
 xhttp.send();
</script> 


