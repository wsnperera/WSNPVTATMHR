@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewModuleTask')}}> << Back to Module Task</a>
                <h1>Module Task<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal"  method="POST" id='NewModule'/>
            <div class="control-group">
                <label class="control-label" for="CourseListCode">Trade : </label>
                <div class="controls">
                    <select name="Trade" id="Trade">
                        <option value="">--Select--</option>
                        @foreach($Trades as $t)
                        <option value="{{$t->TradeId}}">{{$t->TradeCode}} - {{$t->TradeName}}</option>
                        @endforeach
                    </select> </select><span id="img1"></span>

                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div>
            <div class="control-group">
                        
                            <label class="control-label" for="Medium">Competency Standard</label>

                             <div class="controls">

                                <select name="ComStand" id="ComStand" required="true">

                                    

                                </select><span id="img2"></span>

                             </div>
                              
                            
                    </div>
                     <div class="control-group">
                        
                            <label class="control-label" for="Medium">Qualification Package</label>

                             <div class="controls">

                                <select name="Qpackage" id="Qpackage" required="true">

                                    

                                </select> </select><span id="img3"></span>


                             </div>
                            
                    </div> 
            <div class="control-group">
                <label class="control-label" for="CourseListCode">Course List Code : </label>
                <div class="controls">
                    <select name="CourseListCode" id="CourseListCode">
                        <option value="">--Select--</option>
                        @foreach($listCode as $lc)
                        <option value="{{$lc->CD_ID}}">{{$lc->CourseListCode}} - [{{$lc->CourseName}}] - {{$lc->CourseType}}-{{$lc->Nvq}}-{{$lc->CourseLevel}}-{{$lc->Duration}}</option>
                        @endforeach
                    </select> </select><span id="img4"></span>

				<!--	Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div> 
<!--  -->
            <div class="controls" id='table'>
            </div>

            <div class="control-group">
                <label class="control-label" >Module Code : </label>
                <div class="controls" id="ModuleDiv">
                    <select name="M_Code" id="M_Code">
                        <option value="">--Select--</option>
                        @foreach($modules as $m)
                        <option value="{{$m->ModuleId}}">{{$m->ModuleCode}} - {{$m->ModuleName}}</option>
                        @endforeach
                    </select>
                   
                    <!--<button type="button" class="btn btn-small btn-danger" name="NewModule" id="NewModule" onclick="addModule()">New Module Code</button>-->
                </div>         
            </div>
             <div class="controls" id='table1'>
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
                <label class="control-label"></label>
                <div class="controls" id="ModuleNameDiv">
                    <input id="AjaxModuleName"   type="hidden" readonly="">
                    <input id="AjaxModuleId"  Name="ModuleId"  type="hidden" readonly=""  >
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" >Task Code : </label>
                <div class="controls" id="TaskDiv">
				
                    <select name="T_Code" id="T_Code" class="chzn-select" data-placeholder="Choose Task..." required>
                        <option value="">--Select--</option>
                        @foreach($tasks as $m)
                        <option value="{{$m->id}}">{{$m->TaskCode}} - {{$m->TaskName}}</option>
                        @endforeach
                    </select>
                   
                     <button type="button" class="btn btn-small btn-danger" name="NewTask" id="NewTask" onclick="addTask()">New Task Code</button>
                </div>         
            </div>
             <div class="controls" id='table2' hidden="true">
            </div>

            <div class="control-group" hidden="" id="addTask" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">

                <div class="control-group">
                    <label class="control-label">Task Code</label>
                    <div class="controls">
                      
                        <textarea id="TaskCode" placeholder=""></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Task Name</label>
                    <div class="controls">
                        
                         <textarea id="TaskName" placeholder=""></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Create New Task Code" onclick="fillTask()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>

            <div class="control-group">
                <label class="control-label">Task Name</label>
                <div class="controls" id="TaskNameDiv">
                    <input id="AjaxTaskName"   type="text" readonly="">
                    <input id="AjaxTaskId"  Name="TaskId"  type="hidden" readonly=""  >
                </div>
            </div>
            <div class="control-group">
                    <label class="control-label">Order</label>
                    <div class="controls">
                        <input id="Order" name="Order" placeholder="" type="text" required>
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label">No of Session</label>
                    <div class="controls">
                        <input id="SessionNo" name="SessionNo" placeholder="" type="text" required>
                    </div>
                </div>

