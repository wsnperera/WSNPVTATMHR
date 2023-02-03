@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('ViewIROJTVacancy')}}> << Back to OJT Vacancy</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>OJT Vacancy<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
		@if($user->hasPermission('CreateIROJTVacancy'))
             <form name='search' action="{{url('CreateIROJTVacancy')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-primary">
                <i class="icon-pencil bigger-100"></i>Create OJT Vacancy</button>
			 </form>
	    @endif
		
		 <hr/>
		 @if(isset($quorga))
			 
		 <table>
    <tr>
       
        <td>
            <form name='search' action="{{url('PrintOJTVacancy')}}" method='POST' class="form-horizontal">
               
                <button type="submit" id="search" class="btn btn-warning">
                <i class="icon-download-alt bigger-200"></i>Download</button>
               
            </form> 
        </td>
    </tr>
    </table>
	
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                
				<thead>
					<tr>
						<th>No</th>
						<th>District</th>
						<th>DS Division</th>
						<th>Company Name</th>
						<th>Address</th>
						<th>Trade</th>
						<th>Course Category</th>
						<th>Training Area</th>
						<th>Vacancy Type</th>
						<th>Vacancy (Female)</th>
						<th>Vacancy (Male)</th>
						<th>Vacancy (Common)</th>
						<th>Total No of Vacancies</th>
						<th>Vacancy Placed(Female)</th>
						<th>Vacancy Placed(Male)</th>
						
						<th>Total No of Vacancies Placed</th>
						<th>Data Entered District</th>
						<th>Data Entered Centre</th>
						<th>Data Entered User</th>
						<th>Active</th>
						<th>Edit</th>
						<th>Remove</th>
					</tr>
				
                </thead>
                 <tbody>
                    <?php $i = 1;

                    ?>
               
                    @foreach($quorga as $mc)
                  
                    <tr>
                       <td>{{$i++}}</td> 
					   <td>{{$mc->DistrictName}}</td>
					   <td>{{$mc->ElectorateName}}</td>
					   <td>{{$mc->CompanyName}}</td>
					   <td>{{$mc->Address}}</td>
					   <td>{{$mc->TradeName}}</td>
					   <td>{{$mc->Category}}</td>
					   <td>{{$mc->TrainingArea}}</td>
					   <td>
					   @if($mc->VacancyType == 'GenderBased')
						   Gender Based Vacancies 
					   @else 
						   Common Vacancies 
					   @endif
					   </td>
					   @if($mc->VacancyType != 'GenderBased')
					   <td>0</td>
					   <td>0</td>
					   <td>{{$mc->VacancyFemale}}</td>
					   @else
					   <td>{{$mc->VacancyFemale}}</td>
					   <td>{{$mc->VacancyMale}}</td>
					   <td>0</td>
					   @endif
					   
					   <td>{{$mc->VacancyFemale+$mc->VacancyMale}}</td>
					   <?php
					   $Ocvac = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvac
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$mc->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Female'"));
					    $newdata =  json_decode(json_encode((array)$Ocvac),true);
						$OccuipFemale = $newdata[0]["occupiedvac"];
						
						$OcvacM = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvacm
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$mc->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Male'"));
					    $newdataM =  json_decode(json_encode((array)$OcvacM),true);
						$OccuipMale = $newdataM[0]["occupiedvacm"];
						
					   ?>
					   
					   @if($mc->VacancyType != 'GenderBased')
					   <td>{{$OccuipFemale}}</td>
					   <td>{{$OccuipMale}}</td>
					   <td>{{$OccuipFemale + $OccuipMale}}</td>
					  
					   @else
					   <td>{{$OccuipFemale}}</td>
					   <td>{{$OccuipMale}}</td>
					   <td>{{$OccuipFemale + $OccuipMale}}</td>
					   @endif
					   
						<td>{{$mc->userdistrict}}</td>
					   <td>{{$mc->UserOrganisationName}}</td>
					   <td>{{$mc->Initials}} {{$mc->LastName}}</td>
					
					   <td>
					   @if($mc->Active == 1) <font color="green"><i class="icon-ok bigger-130"></i></font>
					   @else <font color="red"><i class="icon-remove bigger-130"></i></font>
					   @endif
					   </td>
                      <td>
					   @if($user->hasPermission('EditIROJTVacancy'))
						   <form id="deleteform"  action='EditIROJTVacancy' method="GET">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteIROJTVacancy'))
							@if(($OccuipFemale + $OccuipMale) == 0)
							 <form id="deleteform"  action='DeleteIROJTVacancy' method="POST" onsubmit="return doConfirm('{{$mc->Category}}',this)">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-1x icon-only"></i></button>
                            </form>
							@endif
						@endif
						</td>
                   </tr>
                        @endforeach
                    
                @endif
        </tbody>
            </table>
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
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
     

    function doConfirm(course,formobj)  {
        bootbox.confirm("Are you sure you want to remove "+course, function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
     }
     
      @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
$('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
			{"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
			{"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
			{"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
			{"bSortable": false},
            {"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},{"bSortable": false}
             
             
            
    ]});
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
 <script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
	
	 $('#Decative').click(function()
    {
      
        var Year = $("#YearP").val();
	//	alert(Year);
		 $.ajax({
		   
		   beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
            
            url: "{{url::to('DeactivateHrEmploymentCode')}}",
            data: {Year: Year},
          //  dataType: 'json',
            success: function(result) {

                  location.reload();  

            },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";
							

                        }
            });
		
		
       //alert(CD_ID);
      
 
        
    });


       $("#CourseListCode").change(function() {
        var cid = $("#CourseListCode").val();
        var msg = '---Select Module---';
		var All = 'All';
        $("#ModuleID").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadQuestionModuleCourse')}}",
            data: {CourseListCode: cid},
            success: function(result) {
                $("#ModuleID").append("<option value=''>" + msg + "</option>");
				$("#ModuleID").append("<option value='All'>" + All + "</option>");
                $.each(result, function(i, item)
                {



                    $("#ModuleID").append("<option value=" + item.ModuleId + ">" + item.ModuleCode +  "-" + item.ModuleName + "</option>");



                });

            }
        });
    });
       $("#ModuleID").change(function() {

        var mid = $("#ModuleID").val();
       // alert(mid);
        var cid = $("#CourseListCode").val();
        var msg = '---Select Task---';
		var All = 'All';
        $("#T_Code").html('');
        
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadQuestionModuleTask')}}",
            data: {ModuleId: mid,CD_ID: cid},
            dataType: 'json',
            success: function(result) {
                $("#T_Code").append("<option value=''>" + msg + "</option>");
				$("#T_Code").append("<option value='All'>" + All + "</option>");
                $.each(result, function(i, item)
                {



                    $("#T_Code").append("<option value=" + item.id + ">" + item.TaskCode +  "-" + item.TaskName + "</option>");



                });

            }
        });
    });
        
    
      $('#upload').click(function()
    {
      
        var YearP = $("#YearP").val(); 
        //var ModuleId = $("#ModuleIDP").val(); 
        //var TaksId = $("#TaskIdP").val(); 
      //alert(YearP); 
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintHrEmploymentCode')}}",
                        data: {YearP: YearP},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    ); 

   
    
   
   
    
   
  
</script>