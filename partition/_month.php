<?php
function createFullWordOrdinal2($number)
{
    $ord1     = array( 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $places   = array('st','nd','rd','th','ty');
    $month=$number[5].$number[6];
    $day=substr($number,8);
    if ($month[0]==0){
        if ($day==1){
            $ord=$day.'st'.' '.$ord1[$month[1]-1];
        }
        else if($day==2){
            $ord=$day.'st'.' '.$ord1[$month[1]-1];
        }
        else if($day==3){
            $ord=$day.'rd'.' '.$ord1[$month[1]-1];
        }
        else if($day==20 || $day==30){
            $ord=$day.'th'.' '.$ord1[$month[1]-1];
        }
        else{
            $ord=$day.'th'.' '.$ord1[$month[1]-1];
        }
    }
    else
    {
        if ($day==1){
            $ord=$day.'st'.' '.$ord1[$month];
        }
        else if($day==2){
            $ord=$day.'st'.' '.$ord1[$month];
        }
        else if($day==3){
            $ord=$day.'rd'.' '.$ord1[$month];
        }
        else if($day==20 || $day==30){
            $ord=$day.'th'.' '.$ord1[$month];
        }
        else{
            $ord=$day.'th'.' '.$ord1[$month];
        }
    }
    return $ord;
}

?>