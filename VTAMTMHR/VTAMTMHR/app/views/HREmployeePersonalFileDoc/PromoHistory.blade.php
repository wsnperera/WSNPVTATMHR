@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeePersonalFileDoc')}}"> << Back to HR - Employee Personal File Document List  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR -  Employee Personal File Document List History		
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
								<input type="submit"  value="Search Employee Training" class="btn btn-small btn-warning"/>
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
                       
                       
                        <th rowspan="2">NIC </th>
                        <th rowspan="2">EPF</th>
						<th rowspan="2">File No</th>
                        <th colspan="{{$countquaorg}}" class="center">Document List</th>
						<th rowspan="2">Active</th>
						
                    </tr>
                    <tr>
					@foreach($quaorg as $g)
						<th class="center">{{$g->DocumentName}}<br/>(Page No)</th>
                    @endforeach  
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i = 1; ?>
                    @foreach ($promotion as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                     
                      
                        <td>{{$eq->NIC}}</td>
						<td>{{$eq->EPFNo}}</td>
						<td>{{$eq->FileNo}}</td>
						
						@foreach($quaorg as $g)
						<td class="center">
						<?php
						
						$result = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$eq->id)->where('DocumentId','=',$g->id)->pluck('Availability');
						$PageNo = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$eq->id)->where('DocumentId','=',$g->id)->pluck('PageNo');
						$countres = count($result);
						?>
						@if($countres == 0)
							Not Available
						@else
							@if($result == 1)
								<font color="green"><i class="icon-ok bigger-130"></i></font><br/>
											@if(!empty($PageNo))
											<font color="blue">({{$PageNo}})</font>
											@else
											@endif
								@else
									<font color="red"><i class="icon-remove bigger-130"></i></font>
									@endif
							
						@endif
						</td>
						 @endforeach  
						
							  <td>
							  @if($eq->Active == 1)
								  Yes 
							  @else 
								  No 
							  @endif</td>
							    
                       
                     
                       
                      
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
                                        {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},
                                        {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},
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
