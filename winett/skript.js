function fill(Value) {
   //Assigning value to "search" div in "search.php" file.
   $('#touser').val(Value);
   //Hiding "display" div in "search.php" file.
   $('#display7').hide();
}
$(document).ready(function() {
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
   $('#touser').keyup(function() {
       //Assigning search box value to javascript variable named as "name".
       var name = $('#touser').val();
       //Validating, if "name" is empty.
       if (name == "") {
           //Assigning empty value to "display" div in "search.php" file.
           $("#display7").html("nothing to dispay");
       }
       //If name is not empty.
       else {
           //AJAX is called.
           $.ajax({
               //Data, that will be sent to "ajax.php".
              
                   //Assigning value of "
               //If result found, this funtion will be called.
               
                   //Assigning result to "display" div in "search.php" file.
                   $("#display7").html(html).show();
              
   });
  }
 });
 });