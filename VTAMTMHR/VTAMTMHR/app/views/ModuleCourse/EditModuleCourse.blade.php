@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewModuleCourse')}}> << Back to Module Course</a>
                <h1>Module Course<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='editModuleCourse' method="POST"  id='EditModule'>
                <input type="hidden" name="MC_ID" value="{{$moduleC->MC_ID}}" />
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>

                    <div class="controls">
                        <select name="CourseListCode">
                            @foreach($listCode as $lc)
                            <option @if($moduleC->CourseListCode==$lc->CourseListCode) selected @endif >{{$lc->CourseListCode}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Module Code : </label>
                    <div class="controls" id="ModuleDiv">
                        <select name="M_Code" id="M_Code">
                            <option>--Select--</option>
                            @foreach($modules as $m)
                            <option @if($moduleC->M_Code==$m->ModuleCode) selected @endif value="{{$m->ModuleCode}}" >{{$m->ModuleCode}}</option>
                            @endforeach
                        </select>
                         <input type="button"  value="Edit Module Code" name="EditModule" id="EditModule" onclick="editModule()">
                    </div>
                </div>
                
                 <div class="control-group" hidden="" id="editModule" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">

                     <div class="controls">
                         <input id="ModuleId" type="hidden" value="{{$m2}}" />
                        </div>
                     
                <div class="control-group">
                    <label class="control-label">Module Code</label>
                    <div class="controls">
                        <input id="ModuleCode" placeholder="" type="text" value="{{$m3}}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Module Name</label>
                    <div class="controls">
                        <input id="ModuleName" placeholder="" type="text" value="{{$m4}}">
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Edit Module Code" onclick="updateModule()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>
                
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Module Name : </label>
                <div class="controls">
                      <input id="AjaxModuleName"   type="text" readonly="">
                    <input id="AjaxModuleId"  Name="ModuleId"  type="hidden" readonly=""  >
<!--                        <select name="ModuleId">
                            @foreach($modules as $m)
                            <option @if($moduleC->ModuleId==$m->ModuleId) selected @endif value="{{$m->ModuleId}}" >{{$m->ModuleName}}</option>
                            @endforeach
                        </select>-->
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Type : </label>
                <div class="controls">
                        <select name="Type">
                            <option value="">--Select--</option>
                            <option @if($moduleC->Type == "Theory") selected @endif value="Theory" >Theory</option>
                           <option @if($moduleC->Type == "Practical") selected @endif value="Practical" >Practical</option>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label"> Hours:</label>
                    <div class="controls">
                        <input style="width:50px;text-align:right" id="Hours" name="Hours" placeholder="" type="text" value="{{$moduleC->Hours}}" >  Hours
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Assessment Weight:</label>
                    <div class="controls">
                        <input style="width:50px;text-align:right" id="assessmentweight" name="assessmentweight"  type="text"  value="{{$moduleC->assessmentweight}}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">CA CutOff:</label>
                    <div class="controls">
                        <input style="width:50px;text-align:right" id="CACutOff" name="CACutOff" type="text"  value="{{$moduleC->CACutOff}}">
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Final Exam Weight:</label>
                    <div class="controls">
                        <input style="width:50px;text-align:right" id="finalmarkweight" name="finalmarkweight" type="text"  value="{{$moduleC->finalmarkweight}}">
                    </div>
                </div>
                
                 <div class="control-group">
                    <label class="control-label">Final Exam CutOff:</label>
                    <div class="controls">
                        <input style="width:50px;text-align:right" id="FECutOff" name="FECutOff"  type="text"  value="{{$moduleC->FECutOff}}">
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
    </div>
</div>
</div>
@include('includes.footer')
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Test Center Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
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
  $(document).ready(function(){
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
  
 function editModule() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#editModule').is(':hidden')) {
                            $('#editModule').show();
                        } else {
                            $('#editModule').hide();
                        }
                    }
                });
    }
   
     function updateModule() {
         var ModuleName = document.getElementById('ModuleName').value;
        var ModuleCode = document.getElementById('ModuleCode').value;
        var ccid =document.getElementById('ModuleId').value;
        var ccidValue = parseInt(ccid);
        $.ajax ({
                    url: "{{url::to('saveupdateModule')}}",
                    data: {ModuleName: ModuleName, ModuleCode: ModuleCode,ModuleId:ccidValue},
                    dataType: 'json',
                    success: function(result){
                       
                       if (result.ModuleId !== 0) {
                            $("#ModuleDiv").html(result.html);
                            $('#editModule').hide();
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
    
</script>