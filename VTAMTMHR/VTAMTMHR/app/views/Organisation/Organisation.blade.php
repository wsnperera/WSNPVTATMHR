@include('includes.bar')       
@if(isset($Issearch))
<a href={{url('organisation')}}> << Back to Center </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
           Center		
            <small>
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
        <div class="row-fluid">
            <form name='search' action="{{url('findOrganisation')}}" method='get'>
               <!--  Search Center <input type='text' name="serachkey" placeholder="Search by Cenetr Code OR District..."/>   <input type='submit' value='Search'/> &nbsp; -->
                 
                
             <!--    <a href={{url('createOrganisation')}}><input class="btn-small" type="button" value="Create Center"/></a> -->
                 
                  @if($user->hasPermission('createOrganisation'))
                   <button type='button' class='btn btn-primary' onclick='createOrganisationDetails()'>
                     <i class='icon-edit bigger-200'></i>Create Center
                   </button>
                 @endif
                 <button type='button' class='btn btn-primary btn-purple' onclick='downloadOrganisationDetails()'>
                     <i class='icon-cloud-download bigger-200'></i>Download
                 </button>
                 <input type='hidden' value='{{$type}}' name='Orga_details' id='Orga_details'/>
            </form>
            
            <div class="span12">
                <div id="loding">
                <center>    <img height="50%" width="25%" src="assets/redballs.gif"/></center>
                </div>
                 <table id="sample-table-2" class="table table-striped table-bordered table-hover" style="display: none">
              <thead>
                   <tr>
                        <th>Center ID</th>
                        <th>Institute Name</th>
                        <th>College Name</th>
                        <th>College Code</th>
                        <th>College Type</th>
                        <th>Address</th>
                        <th>Telephone No</th>
                        <th>Fax No</th>
                        <th>Email</th>
                        <th>Career Guidance Telephone No</th>
                        <th>Registration No</th>
                        <th>Business Unit</th>
                        <th>Ownership</th>
                        <th>District</th>
                        <th>Electorate</th>
                        <th>Date Closed</th>
                        <th>Date Entered</th>
                        <th>OIC</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Active</th>

                        <th>Remove</th>

                    </tr>
                </thead>
                    @if(isset ($organisation))
                    <tbody>
                    @foreach ($organisation as $o)
                    <tr>
                        <td>@if($user->hasPermission('editOrganisation'))
                            <a href="{{url('editOrganisation?id='.$o->id)}}">{{$o->id}}</a>
                            @else 
                            {{$o->id}}  
						
                            @endif
                        </td>
                        <td>@if(!is_null($o->getInstitute)){{$o->getInstitute->InstituteName}}@endif</a></td>
                        <td>{{$o->OrgaName}}</td>
                        <td>{{$o->CenterCode}}</td>
                        <td>@if(!is_null($o->OrgType)){{$o->OrgType->Type}}@endif</td>
                        <td>{{$o->AddL1}}</td>
                        <td>{{$o->Tel}}</td>
                        <td>{{$o->Fax}}</td>
                        <td>{{$o->Email}}</td>
                        <td>{{$o->CaGuTel}}</td>
                        <td>{{$o->RegistrationNo}}</td>
                        <td>{{Organisation::getOWNERSHIP($o->Ownership)}}</td>
                        <td>{{$o->BusinessUnit}}</td>
                        <td>@if(!is_null($o->getDistrict)){{$o->getDistrict->DistrictName}} @endif</td>
                        <td>@if(!is_null($o->getElec)){{$o->getElec->ElectorateName}} @endif</td>
                        <td>{{$o->DateClosed}}</td>
                        <td>{{$o->DateEntered}}</td>
                        <?php $Organization = Organisation::getOICName($o->OIC);
                        ?>
                        <td>{{$Organization['Initials']}}{{$Organization['LastName']}}</td>
                        <td>{{$o->Latitude}}</td>
                        <td>{{$o->Longitude}}</td>
                        <td>{{$o->Active}}</td>
                         <td>
                          @if($user->hasPermission('deleteOrganisation'))
                            
                   


                            <form id="deleteform"  action={{url('deleteOrganisation')}} method="POST" onsubmit="return doConfirm('{{$o->OrgaName}}', this)">
                                <input type="hidden" name='oid' value={{$o->id}} />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                           </form>
                           @else no permission
                  @endif      </td>
                    </tr>
                    @endforeach
                    </tbody>
                   @endif
                </table>
            
                <!--PAGE CONTENT BEGINS-->
             
                   
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    @include('includes.footer')   

    <script type="text/javascript">
                function doConfirm(organisation, formobj) {
                bootbox.confirm("Are you sure you want to remove " + organisation, function(result) {
                if (result){
                formobj.submit();
                }
                });
                        return false; // by default do nothing hack :D
                }



    </script>

    <script type="text/javascript">

function downloadOrganisationDetails(){
   // alert(1);
    var Orga_details=$("#Orga_details").val();
    location.replace('downloadOrganisationDetails?Orga_details='+Orga_details);

    }
function createOrganisationDetails(){
   // alert(1);
   // var Orga_details=$("#Orga_details").val();
    location.replace('createOrganisation');

    }
   
</script>

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

<script>
     

     // on sready function start

    $(document).ready(function() {
        $("#loding").css("display", "none");
        $('#sample-table-2').dataTable({
            //"bPaginate": false,
            //"bLengthChange": false,
            "aoColumns": [
                {"bSortable": false},
                null,
                null,
                null,
                null,
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                null,
                null,
                null,
                null,
                null,
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                null,
                {"bSortable": false}
            ]});
        $("#sample-table-2").css("display", "");
    });
</script>


