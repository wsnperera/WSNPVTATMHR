@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployee')}}"> << Back to Employee </a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                HR - Employee		
                <small>
                    <i class="icon-double-angle-right"></i>
                    View
                </small>			
            </h1>
        </div>

      <div class="span12">
		<form>	  
            @if($user->hasPermission('CreateHREmployee'))
            <a href="{{url('CreateHREmployee')}}"><button type="button" id="submit" class="btn btn-success">
                <i class="icon-pencil bigger-100"></i>Create Employee</button></a>
            @endif
			
			<br/>
			<hr/>
       

        <div class="span16">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>

                    <th rowspan='3'>#No#</th>
                    
                    <th rowspan='3'>Current Organisation</th> 
                    <th rowspan='3'>EPF No</th>
					<th rowspan='3'>Photograph</th>
                    <th colspan='3' style="text-align: center"> Employee Name</th>
                    <th rowspan='3'>NIC</th>	
                    <th rowspan='3'>DOB</th>
                    <th rowspan='3'>Sex</th>
                    <th rowspan='3'>Civil Status</th>
                    <th rowspan='3'>Race</th>
                    <th rowspan='3'>Religion</th>
                    <th rowspan='3'>Blood Group</th>
                    <th rowspan='3'>Passport No</th>
                    <th rowspan='3'>DS Division</th>
                    <th rowspan='3'>District Name</th>
                    <th colspan='2' style="text-align: center">Address</th>
                    <th colspan='6' style="text-align: center">Contact Details</th>
                    <th colspan='2' style="text-align: center">Academic Field</th>
					<th rowspan='3'>Add New NIC</th>
					<th rowspan='3'>Add New EPF</th>
					<th rowspan='3'>Mark Personal File Completed</th>
                    <th rowspan='3'>@if($user->hasPermission('DeleteHREmployee')) Remove @endif</th>	
                </tr>
                <tr> 
                    <th rowspan='2'>Initials</th>
                    <th rowspan='2'>Name</th>
                    <th rowspan='2'>Last Name</th>
                    <th rowspan='2'>Permanent </th>
                    <th rowspan='2'>Current </th>
                    <th colspan='3' style="text-align: center">Personal</th>
                    <th colspan='3' style="text-align: center">Official</th>
					<th rowspan='2'>Trade</th>
                    <th rowspan='2'>Course Name</th>
				
                    
                </tr>
                <tr>
                    <th >Land Line</th>
                    <th >Mobile</th>
                    <th >Email</th>
                    <th >Land Line</th>
                    <th >Mobile</th>
                    <th >Email</th>
					
                </tr>
                 </thead>
                 
                 <tbody>
<?php $i = 0; ?>
                @if(isset ($Employee))
                @foreach ($Employee as $e)
                <tr>
                    <td><?php $i++;echo $i; ?></td>
                   
                    <td><?php $CoverUpId = TransferType::where('Deleted','!=',1)->where('TransferType','LIKE','Cover%')->pluck('T_ID');
                        $EmpProOrgId =HRPromotion::where('Emp_ID','=',$e->id)->where('CurrentRecord','=','Yes')->where('TransferType','!=',$CoverUpId)->pluck('ToOrganisation');
                                  $EmpProOrgName =Organisation::where('id','=',$EmpProOrgId)->pluck('OrgaName');
                                   ?>
					{{$EmpProOrgName}}
					</td>
					
                   
					
					<td class="center">@if($user->hasPermission('EditHREmployee'))
                        <a href="{{url('EditHREmployee?cid='.$e->id)}}"><input type='button' value='{{$e->EPFNo}}' class="btn btn-small btn-primary" /></a>
                    
                        @endif
					
					</td>
					<td class="center">
					<!-- Photograph-->
					
					<img src="{{Url($e->Photograph)}}"  height="100" width="90"/>
					
					</td>
					
					
					
					
                    <td>{{$e->Initials}} </td>  
                    <td>{{$e->Name}} </td> 
                    <td>{{$e->LastName}} </td> 
                    <td>
						@if($e->NIC != $e->OldNIC)
						 {{$e->NIC}} [{{$e->OldNIC}}] 
						@else
						 {{$e->NIC}}
						@endif
					</td>  
                    <td>{{$e->DOB}} </td>
                    <td>{{$e->Sex}} </td>   
                    <td>{{$e->CivilStatus}} </td> 
                    <td>{{$e->Race}}</td>
                    <td>{{$e->Religion}}</td>
                    <td>{{$e->BloodGroup}} </td>
                    <td>{{$e->PassportNo}} </td>
					<?php
					$ElectorateName = Electorate::where('ElectorateCode','=',$e->DSDivision)->pluck('ElectorateName');
					$DistrictNAme = District::where('DistrictCode','=',$e->DistrictName)->pluck('DistrictName');
					?>
                    <td>{{$ElectorateName}} </td>  
                    <td>{{$DistrictNAme}}</td>
                    <td>{{$e->PAddress}} </td>
                    <td>{{$e->CAddress}} </td>
                    <td>{{$e->Contact}} </td>
                    <td>{{$e->Mobile}} </td>
                    <td>{{$e->Email}} </td>
                    <td>{{$e->OContact}} </td>
                    <td>{{$e->OMobile}} </td>
                    <td>{{$e->OEmail}} </td>
                    <td>
					<?php
					$getTradeName = Trade::where('TradeId','=',$e->Trade)->pluck('TradeName');
					$getCourseName = HREmployeeTradeCourse::where('id','=',$e->TradeCourseId)->pluck('CourseName');
					?>
					{{$getTradeName}} 
					</td>
					<td>
					{{$getCourseName}} 
					</td>
					<td><font color="green"><a class="green"  id="{{$e->id}}"> <i class="icon-smile icon-3x"></i></a> </font></td>
					<td><font color="pink"><a class="pink"  id="{{$e->id}}"> <i class="icon-wrench icon-3x"></i></a> </font></td>
					<td class='center'>
					@if($e->PersonalFileCompleted == 0)
						@if($user->hasPermission('DeleteHREmployee'))
							<font color="blue"><a class="blue"  id="{{$e->id}}"> <i class="icon-thumbs-up icon-3x"></i></a> </font>
						@endif
					@else
						Completed
					@endif
					
					</td>
                    <td>@if($user->hasPermission('DeleteHREmployee'))
                        <form id="deleteform"  action="{{url('DeleteHREmployee?id='.$e->id)}}" method="POST" onsubmit="return doConfirm('{{$e->NIC}}', this)">
                            <input type="hidden" name='cid' value="{{$e->id}}" />
                            <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                        </form>@endif
                    </td>
                </tr>
                @endforeach
                @endif
                 </tbody>
            </table>
			</form>
			</div>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">

            function doConfirm(Employee, formobj)  {
            bootbox.confirm("Are you sure you want to remove " + Employee, function(result)  {
            if (result){
            formobj.submit();
            }
            });
                    return false; // by default do nothing hack :D
            }
