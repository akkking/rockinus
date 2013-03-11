<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
alert("11");
$(document).ready(function() {
    var zeus    =  $('#zeus'), 
        zeuss   =  $('#zeuss'),
        forward = true;

    setInterval(function() {
        if (forward) {
           zeus.fadeOut(1000, function() { zeuss.fadeIn(1000); });
        }
        else { 
           zeuss.fadeOut(1000, function() { zeus.fadeIn(1000); });
        }

        forward = !forward;

     }, 5000);
});?
</script>

<div id="zeus">Zeus Banner</div>
<div id="zeuss">Zeuss Banner</div>

