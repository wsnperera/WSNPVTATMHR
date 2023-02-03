@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                Employee		
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Reports
                    <i class="icon-double-angle-right"></i>
                    Categorize Employee base on their Position
                </small>			
            </h1>
        </div>
        <form>
            <a href="{{url('downloadxlEmpPosition')}}" class="btn btn-primary pull-right "><i class="icon-download-alt"> </i> EXCEL Format Download</a>
        </form>
        </br></br>
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table class="table">
                <tr>	
                    <th>Designation</th>
                    <th>Institute Name</th>
                    <th>Organization Name</th>
                    <th>NIC</th>
                    <th>EPF No</th>
                    <th>Full Name</th>
                    <th>Employee Type</th>
                    <th>Staff Type</th>
                </tr>
                @if(isset ($Designation))
                @foreach ($Designation as $d)
                <tr> 
                    <th style="color: royalblue"> {{$d->Designation}} </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
               
                </tr>
                @if(isset ($Employee))
                @foreach ($Employee as $e)
                @if($e->Designation == $d->Designation)
                <tr>
                    <td></td>
                    <td>{{$e->InstituteName}}</td>
                    <td>{{$e->OrgaName}}</td>
                    <td>{{$e->NIC}}</td>
                    <td>{{$e->EPFNo}} </td>
                    <td>{{$e->Name}} </td> 
                    <td>{{$e->EmployeeType}}</td>
                    <td>{{$e->Academic}}</td>
                </tr>
                @endif
                @endforeach
                @endif
                
                @endforeach
                @endif

            </table>

            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer')   

<script type="text/javascript">
</script>