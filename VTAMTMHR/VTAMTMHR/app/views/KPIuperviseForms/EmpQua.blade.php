@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>KPI Supervise Forms<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
  
        
       

       
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                        <tr>
                            <th>No</th>
                            <th>EPF No</th>
							<th>Name With Initials</th>
							
							<th>Current Center</th>
							<th>Division</th>
							<th>Designation</th>
							<th>Employee Type</th>
                            <th>Supervise KPI Form</th>
							<th>View KPI Form</th>
							<th>Approve & Complete the Supervision</th>

                           
                        </tr>
                 </thead>
                 <tbody>
                    <?php
                        $i = 1;
                    ?>
                @if(isset($moduleTask))
                    @foreach($moduleTask as $mc)
                    <tr>
                        <!--<td><b><u><a href="{{url('editModuleCourse?id='.$mc->EmpId)}}">{{$mc->EmpId}}</a></u><b></td>-->
                       <td>{{$i++}}</td>
                       <td>{{$mc->EPFNo}}</td>
                       <td>{{$mc->Initials}} {{$mc->LastName}}</td>
                       <td>{{$mc->OrgaName}}</td>
                       
                       <td>{{$mc->DepartmentName}}</td>
                       <td>{{$mc->Designation}}</td>
					   <td>{{$mc->EmployeeType}}</td>
                     
					
					    <td class='center'>
						@if($mc->SupervisorCompletedStatus == 0)
						
							<a href="{{url('CreateKPISuperviseForm?id='.$mc->id)}}"><button type="button" class="btn btn-purple btn-mini"><i class="icon-edit icon-2x icon-only"></i></button></a>
						@endif
						</td>
                       <td class='center'>
					
							<a href="{{url('ViewSeltKPISuperviseForm?id='.$mc->id)}}"><button type="button" class="btn btn-pink btn-mini"><i class="icon-edit icon-2x icon-only"></i></button></a>
						 
						</td>
					    <td class='center'> 
						@if($mc->SupervisorCompletedStatus == 0)

						<font color="Blue"><a class="Blue"  id="{{$mc->id}}"> <i class="icon-thumbs-up bigger-250"></i></a> </font>
						@else
								<font color="red">Approved & Completed</font>
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
	"bPaginate":false,
    "aaSorting":[],
    "aoColumns": [
            {"bSortable": false},   {"bSortable": false}, 

            {"bSortable": true}, {"bSortable": true},
              {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
             
             
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


             $('#upload').click(function()
    {
      
        var CD_ID = $("#CD_IDP").val(); 
       
      alert(CD_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintModuleTaskSeq')}}",
                        data: {CD_ID: CD_ID},
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

 $(".Blue").click(function(){

     var id = this.id;
     //alert(id);


     $.ajax  ({
                    url: "{{url::to('KPIApproveCompleteForm')}}",
                    data: { id: id},
                    
                   success: function(result) {

                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });
  
});

 </script>