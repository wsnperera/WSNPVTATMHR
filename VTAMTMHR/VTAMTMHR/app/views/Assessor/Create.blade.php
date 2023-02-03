@include('includes.bar')
<link rel="stylesheet" type="text/css" href="assets/DatePic/css/prettify.css">
<link rel="stylesheet" type="text/css" href="assets/DatePic/css/mdp.css">
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/colorpicker.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewAndDownloadAssessor')}}> << Back to Assessor View</a>
                <h1>Assessor<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='saveAssessorRecord' method="POST"  id='NewModule'>
                  <div class="control-group">
                   
                    <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                                Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div> 
                 <div class="control-group">
                   
                    <div class="controls">
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
                <div class="control-group">
                    <label class="control-label" for="Name">Assessor ID</label>
                    <div class="controls">
                        <input type="text" name="AssessorID" id="AssessorID" required="true"/><span><font color="red"><b>*</b></font></span>
                    
                    </div>
                   
                        
                   
                    
                </div> 
                <div class="control-group">
                    <label class="control-label" for="Name">Assessor Name</label>
                    <div class="controls">
                        <input type="text" name="Name" id="Name" required="true"/><span><font color="red"><b>*</b></font></span>
                    
                    </div>
                </div> 
                 
                 <div class="control-group">
                    <label class="control-label" for="Name">Home Address</label>
                    <div class="controls">
                        <textarea name="HAddress" id="HAddress" ></textarea>
                    
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="Name">Home Telephone</label>
                    <div class="controls">
                        <input type="text" name="HTelephone" id="HTelephone" class="num_inp" />
                    
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="Name">Mobile No</label>
                    <div class="controls">
                        <input type="text" name="Mobile" id="Mobile" class="num_inp" />
                    
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="Designation">Designation</label>
                    <div class="controls">
                        <input type="text" name="Designation" id="Designation" />
                    
                    </div>
                </div>

                <div class="controls" id='table'>
                </div>

            <div class="control-group">
                <label class="control-label" >Office Institute : </label>
                <div class="controls" id="ModuleDiv">
                    <select name="M_Code" id="M_Code">
                         <option value="">--Select Working Institute--</option>
                        @foreach($NVQAssessorInstitute as $v)
                        <option value="{{$v->id}}">{{$v->InstituteName}} - {{$v->Address}}</option>
                        @endforeach
                    </select>
                    <input type="button"  value="New Working Institute" name="NewModule" id="NewModule" class="btn btn-small btn-success" onclick="addModule()" />
                </div>         
            </div>

            <div class="control-group" hidden="" id="addModule" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">

                <div class="control-group">
                    <label class="control-label">Institute Name</label>
                    <div class="controls">
                        <input id="InstituteName" placeholder="" type="text">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Institute Address</label>
                    <div class="controls">
                        <input id="InstituteAddress" placeholder="" type="text" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Create New Institute" onclick="fillModule()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>

            
            <div class="control-group">
                <label class="control-label" >Office Working Place : </label>
                <div class="controls" id="ModuleDiv1">
                    <select name="WorkingPlace" id="WorkingPlace" >
                         <option value="">--Select Working Place--</option>
                        
                    </select>
                    <input type="button"  value="New Working Place" name="NewModule" id="NewModule" class="btn btn-small btn-warning" onclick="addModule1()" />
                </div>         
            </div> 

               <div class="control-group" hidden="" id="addModule1" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">

                <div class="control-group">
                    <label class="control-label">Working Place Name</label>
                    <div class="controls">
                        <input id="WorkingPlaceName" placeholder="" type="text" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Working Place Address</label>
                    <div class="controls">
                        <input id="WorkingPlaceAddress" placeholder="" type="text"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Working Place Contact No</label>
                    <div class="controls">
                        <input id="ContactNo" placeholder="" type="text"  />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" class="btn btn-small btn-primary"value="Create New Working Place" onclick="fillModule1()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>
            <div class="control-group">
                <label class="control-label" for="Name">Office Telephone</label>
                <div class="controls">
                    <input type="text" name="OTelephone" id="OTelephone" class="num_inp"  />
                
                </div>
            </div>
             <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls" id="">
                    <select id="Type" Name="Type" required="true">
                        <option value="">--Select Type--</option>
                        <option value="Probation">Probation</option>
                        <option value="Licenced">Licenced</option>
                        <option value="Registered">Registered</option>
                    </select>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label" for="Name">Note</label>
                <div class="controls">
                    <textarea name="Note" id="Note" ></textarea>
                
                </div>
            </div> 
             <div class="control-group">
                <label class="control-label" >Assessor Trade : </label>
                <div class="controls" id="Trade">
                    <select name="TradeId" id="TradeId" multiple="multiple" class="chzn-select" >
                         <option value="">--Select Trade--</option>
                        @foreach($NVQcompetencystandard as $v)
                        <option value="{{$v->id}}">{{$v->code}} - {{$v->name}}</option>
                        @endforeach
                    </select>
                   
                </div>         
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save Assessor Details</button>
                </div>
            </div>             

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
        <div class="span4" id="ajaxerror">
            
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
<script src="assets/js/chosen.jquery.min.js"></script>
<script>
jQuery(document).ready(function() 
{
   
$("#TradeId").trigger("liszt:activate");
$("#TradeId").chosen(); 




});

   
    
