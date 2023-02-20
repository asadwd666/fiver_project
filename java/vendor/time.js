<script type="text/javascript">

function GetClockNew() {
    var d=new Date();
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    document.getElementById('clockbox').innerHTML=""+hours+":"+minutes+" "+ampm+"";
}

window.onload=function(){
    GetClockNew();
    setInterval(GetClockNew,1000);
}
</script>
<div id="clockbox"></div>