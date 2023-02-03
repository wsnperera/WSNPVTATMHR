@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-header position-relative">
                <h1>
                    Carder			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>
                </h1>
                <a href="Employment" ><< Back To View </a>
            </div>
            <form class="form-horizontal" action="{{url('editEmployment')}}" method="POST" id="EditSalaryScale">
                <input type="hidden" name="id" value="{{Request::get('cid')}} "/><br/>
                <div class="control-group">
                    <label class="control-label" for="EmpCode">Carder</label>
                    <div class="controls">
                        <input type="text" name="EmpCode" value="{{$Event->EmpCode}}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="MajorMinor">Academic</label>
                    <div class="controls">
                        <select name="Academic">
                            <option @if($Event->Academic == "Yes") selected @endif>Yes</option>
                            <option @if($Event->Academic == "No") selected  @endif>No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="Designation">Designation</label>
                    <div class="controls">
                        <input type="text" name="Designation" value="{{$Event->Designation}}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="Designation">No Of Positions</label>
                    <div class="controls">
                        <input type="text" name="Positions" value="{{$Event->Positions}}" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="Designation">Salary Code</label>
                    <div class="controls">
                        <input type="text" name="SalaryCode" value="{{$Event->SalaryCode}}" />
                    </div>
                </div>
                
                 <div class="control-group">
                    <label class="control-label" for="SalaryScale">Salary Scale</label>
                    <div class="controls" id="SalaryScaleDiv">
                        <select name="SS_ID" id="SS_ID" >
                         <option>--Select--</option>
                        @foreach ($salaryScale as $ss)
                        <option @if( $ss->SS_ID == $Event->SS_ID) selected  @endif value="{{$ss->SS_ID}}"  >{{$ss->SalaryScale}}</option>
                        @endforeach
                        </select>
                        <input type="button"  value="Edit Salary Scale" name="EditSalaryScale" id="EditSalaryScale" onclick="editSalaryScale()" class="btn btn-small btn-primary"/>
                    </div>
                </div>
                
                
                <div class="control-group" hidden="" id="editSalaryScale" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">
                    <h6 align="center" style="font-family: arialblack;font-size: 12pt" ><b>Edit Salary Scale</b></h6>
                  
                   
                        <div class="controls">
                            <input id="SSID" type="hidden" value="{{$ValueOfSS_ID}}">
                        </div>

                    
                    <div class="control-group">
                        <label class="control-label">Salary Scale </label>
                        <div class="controls">
                            <input id="SalaryScale" type="text" value="{{$ValueOfSS_IDSalaryScale}}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Minimum Salary</label>
                        <div class="controls">
                            <input id="MinSalary"  type="text" value="{{$ValueOfSS_IDMinSalary}}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Maximum Salary</label>
                        <div class="controls">
                            <input id="MaxSalary"  type="text" value="{{$ValueOfSS_IDMaxSalary}}">
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input type="button" value="Update Salary Scale" onclick="updateSalaryScale()" class="btn btn-small btn-primary"/>
                        </div>
                    </div>  

                </div>
                
                <div class="control-group">
                    <label class="control-label" for="MajorMinor">Major or Minor</label>
                    <div class="controls">
                        <select name="MajorMinor">
                            <option @if($Event->MajorMinor == "1") selected value="1" @endif>Major</option>
                            <option @if($Event->MajorMinor == "0") selected value="0" @endif>Minor</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-small btn-primary">Update</button>
                    </div>
                </div>
            </form>
            <div class="span4" id="ajaxerror">
            @if(Session::has('done'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                    {{Session::get('done')}}
                </strong>
                <br>
            </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>{{Session::get('message')}}</strong><br>
            </div>
            @endif
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Error!
                </strong>{{$msg}}
                <br>
            </div>
            @endforeach
            @endif

        </div>
        </div>
    </div>
</div>
@include('includes.footer')

<script>
     function editSalaryScale() {
                $.ajax({
                            url: "{{url::to('')}}",
                            success: function(result)
                            {
                                if ($('#editSalaryScale').is(':hidden')) {
                                    $('#editSalaryScale').show();
                                } else {
                                    $('#editSalaryScale').hide();
                                }
                            }
                        });
            }
            
    function updateSalaryScale() {
        var SalaryScale = document.getElementById('SalaryScale').value;
        var MaxSalary = document.getElementById('MaxSalary').value;
        var MinSalary = document.getElementById('MinSalary').value;
        var SalaryScaleValue = String(SalaryScale);
        var MaxSalaryValue =  parseInt(MaxSalary);
        var MinSalaryValue =  parseInt(MinSalary);
        var ccid =document.getElementById('SSID').value;
        var ccidValue = parseInt(ccid);
       
        if(MaxSalaryValue<MinSalaryValue){
            alert('Maximum Salary value cannot be less than Minimum Salary value!...');
            
        }else{
             if(ccid !== ''){
        $.ajax ({
                    url: "{{url::to('saveupdateSalaryScale')}}",
                    data: {SalaryScale: SalaryScaleValue, MaxSalary: MaxSalaryValue, MinSalary: MinSalaryValue,SS_ID:ccidValue},
                    dataType: 'json',
                    success: function(result){
                       
                        if (result.SS_ID !== 0) {
                            $("#SalaryScaleDiv").html(result.html);
                            $('#editSalaryScale').hide();
                            $('#ajaxerror').html(result.done);
                            

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
            }else{
               $.ajax ({
                    url: "{{url::to('saveupdateSalaryScale')}}",
                    data: {SalaryScale: SalaryScaleValue, MaxSalary: MaxSalaryValue, MinSalary: MinSalaryValue,SS_ID:ccid},
                    dataType: 'json',
                    success: function(result){
                        
                        if (result.SS_ID !== 0) {
                            $("#SalaryScaleDiv").html(result.html);
                            $('#editSalaryScale').hide();
                            $('#ajaxerror').html(result.done);
                            

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
            }
            }
    }
    
    

    </script>