</script>
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
    function addModule1() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule1').is(':hidden')) {
                            $('#addModule1').show();
                        } else {
                            $('#addModule1').hide();
                        }
                    }
                });
    }
    function fillModule() {
        var InstituteName = document.getElementById('InstituteName').value;
        var InstituteAddress = document.getElementById('InstituteAddress').value;
        $.ajax({
                    url: "{{url::to('saveAssessorInstitute')}}",
                    data: {InstituteName: InstituteName, InstituteAddress: InstituteAddress},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            $("#ModuleDiv").html(result.html);
                            $('#addModule').hide();
                            $('#ajaxerror').html(result.done);
                            
                           var InstititeId = result.InstituteAddress;
                            $("#WorkingPlace").html('');
                              /*  $.ajax({
                                            url: "{{url::to('getModuleId')}}",
                                            data: {ModuleCode: ModuleCode},
                                            success: function(re) {
                                                  document.getElementById("AjaxModuleId").value = re;
                                                               }
                                       });*/

                         $.ajax  ({
                                    url: "{{url::to('getWorkingPlace')}}",
                                    data: { InstititeId: InstititeId},
                                    dataType: "json", 
                                    success: function(result) {

                                        //alert(result);
                                        $("#WorkingPlace").append("<option value=''>" + msg + "</option>");
                                         $.each(result, function(i, item)
                                        {



                                            $("#WorkingPlace").append("<option value=" + item.id + ">" + item.Placename + "  (" + item.Address + ")</option>");



                                        });
                                                        
                                        
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

        //alert('dg');
       var ModuleCode = document.getElementById('M_Code').value; 
       var msg = '--- Select Working Place ---';
        $("#WorkingPlace").html('');
       $.ajax  ({
                    url: "{{url::to('getWorkingPlace')}}",
                    data: { ModuleCode: ModuleCode},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#WorkingPlace").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#WorkingPlace").append("<option value=" + item.id + ">" + item.Placename + "  (" + item.Address + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });

    function fillModule1() {

        //alert('dfhgftrghy');
        var WorkingPlaceName = document.getElementById('WorkingPlaceName').value;
        var WorkingPlaceAddress = document.getElementById('WorkingPlaceAddress').value;
        var InstituteId = document.getElementById('M_Code').value;
        var ContactNo = document.getElementById('ContactNo').value;
        $.ajax({
                    url: "{{url::to('saveAssessorWorkingPlace')}}",
                    data: {WorkingPlaceName: WorkingPlaceName, WorkingPlaceAddress: WorkingPlaceAddress, InstituteId: InstituteId,ContactNo: ContactNo},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            $("#ModuleDiv1").html(result.html);
                            $('#addModule1').hide();
                            $('#ajaxerror').html(result.done);
                            
                           //var InstititeId = result.InstituteAddress;
                           // $("#WorkingPlace").html('');
                              /*  $.ajax({
                                            url: "{{url::to('getModuleId')}}",
                                            data: {ModuleCode: ModuleCode},
                                            success: function(re) {
                                                  document.getElementById("AjaxModuleId").value = re;
                                                               }
                                       });*/

                        /* $.ajax  ({
                                    url: "{{url::to('getWorkingPlace')}}",
                                    data: { InstititeId: InstititeId},
                                    dataType: "json", 
                                    success: function(result) {

                                        //alert(result);
                                        $("#WorkingPlace").append("<option value=''>" + msg + "</option>");
                                         $.each(result, function(i, item)
                                        {



                                            $("#WorkingPlace").append("<option value=" + item.id + ">" + item.Placename + "  (" + item.Address + ")</option>");



                                        });
                                                        
                                        
                                        }


                                    
                                });*/

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
    }
    </script>


