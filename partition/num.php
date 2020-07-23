<?php
function createFullWordOrdinal($number)
{
    $ord1     = array(1 => "first", 2 => "second", 3 => "third", 5 => "fifth", 8 => "eight", 9 => "ninth", 11 => "eleventh", 12 => "twelfth", 13 => "thirteenth", 14 => "fourteenth", 15 => "fifteenth", 16 => "sixteenth", 17 => "seventeenth", 18 => "eighteenth", 19 => "nineteenth");
    $num1     = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eightteen", "nineteen");
    $num10    = array("zero", "ten", "twenty", "thirty", "fourty", "fifty", "sixty", "seventy", "eighty", "ninety");
    $places   = array(2 => "hundred", 3 => "thousand", 6 => "million", 9 => "billion", 12 => "trillion", 15 => "quadrillion", 18 => "quintillion", 21 => "sextillion", 24 => "septillion", 27 => "octillion");

    $number = array_reverse(str_split($number));

    if ($number[0] == 0) 
    {
        if ($number[1] >= 2)
            $out = str_replace("y", "ieth", $num10[$number[1]]);
        else
            $out = $num10[$number[1]]."th";
    } 
    else if (isset($number[1]) && $number[1] == 1) 
    {
        $out = $ord1[$number[1] . $number[0]];
    } 
    else 
    {
        if (array_key_exists($number[0], $ord1))
            $out = $ord1[$number[0]];
        else
            $out = $num1[$number[0]]."th";
    }

    if((isset($number[0]) && $number[0] == 0) || (isset($number[1]) && $number[1] == 1))
    {
        $i = 2;
    } 
    else 
    {
        $i = 1;
    }

    while ($i < count($number)) 
    {
        if ($i == 1) 
        {
            $out = $num10[$number[$i]] . " " . $out;
            $i++;
        } 
        else if ($i == 2) 
        {
            $out = $num1[$number[$i]] . " hundred " . $out;
            $i++;
        } 
        else 
        {
            if (isset($number[$i + 2])) 
            {
                $tmp = $num1[$number[$i + 2]] . " hundred ";
                $tmpnum = $number[$i + 1].$number[$i];
                if ($tmpnum < 20)
                    $tmp .= $num1[$tmpnum] . " " . $places[$i] . " ";
                else
                    $tmp .= $num10[$number[$i + 1]] . " " . $num1[$number[$i]] . " " . $places[$i] . " ";

                $out = $tmp . $out;
                $i+=3;
            } 
            else if (isset($number[$i + 1])) 
            {
                $tmpnum = $number[$i + 1].$number[$i];
                if ($tmpnum < 20)
                    $out = $num1[$tmpnum] . " " . $places[$i] . " " . $out;
                else
                    $out = $num10[$number[$i + 1]] . " " . $num1[$number[$i]] . " " . $places[$i] . " " . $out;
                $i+=2;
            } 
            else 
            {
                $out = $num1[$number[$i]] . " " . $places[$i] . " " . $out;
                $i++;
            }
        }
    }
    return $out;
}
?>