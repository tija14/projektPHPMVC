<?php


class CCalender{

private $db;
private $month;
private $id;


public function __construct($_db){

	
	$this->db = $_db;
	

}

function today(){

	$day = date("l");
    $day2 = date("d");
    $month = date("m");
    $year = date("Y");
                    
                    
    $html = "Dagen datum: " . $year ."-" .$month ."-" .$day2;
	
	return $html;


}
function calender(){

	$day = date("j");
    $this->month = date("n");
    $year = date("Y");
                    
    $currentTimeStamp = strtotime("$year-$this->month-$day");
    $monthName = date("F", $currentTimeStamp);
    $numDay = date("t", $currentTimeStamp);
    $counter =0;

	$html = "
	 <div id='calender'>
                  <table border='1' colspacing='0' cellspacing='0' width='190px'>
                      
                      <tr>
                           <td> </td>
                          <td colspan='5'> {$monthName} {$year} </td>
                          <td> </td>
                          
                      </tr>
                       <tr >
                          <td>Mon</td>
                          <td>Tue</td>
                          <td>Wed</td>
                          <td>Thu</td>
                          <td>Fri</td>
                          <td>Sat</td>
                          <td>Sun</td>
                      </tr>
                 
                 ";
				 
				 
			    $html .= "<table border='1' cellspacing='0' cellpadding='0' width='190px' height='100px'>";
                for($i = 1; $i< $numDay +1; $i++, $counter ++)
                {
                    
                    $timestamp = strtotime("$year-$this->month-$i");
                    if($i == 1)
                    {
                        
                        $firstDay = date("w", $timestamp);
                        for($j = 1; $j < $firstDay; $j++, $counter++)
                        {
                            $html .= "<td>&nbsp;</td>";
                        }

                    }
                  
                    if($counter % 7 == 0){
                        $html .= "</tr><tr>";
                    }
                   $monthstring = $this->month;
                   $monthlength = strlen($monthstring);
                   $daystring = $i;
                   $daylength = strlen($daystring);
                   if($monthlength <= 1)
                   {
                       $monthstring = "0".$monthstring;
                   }
                   if($daylength <= 1)
                   {
                       $daystring = "0".$daystring;
                   }
                   $todaysDate = date("m/d/Y");
                   
                   $dateToCompare = $monthstring . "/" . $daystring . "/" . $year;
                  
                    $html .= "<td align='center'";
                    if($todaysDate == $dateToCompare){
                        $html .= "class='today'";
                    }
                    
                    
                   $html .= ">
                    $i </td>";
                    
                }
                
               $html .= "</table></div>";
			   
				return $html;

}

function getMovieOfTheMonth(){
	
	$html = "<div id='movieMonth'>";	
		$sql = "
		SELECT *
		FROM movie
		WHERE month = $this->month LIMIT 1
		";
		
		
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
		
		if(isset($res[0])){
		$c = $res[0];
	}
	$id = htmlentities($c->id, null, 'UTF-8');
	
	foreach($res as $val){
		
		$html .= "<a href='movie.php?id={$id}'>  månadens film</a>";
	 
	}
	return $html;




}









}