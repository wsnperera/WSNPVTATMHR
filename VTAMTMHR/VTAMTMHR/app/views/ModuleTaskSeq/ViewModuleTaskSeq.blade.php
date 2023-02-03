@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('ViewModuleTask')}}> << Back to Module Task</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>Module Task Sequence<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
        <form name='search' action="{{url('SearchModuleTaskSeq')}}" method='get' class="form-horizontal">
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
                            
                            <button type="button" id="upload" class="btn btn-yellow">
                            <i class="icon-print bigger-200"></i>Print</button>
                            <span id='img4'></span>
            </form> 
                       
        </td>
		<td></td>
		 @if($user->hasPermission('InactiveModuletask'))
		 <td>
          
            <form> 
                            <input type="hidden" value="{{$CDID}}" name="CD_IDP" id="CD_IDP"/>
                            
                            <button type="button" id="Revise" class="btn btn-pink">
                            <i class="icon-remove bigger-150"></i>Inactive</button>
                            <span id='img4'></span>
            </form> 
                       
        </td>
       @endif
    </tr>
	
    </table>
        

        @endif
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
                    <th>Module TaskSeq ID</th>
					<th>Edit Order</th>
					<th>Edit No of Session</th>
                    <th>Course Name</th>
                    <th>Module Name</th>
                    <th>Module Code</th>
                    <th>Task Name</th>
                    <th>Task Code</th>
                    <th>No Of Sessions</th>
                    <th>Order</th>
                    <th>Remove </th>
                </tr>
                 </thead>
                 <tbody>
                @if(isset($moduleTask))
                    @foreach($moduleTask as $mc)
                    <tr>
                        <!--<td><b><u><a href="{{url('editModuleCourse?id='.$mc->id)}}">{{$mc->id}}</a></u><b></td>-->
                       <td>{{$mc->id}}</td>
					  <td><font color="green"><a class="green"  id="{{$mc->id}}"> <i class="icon-smile icon-3x"></i></a> </font></td>
					  <td><font color="pink"><a class="pink"  id="{{$mc->id}}"> <i class="icon-smile icon-3x"></i></a> </font></td>

                       <td>{{$mc->CourseName}}</td>
                       <td>{{$mc->ModuleName}}</td>
                       <td>{{$mc->ModuleCode}}</td>
                       <td>{{$mc->TaskName}}</td>
                       <td>{{$mc->TaskCode}}</td>
                       <td>{{$mc->noofsessions}}</td>
                       <td>{{$mc->orderMT}}</td>
                       <td>
                        @if($user->hasPermission('deleteModuleTaskSeq'))
                        <form id="deleteform"  action='deleteModuleTaskSeq' method="POST" onsubmit="return doConfirm('{{$mc->ModuleName}}-{{$mc->TaskName}}',this)">
                                <input type="hidden" name='id' value="{{$mc->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                        </form>
                        @endif
                        </td>
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
$( document ).ready(function() {
	
	
	 $(".pink").click(function(){
		 
		 

     var id = this.id;
     //alert(id);
	 
	  var x = '<form id="infos" action="" style="border-style: solid;border-color: pink pink pink pink;border-width: thick;">'
      + '<table'
      + 'boder="2" cellspacing="2"><div class="control-group"><div  class="controls"><tr>'
      + '<td cellspacing="2"><br/>&nbsp&nbspSession no:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="SessionNo" id="SessionNo" required="true"/></td></tr></div></div><table></form>';
	  
	  
 bootbox.confirm(x, function(result) {
        if(result)
        {
           

         var SessionNo = $("#SessionNo").val();
         if(SessionNo == "")
		 {
			 bootbox.alert('Plase Enter No of Session Required!!!');
		 }
		 else
		 {
			 doStuffWithResultspink(id,SessionNo);
		 }


        
        }
});  

  
});

function doStuffWithResultspink(id,SessionNo) {
	


     $.ajax  ({
                    url: "{{url::to('AddModuleTaskSeqSessionNo')}}",
                    data: { id: id,SessionNo: SessionNo},
                    
                   success: function(result) {
					   if(!bootbox.alert('Session Number Added Successfully!!!!!')){window.location.reload();}

                        
                        }


                    
                });
   
}
	
	 $(".green").click(function(){
		 
		 

     var id = this.id;
     //alert(id);
	 
	  var x = '<form id="infos" action="" style="border-style: solid;border-color: pink pink pink pink;border-width: thick;">'
      + '<table'
      + 'boder="2" cellspacing="2"><div class="control-group"><div  class="controls"><tr>'
      + '<td cellspacing="2"><br/>&nbsp&nbspOrder no:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="OrderNo" id="OrderNo" required="true"/></td></tr></div></div><table></form>';
	  
	  
 bootbox.confirm(x, function(result) {
        if(result)
        {
           

         var OrderNo = $("#OrderNo").val();
         if(OrderNo == "")
		 {
			 bootbox.alert('Plase Enter Order Number!!!');
		 }
		 else
		 {
			 doStuffWithResults(id,OrderNo);
		 }


        
        }
});  

  
});
function doStuffWithResults(id,OrderNo) {
	


     $.ajax  ({
                    url: "{{url::to('AddModuleTaskSeqOrderNo')}}",
                    data: { id: id,OrderNo: OrderNo},
                    
                   success: function(result) {
					   if(!bootbox.alert('Order Number Added Successfully!!!!!')){window.location.reload();}

                        
                        }


                    
                });
   
}
 });
 </script>
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
	"bPaginate":false,
    "aaSorting":[],
    "aoColumns": [
            {"bSortable": false}, 
            null, 
			  null, 
              null,
             null, 
              null,
             null,
              null,
               null,
                null,null,
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

             $('#upload').click(function()
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
                        url: "{{Url('PrintModuleTaskSeq')}}",
                        data: {CD_ID: CD_ID},
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