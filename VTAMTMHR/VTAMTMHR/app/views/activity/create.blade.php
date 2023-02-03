
@include('includes.bar')      
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->

            <div class="page-header position-relative">
                <h1>
                    Activity			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
                <a href='viewActivity'> << Back </a>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createActivity')}}" method="POST"/>
            <div class="control-group">
                <label class="control-label" for="routename">Route Name</label>
                <div class="controls">
                    <input type="text" name="routename"  />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="activityname">Activity Name</label>
                <div class="controls">
                    <input type="text" name="activityname"  />
                </div>
            </div>


            <div class="control-group">

                <div class="controls">

                    <button type="submit" class="btn btn-small btn-primary">Create</button>

                </div>
            </div>
        </div>

        </form>

    </div><!--/.span-->




    <!--/span 4 for error handling -->
<!--
    <div class="span4">-->

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

            $.gritter.add({title: "", text: "Activity Added Successfully", class_name: "gritter-info gritter-center"});

    @endif

</script>











