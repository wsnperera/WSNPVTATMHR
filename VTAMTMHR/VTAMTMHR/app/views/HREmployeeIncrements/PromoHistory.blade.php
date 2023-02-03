@include('includes.bar')       
@if(isset($Issearch))

@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR - Employee Increments 	
            <small>
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>

    </div><!--/.page-header-->
    <div class="row-fluid">
			<form class="form-horizontal" action="" method="POST" name="form1"  >
				<table>
					<tr>
					<td>
					  <div class="control-group">
							<label class="control-label" for="form-field-1"></label>
								<div class="controls">
								<select id="SType" name="SType" required>
								<option value="">---Select Type---</option>
								<option value="NIC">Search using NIC</option>
								<option value="EPF">Search using EPF</option>
								</select>
								<input type="text" name="NIC" id="NIC" placeholder="Type NIC/EPF Here....." required/> 
								<input type="submit"  value="Search Employee Loan" class="btn btn-small btn-warning"/>
								</div>
					  </div>
					</td>
						
				   
							
				   
						
					</tr>
				</table>
			</form>
        
      
	  <hr/>
     @if(isset ($Employeerec))
	  <br/>
	   <div class="span3">   
        <center>
            <span class="profile-picture">
               
                <img id="avatar" class="editable" height="600" width="150" alt="Alex's Avatar" src="{{Url($Employeerec->Photograph)}}" />
              
            </span>

        </br></br>

        <div class="width-70 label label-info label-large arrowed-in arrowed-in-right">
            <div class="inline position-relative">
                <center><span class="white middle bigger-120">{{$Employeerec->Initials}} {{$Employeerec->LastName}}</span></center>
            </div>
        </div>
		<br/><br/>
    </div>
    @endif
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
			 @if(isset ($promotion))
              <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class='center'>No</th>
						<th class='center'>Deatails Edit</th>
                        <th class='center'>Current Organisation</th>
                       
                        <th class='center'>NIC</th>
						  <th class='center'>EPF No</th>
                        <th class='center'>Designation</th>
                        <th class='center'>Service Category</th>
                        <th class='center'>Step No</th>
                        <th class='center'>Increment Date</th>
                        <th class='center'>Approve Status</th>
                        <th class='center'>Reason To Reject</th>
						<th class='center'>Temporary Hold Months</th>
						<th class='center'>Reactivated Date</th>
						<th class='center'>Gross Salary</th>
						
						<th class='center'>@if($user->hasPermission('DeleteHREmployeeIncrementHistory')) Remove  @endif</th>
                        
                        
                       
                        
                </tr>
                </thead>
                    <tbody>

                  <?php 
                  $SerialNo=1;
				  $curdate = DB::select(DB::raw("select CURDATE() as curdateasa"));
				 
								$newdataaa =  json_decode(json_encode((array)$curdate),true);
								$curdateo = $newdataaa[0]["curdateasa"];
                  ?>
               
					
                @foreach($promotion as $t)

               
                
                        <tr>
                           <font color="red">
                            <td class="center">{{$SerialNo++}}</td>
								<td class="center">
							@if($user->hasPermission('EditHREmployeeIncrementsHistory'))
								<?php
								$UsetID = User::getSysUser()->userID;
								$userTypeID = User::getSysUser()->userType;
								$userOrgaId = User::getSysUser()->organisationId;
								$userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
								$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
								$userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
								$available = HRUserEPFList::where('UserID','=',$UsetID)->where('Active','=',1)->where('Deleted','=',0)->where('EPFNo','=',$t->EPF)->get();
							
								?>
								@if($userOrgaType === 'HO') 
									
									@if($UserTypeName == 'HR-MAPF')
			
										@if(count($available) != 0)
										<a href="{{url('EditHREmployeeIncrementsHistory?id='.$t->id)}}"><i class="icon-edit bigger-300 icon-only"></i></a>
										@else
										
										@endif
										
									@else
									<a href="{{url('EditHREmployeeIncrementsHistory?id='.$t->id)}}"><i class="icon-edit bigger-300 icon-only"></i></a>
								
									@endif
								
								@endif
						
						    @else
							
							@endif
							
                             
							</td>
                            <td class="center">{{$t->OrgaName}}({{$t->Type}})</td>
                            <td class="center">{{$t->NIC}}</td>
							<td class="center">{{$t->EPF}}</td>
                            <td class="center">{{$t->Designation}}</td>
                            <td class="center">{{$t->ServiceCategory}}</td>
							<td class="center">{{$t->StepNo}}</td>
                            <td class="center">{{$t->NextIncrementDate}}</td>
							<td class="center">
							@if($t->Approved == 1)
							Yes
							@elseif($t->Approved == 2)
							Temporary Hold
							@elseif($t->Approved == 3)
							Hold
							@elseif($t->Approved == 4)
							Stop
							@elseif($t->Approved == 5)
							Reactive
							@else
						    Pending
							@endif
							</td>
							<td class="center">{{$t->ReasonForHold}}</td>
							
                            <td class="center">
							<?php
							$gettempholdmonths = HREmployeeIncrementHoldMonths::GetMonths($t->id);
							?>
							@foreach($gettempholdmonths as $an)
							@if($an->MonthNo == '1')
								January<br/>
							
							@elseif($an->MonthNo == '2')
							February<br/>
							@elseif($an->MonthNo == '3')
							March<br/>
							@elseif($an->MonthNo == '4')
							April<br/>
							@elseif($an->MonthNo == '5')
							May<br/>
							@elseif($an->MonthNo == '6')
							June<br/>
							@elseif($an->MonthNo == '7')
							July<br/>
							@elseif($an->MonthNo == '8')
							August<br/>
							@elseif($an->MonthNo == '9')
							September<br/>
							@elseif($an->MonthNo == '10')
							October<br/>
							@elseif($an->MonthNo == '11')
							November<br/>
							@elseif($an->MonthNo == '12')
							December<br/>
							@else
								@endif
							@endforeach
							  </td>
							  <td>{{$t->ReactivatedDate}}</td>
							  <td>{{$t->GrossSalary}}</td>
							  
							 
							  <td>
						@if($user->hasPermission('DeleteHREmployeeIncrementHistory'))
							 <form id="deleteform"  action='DeleteHREmployeeIncrementHistory' method="POST" onsubmit="return doConfirm('{{$t->NextIncrementDate}} of {{$t->EPF}}- {{$t->NIC}}',this)">
                                <input type="hidden" name='id' value="{{$t->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                            </form>
						@endif
						</td>
							  
						
                       </font>
                            
                        </tr>
                
           

                
                    
               
               
                @endforeach

               
               
            </tbody>
            </table>
			 @endif
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">

                                function doConfirm(promotion, formobj) {
                                bootbox.confirm("Are you sure you want to remove Increment record of" + promotion, function(result){
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
                                         
           
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
                                        ]});
                          
                               

$("#EmpSearch").click(function() {
    var EPFNo =$('#EPFNo').val();
    alert(EPFNo);
                   
                      // var id=document.getElementById('sid').value;
                       //var ccode=document.getElementById('CourseCode').value;
                      // var form =$("#please").serializeArray();
                
                //alert('dghsg');   
                     $.ajax({
                        url: "{{url('pleaseSubmitForm')}}",
                        type: "POST",
                        data: form,

                       
                                success: function(result) {
                                 response(result.print);
                             window.location.replace("{{url('viewFees')}}");
                             
                                
                                }
                               
                          
                    });
                 
                });
</script>

