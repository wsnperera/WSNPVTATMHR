@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('HistoryViewModuleTaskSeq')}}> << Back to History Module Task</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>History Module Task Sequence<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
        <form name='search' action="{{url('HistorySearchModuleTaskSeq')}}" method='get' class="form-horizontal">
<!--            Search Module Course By Course List Code : <input type='text' name="key"/>   <input type='submit' value='Search'/>-->
            <!--<a href="{{url('CreateModuleTask')}}"><input type='button' value='Create Module Task' /></a>-->
            
<div class="control-group">
                <label class="control-label" for="CourseListCode">Trade : </label>
                <div class="controls">
                    <select name="Trade" id="Trade">
                        <option value="">--Select--</option>
                        @foreach($Trades as $t)
                        <option value="{{$t->TradeId}}">{{$t->TradeCode}} - {{$t->TradeName}}</option>
                        @endforeach
                    </select><span id="img1"></span>
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
                <label class="control-label" for="CourseListCode">Course Name : </label>
                <div class="controls">
                    <select name="CourseListCode" id="CourseListCode">
                        <option value="">--Select--</option>
                        @foreach($listCode as $lc)
                        <option value="{{$lc->CD_ID}}">{{$lc->CourseListCode}} - [{{$lc->CourseName}}] - {{$lc->CourseType}}-{{$lc->Nvq}}-{{$lc->CourseLevel}}-{{$lc->Duration}}</option>
                        @endforeach
                    </select>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div> 
			 <div class="control-group">
                        
                            <label class="control-label" for="Medium">Old Version Number</label>

                             <div class="controls">

                                <select name="Version" id="Version" required="true">

                                    

                                </select> </select><span id="img12"></span>


                             </div>
                            
                    </div> 
            <div class="control-group">
                <div class="controls">
                        <input type="submit" value="Search"  class="btn btn-small btn-primary"/>
                    </div>
            </div> 
        </form>
        <hr/>
        @if(isset($moduleTask))
        
    <table>
    <tr>
        <td>
          
            <form> 
                            <input type="hidden" value="{{$CDID}}" name="CD_IDP" id="CD_IDP"/>
                            <input type="hidden" value="{{$VersionD}}" name="VersionP" id="VersionP"/>
                            <button type="button" id="upload" class="btn btn-purple">
                            <i class="icon-print bigger-200"></i>Print</button>
                            <span id='img4'></span>
            </form> 
                       
        </td>
		<td></td>
		
    </tr>
	
    </table>
        

        @endif
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
                    <th>Module TaskSeq ID</th>
                    <th>Course Name</th>
                    <th>Module Name</th>
                    <th>Module Code</th>
                    <th>Task Name</th>
                    <th>Task Code</th>
                    <th>No Of Sessions</th>
                    <th>Order</th>
                   
                </tr>
                 </thead>
                 <tbody>
                @if(isset($moduleTask))
                    @foreach($moduleTask as $mc)
                    <tr>
                        <!--<td><b><u><a href="{{url('editModuleCourse?id='.$mc->id)}}">{{$mc->id}}</a></u><b></td>-->
                       <td>{{$mc->id}}</td>
                       <td>{{$mc->CourseName}}</td>
                       <td>{{$mc->ModuleName}}</td>
                       <td>{{$mc->ModuleCode}}</td>
                       <td>{{$mc->TaskName}}</td>
                       <td>{{$mc->TaskCode}}</td>
                       <td>{{$mc->noofsessions}}</td>
                       <td>{{$mc->orderMT}}</td>
                      
                   </tr>
                        @endforeach
                    @if($moduleTask=='[]')
                        <center>Data Not Found</center>
                    @endif
                @endif
        </tbody>
            </table>
            <!--PAGE CONTENT ENDS-->
             
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
     

    function doConfirm(course,formobj)  {
        bootbox.confirm("Are you sure you want to remove "+course, function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
     }
     
      @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
$('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false}, 
            null, 
              null,
             null, 
              null,
             null,
              null,
               null,
                
    ]});
            $('table th input:checkbox').on('click', function() {
    var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function() {
            this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
            });
    });
            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
            function tooltip_placement(context, source) {
            var $source = $(source);
                    var $parent = $source.closest('table')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();
                    var off2 = $source.offset();
                    var w2 = $source.width();
                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                    return 'right';
                    return 'left';
            }
			
			
			
         $('#Revise').click(function()
    {
      
        var CD_ID = $("#CD_IDP").val(); 
       
      //alert(CD_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('InactiveModuletask')}}",
						 data: {CD_ID: CD_ID},
                        dataType: "json", 
						success: function(result) {

							location.reload();  
                                        
                        
                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    );
	
	$('#CourseListCode').change(function(){

       var CDID = document.getElementById('CourseListCode').value;
     
       var msg = '--- Select Version ---';
        $("#Version").html('');
       $.ajax  ({
                     beforeSend: function()
                                        {
                                            
                                            document.getElementById('img12').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                    url: "{{url::to('GetcourseVertions')}}",
                    data: {CDID: CDID},
                    dataType: "json", 
                    success: function(result) {
							$("#Version").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {
								$("#Version").append("<option value=" + item.vv + ">"+ item.vv+"</option>");
                           });
                       
                        },
                                        complete: function() {
                                            document.getElementById('img12').innerHTML ="";

                                        }


                    
                });
        


       
    });

             $('#upload').click(function()
    {
      
        var CD_ID = $("#CD_IDP").val(); 
       var Version = $("#VersionP").val();
      //alert(CD_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('HistoryPrintModuleTaskSeq')}}",
                        data: {CD_ID: CD_ID,Version: Version},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    );

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


    
 </script>