@include('includes.bar')       
@if(isset($Issearch))
<a href={{url('viewUserType')}}> << Back to User Type </a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                User Type		
                <small>
                    <i class="icon-double-angle-right"></i>
                    View
                </small>			
            </h1>
        </div>

        <form name='search' action="{{url('searchUserType')}}" method='get'>
            Search User Type <input type='text' name="serachkey" placeholder="Search By user Type"/>   <button type="submit" class="btn btn-primary">Search</button>
            <a href={{url('createUserType')}}><button type="button" class="btn btn-primary">Create</button></a>
        </form>

        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table class="table">
                <tr>
                    
                    <th>User Type ID</th>
                    <th>Institute Name</th>
                    <th>User Type</th>
                    <th>Active</th>	
                    <th>Remove</th>	
                </tr>

                @if(isset ($UserType))
                @foreach ($UserType as $ut)
                <tr>
                    <td><a href="{{url('editUserType?id='.$ut->id)}}">{{$ut->id}}</a></td>
                    <td>{{$ut->Institute->InstituteName}} </td>
                    <td>{{$ut->UType}} </td>  
                    <td>{{$ut->Active}} </td> 
                    <td>
                        <form id="deleteform"  action="{{url('deleteUserType?id='.$ut->id)}}" method="POST" onsubmit="return doConfirm('{{$ut->NIC}}', this)">
                            <input type="hidden" name='id' value="{{$ut->id}}" />
                            <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
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

            function doConfirm(UserType, formobj)  {
            bootbox.confirm("Are you sure you want to remove " + UserType, function(result)
            {
            if (result){
            formobj.submit();
            }
            });
                    return false; // by default do nothing hack :D
            }

</script>