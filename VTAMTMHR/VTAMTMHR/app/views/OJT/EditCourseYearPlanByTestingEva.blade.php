@include('includes.bar')
<link rel="stylesheet" type="text/css" href="assets/DatePic/css/mdp.css">
<link rel="stylesheet" type="text/css" href="assets/DatePic/css/prettify.css">

<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/colorpicker.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-header position-relative">
                <a href={{url('ViewTrainingPlanUpdateIROJT')}}> << Back to View </a>
                <h1>OJT and JOB Placement (IR Division)<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <input type='hidden' name='id' value='{{$CourseYearPlan->id}}' />
				<input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
				<input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
				<input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
				<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Organisation : </label>
                        <div class="controls">
                        <input type="text" name="CourseListCode" id="CourseListCode"  value="{{CourseYearPlan::getOrganizatinName($CourseYearPlan->OrgId)}}" readonly />
                    </div>
                </div>
				<!-- Edit by Amila 2017-05-09 -->
               
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Year : </label>
                        <div class="controls">
						<input type="text" name="Year" value="{{$CourseYearPlan->Year}}" readonly/>
                          
                        </div>
                </div>
                
				
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                        <div class="controls">
						<input type="text" name="CourseListCode" value="{{$CourseYearPlan->CourseListCode}}" readonly/>
                           
                        </div>
                </div>
               
				 <div class="control-group">
                    <label class="control-label" for="CourseLevel">Course Level : </label>
                        <div class="controls">
						<input type="text" name="CourseListCode" value="{{$CourseYearPlan->CourseLevel}}" readonly/>
                            
                        </div>
                </div>
				
				
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Batch : </label>
                        <div class="controls">
						<input type="text" name="CourseListCode" value="{{$CourseYearPlan->batch}}" readonly/>
                           
                        </div>
                </div>
               
				
				
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Parallel Batch : </label>
                        <div class="controls">
						 
						<input type="text" name="CourseListCode" value="{{$CourseYearPlan->parallelGroups}}" readonly/>
						
                        </div>
                </div>
               
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Medium : </label>
                        <div class="controls">
							<input type="text" name="CourseListCode" value="{{$CourseYearPlan->medium}}" readonly/>
                            
                        </div>
                </div>
				
				
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Max Capacity : </label>
                    <div class="controls">
					<input type="text" name="CourseListCode" value="{{$CourseYearPlan->maxCapacity}}" readonly/>
                  
                    </div>
                </div>
               
				
				
                 <!--  <div class="control-group">
                        <label class="control-label" for="Nvq">Is NVQ</label>
                        <div class="controls">
                            <select name="Nvq" id="Nvq">
                            @if($CourseYearPlan->Nvq=='NVQ')
                                <option value=""></option>
                                <option value="NVQ" selected>Yes</option>
                                <option value="NON-NVQ">No</option>
                             @else
                                 <option value=""></option>
                                <option value="NVQ">Yes</option>
                                <option value="NON-NVQ" selected>No</option>
                             @endif   
                            </select>
                        </div>
                </div>
                <div class="control-group">
                        <label class="control-label" for="Medium">Course Level</label>
                        <div class="controls">
                            <select name="CourseLevel" id="CourseLevel"> 
                            </select>
                        </div>
                        <div class="controls">
                            <input type="text" id="courseLevelStatus" name="courseLevelStatus"  readonly value={{$CourseYearPlan->CourseLevel}} />
                        </div>
                </div> -->
               
			<div class="control-group">
                    <label class="control-label" for="attachedCenter">Attached Centre : </label>
                        <div class="controls">
						<input type="text" name="CourseListCode" value="{{$CourseYearPlan->attachedCenter}}" readonly/>
                            
                        </div>
                </div>
                
               
              <?php
						   $CD_IDm = Course::where('CourseListCode','=',$CourseYearPlan->CourseListCode)->where('Deleted','=',0)->pluck('CD_ID');
						   $getAccredit = AccreditationDetails::getAccreditation($CourseYearPlan->OrgId,$CD_IDm);
						   $AccCount = count($getAccredit);
						   $AccreditM = '';
						   $AccreditRec = '';
						   $AccreditFrom = '';
						   $AccreditTo = '';
						   foreach($getAccredit as $aa)
						   {
							   $AccreditM = $aa->Accredit;
							   $AccreditRec = $aa->AccreditRecommandedDate;
							   $AccreditFrom = $aa->AccreditDate;
							   $AccreditTo = $aa->AccreditationValidDate;
						   }
						   ?>
                <div class="control-group">
                    <label class="control-label" for="attachedCenter">Accredit  : </label>
                        <div class="controls">
							<input type="text" name="CourseListCode" value="{{$AccreditM}}" readonly/>
                         
                        </div>
                </div>
				@if($AccreditM == 'Yes')
					
				<div class="control-group" id="rec">
                    <label class="control-label" for="AccreditDate">Accredit Recommended Date : </label>
                        <div class="controls">
                           <input type="text" name="AccreditRecommendDate" id="AccreditRecommendDate" value="{{$AccreditRec}}" readonly/>
                        </div>
                </div>
					 <div class="control-group" style="visibility: show" id="xyz">
                    <label class="control-label" for="AccreditDate">Accredit Date : </label>
                        <div class="controls">
                           <input type="text" name="AccreditDate" id="AccreditDate" value="{{$AccreditFrom}}" readonly/>
                        </div>
                </div>
				
				<div class="control-group" style="visibility: show" id="xyz1">
                    <label class="control-label" for="AccreditationValidDate">Accredit Valid Date : </label>
                        <div class="controls">
                           <input type="text" name="AccreditationValidDate" id="AccreditationValidDate" value="{{$AccreditTo}}" readonly/>
                        </div>
                </div>
				@elseif($AccreditM== 'Recommended')
				<div class="control-group" id="rec">
                    <label class="control-label" for="AccreditDate">Accredit Recommended Date : </label>
                        <div class="controls">
                           <input type="text" name="AccreditRecommendDate" id="AccreditRecommendDate" value="{{$AccreditRec}}" readonly/>
                        </div>
                </div>
				@elseif($AccreditM== 'Expired')
				<div class="control-group" style="visibility: show" id="xyz1">
                    <label class="control-label" for="AccreditationValidDate">Accredit Valid Date : </label>
                        <div class="controls">
                           <input type="text" name="AccreditationValidDate" id="AccreditationValidDate" value="{{$AccreditTo}}" readonly/>
                        </div>
                </div>
				@else
					
				@endif
               
				
               <div class="control-group">
                <label class="control-label" >Instructors: </label>
                <div class="controls" id="ModuleDiv">
				 
				 <span> @foreach($AddedInstructors as $t)
									
                                       {{$t->Name}} - {{$t->EPFNo}}</br>
								  
                                    @endforeach
									</span>
                   
                </div>         
            </div>
			    
			
			  

        
             <div class="control-group">
                    <label class="control-label" for="CourseListCode">Trainee Count : </label>
                    <div class="controls">
                    <input type="number" name="TCount" id="TCount" min="0" value="{{$CourseYearPlan->NoOfTrainees}}" readonly/>
                    <span class="lbl" style="color: red"><b></b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Dropout Count : </label>
                    <div class="controls">
                    <input type="number" name="DCount" id="DCount" min="0" value="{{$CourseYearPlan->Dropout}}" readonly/>
                    <span class="lbl" style="color: red"><b></b></span>
                    </div>
                </div>
				
				 <div class="control-group">
                    <label class="control-label" for="attachedCenter">Started Status(Yes/No)</label>
                        <div class="controls">
						@if($CourseYearPlan->StartedStatus ==0)
						 <input type="text" name="DCount" id="DCount"  value="No" readonly/>
					 @else
						 <input type="text" name="DCount" id="DCount"  value="Yes" readonly/>
						 @endif
                            
                        </div>
                </div>
				
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">No of OJT Placed: </label>
                    <div class="controls">
                    <input type="number" name="NoOFOJTPlaced" id="NoOFOJTPlaced" min="0" value="{{$CourseYearPlan->NoOFOJTPlaced}}" />
                    <span class="lbl" style="color: red"><b></b></span>
                    </div>
               </div>
			   	<div class="control-group">
                    <label class="control-label" for="CourseListCode">No of OJT Completed: </label>
                    <div class="controls">
                    <input type="number" name="NoOFOJTCompleted" id="NoOFOJTCompleted" min="0" value="{{$CourseYearPlan->NoOFOJTCompleted}}" />
                    <span class="lbl" style="color: red"><b></b></span>
                    </div>
               </div>
			 
			  
		
	        <div class="control-group">
                <label class="control-label" >No Of trainees Job Placed:</label>
                <div class="controls" id="ModuleDiv">
				<input type="number" name="NoOfJobPlaaced" id="NoOfJobPlaaced" min="0" value="{{$CourseYearPlan->NoOfJobPlaaced}}"/>
                    
                </div>         
            </div>
			<div class="control-group">
                <label class="control-label" >OJT Course Level:</label>
                <div class="controls" >
				<select  name="OJTCourseLevel" id="OJTCourseLevel" />
				<option value="">---select OJT Level---</option>
				@foreach($CourseLevels as $cl)
				<option @if($CourseYearPlan->OJTPlacedNVQLevel== $cl->CourseLevel)selected="true" @endif value="{{$cl->CourseLevel}}">{{$cl->CourseLevel}}</option>
				@endforeach
                 </select>   
                </div>         
            </div>
			
			<div class="control-group">
                <div class="controls">
                    <input type="submit" class="btn btn-block btn-primary" value="Save"/>
                </div>
            </div>
                   
            </form>
        </div>
        <div class="span4">
            @if($errors->has())
                @foreach($errors->all() as $msg)
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('includes.footer')
<!-- loads jquery and jquery ui -->
<script type="text/javascript" src="assets/DatePic/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="assets/DatePic/js/jquery-ui-1.11.1.js"></script>
    
