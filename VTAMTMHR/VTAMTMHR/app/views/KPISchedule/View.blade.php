@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>Schedule KPI<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
		@if($user->hasPermission('CreateKPISchedule'))
             <form name='search' action="{{url('CreateKPISchedule')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-primary">
                <i class="icon-pencil bigger-100"></i>Create Schedule</button>
			 </form>
	    @endif
		<hr/>
        <div class="span12">
		
		 @if(isset($SalaryScales))
	
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                
				<thead>
					<tr>
						<th>No</th>
						<th>Year</th>
						<th>Quater</th>
						<th>Description</th>
						<th>Final Submission Date</th>
						<th>End the Schedule</th>
						<th>Edit</th>
						<th>Remove</th>
					</tr>
				
                </thead>
                 <tbody>
                    <?php $i = 1;

                    ?>
               
                    @foreach($SalaryScales as $mc)
                  
                    <tr>
                       <td>{{$i++}}</td> 
                       <td>{{$mc->Year}}</td>
                       <td>{{$mc->Quater}}</td>
					   <td>{{$mc->Description}}</td>
                       <td>{{$mc->SubmissionDate}}</td>
					 
					   <td class='center'>
					   @if($mc->EndingStatus == '0')
					   
							 <form id="Endform"  action='EndKPISchedule' method="POST" onsubmit="return doConfirmEnd('{{$mc->Year}}-{{$mc->Quater}}',this)">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-warning btn-small">End Now<i class="icon-ok icon-1x icon-only"></i></button>
                            </form>
						
				       @else
					   <font color="red">Schedule Ended<i class="icon-remove bigger-130"></i></font>
				       @endif
					   </td>
                     
                       <td>
					   @if($user->hasPermission('EditKPISchedule'))
						   <form id="deleteform"  action='EditKPISchedule' method="GET">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteKPISchedule'))
							 <form id="deleteform"  action='DeleteKPISchedule' method="POST" onsubmit="return doConfirm('{{$mc->Year}}-{{$mc->Quater}}',this)">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-1x icon-only"></i></button>
                            </form>
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
     
	function doConfirmEnd(course,formobj)  {
        bootbox.confirm("Are you sure you want to End the  "+course, function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
     }
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
            
            url: "{{url::to('DeactivateHrServiceCategory')}}",
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



</script>