@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('viewCourseYearPlan')}}> << Back to View </a>
                <h1>Course Year Plan<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='' onsubmit="return validateForm()" method="POST" >
                <input type='hidden' name='id' value='{{$CourseYearPlan->id}}' />
				
					<div class="control-group">
                    <label class="control-label" for="CourseListCode">District : </label>
                        <div class="controls">
                            <select name='district' required="true" id="district" required="true">
                                <option value="">--- select ---</option>
                                @foreach($district as $o)
                                    <option value="{{$o->DistrictCode}}" @if($o->DistrictCode == $district_R) selected ="True"  @endif>{{$o->DistrictName}}</option>
                                @endforeach
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
				
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Organisation : </label>
                        <div class="controls">
                            <select name='OrgId' required="true" id="OrgId" required="true">
                             <option value="">--- select ---</option>   
							 @foreach($organisation as $i)
                                    <option value="{{$i->id}}" @if($i->id == $organisation_R) selected ="True"  @endif>{{$i->OrgaName}} - {{$i->Type}}</option>
                                @endforeach
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
				<!-- Edit by Amila 2017-05-09 -->
                @if($userType=="Admin")
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Year : </label>
                        <div class="controls">
						<?php
						$GetYears = DB::select(DB::raw("select DISTINCT Year from courseyearplan where Year !=''"));
						?>
                            <select name='Year' id='Year' required="true">
							
							@foreach($GetYears as $gg)
							 <option value="{{$gg->Year}}" @if($CourseYearPlan->Year==$gg->Year) selected="true" @endif >{{$gg->Year}}</option>
							@endforeach
							
                            <option value="{{date('Y')+1}}" @if($CourseYearPlan->Year==date('Y')+1) selected="true" @endif >{{date('Y')+1}}</option>
							<option value="{{date('Y')+2}}" @if($CourseYearPlan->Year==date('Y')+2) selected="true" @endif >{{date('Y')+2}}</option>
                            </select>
                        </div>
                </div>
                @else
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Year : </label>
                        <div class="controls">
                            <select name='Year' readonly>
							 @if($CourseYearPlan->Year==date('Y')-2)
                            <option  value="{{date('Y')-2}}" selected="true">{{date('Y')-2}}</option>
                            @endif
                            @if($CourseYearPlan->Year==date('Y')-1)
                            <option  value="{{date('Y')-1}}" selected="true">{{date('Y')-1}}</option>
                            @endif
                            @if($CourseYearPlan->Year==date('Y'))
                            <option  value="{{date('Y')}}" selected="true">{{date('Y')}}</option>
                            @endif
                            @if($CourseYearPlan->Year==date('Y')+1)
                            <option  value="{{date('Y')+1}}" selected="true" >{{date('Y')+1}}</option>
                            @endif 
							@if($CourseYearPlan->Year==date('Y')+2)
                            <option  value="{{date('Y')+1}}" selected="true" >{{date('Y')+2}}</option>
                            @endif 
                            </select>
                        </div>
                </div>
                @endif
				
				@if($userType=="Admin")
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                        <div class="controls">
                            <select name="CourseListCode" id="CourseListCode" required="true">
                                @foreach($CourseListCode as $clc)
                                    <option value="{{$clc->CD_ID}}" @if($CourseYearPlan->CD_ID ==$clc->CD_ID ) selected @endif>{{$clc->CourseListCode}} -{{$clc->CourseName}} -{{$clc->CourseType}}- ({{$clc->Nvq}}) {{$clc->Duration}} - Months</option>                                                              
                                @endforeach
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                @else
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                        <div class="controls">
                            <select name="CourseListCode" id="CourseListCode" required="true">
                                @foreach($CourseListCode as $clc)
                                    @if($CourseYearPlan->CD_ID ==$clc->CD_ID )
                                    <option value="{{$clc->CD_ID}}"  selected >{{$clc->CourseName}} ({{$clc->CourseListCode}})-{{$clc->CourseType}}- ({{$clc->Nvq}}) {{$clc->Duration}} - Months</option>                                                              
                                    @endif
                                @endforeach
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                @endif
				 <div class="control-group">
                    <label class="control-label" for="CourseLevel">Course Level : </label>
                        <div class="controls">
                            <select name="CourseLevel" id="CourseLevel" required="true">
                                <option></option>
								@if($NVQ=='NVQ')
								<option value="1" @if($CourseLevel=='1') selected @endif>Level 1</option>
								<option value="2" @if($CourseLevel=='2') selected @endif>Level 2</option>
							<option value="3" @if($CourseLevel=='3') selected @endif>Level 3</option>				
                                    <option value="4" @if($CourseLevel=='4') selected @endif>Level 4</option>
									<option value="5" @if($CourseLevel=='5') selected @endif>Level 5</option>
									<option value="6" @if($CourseLevel=='6') selected @endif>Level 6</option>
								@else
									<option value="Certificate" @if($CourseLevel=='Certificate') selected @endif>Certificate</option>
									<option value="Diploma" @if($CourseLevel=='Diploma') selected @endif>Diploma</option>
								@endif
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
				
				@if($userType=="Admin")
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Batch : </label>
                        <div class="controls">
                            <select name='batch' >
                                @if($CourseYearPlan->batch==1)
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
									<option value="1.2">1.2</option>
									<option value="2.2">2.2</option>
                                @elseif($CourseYearPlan->batch==2)
                                   
                                   <option value="1" >1</option>
                                    <option value="2" selected>2</option>
									<option value="1.2">1.2</option>
									<option value="2.2">2.2</option>
									  @elseif($CourseYearPlan->batch==1.2)
                                   <option value="1" >1</option>
                                    <option value="2" >2</option>
									<option value="1.2" selected>1.2</option>
									<option value="2.2">2.2</option>
									 @else
								    <option value="1" >1</option>
                                    <option value="2" >2</option>
									<option value="1.2" >1.2</option>
									<option value="2.2" selected>2.2</option>
                                @endif
                            </select>
                        </div>
                </div>
                @else
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Batch : </label>
                        <div class="controls">
                            <select name='batch' >
                                @if($CourseYearPlan->batch==1)
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
									<option value="1.2">1.2</option>
									<option value="2.2">2.2</option>
                                @elseif($CourseYearPlan->batch==2)
                                   
                                   <option value="1" >1</option>
                                    <option value="2" selected>2</option>
									<option value="1.2">1.2</option>
									<option value="2.2">2.2</option>
									  @elseif($CourseYearPlan->batch==1.2)
                                   <option value="1" >1</option>
                                    <option value="2" >2</option>
									<option value="1.2" selected>1.2</option>
									<option value="2.2">2.2</option>
									 @else
								    <option value="1" >1</option>
                                    <option value="2" >2</option>
									<option value="1.2" >1.2</option>
									<option value="2.2" selected>2.2</option>
                                @endif
                            </select>
                        </div>
                </div>
                @endif
				
				@if($userType=="Admin")
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Parallel Batch : </label>
                        <div class="controls">
                            <select name='parallel_batch' required="true" >
                                <option value="Yes" @if($CourseYearPlan->parallelGroups=='Yes') selected="true" @endif >Yes</option>
                                <option value="No" @if($CourseYearPlan->parallelGroups=='No') selected="true" @endif >No</option>
                            </select> 
                        </div>
                </div>
                @else
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Parallel Batch : </label>
                        <div class="controls">
                            <select name='parallel_batch' required="true" >
                                @if($CourseYearPlan->parallelGroups=='Yes')
                                    <option selected="true" value="Yes">Yes</option>
                                @endif
                                @if($CourseYearPlan->parallelGroups=='No') 
                                    <option selected="true" value="No">No</option>
                                @endif
                            </select> 
                         
                        </div>
                </div>
                @endif
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Medium : </label>
                        <div class="controls">
                            <select name='medium' required="true">
                                <option></option>
                                <option value="S" @if($CourseYearPlan->medium=='S') selected="true" @endif>Sinhala</option>
                                <option value="T" @if($CourseYearPlan->medium=='T') selected="true" @endif>Tamil</option>
                                <option value="E" @if($CourseYearPlan->medium=='E') selected="true" @endif>English</option>
                                <option value="O" @if($CourseYearPlan->medium=='O') selected="true" @endif>Other</option>
                            </select>
                        </div>
                </div>
				
				@if($userType=="Admin")
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Max Capacity : </label>
                    <div class="controls">
                    <input type="number" name="maxCapacity" min="1" required="true" value="{{$CourseYearPlan->maxCapacity}}" />
                    <span class="lbl" style="color: red"><b></b></span>
                    </div>
                </div>
                @else
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Max Capacity : </label>
                    <div class="controls">
                    <input type="number" name="maxCapacity" min="1" required="true" value="{{$CourseYearPlan->maxCapacity}}" readonly/>
                    <span class="lbl" style="color: red"><b></b></span>
                    </div>
                </div>
                @endif
				
				
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
                            <select name='attachedCenter' id='attachedCenter'>
                                @if($CourseYearPlan->attachedCenter == 'No')
                                <option value="No" selected="">No</option>
                                <option value="Yes">Yes</option>
                                @else
                                <option value="No" selected="">No</option>
                                <option value="Yes" selected>Yes</option>
                                @endif
                            </select>
                        </div>
                </div>
				
				 <div class="control-group">
                    <label class="control-label" for="CourseListCode">Real Start Date : </label>
                    <div class="controls">
                        <input type="date" name="RealStartDate" id="RealStartDate" value="{{$CourseYearPlan->RealstartDate}}"/>
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
				 <div class="control-group">
                    <label class="control-label" for="CourseListCode">Real End Date : </label>
                    <div class="controls">
                        <input type="date" name="RealEndDate" id="RealEndDate" value="{{$CourseYearPlan->RealEndDate}}"/>
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div id="abc">
                </div>
               
               <!-- <div class="control-group">
                    <label class="control-label" for="attachedCenter">Accredit  : </label>
                        <div class="controls">
                            <select name='Accredit' id='Accredit'>
                                @if($CourseYearPlan->Accredit == 'No')
                                <option value="No" selected="">No</option>
                                <option value="Yes">Yes</option>
								<option value="Recommended">Recommended</option>
                                @elseif($CourseYearPlan->Accredit == 'Yes')
                                <option value="No" >No</option>
                                <option value="Yes" selected>Yes</option>
								<option value="Recommended">Recommended</option>
								@else
									 <option value="No" >No</option>
                                <option value="Yes" >Yes</option>
								<option value="Recommended" selected>Recommended</option>
                                @endif
                            </select>
                        </div>
                </div>
				<div class="control-group" id="rec">
                    <label class="control-label" for="AccreditDate">Accredit Recommended Date : </label>
                        <div class="controls">
                           <input type="Date" name="AccreditRecommendDate" id="AccreditRecommendDate" value="{{$CourseYearPlan->AccreditRecommendDate}}" />
                        </div>
                </div>
				
					 <div class="control-group" id="accd">
                    <label class="control-label" for="AccreditDate">Accredit Date : </label>
                        <div class="controls">
                           <input type="Date" name="AccreditDate" id="AccreditDate" value="{{$CourseYearPlan->AccreditDate}}" />
                        </div>
                </div>
				<div class="control-group" id="accvd">
                    <label class="control-label" for="AccreditationValidDate">Accredit Valid Date : </label>
                        <div class="controls">
                           <input type="Date" name="AccreditationValidDate" id="AccreditationValidDate" value="{{$CourseYearPlan->AccreditationValidDate}}" />
                        </div>
                </div>-->
				
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

