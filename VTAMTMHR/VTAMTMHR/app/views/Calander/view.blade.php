@include('includes.bar')
<?php
    $mr=0;                  //use for chech and get new row in months
    $ch=array(
    0=>'Mo',
    1=>'Tu',
    2=>'We',
    3=>'Th',
    4=>'Fr',
    5=>'Sa',
    6=>'Su');   // column head values 
    $monthName=array(0=>'January',1=>'February',2=>'March',3=>'April',
                    4=>'May',5=>'June',6=>'July',7=>'August',
                    8=>'September',9=>'October',10=>'November',11=>'December');   // Month Names
?>
<br>
<center>
<form method='get' action="calander">
    Trade : 
    <select name='trade' id='trade'>
        <option>All Trades</option>
        @foreach($trade as $t)
            <option>{{$t->TradeName}}</option>
        @endforeach
    </select>
    Course Code : 
    <select name='courseCode' id='courseCode'>
        @foreach($coursestarted as $t)
            <option>{{$t->CourseCode}}</option>
        @endforeach
    </select>
    <input type="submit" value='Search' />
</form>
</center>
@if(!isset($course))
    <?php $nowYear= date("Y");  //get Current year ?>
<h1><center>Calander For {{$nowYear}}</center></h1><br>
    <center>
    <table border='0' class="table">
        @for($n=1;$n<=12;$n++)
        <?php $hdYes=FALSE; ?>
            @if($mr==0)
                <tr>
            @endif
            <?php $mr++; ?>
            <td>
                <b><center>{{$monthName[$n-1]}}</center></b>
            <?php
                $fdt=date("l", mktime(0, 0, 0, $n, 1, $nowYear));      //get selected month first day type
                $fdt=substr($fdt,0,2);  //substring for generate day no
                $noDays = cal_days_in_month(CAL_GREGORIAN, $n, $nowYear); //get Month day count
                $noOfDaysSkip=0;
                $nr=0;                //use for chech and get new row
                $c=0;
                $temp=1;
                for($c=0;$c<7;$c++)
                {
                        if($fdt==$ch[$c])
                        {
                            $noOfDaysSkip=$c;
                        }
                }
            ?>
            <table border='0' class="table">
                <tr>
                    @for($c=0;$c<7;$c++)
                        <th>{{$ch[$c]}}</th>
                    @endfor
                </tr>
                <tr>
                @for($c=0;$c<$noOfDaysSkip;$c++)
                    <td></td>
                @endfor
                @if($c<7)
                   @for($c=$c;$c<7;$c++)
                        @foreach($holiday as $h)
                            @if( $h->HolidayMonth==$n && $h->HolidayDay==$temp)
                                @if($h->HTId=='4')
                                    <td bgcolor='green'><?php 
                                                            echo $temp++;
                                                            $hdYes=TRUE;
                                                            break;
                                                        ?> 
                                    </td>
                                @else
                                    <td bgcolor='red'><?php 
                                                            echo $temp++;
                                                            $hdYes=TRUE;
                                                            break;
                                                        ?> 
                                    </td>
                                @endif
                            @else
                                <?php $hdYes=FALSE; ?>
                            @endif
                        @endforeach
                        @if(!$hdYes)
                            <td>{{$temp++}}</td>
                        @endif
                        <?php $noDays--; ?>
                        @if($c==6)
                            </tr>
                        @endif
                    @endfor 
                @endif
                <?php $hdYes=FALSE; ?>
                @for($c=0;$c<$noDays;$c++)
                    @if($nr==0)
                        <tr>
                    @endif
                    <?php $nr++; ?>
                    @foreach($holiday as $h)
                        @if($h->HolidayMonth==$n && $h->HolidayDay==$c+$temp)
                            @if($h->HTId=='4')
                                <td bgcolor='green'><?php 
                                                        echo $c+$temp;
                                                        $hdYes=TRUE;
                                                        break;
                                                    ?> 
                                </td>
                            @else
                                <td bgcolor='red'><?php 
                                                        echo $c+$temp;
                                                        $hdYes=TRUE;
                                                        break;
                                                    ?> 
                                </td>
                            @endif
                        @else
                            <?php $hdYes=FALSE; ?>
                        @endif
                    @endforeach
                    @if(!$hdYes)
                        <td>{{$c+$temp}}</td>
                    @endif
                    @if($nr==7)
                        </tr><?php $nr=0; ?>
                    @endif
                @endfor
            </table>
            </td>
            @if($mr==4)
                </tr><?php $mr=0; ?>
            @endif
        @endfor
    </table>
    </center>
