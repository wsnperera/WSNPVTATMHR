@include('includes.bar')       
<a href={{url('viewUserType')}}> << Back to User Type </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->

            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    User Type			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createUserType')}}" method="POST" />

            <div class="control-group">
                <label class="control-label" for="InstituteId">Institute Name</label>
                <div class="controls">
                    <input type="text"  readonly="readonly" value="{{$institute}}"/>
                    <input type="hidden" name="InstituteId" value="{{$in_id}}"/>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="UType">User Type</label>
                <div class="controls">
                    <input type="text" name="UType"  />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Active">Active</label>
                <div class="controls">
                    <select name="Active" >
                        <option value=''>--Select--</option>
                        <option value='1'>Yes</option>
                        <option value='0'>No</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>
            </form>

        </div><!--/.span-->

        <!--/span 4 for error handling -->

        <div class="span4">

            <!-- Error Handling --!>
                    @if($errors->has())
                          @foreach($errors->all() as $msg)
            <!-- Error Message --!>
              <div class="alert alert-error">
                 <button type="button" class="close" data-dismiss="alert">
                         <i class="icon-remove"></i>
                 </button>
                 <strong> <i class="icon-remove"></i>{{$msg}}</strong>
              </div>
            <!-- Error Message --!>
      @endforeach
    @endif
            <!-- Error Handling --!>
    </div>
            <!--/span 4-->
            <!--PAGE CONTENT ENDS-->

        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
    @include('includes.footer')  
    <script>

        @if (isset($done))

                $.gritter.add({title: "", text: "UserType Added Successfully", class_name: "gritter-info gritter-center"});

        @endif

    </script>