<!-- loads mdp -->
<script type="text/javascript" src="assets/DatePic/js/jquery-ui.multidatespicker.js"></script>
        
<!-- mdp demo code -->
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
<!-- loads some utilities (not needed for your developments) -->
<script type="text/javascript" src="assets/DatePic/js/prettify.js"></script>
<script type="text/javascript" src="assets/DatePic/js/lang-css.js"></script>

<script type="text/javascript">
    $(function() {
        prettyPrint();
    });
</script>

<script type="text/javascript">
// final Assessment Dates
var date = document.getElementById('AlreadySelected').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altField'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
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
<script type="text/javascript">
//Document sending to HO
var date = document.getElementById('AlreadySelectedDSHO').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-DSHO').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldDSHO'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-DSHO").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//Result Checked Dates
var date = document.getElementById('AlreadySelectedRCD').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-RCD').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldRCD'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-RCD").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//Documents sending dates to TVEC
var date = document.getElementById('AlreadySelectedDSDT').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-DSDT').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldDSDT'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-DSDT").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//Date prepare ROA
var date = document.getElementById('AlreadySelectedDPROA').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-DPROA').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldDPROA'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-DPROA").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//Date certificate recieve from TVEC
var date = document.getElementById('AlreadySelectedCRDFTVEC').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-CRDFTVEC').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldCRDFTVEC'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-CRDFTVEC").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//Date certificate issuing dates to District
var date = document.getElementById('AlreadySelectedCIDTDIS').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-CIDTDIS').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldCIDTDIS'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-CIDTDIS").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//English Trade Course To HO
var date = document.getElementById('AlreadySelectedETCRDHO').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-ETCRDHO').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldETCRDHO'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-ETCRDHO").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script type="text/javascript">
//CBT results HO
var date = document.getElementById('AlreadySelectedCBTHO').value;
var array = new Array();
var array = date.split(",");

    $('#with-altField-HO-CBTHO').multiDatesPicker({
        dateFormat: "yy-mm-dd",
        maxPicks: 31,
        altField: '#altFieldCBTHO'
		//addDates: [array[0]]
			
		
    });
	
     for (var j = 0; j < array.length; j++) {
			 $("#with-altField-HO-CBTHO").multiDatesPicker("addDates", array[j]);
		}
			
		
   
	//var dateArray= ["09/03/2015", "11/03/2015"]
 //$("#with-altField-HO").multiDatesPicker('addDates', dateArray);
