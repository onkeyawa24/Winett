 
function fill(Value) {
   //Assigning value to "search" div in "search.php" file.
   $('#search').val(Value);
   $('#display').hide();
}
$(document).ready(function() {
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
   $("#search").keyup(function() {
       //Assigning search box value to javascript variable named as "name".
       var name = $('#search').val();
       //Validating, if "name" is empty.
       if (name == "") { 
           //Assigning empty value to "display" div in "search.php" file.
           $("#display").html("");
       }
       else {
           $.ajax({
               type: "POST",
               url: "ajax.php",
               data: {
                   //Assigning value of "name" into "search" variable.
                   search: name
               },
               //If result found, this funtion will be called.
               success: function(html) {
                   //Assigning result to "display" div in "search.php" file.
                   $('#display').html(html).show();
               }
           });
       }
   });
});

 