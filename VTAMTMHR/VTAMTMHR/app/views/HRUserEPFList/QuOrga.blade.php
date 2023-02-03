@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('ViewHRExperienceDesignation')}}> << Back to Experience Designation</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>User EPF No List<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
		@if($user->hasPermission('CreateHRUserEPFList'))
             <form name='search' action="{{url('CreateHRUserEPFList')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-primary">
                <i class="icon-pencil bigger-100"></i>Create</button>
			 </form>
	    @endif
		
		 <hr/>
		 @if(isset($quorga))
	
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                
				<thead>
					<tr>
						<th class='center'>No</th>
						<th class='center'>EPF No</th>
						<th >Personal File Owner</th>
						<th >Centre (Type)</th>
						<th class='center'>Active Status</th>
						<th class='center'>Edit</th>
						<th class='center'>Remove</th>
					</tr>
				
                </thead>
                 <tbody>
                    <?php $i = 1;

                    ?>
               
                    @foreach($quorga as $mc)
                  
                    <tr>
                       <td class='center'>{{$i++}}</td> 
					   <td class='center'>{{$mc->EPFNo}}</td>
					   <td>{{$mc->Initials}} {{$mc->LastName}}</td>
					   <td>{{$mc->OrgaName}} ({{$mc->Type}})</td>
					     <td class='center'>
						 <font color='green'>
						 @if($mc->Active == 1)
							  <i class="icon-ok bigger-130"></i>
							 @else
								 <i class="icon-remove bigger-130"></i>
								 @endif</td></font>
                      <td class='center'>
					   @if($user->hasPermission('EditHRUserEPFList'))
						   <form id="deleteform"  action='EditHRUserEPFList' method="GET">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
					   @endif
						</td>
                        <td class='center'>
						@if($user->hasPermission('DeleteHRUserEPFList'))
							 <form id="deleteform"  action='DeleteHRUserEPFList' method="POST" onsubmit="return doConfirm('{{$mc->EPFNo}}',this)">
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
              {"bSortable": false}, {"bSortable": false},
             {"bSortable": false}, {"bSortable": false},
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