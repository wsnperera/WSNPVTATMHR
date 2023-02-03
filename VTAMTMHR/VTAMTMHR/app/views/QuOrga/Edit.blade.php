@include('includes.bar')    
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
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('editQuorg')}}" method="POST"/>

<div class="control-group">
<table height="250" width="500">


<tr>
<td><label class="control-label" for="form-field-1">Qualified University ID</label></td>

<td><input type="text" style="color:red" name="QO_ID" value="{{Request::get('id')}}" readonly="readonly"/></td>

</td>
</tr>
<tr>
<td>
    <label class="control-label" for="form-field-2">Institute Name</label></td>
<td><input type="text"  value="{{$ins_name}}" readonly="readonly"/>
<input type="hidden" name="instituteId" value="{{$in_id}}" />
</td>
   
</tr>
<tr>
<td>
 <label class="control-label" for="form-field-3">University Name</label></td>
<td><input type="text" name="OrgaName" value="{{$quorg->OrgaName}}"/></td>
</tr>
 @if($user->userType == 'Admin')
<tr >

<td align="right"> <input class="btn btn-small btn-primary" type="submit"  value="Update" /></td>

</tr>
@endif
</table>
</div>

</form>
<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
     @if ($errors->has())
@foreach ($errors->all() as $error)
    <div class='bg-danger alert'>{{ $error }}</div>
@endforeach
@endif
</div>
</div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script type="text/javascript">
    
  

    
</script>