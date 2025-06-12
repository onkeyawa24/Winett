function fill(Value) {
   //Assigning value to "search" div in "search.php" file.
   $('#chat_message_25').val(Value);
   //Hiding "display" div in "search.php" file.
   $('#display').hide();
}
$(document).ready(function() {
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
   $('#chat_message_25').keyup(function() {
       //Assigning search box value to javascript variable named as "name".
       var name = $('#chat_message_25').val();
       //Validating, if "name" is empty.
       if (name == "") { 
           //Assigning empty value to "display" div in "search.php" file.
           $("#display").html("125478745");
       }
       //If name is not empty.
       else {
           //AJAX is called.
           $.ajax({
               //AJAX type is "Post".
               type: "POST",
               //Data will be sent to "ajax.php".
               url: "amax.php",
               //Data, that will be sent to "ajax.php".
               data: {
                   //Assigning value of "name" into "search" variable.
                   chat_message_25: name
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

 