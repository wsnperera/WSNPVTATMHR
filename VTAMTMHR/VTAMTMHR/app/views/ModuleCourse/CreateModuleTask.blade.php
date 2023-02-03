@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewModuleTask')}}> << Back to Module Task</a>
                <h1>Module Task<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='CreateModuleTask' method="POST"  id='NewModule'/>
            <div class="control-group">
                <label class="control-label" for="CourseListCode">Course List Code : </label>
                <div class="controls">
                    <select name="CourseListCode" id="CourseListCode">
                        <option value="">--Select--</option>
                        @foreach($listCode as $lc)
                        <option value="{{$lc->CourseListCode}}">{{$lc->CourseListCode}} - [{{$lc->CourseName}}]</option>
                        @endforeach
                    </select>
				<!--	Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div> 

            <div class="controls" id='table'>
            </div>

            <div class="control-group">
                <label class="control-label" >Module Code : </label>
                <div class="controls" id="ModuleDiv">
                    <select name="M_Code" id="M_Code">
                        <option value="">--Select--</option>
                        @foreach($modules as $m)
                        <option value="{{$m->ModuleCode}}">{{$m->ModuleCode}}</option>
                        @endforeach
                    </select>
                    <input type="button"  value="New Module Code" name="NewModule" id="NewModule" onclick="addModule()">
                </div>         
            </div>

            <div class="control-group" hidden="" id="addModule" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">

                <div class="control-group">
                    <label class="control-label">Module Code</label>
                    <div class="controls">
                        <input id="ModuleCode" placeholder="" type="text">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Module Name</label>
                    <div class="controls">
                        <input id="ModuleName" placeholder="" type="text">
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Create New Module Code" onclick="fillModule()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>

            <div class="control-group">
                <label class="control-label">Module Name</label>
                <div class="controls" id="ModuleNameDiv">
                    <input id="AjaxModuleName"   type="text" readonly="">
                    <input id="AjaxModuleId"  Name="ModuleId"  type="hidden" readonly=""  >
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls" i>
                    <select id="Type" Name="Type" >
                        <option value="">--Select--</option>
                        <option value="Theory">Theory </option>
                        <option value="Practical">Practical</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"> Hours</label>
                <div class="controls">
                    <input style="width:50px;text-align:right" id="Hours" name="Hours" placeholder="" type="text"> Hours
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">CA Weight</label>
                <div class="controls">
                    <input style="width:50px;text-align:right" id="assessmentweight" name="assessmentweight" placeholder="" type="text"> 
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">CA Cut-Off</label>
                <div class="controls">
                    <input style="width:50px;text-align:right" id="CACutOff" name="CACutOff" placeholder="" type="text"> 
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Final Exam Weight</label>
                <div class="controls">
                    <input style="width:50px;text-align:right" id="finalmarkweight" name="finalmarkweight" placeholder="" type="text"> 
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Final Exam Cut-Off</label>
                <div class="controls">
                    <input style="width:50px;text-align:right" id="FECutOff" name="FECutOff" placeholder="" type="text"> 
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>             

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
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
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


       $("#CourseListCode").change(function() {
        var cid = $("#CourseListCode").val();
        $("#table").html('');
        $.ajax({
            type: "GET",
            url: "{{url::to('moduleCourseexist')}}",
            data: {CourseListCode: cid},
            success: function(result) {
                $('#table').html(result);

            }
        });
    });

    function addModule() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule').is(':hidden')) {
                            $('#addModule').show();
                        } else {
                            $('#addModule').hide();
                        }
                    }
                });
    }
    function fillModule() {
        var ModuleName = document.getElementById('ModuleName').value;
        var ModuleCode = document.getElementById('ModuleCode').value;
        $.ajax({
                    url: "{{url::to('saveModule')}}",
                    data: {ModuleName: ModuleName, ModuleCode: ModuleCode},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            $("#ModuleDiv").html(result.html);
                            $('#addModule').hide();
                            $('#ajaxerror').html(result.done);
                            
                            document.getElementById("AjaxModuleName").value = ModuleName;
                                $.ajax({
                                            url: "{{url::to('getModuleId')}}",
                                            data: {ModuleCode: ModuleCode},
                                            success: function(re) {
                                                  document.getElementById("AjaxModuleId").value = re;
                                                               }
                                       });

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
    }
    
    $('#M_Code').change(function(){
       var ModuleCode = document.getElementById('M_Code').value; 
       $.ajax  ({
                    url: "{{url::to('getModuleName')}}",
                    data: { ModuleCode: ModuleCode},
                    success: function(result) {
                        var a = result.split('/n/');
                     document.getElementById('AjaxModuleName').value = a[0];
                     document.getElementById('AjaxModuleId').value = a[1];
                        }
                    
                });
       
    });
  
</script>


