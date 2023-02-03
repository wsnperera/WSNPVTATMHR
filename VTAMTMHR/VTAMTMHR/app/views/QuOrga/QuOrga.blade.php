
@include('includes.bar')       

@if(isset($Issearch))

<a href={{url('quorga')}}> << Back to Qualification Universities </a> 

@endif

<div class="page-content">
  <div class="page-header position-relative">
                                            
                                            <h1>
                                           Qualified Universities			
                                            <small>
                                                    <i class="icon-double-angle-right"></i>
                                                    View
                                            </small>			
                                            </h1>
                                            
		</div><!--/.page-header-->

<div class="row-fluid">

<form name='search' action="{{url('findQuorg')}}" method='get'>
Search Qualified Universities<input type='text' name="searchKey" placeholder="Search by Universities Name..."/>   <input type='submit' value='Search'/> &nbsp;
 
<a href={{url('createQuaorg')}}><input class="btn-small" type="button" value="Create Qualified University"/></a>

</form>
<div class="span12">
<!--PAGE CONTENT BEGINS-->
<table class="table" >
<tr>

<th>Qualified Universities ID</th>
<th>Institute Name</th>
<th >University Name</th>

<th>Remove</th>

</tr>
@if(isset ($quorga))
@foreach ($quorga as $qo)

<tr>

<td><a href="{{url('editQuorg?id='.$qo->QO_ID)}}">{{$qo->QO_ID}}</a></td>

<td>{{$qo->getInstitute->InstituteName}}</td>
<td >{{$qo->OrgaName}}</td>
 
<td>
<form id="deleteform"  action={{url('deleteQuorg')}} method="POST" onsubmit="return doConfirm('{{$qo->OrgaName}}',this)">
 <input type="hidden" name='qoid' value="{{$qo->QO_ID}}" />
<button type="submit" class="btn  btn-small"><i class="icon-trash icon-2x icon-only"></i></button>

</form>

</td>


</tr>
@endforeach
@endif

</table>
<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
</div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer')   

<script type="text/javascript">


        function doConfirm(quorga,formobj)
        {


            bootbox.confirm("Are you sure you want to remove Qualified Organisation of"+quorga, function(result) 
            {
                   if(result) 
                   {
                        formobj.submit();

                    }


            });


            return false;  // by default do nothing hack :D
        }



</script>