<!---     -->

 
            <div class="control-group">
                <div class="controls">
                        <input type="button" value="Save Me" onclick="saveAll()" class="btn btn-small btn-primary"/>
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
           
           

        </div>
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
   jQuery(document).ready(function() {
   
$(".chzn-select").trigger("liszt:activate");
$(".chzn-select").chosen(); 
});

   
    
</script>
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif

     $("#Trade").change(function() {
        var TradeId = $("#Trade").val();
        $("#ComStand").html('');
        
        var msg = '--- Select Competency Standard ---';
      
            
                          $.ajax({

                                       beforeSend: function()
                                        {
                                            
                                            document.getElementById('img1').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                                        type: "GET",
                                        url: "{{url::to('LoadCompetencyCourseCreate')}}",
                                        data: {TradeId: TradeId},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#ComStand").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#ComStand").append("<option value=" + item.code + ">" +item.code + "-"+ item.name +  "</option>");



                                                });

                                        },
                                        complete: function() {
                                            document.getElementById('img1').innerHTML ="";

                                        }
                                });            

            
       
    });

                 $("#ComStand").change(function() {
        var ComStand = $("#ComStand").val();
        $("#Qpackage").html('');
        
        var msg = '--- Select Qualification Package ---';
      
            
                          $.ajax({
                                        beforeSend: function()
                                        {
                                            
                                            document.getElementById('img2').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                                        type: "GET",
                                        url: "{{url::to('LoadNVQCourseComPackageQQQ')}}",
                                        data: {ComStand: ComStand},
                                        dataType: "json", 
                                         success: function(result) {
                                             $("#Qpackage").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#Qpackage").append("<option value=" + item.id + ">" +item.packagecode + "</option>");



                                                });

                                        },
                                        complete: function() {
                                            document.getElementById('img2').innerHTML ="";

                                        }
                                });            

            
       
    }); 

       $("#CourseListCode").change(function() {
        var cid = $("#CourseListCode").val();
        var msg = '--- Select Module ---';
        $("#table").html('');
        $.ajax({

            beforeSend: function()
                                        {
                                            
                                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
            type: "GET",
            url: "{{url::to('moduleCourseexist')}}",
            data: {CourseListCode: cid},
            success: function(result) {
               // $('#table').html(result);

                 $.ajax({
                                        
                                        type: "GET",
                                        url: "{{url::to('LoadPackageModuleListForModuleTask')}}",
                                        data: {cid: cid},
                                        dataType: "json", 
                                         success: function(result) {
                                            $("#M_Code").html('');
                                             $("#M_Code").append("<option value=''>" + msg + "</option>");

                                                 $.each(result, function(i, item)
                                                {



                                                    $("#M_Code").append("<option value=" + item.ModuleId + ">" +item.ModuleCode + "-" +item.ModuleName + "</option>");



                                                });

                                        } ,
                                        complete: function() {
                                            document.getElementById('img4').innerHTML ="";

                                        }
                                }); 

            }
        });
    });
       $("#M_Code").change(function() {

        var cid = $("#M_Code").val();
        $("#table1").html('');
       // alert($("#M_Code").val());
        
        $.ajax({
            type: "GET",
            url: "{{url::to('moduleTaskexist')}}",
            data: {ModuleId: cid},
            dataType: 'json',
            success: function(result) {

               // $('#table1').html(result.html);
                document.getElementById("AjaxModuleName").value = result.ModuleName;

            }
        });
    });
        $("#T_Code").change(function() {            
            
        var cid = $("#M_Code").val();
        var taskid = $("#T_Code").val();
        $("#table2").html('');
        $.ajax({
            type: "GET",
            url: "{{url::to('moduleTaskOrderexist')}}",
            data: {M_Code: cid,T_Code:taskid},
            dataType: 'json',
            success: function(result) {

               // $('#table2').html(result.html);
                document.getElementById("AjaxTaskName").value = result.TaskName;

            }
            });
        });
    
        function addTask() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addTask').is(':hidden')) {
                            $('#addTask').show();
                        } else {
                            $('#addTask').hide();
                        }
                    }
                });
    }

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
        var courseCode = document.getElementById('CourseListCode').value;
        $.ajax({
                    url: "{{url::to('saveModuleforTask')}}",
                    data: {ModuleName: ModuleName, ModuleCode: ModuleCode,courseCode: courseCode},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            $("#ModuleDiv").html(result.html);
                            $('#addModule').hide();
                           /* $('#ajaxerror').html(result.done);*/
                            
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
    function saveAll(){
        var M_Code = document.getElementById('M_Code').value;
        var CourseListCode = document.getElementById('CourseListCode').value;
        var T_Code = document.getElementById('T_Code').value;
        var SessionNo = document.getElementById('SessionNo').value;
        var Order = document.getElementById('Order').value;
        //var CourseListCode = document.getElementById('CourseListCode').value;
        //var CourseListCode = document.getElementById('CourseListCode').value;
        
        $.ajax({
            type: "POST",
            url: "{{url::to('saveAll')}}",
            data: {M_Code: M_Code,CourseListCode: CourseListCode,T_Code: T_Code,SessionNo: SessionNo,Order: Order},
            dataType: 'json',
            success: function(result) {

                $('#ajaxerror').html(result.done);
               // $('#table1').html(result.pttab1);
                $('#table2').html(result.taskseq);
               // document.getElementById("AjaxTaskName").value = result.TaskName;

            }
            });

    }
    /*function saveAll() {
        var M_Code = document.getElementById('M_Code').value;
        var CourseListCode = document.getElementById('CourseListCode').value;
        var T_Code = document.getElementById('T_Code').value;
        var SessionNo = document.getElementById('SessionNo').value;
        var Order = document.getElementById('Order').value;
        var CourseListCode = document.getElementById('CourseListCode').value;
        var CourseListCode = document.getElementById('CourseListCode').value;
        $.ajax({
                    url: "{{url::to('saveAll')}}",
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
    }*/
    function fillTask() {


        
        var TaskName = document.getElementById('TaskName').value;
        var TaskCode = document.getElementById('TaskCode').value;
		//alert(TaskCode);
        $.ajax({
                    url: "{{url::to('saveTask')}}",
                    data: {TaskName: TaskName, TaskCode: TaskCode},
                    dataType: 'json',
                    success: function(result) {
                        if (result.TaskId !== 0) {
                           // $("#TaskDiv").html(result.html);
                            
							
							var html='<select id="T_Code" name="T_Code"  class="chzn-select" data-placeholder="Choose Task..." required="true">'+result.html1+'</select>';
                                            
                                             $("#TaskDiv").html('');
                                            $("#TaskDiv").append(html);
                                            $("#T_Code.chzn-select").trigger("liszt:updated");
                                            $(".chzn-select").chosen();
											
							$('#addTask').hide();
                            $('#ajaxerror').html(result.done);
                            
                            document.getElementById("AjaxTaskName").value = TaskName;
                                $.ajax({
                                            url: "{{url::to('getTaskId')}}",
                                            data: {TaskCode: TaskCode,TaskName: TaskName},
                                            success: function(re) {
                                                  document.getElementById("AjaxTaskId").value = re;
                                                               }
                                       });

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
                
               
    }
    
   /* $('#M_Code').change(function(){
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
       
    }); */
      $('#Qpackage').change(function(){

       // alert('dg');
       //e.preventDefault();
       var Trade = document.getElementById('Trade').value; 
       var Qpackage = document.getElementById('Qpackage').value;
      // alert(Trade); 
        //var a=1;
       var msg = '--- Select Course ---';
        $("#CourseListCode").html('');
       $.ajax  ({
                     beforeSend: function()
                                        {
                                            
                                            document.getElementById('img3').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                    url: "{{url::to('LoadTradeWiseCLCmoTask11')}}",
                    data: { Trade: Trade,Qpackage: Qpackage},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode").append("<option value=" + item.CD_ID + ">"+ item.CourseListCode+"-"+item.CourseName+"["+item.CourseType+"/"+item.Nvq+"/"+item.CourseLevel+"/"+item.Duration+"]</option>");
                           // a = a +1;



                        });
                                        
                        
                        },
                                        complete: function() {
                                            document.getElementById('img3').innerHTML ="";

                                        }


                    
                });
        


       
    });
  
</script>


