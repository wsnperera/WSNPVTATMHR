@include('includes.bar')
<a href={{url('viewUserType')}}> << Back to User Type </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    User Type		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->

            <!--Write your code here start-->

            <form class="form-horizontal" action="{{url('editUserType')}}" method="POST" />
            <input type="hidden" name="id" value="{{$UserType->id}} "/>
            <br/>

            <div class="control-group">
                <label class="control-label" for="InstituteId">Institute Name</label>
                <div class="controls">
                    <input type="text"  disabled="true" value="{{$institute}}"/>
                    <input type="hidden" name="InstituteId" value="{{$in_id}}"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="UType">User Type </label>
                <div class="controls">
                    <input type="text" name="UType" value="{{$UserType->UType}}" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Active">Active</label>
                <div class="controls">
                    <select name="Active">
                         <option @if( $UserType->Active == '') selected  value="" @endif>--Select--</option>
                        <option @if( $UserType->Active == '1') selected  value="1" @endif>Yes</option>
                         <option @if( $UserType->Active == '0') selected  value="0" @endif>No</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
        <!--/span 4 for error handling -->

        <div class="span4">



            @if($errors->has())
            @foreach($errors->all() as $msg)

            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong> <i class="icon-remove"></i>{{$msg}}</strong>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
</div>

@include('includes.footer')
<script type="text/javascript">

</script>







