<script type="text/javascript">


  window.onload = function () {
    var m = document.getElementById("Accredit").value;
	if(m == 'No')
	{
		$('#rec').hide();
		$('#accd').hide();
		$('#accvd').hide();
	}
	else if(m == 'Yes')
	{
		$('#rec').show();
		$('#accd').show();
		$('#accvd').show();
	}
	else{
		$('#rec').show();
		$('#accd').hide();
		$('#accvd').hide();
		
	}
 
  
}

$("#Accredit").change(function()
    {
        var m = document.getElementById("Accredit").value;
		if(m == 'No')
	{
		$('#rec').hide();
		$('#accd').hide();
		$('#accvd').hide();
	}
	else if(m == 'Yes')
	{
		$('#rec').show();
		$('#accd').show();
		$('#accvd').show();
	}
	else{
		$('#rec').show();
		$('#accd').hide();
		$('#accvd').hide();
		
	}
		
    });
	
	function validateForm() {
		
      /*  var m = document.getElementById("Accredit").value;
	   //alert(m);
	   var rec = document.getElementById("AccreditRecommendDate").value;
	   var accd = document.getElementById("AccreditDate").value;
	   var accvd = document.getElementById("AccreditationValidDate").value;
		if(m == 'Yes')
		{
			if(rec == "" || accd == "" || accvd == "")
			{
				alert("Please Fill All Dates Including Accredit Recommended Date,Accredit Date & Accredit Valid Date !!!");
				return false;
			}
			else
			{
				return true;
			}
		}
		else if(m == 'Recommended')
		{
			if(rec == "")
			{
				alert("Please Fill  Accredit Recommended Date!!!");
				return false;
			}
			else
			{
				return true;
			}
			
		}
		else
		{
			return true;
		} */
	   return true;
    }
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
  
   $("#district").change(function() {

                                    var district = document.getElementById('district').value;
									change_district(district);
                                });	

 function change_district(district){
    //alert(district);
                                    $.ajax({
                                        url: "{{url::to('ajaxOrganisationLoad')}}",
                                        data: {district: district},
                                      
                                        success: function(result) {
                                            document.getElementById('OrgId').innerHTML = result;
                                        }
                                       
                                    });
 } 

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
       
               
               
               
      
        
        

    