$('#sample-table-2').dataTable({
    "bPaginate":false,
    "aaSorting":[],
    "aoColumns": [
            {"bSortable": false},{"bSortable": false},null, null, {"bSortable": false},null,null,null,{"bSortable": false},{"bSortable": false},
            {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false}, {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
            {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false}
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
<script type="text/javascript">
$( document ).ready(function() {
	
	 $(".green").click(function(){

     var id = this.id;
     //alert(id);
	 
	  var x = '<form id="infos" action="" style="border-style: solid;border-color: pink pink pink pink;border-width: thick;">'
      + '<table'
      + 'boder="2" cellspacing="2"><div class="control-group"><div  class="controls"><tr>'
      + '<td cellspacing="2"><br/>&nbsp&nbspNew NIC:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea cols="4000" rows="2" name="NIC" id="NIC" required="true"></textarea></td></tr></div></div><table></form>';
	  
	  
 bootbox.confirm(x, function(result) {
        if(result)
        {
           

         var NIC = $("#NIC").val();
         if(NIC == "")
		 {
			 bootbox.alert('Plase Enter NIC!!!');
		 }
		 else
		 {
			 doStuffWithResults(id,NIC);
		 }


        
        }
});  

  
});
function doStuffWithResults(id,NIC) {
	


     $.ajax  ({
                    url: "{{url::to('AddHREmployeeNIC')}}",
                    data: { id: id,NIC: NIC},
                    
                   success: function(result) {
					   if(!bootbox.alert('NIC Added Successfully!!!!!')){window.location.reload();}

                        
                        }


                    
                });
   
}
 $(".pink").click(function(){

     var id = this.id;
     //alert(id);
	 
	  var y = '<form id="infos" action="" style="border-style: solid;border-color: pink pink pink pink;border-width: thick;">'
      + '<table'
      + 'boder="2" cellspacing="2"><div class="control-group"><div  class="controls"><tr>'
      + '<td cellspacing="2"><br/>&nbsp&nbspNew EPF No:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea cols="4000" rows="2" name="EPF" id="EPF" required="true"></textarea></td></tr></div></div><table></form>';
	  
	  
 bootbox.confirm(y, function(result) {
        if(result)
        {
           

         var EPF = $("#EPF").val();
		 
         if(EPF == "")
		 {
			 bootbox.alert('Plase Enter EPF!!!');
		 }
		 else
		 {
			 doStuffWithResultsEPF(id,EPF);
			 //alert(EPF);
		 }


        
        }
});  

  
});
function doStuffWithResultsEPF(id,EPF) {
	


     $.ajax  ({
                    url: "{{url::to('AddHREmployeeEPF')}}",
                    data: { id: id,EPF: EPF},
                    
                   success: function(result) {

                  
            if(!bootbox.alert('EPF No Added Successfully!!!!!')){window.location.reload();}
                        
					   
					  
                        
                        }


                    
                });
   
}

 $(".blue").click(function(){

     var id = this.id;
     //alert(id);


     $.ajax  ({
                    url: "{{url::to('HrEmployeepersonalfileCompleted')}}",
                    data: { id: id},
                    
                   success: function(result) {

                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });
  
});

});
</script>