$(document).ready(function(){
    setInterval(function(){ 
        header_update();
    }, 5000);
    function header_update()
    {
    	$.ajax({
            url:"header_update.php",
           	type:"POST",
            success:function(data){
            $('.header_update').html(data);
            }
        })
    }
});