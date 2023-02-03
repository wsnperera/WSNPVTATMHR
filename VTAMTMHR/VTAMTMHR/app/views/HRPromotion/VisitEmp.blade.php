@include('includes.bar')  
<a href="{{url('promotion')}}"> << Back to Promotion </a>
@if(isset($Issearch))
<a href="{{url('visitingEmpView')}}"> << Back to Visiting Employee </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Promotion		
            <small>
                <i class="icon-double-angle-right"></i>
                Visiting Employee
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">

        <form name='search' action="{{url('findVisitPromotion')}}" method='get'>
            Search Promotions<input type='text' name="searchKey" placeholder="Search by NIC..."/>   <input type='submit' value='Search'/> &nbsp;

        </form>
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table class="table" >
                <tr>

                    <th>Employee Reference No</th>
                    <th>Transfer ID</th>
                    <th>Institute Name</th>
                    <th>Employee Name</th>
                    <th>N.I.C</th>
                    <th>Effective Date</th>
                    <th>To Organisation</th>
                    <th>To Department</th>
                    <th>Transfer Type</th>
                    <th>New Post</th>
                    <th>Employee Type</th>
                    <th>Grade</th>
                    <th>Salary Scale</th>
                    <th>Salary Step</th>
                    <th>Salary Code</th>
                    <th>Increment Day</th>
                    <th>Increment Month</th>
                    <th>Remove</th>
                </tr>
                @if(isset ($promotion))
                @foreach ($promotion as $pr)

                <tr>

                    <td><a href="{{url('editPromotion?id='.$pr->P_ID)}}">{{$pr->EPF}}</a></td>
                    <td>{{$pr->P_ID}}</td>
                    <td>@if(!is_null($pr->getInstitute)){{$pr->getInstitute->InstituteName}}@endif</td>
                    <td>@if(!is_null($pr->getEmp)){{$pr->getEmp->Name}}@endif</td>
                    <td>{{$pr->NIC}}</td>
                    <td >{{$pr->StartDate}}</td>
                    <td>@if(!is_null($pr->getOrga)){{$pr->getOrga->OrgaName}}@endif</td>
                    <td>@if(!is_null($pr->getDepartment)){{$pr->getDepartment->DepartmentName}}@endif</td>
                    <td>@if(!is_null($pr->getTransferType)){{$pr->getTransferType->TransferType}}@endif</td>
                    <td>@if(!is_null($pr->getPost)){{$pr->getPost->Designation}}@endif</td>
                    <td>{{$pr->EmpType}}</td>
                    <td>{{$pr->Grade}}</td>
                    <td>@if(!is_null($pr->getSalaryScale)){{$pr->getSalaryScale->SalaryScale}}@endif</td>
                    <td>{{$pr->SalaryStep}}</td>
                    <td>{{$pr->SalaryCode}}</td>
                    <td>{{$pr->IncrementDay}}</td>
                    <td>{{$pr->IncrementMonth}}</td>
                    <td>
                        <form id="deleteform"  action={{url('deletePromotion')}} method="POST" onsubmit="return doConfirm('{{$pr->NIC}}', this)">
                            <input type="hidden" name='pid' value="{{$pr->P_ID}}" />
                            <button type="submit" class="btn btn-small"><i class="icon-trash icon-2x icon-only"></i></button>

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


            function doConfirm(promotion, formobj)  {
            bootbox.confirm("Are you sure you want to remove promotion record of" + promotion, function(result)    {
            if (result)    {
            formobj.submit();
            }
            });
                    return false; 
            }

</script>
