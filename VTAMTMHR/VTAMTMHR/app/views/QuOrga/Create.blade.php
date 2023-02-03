@include('includes.bar')       
<a href={{url('quorga')}}> << Back to Qualification Universities </a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
     Qualified Universities		
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('createQuaorg')}}" method="POST" />

    <div class="control-group">
       <table height="100" width="500">
<tr>
        <td>
            <label class="control-label" for="form-field-7">Institute Name</label></td>
           <td><input type="text" value="{{$ins_name}}" readonly="readonly">
               <input type="hidden" name="instituteId" value="{{$in_id}}" />
           </td>
           </tr>
    
    <tr>
            <td>
            <label class="control-label" for="form-field-3">University Name</label></td>
            <td>
                
                <input type="text" name="OrgaName" id="OrgaName">
             </td>
                   
        </tr>
      
        
         </table>
    </div>
<div class="controls">
    <input type="submit" class="btn btn-small btn-primary"  value="Save" />
</div>
</form>
    <!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
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
</div>
</div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer')   





