@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeServiceLettersIssued')}}"> << Back to HR - Employee ServiceLetters  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
           HR -  Employee Service Letters
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeeServiceLetters'))
             <form name='search' action="{{url('CreateHREmployeeServiceLetters')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Employee Service Letter</button>
			 </form>
	    @endif
		
		 <hr/>
        <div class="span10">
            <!--PAGE CONTENT BEGINS-->
			@if(isset ($quorga))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee Name</th>
                        <th>NIC </th>
                        <th>EPF</th>
						<th>Date Issued</th>
						<th>Address To</th>
						<th>Personal File No</th>
						<th>Issued By</th>
						<th>Remove</th>
                    </tr>
                   
                </thead>
                <tbody>
                    
                    <?php $i = 1; ?>
                    @foreach ($quorga as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$eq->Initials}} {{$eq->LastName}}</td>
                        <td>{{$eq->NIC}}</td>
						<td>{{$eq->EPFNo}}</td>
						<td>{{$eq->DateIssued}}</td>
						<td>{{$eq->AddressTo1}},<br/>{{$eq->AddressTo2}},<br/>{{$eq->AddressTo3}},<br/>{{$eq->AddressTo4}},<br/>{{$eq->AddressTo5}},<br/>{{$eq->AddressTo6}}</td>
						<td>{{$eq->FileNo}}</td>
						<td>{{$eq->userinitials}} {{$eq->userlastname}}</td>
                        <td>
						@if($user->hasPermission('DeleteHREmployeeServiceLetter'))
							 <form id="deleteform"  action='DeleteHREmployeeServiceLetter' method="POST" onsubmit="return doConfirm('{{$eq->Initials}} {{$eq->LastName}}',this)">
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
										{"bSortable": false},
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