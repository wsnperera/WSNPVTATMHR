@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeOLResults')}}"> << Back to HR - Employee O/L Results  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
           HR -  Employee O/L Results	
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeeOLResults'))
             <form name='search' action="{{url('CreateHREmployeeOLResults')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Employee O/L Results</button>
			 </form>
	    @endif
		
		 <hr/>
        <div class="span10">
            <!--PAGE CONTENT BEGINS-->
			@if(isset ($quorga))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                        <th rowspan="2">Employee Name</th>
                        <th rowspan="2">NIC </th>
                        <th rowspan="2">EPF</th>
						<th rowspan="2">Attempt</th>
						<th rowspan="2">Medium</th>
						<th colspan="4" class="center">Exam Details</th>
						<th rowspan="2">View Results</th>
						<th rowspan="2"> @if($user->hasPermission('EditHREmployeeOLResults')) Edit Results @endif</th>
                        <th rowspan="2">@if($user->hasPermission('DeleteHREmployeeOLResults')) Remove  @endif </th>
                    </tr>
                    <tr>
						<th class="center">Year</th>
						<th class="center">Month</th>
						<th class="center">Centre No</th>
                        <th class="center">Index No</th>
						
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i = 1; ?>
                    @foreach ($quorga as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                     
                        <td>{{$eq->Initials}} {{$eq->LastName}}</td>
                        <td>@if($eq->NIC == $eq->OldNIC || $eq->OldNIC == ""){{$eq->NIC}} @else {{$eq->NIC}} [{{$eq->OldNIC}}]@endif</td>
						<td>{{$eq->EPFNo}}</td>
						<td>{{$eq->Attempt}}</td>
						<td>{{$eq->Medium}}</td>
						<td>{{$eq->Year}}</td>
						<td>{{$eq->Month}}</td>
						<td>{{$eq->CentreNo}}</td>
                        <td>{{$eq->IndexNo}}</td>
                        <td class='center'><font color="pink"><a class="pink"  id="{{$eq->id}}"> <i class="icon-eye-open bigger-200"></i></a> </font></td>
                     
                       
                       <td>
					   @if($user->hasPermission('EditHREmployeeOLResults'))
						   <form id="deleteform"  action='EditHREmployeeOLResults' method="GET">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
							
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteHREmployeeOLResults'))
							 <form id="deleteform"  action='DeleteHREmployeeOLResults' method="POST" onsubmit="return doConfirm('{{$eq->Attempt}}- {{$eq->Year}}- {{$eq->NIC}}',this)">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
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
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
                                                function doConfirm(empqua, formobj) {
                                                bootbox.confirm("Are you sure you want to remove O/L results of the Employee Attempt " + empqua, function(result) {
                                                if (result) {
                                                formobj.submit();
                                                }
                                                });
                                                        return false; // by default do nothing hack :D
                                                }

                                         $('#sample-table-2').dataTable({
                                        "aoColumns": [
                                        {"bSortable": false}, {"bSortable": false},
                                        {"bSortable": false},{"bSortable": false}, 
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false}
										
                                        ]});
                                               
												

</script>
<script type="text/javascript">
$(".pink").click(function(){

     var id = this.id;
    // alert(id);
	 
     $.ajax({
                    url: "{{url::to('HREmployeeOLResultsSheet')}}",
                    data: {id: id},
                     dataType: "json", 
                   success: function(result) {
					   var c=1;
						var x = '<form id="infos" action=""><div class="control-group">'
						  + '<div  class="controls"><table '
						  + 'class="table table-striped table-bordered table-hover" style="width:100%" style="border-style: solid;border-color: green green green green;border-width: thick;;"><thead><tr>'
						  + '<th>No</th>'
						  +'<th>Subject</th>'
						  +'<th>Result</th>'
						  +'</tr></thead><tbody>';
                         $.each(result, function(i, item)
                        {

							x +='<tr><td>'+ c +'</td>'
							+'<td>'+item.Subject+'</td>'
							+'<td>'+item.Grade+'</td></tr>';
							

							c = c +1;


                        });   
						x+='</tbody</table</div></div></form>';
                        bootbox.alert(x,'Close');
                        }

                         
                    
                });

   }); 
</script>