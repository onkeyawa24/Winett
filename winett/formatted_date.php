<style>
    #formatted_date{
        font-size: 1em; color: #190707; font-family: "Times New Roman"; border-bottom: position: relative;
      display: inline-block;
    }
     
    /* Tooltip text */
    #formatted_date .tooltiptext {
      visibility: hidden;
      width: 120px;
      background-color: black;
      color: #fff;
      text-align: center;
      padding: 5px 0;
      border-radius: 6px;
      /* Position the tooltip text - see examples below! */
      position: absolute;
      left: 20%;
      z-index: 1;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    #formatted_date:hover .tooltiptext {
      visibility: visible;
    }
</style>
<span id="formatted_date" style="font-size: 12px; position: absolute; right: 20px; color: #a2a2a2; ">
        <span class="tooltiptext"><?php echo $row['date_posted']; ?></span>
    <?php 
    /*****************************************************************/
    $saved_time = $row['date_posted'];
    $formated_saved_time = new DateTime($saved_time);

    $minut = date('h',strtotime($row['date_posted'])).":".date_format($formated_saved_time, "i").' '.date_format($formated_saved_time, "A");
    $dey = date('D',strtotime($row['date_posted']));
    $am_pm = date_format($formated_saved_time, "A");
    $current_time = new DateTime();
    $interval = $current_time->diff($formated_saved_time);

    if(date_format($formated_saved_time, "m") == 1)
    {
        $get_month = 'Jan';
    }
    elseif(date_format($formated_saved_time, "m") == 2)
    {
        $get_month = 'Feb';
    }
    elseif(date_format($formated_saved_time, "m") == 3)
    {
        $get_month = 'Mar';
    }
    elseif(date_format($formated_saved_time, "m") == 4)
    {
        $get_month = 'Apr';
    }
    elseif(date_format($formated_saved_time, "m") == 5)
    {
        $get_month = 'May';
    }
    elseif(date_format($formated_saved_time, "m") == 6)
    {
        $get_month = 'Jun';
    }
    elseif(date_format($formated_saved_time, "m") == 7)
    {
        $get_month = 'Jul';
    }
    elseif(date_format($formated_saved_time, "m") == 8)
    {
        $get_month = 'Aug';
    }
    elseif(date_format($formated_saved_time, "m") == 9)
    {
        $get_month = 'Sep';
    }
    elseif(date_format($formated_saved_time, "m") == 10)
    {
        $get_month = 'Oct';
    }
    elseif(date_format($formated_saved_time, "m") == 11)
    {
        $get_month = 'Nov';
    }
    elseif(date_format($formated_saved_time, "m") == 12)
    {
        $get_month = 'Dec';
    }
    else
    {
        $get_month = 'Error!';
    }

    if (!empty($interval->format('%a')))
    {
        $time_difference=$interval->format('%a').'d &bull; '.$dey;;
        if($time_difference == 1)
        {
            $time_difference = 'yesterday &bull; '.$minut ;
        }
        elseif($time_difference > 6 && $time_difference < 14)
        {
            $time_difference = 'Last week &bull; '.$dey;
        }
        elseif ($time_difference >= 14 && $time_difference < 21) 
        {
            $time_difference = ' 2W &bull; '.$dey ;  
        }
        elseif ($time_difference >= 21  && $time_difference < 28) 
        {
            $time_difference = ' 3W &bull; '.$dey ;
        }
        elseif ($time_difference >= 28 ) 
        {
             
                if(date_format($formated_saved_time, "y") == date_format($current_time, "y"))
                {
                    $time_difference = date('d',strtotime($row['date_posted']))." ".$get_month;
                }
                else
                {
                    $time_difference = date('d',strtotime($row['date_posted']))." ".$get_month." ".date_format($formated_saved_time, "y");
                } 
               
        } 
        /****************/ /*///////// /* */  /* */ /*ui*/
    } 
    elseif ($formated_saved_time->format('d') != $current_time->format('d'))
    {
        $time_difference="Yesterday &bull; ".$minut;
    }
    elseif (!empty($interval->format('%h')))
    {
        $time_difference=' Today &bull; '.$minut ; 
    }
    elseif (!empty($interval->format('%i')))
    {
        if($interval->format('%i') == '1')
        {
            $time_difference=$interval->format('%i min ago');
        }
        else
        {
            $time_difference=$interval->format('%i mins ago');
        }
    } 
    elseif (!empty($interval->format('%s')))
    {
         $time_difference=$interval->format('%s sec ago');
    } 
    else
    {
        $time_difference = 'Now';
    }
    /********************************************************************/
    echo /*date_format($current_time, "h")." ** ". date_format($formated_saved_time, "h") ." ".*/
            $time_difference;?>
</span>

