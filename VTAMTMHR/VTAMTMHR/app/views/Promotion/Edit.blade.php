@include('includes.bar')    
<a href="{{url('promotion')}}"> << Back to Promotion </a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Promotion		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->

            @if ($errors->has())
            @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
            @endif


            <form class="form-horizontal" action="{{url('editPromotion')}}" method="POST"/>
<h4 style="text-align: right"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h4>

            <div class="control-group">
                <label class="control-label" for="form-field-2">Institute Name</label>
                <div class="controls">
                    <input type="hidden" name="InstituteId" id="InstituteId"  value="{{$InstituteID}}"/>
                    <input type="text"  readonly value="{{$InstituteName}}"/>
                </div>
            </div>

            <div class="page-header position-relative"></div>


            <div class="control-group">
                <label class="control-label" for="form-field-1">Promotion Id</label>
                <div class="controls">
                    <input type="text" style="color:red" name="P_ID" value="{{Request::get('id')}}" readonly="readonly"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-2">N.I.C</label>
                <div class="controls">
                    <input type="text" name="NIC" value="{{$promotion->NIC}}" readonly="readonly"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPF" value="{{$promotion->EPF}}"  />
                </div>
            </div>

            <div class="control-group">
<!--                <label class="control-label" for="form-field-3">Employee ID</label>-->
                <div class="controls">
                    <input type="hidden" name="Emp_ID" id="Emp_ID" value="{{$promotion->Emp_ID}}" readonly="readonly"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-4">Effective Date</label>
                <div class="controls">
                    <input type="date" name="StartDate" id="StartDate" value="{{$promotion->StartDate}}"/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-5">Transfer Type</label>
                <div class="controls">
                    <select name="TransferType"  onchange="readonly()" id="TransferType">
                        @foreach($transfertype as $tt)
                        <option @if($tt->T_ID == $promotion->TransferType) selected   @endif value={{$tt->T_ID}}>{{$tt->TransferType}}</option>
                       @endforeach     
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-6">To Organisation</label>
                <div class="controls">
                    <select name="ToOrganisation" id="ToOrganisation" >
                        @if($promotion11 != "")
                        @foreach($organisation as $o)
                        <option @if($o->id == $promotion11) selected   @endif value={{$o->id}}>{{$o->OrgaName}}</option>
                        @endforeach
                        <!-- <option @if ($promotion->ToOrganisation=="Head Office") selected @endif value="Head Office">Head Office</option>-->
                        @endif
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-7">To Department</label>
                <div class="controls">
                    <select name="ToDepartment" id="ToDepartment" >
                        <option></option>
                        @foreach($department as $d)
                        <option @if($d->D_ID == $promotion->ToDepartment) selected   @endif value={{$d->D_ID }}>{{$d->DepartmentName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-8">New Post</label>
                <div class="controls">
                    <select name="NewPost"  id='NewPost' >
                        @foreach($employmentcode as $ec)
                        <option @if($ec->id == $promotion->NewPost) selected   @endif value={{$ec->id }}>{{$ec->Designation }}</option>
                        @endforeach
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-9">Employee Type</label>
                <div class="controls">
                    <select name="EmpType" id='EmpType'  >
                        @foreach($employeetype as $et)
                        <option @if($et->EmployeeType == $promotion->EmpType) selected   @endif value={{$et->EmployeeType }}>{{$et->EmployeeType}}</option>
                        @endforeach
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-10">Grade</label>
                <div class="controls">
                    <input type="text" name="Grade" value="{{$promotion->Grade}}" id='Grade'/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-11">Salary Scale</label>
                <div class="controls">
                    <input type="text"  id="FullSalaryScale" readonly=""/>
                    <input type="hidden" name="SalaryScale" id='SalaryScale'/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-12">Salary Step</label>
                <div class="controls">
                    <input type="text" name="SalaryStep" value="{{$promotion->SalaryStep}}" id='SalaryStep'/><b style="color: red">*</b>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-13">Increment Day</label>
                <div class="controls">
                    <input type="Text" name="IncrementDay" value="{{$promotion->IncrementDay}}" id='IncrementDay'/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-14">Increment Month</label>
                <div class="controls">
                    <select name="IncrementMonth"  id='IncrementMonth'>
                        <option @if($promotion->IncrementMonth =="") selected @endif value= "">--Select--</option>
                        <option @if($promotion->IncrementMonth =="January") selected @endif value="January">January</option>
                        <option @if($promotion->IncrementMonth =="February")selected @endif value="February">February</option>
                        <option @if($promotion->IncrementMonth =="March") selected @endif value="March">March</option>
                        <option @if($promotion->IncrementMonth =="April") selected @endif value="April">April</option>
                        <option @if($promotion->IncrementMonth =="May") selected @endif value="May">May</option>
                        <option @if($promotion->IncrementMonth =="June") selected @endif value="June">June</option>
                        <option @if($promotion->IncrementMonth =="July") selected @endif value="July">July</option>
                        <option @if($promotion->IncrementMonth =="August") selected @endif value="August">August</option>
                        <option @if($promotion->IncrementMonth =="September")selected @endif value="September">September</option>
                        <option @if($promotion->IncrementMonth =="October") selected @endif value="October">October</option>
                        <option @if($promotion->IncrementMonth =="November") selected @endif value="November">November</option>
                        <option @if($promotion->IncrementMonth =="December") selected @endif value="December">December</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-small btn-primary" type="submit"  value="Update" />
                </div>
            </div>
            
            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script type="text/javascript">
    
 function readonly(){
     
     var tt = document.getElementById("TransferType").value;
        if(tt === "2" || tt === "1" || tt === "8" || tt === "")
          {     
            document.getElementById("SalaryScale").readOnly = false; 
            document.getElementById("IncrementDay").readOnly = false;
            document.getElementById("IncrementMonth").readOnly = false;
            document.getElementById("Grade").readOnly = false;
            document.getElementById("SalaryStep").readOnly = false;
            document.getElementById("NewPost").readOnly = false;
           }else if(tt === "5"  || tt === "7") {     
            document.getElementById("SalaryScale").readOnly = true;
            document.getElementById("IncrementDay").readOnly = true;
            document.getElementById("IncrementMonth").readOnly = true;
            document.getElementById("Grade").readOnly = true;
            document.getElementById("SalaryStep").readOnly = true;
            document.getElementById("NewPost").readOnly = true;
           }else{
            document.getElementById("SalaryScale").readOnly = true; 
            document.getElementById("IncrementDay").readOnly = true;
            document.getElementById("IncrementMonth").readOnly = true;
            document.getElementById("Grade").readOnly = true;
            document.getElementById("SalaryStep").readOnly = true;
            document.getElementById("NewPost").readOnly = true;
           }
   
    }  
      $('#NewPost').change(function() {
                        var newPost = document.getElementById('NewPost').value;
                        $.ajax({
                            url: "{{url::to('designationSalaryScaleLoadajax')}}",
                            data: {NewPost: newPost},
                            success: function(re) {
                                var a = re.split('/n/');
                                document.getElementById('FullSalaryScale').value = a[0];
                                document.getElementById('SalaryScale').value = a[1];
                            }
                        });
                    });
                    $(document).ready(function() {
                        var newPost = document.getElementById('NewPost').value;
                        $.ajax({
                            url: "{{url::to('designationSalaryScaleLoadajax')}}",
                            data: {NewPost: newPost},
                            success: function(re) {
                                var a = re.split('/n/');
                                document.getElementById('FullSalaryScale').value = a[0];
                                document.getElementById('SalaryScale').value = a[1];
                            }
                        });
                    });
</script>
<script>

    function check() {
//    alert("zxcvbnm");
        var emp = document.getElementById("Emp_ID").value;
        var type = document.getElementById("TransferType").value;
        var role = document.getElementById("NewPost").value;
        var org = document.getElementById('ToOrganisation').value;
        var sdate = document.getElementById('StartDate').value;
        if (type === '1' || type === '2' || type === 'Transfer' && role === 'A213' || role === 'A212') {
            $.ajax({
                url: "{{url::to('Org_inch')}}",
                data: {emp: emp, type: type, role: role, org: org},
                success: function(result) {
//               alert(result);
                    bootbox.dialog(result, [{
                            "label": "Yes",
                            "class": "btn-small btn-success",
                            "callback": function() {
                                $.ajax({
                                    url: "{{url::to('Org_inch_edit')}}",
                                    data: {org: org, sdate: sdate, emp: emp, type: type, role: role},
                                    success: function(result) {
//                                    alert(result);
                                        bootbox.dialog(result, [{
                                                "label": "oK",
                                                "class": "btn-small btn-primary",
                                            }]);

                                        $("#myform").submit();
                                    }
                                });
                            }
                        },
                        {
                            "label": "No",
                            "class": "btn-small btn-danger",
                            "callback": function() {
                                $("#myform").submit();
                            }
                        }]);

                }


            });
        }

    }




</script>