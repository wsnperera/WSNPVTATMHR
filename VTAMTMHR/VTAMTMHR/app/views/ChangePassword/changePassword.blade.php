@include('includes.bar')       
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Change Password			
                    <small>
                        <i class="icon-double-angle-right"></i>
                         Change Password
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('changePassword')}}" method="POST">
                <div class="control-group">
                    <label class="control-label" for="passWord">Current Password</label>
                    <div class="controls">
                        <input type="password" name="oldPassWord" value="" id="p1" placeholder="Current Password" />
                    </div>
                </div>                 
                <div class="control-group">
                    <label class="control-label" for="passWord">New Password</label>
                    <div class="controls">
                        <input type="password" name="newPassWord" value="" id="p1" placeholder="New Password" />
                    </div>
                </div>      
                <div class="control-group">
                    <label class="control-label" for="passWord">Confirm New Password</label>
                    <div class="controls">
                        <input type="password" name="confirmNewPassWord" value="" id="p1" placeholder="Confirm Password" />
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
</script>



