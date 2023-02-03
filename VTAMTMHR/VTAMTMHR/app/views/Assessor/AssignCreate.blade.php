@include('includes.bar')
<link rel="stylesheet" type="text/css" href="assets/DatePic/css/prettify.css">
<link rel="stylesheet" type="text/css" href="assets/DatePic/css/mdp.css">
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/colorpicker.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ExamViewNPrintLettersForAssignedAssessors')}}> << Back to Assessor View</a>
                <h1>Assessor Details<small><i class="icon-double-angle-right"></i>Assign</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"  id='NewModule'/>
			 <input type='hidden' name='id' value='{{$coursese->id}}' />
				<input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
				<input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
				<input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
				<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
			<table>
			<tr>
			<td>
			<div class="control-group">
                <label class="control-label" >Assesment No : </label>
                <div class="controls" id="District">
                    <input type="text" name="AssessmentNo" id="AssessmentNo" value="{{$coursese->AssessmentNo}}" required><span><font color="red"><b>*</b></font></span>
                    
                </div>         
            </div>
			</td>
			<td>
			</td>
			</tr>
			</table>
             <?php
			$GetAssNomiDates = ExamAssesorMoninatedDates::where('YearPlanID','=',$coursese->id)->where('Deleted','=',0)->get();
			$dates_Nselected = [];

						foreach($GetAssNomiDates as $val) 
						{
							$dates_Nselected[] = $val->AssessorNominatedDate;
						}
						$stringN = implode(',',$dates_Nselected);
			?>
			 <div class="control-group" id="withAltField">
                    <label class="control-label">Assessor Nominated Date:</label>

                    <div class="controls">
                        <div id="with-altField-HO-AN"></div> 
                        </br>
                        <input type="text" id="altFieldAN" name = "datesANM" value="" style="width:100%" readonly /></br>
						 <input type="hidden" id="AlreadySelectedAN" name = "datesAN" value="{{$stringN}}" style="width:100%" readonly />
						
                    </div>
                </div> 
             <?php
				$getAssesorNominated = DB::select(DB::raw("select assessor.id,
															assessor.AssessorId,assessor.Name
															from assessornomination
															left join assessor
															on assessornomination.AssessorId=assessor.id
															where assessornomination.Deleted=0
															and assessornomination.AssessorActive=1
															and assessornomination.NominationType='Nominated'
															and assessornomination.CYPID='".$coursese->id."'
															order by AssessorId"));
			 ?>
             <div class="control-group">
                <label class="control-label" >Nominated Assessors: </label>
                <div class="controls" id="Ass1">
                    <select name="AssessorNominated[]" id="AssessorNominated" multiple="multiple" class="chzn-select" data-placeholder="Choose Renominated Assesors..." required >
                         <option value="">--Select Assessor--</option>
						 @foreach($AssesorList as $as)
						 
						 <option value="{{$as->id}}">{{$as->AssessorId}} - {{$as->Name}}</option>
						 @endforeach
						 @foreach($getAssesorNominated as $ass1)
						 <option value="{{$ass1->id}}" selected="true">{{$ass1->AssessorId}} - {{$ass1->Name}}</option>
						 @endforeach
                    </select>
                   
                </div>         
            </div>
			 <div class="control-group">
                <label class="control-label" >Assessors Renominated: </label>
                <div class="controls" id="Ass1">
                    <select name="RenominatedStatus" id="RenominatedStatus"  required>
                         <option value="">--Select Option--</option>
						 <option @if($coursese->AssessorReNominated == 0 ) selected="true" @endif value="0" >No</option>
						 <option value="1">Yes</option>
						
						
                       
                    </select><span><font color="red"><b>*</b></font></span>
                   
                </div>         
            </div>
			  <?php
				$getAssesorReNominated = DB::select(DB::raw("select assessor.id,
															assessor.AssessorId,assessor.Name
															from assessornomination
															left join assessor
															on assessornomination.AssessorId=assessor.id
															where assessornomination.Deleted=0
															and assessornomination.AssessorActive=1
															and assessornomination.NominationType='ReNominated'
															and assessornomination.CYPID='".$coursese->id."'
															order by AssessorId"));
			 ?>
			<div class="control-group">
                <label class="control-label" >Renominated Assessors: </label>
                <div class="controls" id="Ass1">
                    <select name="AssessorReNominated[]" id="AssessorReNominated" multiple="multiple" class="chzn-select" data-placeholder="Choose Renominated Assesors..."  >
                         <option value="">--Select Assessor--</option>
						 @foreach($AssesorList as $as)
						 <option value="{{$as->id}}">{{$as->AssessorId}} - {{$as->Name}}</option>
						 @endforeach
                       @foreach($getAssesorReNominated as $ass2)
						 <option value="{{$ass2->id}}" selected="true">{{$ass2->AssessorId}} - {{$ass2->Name}}</option>
						 @endforeach
                    </select>
                   
                </div>         
            </div>

           

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>             

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
        <div class="span4" id="ajaxerror">
            @if(Session::has('done'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                    {{Session::get('done')}}
                </strong>
                <br>
            </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>{{Session::get('message')}}</strong><br>
            </div>
            @endif
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Error!
                </strong>{{$msg}}
                <br>
            </div>
            @endforeach
            @endif

        </div>
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>




<script>
jQuery(document).ready(function() 
{
   
$("#AssessorReNominated").trigger("liszt:activate");
$("#AssessorReNominated").chosen(); 

$("#AssessorNominated").trigger("liszt:activate");
$("#AssessorNominated").chosen(); 


});

   
    
</script>
<script type="text/javascript" src="assets/DatePic/js/jquery-ui-1.11.1.js"></script>
<script type="text/javascript">

var latestMDPver = $.ui.multiDatesPicker.version;
var lastMDPupdate = '2014-09-19';
          
$(function() {
    // Version //
    //$('title').append(' v' + latestMDPver);
    $('.mdp-version').text('v' + latestMDPver);
    $('#mdp-title').attr('title', 'last update: ' + lastMDPupdate);
            
    // Documentation //
    $('i:contains(type)').attr('title', '[Optional] accepted values are: "allowed" [default]; "disabled".');
    $('i:contains(format)').attr('title', '[Optional] accepted values are: "string" [default]; "object".');
    
    $('#how-to h4').each(function () {
        var a = $(this).closest('li').attr('id');
        $(this).wrap('<'+'a href="#'+a+'"></'+'a>');
    });
    
    $('#demos .demo').each(function () {
        var id = $(this).find('.box').attr('id') + '-demo';
        $(this).attr('id', id)
        .find('h3').wrapInner('<'+'a href="#'+id+'"></'+'a>');
    });
            
    // Run Demos
    $('.demo .code').each(function() {
        eval($(this).attr('title','NEW: edit this code and test it!').text());
        this.contentEditable = true;
    }).focus(function() {
        if(!$(this).next().hasClass('test'))
        $(this)
        .after('<button class="test">test</button>')
        .next('.test').click(function() {
            $(this).closest('.demo').find('.hasDatepicker').multiDatesPicker('destroy');
            eval($(this).prev().text());
            $(this).remove();
            });
        });
    });

</script>
<script type="text/javascript" src="assets/DatePic/js/prettify.js"></script>
<script type="text/javascript" src="assets/DatePic/js/lang-css.js"></script>
<script type="text/javascript" src="assets/DatePic/js/jquery-ui.multidatespicker.js"></script>


<script type="text/javascript">
    $(function() {
        prettyPrint();
    });
</script>
<script type="text/javascript">
//Assessor Nominated Dates
var date = document.getElementById('AlreadySelectedAN').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-AN').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldAN'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-AN").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


      
$('#districtcode').change(function(){

        //alert('dg');
       var districtcode = document.getElementById('districtcode').value; 
       var msg = '--- Select Center ---';
        $("#CenterId").html('');
       $.ajax  ({
                    url: "{{url::to('GetNVTINDO')}}",
                    data: { districtcode: districtcode},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CenterId").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#CenterId").append("<option value=" + item.id + ">" + item.OrgaName + "  (" + item.Type + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });

$('#CenterId').change(function(){

        //alert('dg');
       var CenterId = document.getElementById('CenterId').value; 
       var msg = '--- Select Course ---';
        $("#CSID").html('');
       $.ajax  ({
                    url: "{{url::to('EUGetOngoingCoursese')}}",
                    data: { CenterId: CenterId},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CSID").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#CSID").append("<option value=" + item.CS_ID + ">" + item.CourseCode + "  (" + item.CourseName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });

$('#AssessorInstitute').change(function(){

        //alert('dg');
       var AssessorInstitute = document.getElementById('AssessorInstitute').value; 
       var CSID = document.getElementById('CSID').value; 
       var msg = '--- Select Assessor 1 ---';
        $("#Assessor1").html('');
       $.ajax  ({
                    url: "{{url::to('LoadAssessors1')}}",
                    data: { AssessorInstitute: AssessorInstitute,CSID: CSID},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Assessor1").append("<option value=''>" + msg + "</option>");
                         $("#Assessor2").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Assessor1").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");
                            $("#Assessor2").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");




                        });
                                        
                        
                        }


                    
                });
        


       
    });
$('#Assessor1').change(function(){

        //alert('dg');
       var Assessor1 = document.getElementById('Assessor1').value; 
       var AssessorInstitute = document.getElementById('AssessorInstitute').value; 
       var msg = '--- Select Assessor 2 ---';
        $("#Assessor2").html('');
       $.ajax  ({
                    url: "{{url::to('LoadAssessors2')}}",
                    data: { AssessorInstitute: AssessorInstitute,Assessor1: Assessor1},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Assessor2").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Assessor2").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });

$('#CSID').change(function(){

        //alert('dg');
       var CSID = document.getElementById('CSID').value; 
       
       var msg = '--- Select Assessor 2 ---';
        $("#Assessor2").html('');
       $.ajax  ({
                    url: "{{url::to('LoadAssessors2')}}",
                    data: { AssessorInstitute: AssessorInstitute,Assessor1: Assessor1},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Assessor2").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Assessor2").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
  
    </script>


