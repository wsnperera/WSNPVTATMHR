@include('includes.bar')         
<a href={{url('viewUsers')}}> << Back to Users </a>                
<div class="page-content">                                    
    <div class="row-fluid">                                                                                                                                                                                                                       
        <div class="span12">							
            <!--PAGE CONTENT BEGINS-->                                        
            <!--/.page-header-->                                        
            <div class="page-header position-relative">                                            
                <h1>
                    Users		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div>
            <!--/.page-header-->               			 
            <!--Write your code here start-->                                
            <form class="form-horizontal" action="{{url('editUsers')}}" method="POST">              
                <input type="hidden" name="UserID" value={{Request::get('cid')}} />                            
                <div class="control-group">                                                 
                    <label class="control-label" for="userID" >NIC</label>              
                    <div class="controls">
                        <input type="text" name="userID" disabled="disabled" value={{$users->getEmployee->NIC}}  />
                    </div>
                </div>    
                <div class="control-group">
                    <label class="control-label" for="userName">User Name</label>
                    <div class="controls">
                        <input type="text" name="userName" value={{$users->userName}}  readonly />
                    </div>
                </div>         
               
                <div class="control-group">
                    <label class="control-label" for="userType">User Type</label>
                    <div class="controls">
                            <!--<input type="text" name="userType"  /> -->
                        <select name="userType">
                            <option value="">Select Type</option>  
                            @foreach($usertype as $t)
                            <option value="{{$t->id}}" @if($users->userType == $t->id) selected @endif>{{$t->UType}}</option>   
                            @endforeach
                        </select>
                    </div>
                </div>   
				 <div class="control-group">
                    <label class="control-label" for="UserDivision">User Division</label>
                    <div class="controls">
                            <!--<input type="text" name="userType"  /> -->
                        <select name="UserDivision" id="UserDivision" required>
                            <option value="">---Select Division---</option>  
                            
                            <option value="Monitoring" @if($users->UserDivision == 'Monitoring') selected @endif>Monitoring</option>   
                           <option value="Admin" @if($users->UserDivision == 'Admin') selected @endif>Admin</option>  
						   <option value="Exam" @if($users->UserDivision == 'Exam') selected @endif>Exam</option> 
							<option value="IR" @if($users->UserDivision == 'IR') selected @endif>IR</option>						   
                        </select>
                    </div>
                </div> 
                <div class="control-group">                                                 
                    <div class="controls">                                                 
                        <button type="submit" class="btn btn-small btn-primary">Update</button>  
                    </div>
                </div>
        </div>                                            
        <!-- Submit Button -->                 
        </form>   
        <!--Write your code here end-->            
        <!--PAGE CONTENT ENDS-->                     
    </div><!--/.span-->
</div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script type="text/javascript"></script>