@else
    <?php 
        $startDay=$course->StartDate;//get course start date
        $startYear=substr($startDay,0,4);   // get start year
        $startMonth=substr($startDay,5,2);   // get start year
        $startDate=substr($startDay,8,2);   // get start year
        $endDay=$course->ExpectedCompleted;//get course expected end date
        $endYear=substr($endDay,0,4);   // get course expected end year
        $endMonth=substr($endDay,5,2);   // get course expected end year
        $endDate=substr($endDay,8,2);   // get course expected end year
        $start=$startMonth;  // chech start year
        $end=$endMonth;      // chech end year
        $courseMode=$course->Mode;   // get course mode
    ?>
<center><h1>Calander For Course Code {{$course->CourseCode}}</h1></center>
    @for($y=$startYear;$y<=$endYear;$y++)
    <center><h3><u>{{$y}}</u></h3></center>
        <?php
        $mr=0;  
        if($startYear!=$endYear)
        {
            if($y==$startYear)
            {
                $start=$startMonth;  // chech start year
                $end=12; 
            }
            elseif($y==$endYear) 
            {
                $start=1;  // chech start year
                $end=$endMonth; 
            }
            else
            {
                $start=1;  // chech start year
                $end=12; 
            }
        }
        else
        {
            $start=$startMonth;  // chech start year
            $end=$endMonth;
        }
        ?>
        <center>
        <table border='0' class="table">
        @for($n=$start;$n<=$end;$n++)
        <?php $hdYes=FALSE; ?>
            @if($mr==0)
                <tr>
            @endif
            <?php $mr++; ?>
            <td>
            <b><center>{{$monthName[$n-1]}}</center></b>    
            <?php
                $nowYear= date("Y"); //get Current year
                $fdt=date("l", mktime(0, 0, 0, $n, 1, $y));      //get selected month first day type
                $fdt=substr($fdt,0,2);  //substring for generate day no
                $noDays = cal_days_in_month(CAL_GREGORIAN, $n, $y); //get Month day count
                $noOfDaysSkip=0;
                $nr=0;                //use for chech and get new row
                $c=0;
                $temp=1;
                for($c=0;$c<7;$c++)
                {
                    if($fdt==$ch[$c])
                    {
                        $noOfDaysSkip=$c;
                    }
                }
            ?>
            <table border='0' class="table">
                <tr>
                    @for($c=0;$c<7;$c++)
                        <th>{{$ch[$c]}}</th>
                    @endfor
                </tr>
                <tr>
                @for($c=0;$c<$noOfDaysSkip;$c++)
                    <td></td>
                @endfor
                @if($c<7)
                   @for($c=$c;$c<7;$c++)
                        @foreach($holiday as $h)
                            @if($h->HolidayYear==$y && $h->HolidayMonth==$n && $h->HolidayDay==$temp)
                                @if($h->HTId=='4')
                                    <td bgcolor='green'><?php 
                                                            echo $temp++;
                                                            $hdYes=TRUE;
                                                            break;
                                                        ?> 
                                    </td>
                                @else
                                    <td bgcolor='red'><?php 
                                                            echo $temp++;
                                                            $hdYes=TRUE;
                                                            break;
                                                        ?> 
                                    </td>
                                @endif
                            @else
                                <?php $hdYes=FALSE; ?>
                            @endif
                        @endforeach
                        @if(!$hdYes && $startYear==$y && $startMonth==$n && $temp<=$startDate)
                            @if($startYear==$y && $startMonth==$n && $temp==$startDate)
                                <td  bgcolor='#F7FF00'>{{$temp++}}</td>
                            @else
                                <td>{{$temp++}}</td>
                            @endif
                        @elseif(!$hdYes && $startYear==$y && $startMonth==$n && $temp==$startDate)
                            @if($startYear==$y && $startMonth==$n && $temp==$startDate)
                                <td  bgcolor='#F7FF00'>{{$temp++}}</td>
                            @else
                                <td>{{$temp++}}</td>
                            @endif
                        @else
                            @if(!$hdYes && $course->Mode=='Evn')
                                @if(substr(date("l", mktime(0, 0, 0, $n, $temp,$y)),0,3)=='Sat' || substr(date("l", mktime(0, 0, 0, $n, $temp,$y)),0,3)=='Sun')
                                    <td>{{$temp++}}</td>
                                @else
                                    <td bgcolor='#B266FF'>{{$temp++}}</td>
                                @endif
                            @elseif(!$hdYes && substr(date("l", mktime(0, 0, 0, $n, $temp,$y)),0,3)==$course->Mode)
                                <td bgcolor='#B266FF'>{{$temp++}}</td>
                            @elseif(!$hdYes)
                                <td>{{$temp++}}</td>
                            @endif
                        @endif
                        <?php $noDays--; ?>
                        @if($c==6)
                            </tr>
                        @endif
                    @endfor 
                @endif
                <?php $hdYes=FALSE; ?>
                @for($c=0;$c<$noDays;$c++)
                    @if($nr==0)
                        <tr>
                    @endif
                    <?php $nr++; ?>
                    @foreach($holiday as $h)
                        @if($h->HolidayYear==$y && $h->HolidayMonth==$n && $h->HolidayDay==$c+$temp)
                        
                            @if($h->HTId=='4')
                                <td bgcolor='green'><?php 
                                                        echo $c+$temp;
                                                        $hdYes=TRUE;
                                                        break;
                                                    ?> 
                                </td>
                            @else
                                <td bgcolor='red'><?php 
                                                        echo $c+$temp;
                                                        $hdYes=TRUE;
                                                        break;
                                                    ?> 
                                </td>
                            @endif
                        @else
                            <?php $hdYes=FALSE; ?>
                        @endif
                    @endforeach
                    @if(!$hdYes && $startYear==$y && $startMonth==$n && $c+$temp<=$startDate)
                        @if($startYear==$y && $startMonth==$n && $c+$temp==$startDate)
                            <td  bgcolor='#F7FF00'>{{$c+$temp}}</td>
                        @else
                            <td>{{$c+$temp}}</td>
                        @endif
                    @elseif(!$hdYes && $endYear==$y && $endMonth==$n && $c+$temp>=$endDate)
                        @if($endYear==$y && $endMonth==$n && $c+$temp==$endDate)
                            <td  bgcolor='#F7FF00'>{{$c+$temp}}</td>
                        @else
                            <td>{{$c+$temp}}</td>
                        @endif
                    @else
                        @if(!$hdYes && $course->Mode=='Evn')
                                @if(substr(date("l", mktime(0, 0, 0, $n, $c+$temp,$y)),0,3)=='Sat' || substr(date("l", mktime(0, 0, 0, $n,$c+$temp,$y)),0,3)=='Sun')
                                    <td>{{$c+$temp}}</td>
                                @else
                                    <td bgcolor='#B266FF'>{{$c+$temp}}</td>
                                @endif
                        @elseif(!$hdYes && substr(date("l", mktime(0, 0, 0, $n,$c+$temp,$y)),0,3)==$course->Mode)
                                <td bgcolor='#B266FF'>{{$c+$temp}}</td>
                        @elseif(!$hdYes)
                            <td>{{$c+$temp}}</td>
                        @endif
                    @endif
                    @if($nr==7)
                        </tr><?php $nr=0; ?>
                    @endif
                @endfor
            </table>
            </td>
            @if($mr==4)
                </tr><?php $mr=0; ?>
            @endif
        @endfor
    </table>
    </center>
    @endfor
@endif
@include('includes.footer')
<script type='text/javascript'>
    $("#trade").change(function()
    {
        $.ajax
        ({
            type: "GET",
            url: 'getCourseCode',
            data:{trade : $("#trade").val()},
            dataType:"json",
            success: function(result)
            {
                
               $("#courseCode").html(''); 
                
                $.each(result, function(i,item) 
                {
                    //alert(item);
                    $("#courseCode").append('<option>'+item.courseCode+'</option>')
                });
                
            },
        });
    });
</script>