@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('ViewIRCompany')}}> << Back to Company</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>Company<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
		@if($user->hasPermission('CreateIRCompany'))
             <form name='search' action="{{url('CreateIRCompany')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-primary">
                <i class="icon-pencil bigger-100"></i>Create Company</button>
			 </form>
	    @endif
		
		 <hr/>
		 @if(isset($quorga))
			 	 
		 <table>
    <tr>
       
        <td>
            <form name='search' action="{{url('PrintOJTCompany')}}" method='POST' class="form-horizontal">
               
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
					<!--	<th>Trade of the Company</th>-->
						<th>Company Name</th>
						<th>Address</th>
						<th>District</th>
						<th>DS Division</th>
						<th>Tel</th>
						<th>Email</th>
						<th>Coordinator's Name</th>
						<th>Coordinator's Mobile</th>
						<th>Company Type</th>
						<th>Owership</th>
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
					  <!-- <td>{{$mc->TradeName}}</td>-->
					   <td>{{$mc->CompanyName}}</td>
					   <td>{{$mc->Address}}</td>
					   <td>{{$mc->DistrictName}}</td>
					   <td>{{$mc->ElectorateName}}</td>
					   <td>{{$mc->TelNo}}</td>
					   <td>{{$mc->Email}}</td>
					   <td>{{$mc->CoordinationOfficerName}}</td>
					   <td>{{$mc->COMobille}}</td>
					   <td>{{$mc->CompanyType}}</td>
					   <td>{{$mc->Ownership}}</td>
					   <td>{{$mc->userdistrict}}</td>
					   <td>{{$mc->UserOrganisationName}}</td>
					   <td>{{$mc->Initials}} {{$mc->LastName}}</td>
					    <td>@if($mc->Active == 1) <font color="green"><i class="icon-ok bigger-130"></i></font>
					   @else <font color="red"><i class="icon-remove bigger-130"></i></font>
					   @endif
					   </td>
                      <td>
					   @if($user->hasPermission('EditIRCompany'))
						   <form id="deleteform"  action='EditIRCompany' method="GET">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteIRCompany'))
							
							 <form id="deleteform"  action='DeleteIRCompany' method="POST" onsubmit="return doConfirm('{{$mc->CompanyName}}',this)">
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
         //   {"bSortable": false},
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