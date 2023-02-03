@include('includes.bar')   
<a href={{url('viewUsers')}}> << Back to Users </a>     
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    User			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createUser')}}" method="POST">
                <div class="control-group">
                    <label class="control-label" for="EmpId">Employee NIC</label>
                    <div class="controls">
                        <input type="text" name="EmpId" id="EmpId" placeholder="Enter NIC"  required/>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" >Centre : </label>
                        <div class="controls" id="Trade">
                            <select name="CenterID" id="CenterID" required>
                                 <option value="">--Select Centre--</option>
								
                            </select>
                           
                        </div>         
                 </div>
                <div class="control-group">
                    <label class="control-label" for="userName">User Name</label>
                    <div class="controls">
                        <input type="text" name="userName" id="user" value="" placeholder="Create User Name" required/>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="passWord">Password</label>
                    <div class="controls">
                        <input type="password" name="passWord" value="" id="p1" placeholder="Select Password"required />
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="userType">User Type</label>
                    <div class="controls">
                            <!--<input type="text" name="userType"  /> -->
                        <select name="userType" required>
                            <option value="">---Select Type---</option>  
                            @foreach($usertype as $t)
                            <option value="{{$t->id}}">{{$t->UType}}</option>   
                            @endforeach
                        </select>
                    </div>
                </div> 
				 <div class="control-group">
                    <label class="control-label" for="UserDivision">User Division</label>
                    <div class="controls">
                          
                        <select name="UserDivision" required>
                            <option value="">---Select Division---</option>  
                            <option value="Monitoring">Monitoring</option>   
                            <option value="Admin">Admin</option>  
						    <option value="Exam">Exam</option>
							<option value="IR">IR</option>						   
                        </select>
                    </div>
                </div> 
				
                
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-small btn-primary" id="submit">Save</button>
                    </div>
                </div>
            </form>
        </div><!--/.span-->
        <!--/span 4 for error handling -->
        <div class="span4">
            <!-- Error Handling -->
            @if($errors->has())                    
            @foreach($errors->all() as $msg)
            <!-- Error Message -->
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong> <i class="icon-remove"></i>{{$msg}}</strong>
            </div>
            <!-- Error Message -->
            @endforeach
            @endif
            <!-- Error Handling -->
        </div>
        <!--/span 4-->
        <!--PAGE CONTENT ENDS-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script type="text/javascript">
                    $(document).ready(function() {
                        $("#user").val("");
                        $("#p1").val("");
                    });
                    @if (isset($done))
                            $.gritter.add({title: "", text: "Course Added Successfully", class_name: "gritter-info gritter-center"});
                            @endif
							
$("#EmpId").change(function() 
	{
        var EmpId = $("#EmpId").val();
		//alert(EmpId);
        $("#CenterID").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Centre ---';
		
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('loadempcentersin')}}",
                                        data: {EmpId: EmpId},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CenterID").append("<option value=''>" + msg + "</option>");
											 
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CenterID").append("<option value=" + item.id + ">" +item.OrgaName + "(" + item.Type + ")</option>");



                                                });

                                        } 
                                });            

            
     
    });
</script>



