<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




		 function test()
		{
			return 1;
		}
	/*public function getWeekName()
	{
		$dayname=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		$outPut='';
		for($w=1;$w<=7;$w++)
		{
			$outPut.='<div class="weekName" >'.$dayname[$w-1].'</div>';
		}
		$outPut.='<div style="clear:both;"></div>';
		return $outPut;
	}
	
	public function printMonthWiseDay($first_week_day,$tataldays,$currentDay,$query)
	{
		//echo $currentDay;
		$outPut= getWeekName();
		$flag=0;
		$day=1;
		$blankday=1;
		$outPut='<div class="calendar">';
		for($monthwise=1;$monthwise<=5;$monthwise++)
		{
			
			$outPut.='<div class="mainrow'.$monthwise.'">';
			for($weekday=1;$weekday<=7;$weekday++)
			{
				if(mysql_num_rows($query)>0)
				{
					mysql_data_seek($query,0);
				}
				if($day<=$tataldays)
				{
					if($first_week_day>$blankday)
					{	
						$outPut.='<div class="monthrow" ></div>'; 
					}
					else
					{
						//print_r($query);
						while($row=mysql_fetch_array($query))
						{
							$flag=0;
							$day1=$day;
							$sessionDate=explode('-',$row['sessionDate']);
							if($day<10)
							{
								$day1="0".$day;
							}
							if($sessionDate[2]==$day1)
							{
								$monthTemplateContent='<div class="monthrow" ><div class="day_num">'.$day.'</div><div class="contentMonth">'.$row["topic"].'</div><div class="viewDetail">View more..</div></div>'; 
								$flag=1;
								break;
							}
						}
						if($flag==1)
						{
							$outPut.=$monthTemplateContent;
						}
						else
						{
							$outPut.='<div class="monthrow" ><div class="day_num">'.$day.'</div><div class="content"></div></div>'; 
						}
						$day++;
					}
				}
				else
				{
					$outPut.='<div class="monthrow" ></div>'; 
				}
				$blankday++;	
			}
			$outPut.='</div>';
			$outPut.='<div style="clear:both;"></div>';
		}
		$outPut.='<div>';
		return $outPut;
	}
	public  function GetCalendar($month=NULL,$year=NULL)
	{
		date_default_timezone_set('Asia/Kolkata');
		if($month==NULL)
			$date=getDate();
		else
			$date=getDate(mktime(0,0,0,$month,1,$year));
		$currentMonth=date('m');
		$currentYear=date('Y');
	//	$day=$date["mday"];
		$day='';
		$month=$date["mon"];
		$month_name=$date["month"];
		$year=$date["year"];
		$this_month=getDate(mktime(0,0,0,$month,1,$year));
		$next_month=getDate(mktime(0,0,0,$month+1,1,$year));
		$first_week_day=$this_month["wday"];
		?>
        <input type="hidden" id="currentMonth" name="currentMonth" value="<?php echo $month;?>">
         <input type="hidden" id="currentYear" name="currentYear" value="<?php echo $year;?>">
        <?php
		if($this_month["mon"]==$currentMonth && $this_month["year"]==$currentYear)
		{
			$day = date('d');
		}
		$days_in_this_month = round(($next_month[0]-$this_month[0])/(60 * 60 * 24));
		
		$outPut='<div id="monthHeading"><div class="Premonth"><a href="week-wise-calendar.php?month='. ($month-1) .'&year='.$year.'" style="text-decoration:none; color:#fff;">Pre Month</a></div><div style="margin-left:350px; float:left;">'. $date['month'].'-'.$date['year'].'</div><div class="Nextmonth" ><a href="week-wise-calendar.php?month='. ($month+1) .'&year='. $year.'" style="text-decoration:none; color:#fff;">Next Month</a></div></div>';
		 $outPut.='<div style="clear:both">';
		//for database connection

		$query=mysql_query("select sessionDate,topic,subject from session_request where sessionDate like '$year-0$month%'") or die("Error::2".mysql_error());  
		//echo mysql_num_rows($query);
		return $outPut.=printMonthWiseDay($first_week_day,$days_in_this_month,$day,$query);
	}
	
	*/
