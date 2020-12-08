<script>
var reqfreq = <?php echo $_REQUEST['FFreq'];  ?> +  "000";
var xhttp = new XMLHttpRequest(); 
 xhttp.open("GET", "riggetstate.php?q=F+" + reqfreq, true); 
 xhttp.send();
</script> 


