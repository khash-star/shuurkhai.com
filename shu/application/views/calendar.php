<?php 

   $year=date("y");

   $month=date("n");

   $Month=date("F");

   switch ($Month)

   {

   case "January": $Month="1-р сар"; break;

   case "February": $Month="2-р сар"; break;

   case "March": $Month="3-р сар"; break;

   case "April": $Month="4-р сар"; break;

   case "May": $Month="5-р сар"; break;

   case "June": $Month="6-р сар"; break;

   case "July": $Month="7-р сар"; break;

   case "August": $Month="8-р сар"; break;

   case "September": $Month="9-р сар"; break;

   case "October": $Month="10-р сар"; break;

   case "November": $Month="11-р сар"; break;

   case "December": $Month="12-р сар"; break;

   }

   $century= floor(date("Y")/100);

   if ($century==19) $y=0; //only range 1900-2099

   if ($century==20) $y=6; 

   $x= array (0,3,3,6,1,4,6,2,5,0,3,5);

   $maxday=31;

   if ($year%4==0) {$x[0]=6;$x[1]=2; if ($month==2) $maxday=29;}

    else if ($month==2) $maxday=28; //eliminate leap year cases

   $sum=($y+$year+floor($year/4)+$x[$month-1]+1)%7; //0-month starts by Sunday; 1-month starts by Monday....

   if ($sum==0) $sum=7;  //correction for weeks start with Monday 

   $day=1;   

   if ($month==4 || $month==6 || $month==9 || $month==11) $maxday=30; 

   $curr_day=date("j");

?> <!--calendar initilials-->
<table class="table">

<tr>

<td colspan="7" align="center">

<?php echo "<h3>".$Month."&nbsp;<font class='holiday'>".$century.$year."</font></h3>";?></td></tr>

<tr class="text"><td>Да</td><td>Мя</td><td>Лх</td><td>Пү</td><td>Ба</td><td class="holiday">Бя</td><td class="holiday">Ня</td></tr>

<?php

$td=0; //put them in table td

 while($day<=$maxday)

 {

 if ($td%7==0) 

 echo "<tr>";

 if ($td%7==6||$td%7==5)

 echo "<td class='holiday days'>"; else echo "<td class='days'>";

 $query=$this->db->query("SELECT * FROM events WHERE event_date='".$century.$year."-".$month."-".$day."'");

 if ($query->num_rows() > 0) echo "<font class='hasevent'>";

 if ($day==$curr_day) echo "<font class='today'>"; // today's style

 if ($sum==1) {echo $day; $day++;} else {echo "&nbsp;"; $sum--;} //month start day correction

 if ($day==$curr_day) echo "</font>";

 echo "</td>";

 if ($td%7==6)   

 echo "</tr>"; 

 $td++;

 }

?>

</table> <!--calendar table-->

<div id="calendar_msg"></div>