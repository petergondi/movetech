<?php
         $test="2019-05-30";
         $sample= date("Y-m-d");
       $datetime1 = new DateTime($sample);
       $datetime2 = new DateTime($test);
       $interval = $datetime1->diff($datetime2);
       echo $interval->format('%R%a');