@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Assign Course Year Plan<small><i class="icon-double-angle-right"></i>Assign</small></h1>
                <a href={{url('viewCourseYearPlan')}}> << Back to View </a>
            </div>
            <form class="form-horizontal" action='' onsubmit="return validateForm()" method="POST">

            <div id="ReturnMessages">
                    @if(Session::has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>
                        <strong>
                            <i class="icon-ok"></i>
                            {{Session::get('message')}}
                        </strong>
                    </div>
                    @endif
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">District : </label>
                        <div class="controls">
                            <select name='district' required="true" id="district" required="true">
                                <option></option>
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
                                
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
				
				
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Year : </label>
                        <div class="controls">
                            <select name='Year' id='Year' required="true" >
                                <option value="">--- Select Year ---</option>
								<option value="{{date('Y')-2}}" @if($year_R == date('Y')-2) selected @endif>{{date('Y')-2}}</option>
								<option value="{{date('Y')-1}}" @if($year_R == date('Y')-1) selected @endif>{{date('Y')-1}}</option>
                                <option value="{{date('Y')}}" @if($year_R == date('Y')) selected @endif>{{date('Y')}}</option>
                                <option value="{{date('Y')+1}}"  @if($year_R == date('Y')+1) selected @endif>{{date('Y')+1}}</option>
								<option value="{{date('Y')+2}}"  @if($year_R == date('Y')+2) selected @endif>{{date('Y')+2}}</option>
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                        <div class="controls">
                            <select name="CourseListCode" id="CourseListCode" required="true">
                                <option value=""></option>
                                @foreach($CourseListCode as $clc)
                                <option value="{{$clc->CD_ID}}">{{$clc->CourseListCode}} - {{$clc->CourseName}}  -{{$clc->CourseType}}- ({{$clc->Nvq}}) - {{$clc->CourseLevel}} -{{$clc->Duration}} - Months</option>
                                @endforeach
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
				 <div class="control-group">
                    <label class="control-label" for="CourseLevel">Course Level : </label>
                        <div class="controls">
                            <select name="CourseLevel" id="CourseLevel" required="true">
                                <option></option>                                
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Batch : </label>
                        <div class="controls">
                            <select name='batch' required="true">
                                <option></option>
                                <option @if($batch_R == '1') selected @endif>1</option>
                                <option @if($batch_R == '2') selected @endif>2</option>
								<option @if($batch_R == '1.2') selected @endif>1.2</option>
								<option @if($batch_R == '2.2') selected @endif>2.2</option>
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Parallel Batch : </label>
                        <div class="controls">
                            <select name='parallel_batch'>
                                <option value=""></option>
                                <option @if($parallel_batch_R == 'Yes') selected @endif>Yes</option>
                                <option @if($parallel_batch_R == 'No') selected @endif>No</option>
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Medium : </label>
                        <div class="controls">
                            <select name='medium' required="true">
                                <option value=""></option>
                                <option value="S" @if($medium_R == 'S') selected @endif>Sinhala</option>
                                <option value="T" @if($medium_R == 'T') selected @endif>Tamil</option>
                                <option value="E" @if($medium_R == 'E') selected @endif>English</option>
                                <option value="O" @if($medium_R == 'O') selected @endif>Other</option>
                            </select>
                            <span class="lbl" style="color: red"><b>*</b></span>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Max Capacity : </label>
                    <div class="controls">
                        <input type="number" name="maxCapacity" min="1" />
                        <span class="lbl" style="color: red"><b></b></span>
                    </div>
                </div>
				 <div class="control-group">
                    <label class="control-label" for="CourseListCode">Real Start Date : </label>
                    <div class="controls">
                        <input type="date" name="RealstartDate" id="RealstartDate" required />
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">Real End Date : </label>
                    <div class="controls">
                        <input type="date" name="RealEndDate" id="RealEndDate" required />
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
               
                 <div class="control-group">
                    <label class="control-label" for="attachedCenter">Attached Centre : </label>
                        <div class="controls">
                            <select name='attachedCenter' id='attachedCenter'>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                </div>
                <div id="abc">
                </div>
               
                <!--<div class="control-group">
                    <label class="control-label" for="attachedCenter">Accredit  : </label>
                        <div class="controls">
                            <select name='Accredit' id='Accredit'>
								<option value="">---Select---</option>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
								 <option value="Recommended">Recommended</option>
                            </select>
                        </div>
                </div>
               	<div class="control-group" id="rec">
                    <label class="control-label" for="AccreditDate">Accredit Recommended Date : </label>
                        <div class="controls">
                           <input type="Date" name="AccreditRecommendDate" id="AccreditRecommendDate" />
                        </div>
                </div>
				
					 <div class="control-group" id="accd">
                    <label class="control-label" for="AccreditDate">Accredit Date : </label>
                        <div class="controls">
                           <input type="Date" name="AccreditDate" id="AccreditDate"  />
                        </div>
                </div>
				<div class="control-group" id="accvd">
                    <label class="control-label" for="AccreditationValidDate">Accredit Valid Date : </label>
                        <div class="controls">
                           <input type="Date" name="AccreditationValidDate" id="AccreditationValidDate" />
                        </div>
                </div>-->
              
			   
			 
			   
         

                
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-block btn-primary" value="Create"/>
                    </div>
                </div>
                <div class="control-group">
                   
                    <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                                 Instructor Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
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
<script>
   
            $('table th input:checkbox').on('click', function() {
    var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function() {
            this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
            });
    });
            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
            function tooltip_placement(context, source) {
            var $source = $(source);
                    var $parent = $source.closest('table')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();
                    var off2 = $source.offset();
                    var w2 = $source.width();
                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                    return 'right';
                    return 'left';
            }
</script>
<script type="text/javascript">

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
		/* 
       var m = document.getElementById("Accredit").value;
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

</script>

<script>

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
                        if ($('#addModule').is(':hidden')) {
                            $('#addModule').show();
                        } else {
                            $('#addModule').hide();
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
      
 <script>
 $(document).ready(function() {
                                    var district_R = "{{$district_R}}";
                                    if (district_R) {
                                        change_district(district_R);
                                        setTimeout(afterOneSeconds, 200);
                                    }
                                });
 function afterOneSeconds(){
    var orgID_R = "{{$orgID_R}}";
                                    if (orgID_R) {
                                        $("#OrgId").val(orgID_R).change();
                                    }
 }
 </script> 
 <script type="text/javascript">
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
                                
                                
                        
</script>         
               
               
               
      
        
        

    
