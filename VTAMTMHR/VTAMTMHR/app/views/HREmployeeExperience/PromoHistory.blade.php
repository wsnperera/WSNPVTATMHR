@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeExperienceHistory')}}"> << Back to HR - Employee Experience </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR - Employee Experience History		
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
								<input type="submit"  value="Search Employee Experience" class="btn btn-small btn-warning"/>
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
                    <tr>
                        <th rowspan="2">No</th>
                       
                       
                        <th rowspan="2">NIC[Old NIC] </th>
                        <th rowspan="2">EPF</th>
                        <th rowspan="2">Organisation Name</th>
                        <th rowspan="2">Designation</th>
                        <th colspan="3" class="center">Duration</th>
						<th rowspan="2">Reason To Leave</th>
                       
                    </tr>
                    <tr>
						<th>Date Joined</th>
                        <th>Date Resigned</th>
                        <th>Period</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($promotion as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                     
                       
                        <td>
						@if($eq->NIC != $eq->OldNIC)
						 {{$eq->NIC}} [{{$eq->OldNIC}}] 
						@else
						 {{$eq->NIC}}
						@endif
						</td>
						 <td>{{$eq->EPFNo}}</td>
                        <td>{{$eq->CompanyName}}</td>
                        <td>{{$eq->Designation}}</td>
                        <td>{{$eq->DateJoined}}</td>
                       <td>{{$eq->DateResigned}}</td>
					  <td>
					   @if(!empty($eq->DateJoined) && !empty($eq->DateResigned || $eq->DateJoined !='0000-00-00' && $eq->DateResigned !='0000-00-00'))
					   <?php 
					   $sql = "Select
								TIMESTAMPDIFF( YEAR, '".$eq->DateJoined."','". $eq->DateResigned."' ) as _year
								,TIMESTAMPDIFF( MONTH,'".$eq->DateJoined."', '". $eq->DateResigned."' ) % 12 as _month
								,FLOOR( TIMESTAMPDIFF( DAY, '".$eq->DateJoined."', '". $eq->DateResigned."' ) % 30.4375 ) as _day";
								$res=DB::select(DB::raw($sql));
								$newdata =  json_decode(json_encode((array)$res),true);
								$year = $newdata[0]["_year"];
								$month = $newdata[0]["_month"];
								$day = $newdata[0]["_day"];
					   ?>
					   {{$year}} Years & {{$month}} Months
					   @else
						 {{$eq->Years}} Years & {{$eq->Months}} Months  
					   @endif
					   </td>
                        <td>{{$eq->ReasonToLeave}}</td>
                       
                     
                       
                       
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
                                bootbox.confirm("Are you sure you want to remove promotion record of" + promotion, function(result){
                                if (result){
                                formobj.submit();
                                }
                                });
                                        return false; // by default do nothing hack :D
                                }

                      $('#sample-table-2').dataTable({
                                        "aoColumns": [
                                        {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},
                                        {"bSortable": false},{"bSortable": false},{"bSortable": false},
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
