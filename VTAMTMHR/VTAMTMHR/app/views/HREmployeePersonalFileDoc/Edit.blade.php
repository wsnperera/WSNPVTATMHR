@include('includes.bar')    
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<a href="{{url('ViewHREmployeePersonalFileDoc')}}"> << Back to HR - Employee Personal File Document List  </a> 
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Personal File Document List
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->
<!--            @if ($errors->has())
            @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
            @endif-->

            <form class="form-horizontal" action="{{url('EditHREmployeePersonalFileDoc')}}" method="POST"/>
          <h5 style="text-align: left"><b style="color: red">* Required/Mandatory Fields </b></h5>
			<hr/>
			 <div class="controls">

                @if(Session::has('ExistAnother'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Personal File Number Alraedy Entered for Another Employee!!!! 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>

            <div class="control-group">
                <!--                <label class="control-label" for="form-field-1">Employee Qualification ID</label>-->
                <div class="controls">
                    <input type="hidden" style="color:red" name="EQ_ID" value="{{Request::get('id')}}" readonly="readonly"/>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPF" value="{{$EPF}}" readonly /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" value="{{$EmpNIC}}" readonly/>
					 <input type="hidden" name="EmpId" id="EmpId" value="{{$EmpId}}"/>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Name</label>
                <div class="controls">
                   
					<textarea name="Ename" id="Ename" readonly>{{$EmpInitials}} {{$EmpLastName}}</textarea>
                </div>
            </div>

			<div class="control-group">
                <label class="control-label" for="form-field-7">File No</label>
                <div class="controls">
                    <input type="text"  name="FileNo" id="FileNo" value="{{$empqua->FileNo}}" required><b style="color: red">*</b>
                </div>
            </div>
             <div class="control-group">
            <div class="controls">
                <pre bgcolor="REBECCAPURPLE"><h5><b><font color="REBECCAPURPLE"><center>Personal File Document List</center></font></b></h5></pre>
               
                      <?php $i=1; ?>
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
								<th class='left'>#</th>
                                    <th class='center'>Document</th>
                                    <th class='center'>Availability</th>
									<th class='center'>Page No</th>
                                </tr>
                                @foreach($quaorg as $g)
                                
                                <tr>
                                   <td><font face="verdana" size="1" color="black">{{$i++}}</font></td>  
                                    <td ><font face="verdana" size="2" color="black">{{$g->DocumentName}}</font></td>
                                    
                                    <td class="center">
										<label>
											<input type="hidden" name="DocIDs[]" id="DocIDs[]" value="{{$g->id}}">
											<?php
											$result = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$empqua->id)->where('DocumentId','=',$g->id)->pluck('Availability');
											$PageNo = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$empqua->id)->where('DocumentId','=',$g->id)->pluck('PageNo');
											$countres = count($result);
											?>
											@if($result == 1)
											  <input name="Checked_ids[]" class="abc" value="{{$g->id}}" type="checkbox" checked="true"/>
										  @else
											  <input name="Checked_ids[]" class="abc" value="{{$g->id}}" type="checkbox" />
											  @endif
											<span class="lbl"> &nbsp;</span>
										</label>
									</td>
                                   <td class="center">
										
											
											<input name="PageNos[]" class="abc"  value="{{$PageNo}}" type="text" />
										
									
									</td>

                                    
                                </tr>
                                @endforeach
                            </thead>
                        </table>
             
            </div>
        </div> 
		<div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                        <select id="Active" name="Active"  required="true">
						<option value="">---Select Active Status---</option>
						<option value="1" @if($empqua->Active == 1) selected="true" @endif>Yes</option>
						<option value="0" @if($empqua->Active == 0) selected="true" @endif>No</option>
						</select>
                    </div>
                </div>

          
			
            
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-block btn-warning" type="submit"  value="Update" />
                </div>
            </div>
            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
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
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>

<script type="text/javascript">
                  
</script>							
                         