</script>
<script>
    $("#courseCode").change(function()
    {
        if($("#courseCode").val()!='')
        {
            
            $("#placeHolder").html(html);
        }
        else
        {
            $("#placeHolder").html('');
        }
    });
    
</script>
<script type="text/javascript">

 function addModule() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule').is(':hidden')) {
                            $('#addModule').show();
                        } else {
                            $('#addModule').hide();
                        }
                    }
                });
    }
	function addModule1() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule1').is(':hidden')) {
                            $('#addModule1').show();
                        } else {
                            $('#addModule1').hide();
                        }
                    }
                });
    }
    function fillModule() {
        var Name = document.getElementById('Name').value;
        var EPF = document.getElementById('EPF').value;
        var msg = '--- Select Instructor---';
        $("#InstructorList").html('');
		$("#InstructorList1").html('');
        $.ajax({
                    url: "{{url::to('SaveMOInstructor')}}",
                    data: {Name: Name, EPF: EPF},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            
                            $('#addModule').hide();
                           $('#ajaxerror').html(result.done);
                            $("#InstructorList").append("<option value=''>" + msg + "</option>");
							 $("#InstructorList1").append("<option value=''>" + msg + "</option>");
                            $.each(result.list, function(i, item)
                            {



                                $("#InstructorList").append("<option value=" + item.EPFNo + ">" + item.Name + "  (" + item.EPFNo + ")</option>");
								$("#InstructorList1").append("<option value=" + item.EPFNo + ">" + item.Name + "  (" + item.EPFNo + ")</option>");



                            });
                                                        
                                   

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
    }
	  function fillModule1() {
        var Name = document.getElementById('Name').value;
        var EPF = document.getElementById('EPF').value;
        var msg = '--- Select Instructor---';
        $("#InstructorList1").html('');
        $.ajax({
                    url: "{{url::to('SaveMOInstructor')}}",
                    data: {Name: Name, EPF: EPF},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            
                            $('#addModule1').hide();
                           $('#ajaxerror').html(result.done);
                            $("#InstructorList1").append("<option value=''>" + msg + "</option>");
                            $.each(result.list, function(i, item)
                            {



                                $("#InstructorList1").append("<option value=" + item.EPFNo + ">" + item.Name + "  (" + item.EPFNo + ")</option>");



                            });
                                                        
                                   

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
    }
    $('#Accredit').click(function() {
                                    var s = $('#Accredit').val();
                                    //alert(s);
                                    if(s == 'Yes')
                                    {
                                      document.getElementById('xyz').style.visibility = 'visible';
									  document.getElementById('xyz1').style.visibility = 'visible';
                                      
                                    }
                                    else
                                    {
                                        document.getElementById('xyz').style.visibility = 'hidden';
										document.getElementById('xyz1').style.visibility = 'hidden';
                                    }
                                    
                                    
                                    
                                  
                                });
$("#attachedCenter").change(function() {
        //alert('1');
                                    var attachedCenter = $('#attachedCenter').val();
                               
                                    if (attachedCenter != 'No') {
                                        $.ajax
                                                ({
                                                    beforeSend: function()
                                                    {
                                                      //  $("body").css("cursor", "progress");
                                                       // $("body input").css("cursor", "progress");
                                                        //$("#loding").html('<br><br><img height="50%" width="25%" src=\"{{Url("assets/images/ajax-loader.gif")}}\"/>');
                                                    },
                                                    type: "POST",
                                                    url: 'ajaxGetattachedCenter',
                                                    data: {attachedCenter: attachedCenter},
                                                    //dataType: 'json',
                                                    success: function(result)
                                                    {
                                                       $("#abc").html(result);
                                                    },
                                                    complete: function() {
                                                        //$("#loding").html('');
                                                      //  $("body").css("cursor", "default");
                                                       // $("body input").css("cursor", "default");                                                       
                                                    }

                                                });
                                    } else {
                                        $("#abc").html("");
                                        //bootbox.alert('Please select Institute !');
                                    }
                                });
$("#CourseListCode").on("change", function() {
                                    var CourseListCode = $('#CourseListCode').val();
                                    if (CourseListCode != '') {
                                        $.ajax
                                                ({
                                                    beforeSend: function()
                                                    {
                                                        $("body").css("cursor", "progress");
                                                        $("body input").css("cursor", "progress");
                                                        //$("#loding").html('<br><br><img height="50%" width="25%" src=\"{{Url("assets/images/ajax-loader.gif")}}\"/>');
                                                    },
                                                    type: "POST",
                                                    url: 'ajaxGetNvqLevelCourse',
                                                    data: {CourseListCode: CourseListCode},
                                                    //dataType: 'json',
                                                    success: function(result)
                                                    {
                                                       $("#CourseLevel").html(result);
                                                    },
                                                    complete: function() {
                                                        //$("#loding").html('');
                                                        $("body").css("cursor", "default");
                                                        $("body input").css("cursor", "default");                                                       
                                                    }

                                                });
                                    } else {
                                        //bootbox.alert('Please select Institute !');
                                    }
                                });
</script> 
       
               
               
               
      
        
        

    
