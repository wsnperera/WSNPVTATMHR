@include('includes.bar')  
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        NVQ Exams        
                        <small>
                            <i class="icon-double-angle-right"></i>
                            View ROA & NVQ Certificate List
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="" method='POST' class='form-horizontal'>
             <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center" id="center" required>
                             <option value="">--- Select Center ---</option>
                           <!-- <option value="0">All</option>-->

                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label" for="centers">Course:</label>
                    <div class="controls">
                        <select name="Course" id="Course" required>
                            <option value="">--- Select Course ---</option>
                          
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="centers">Certificate Type:</label>
                    <div class="controls">
                        <select name="CertificateType" id="CertificateType" required>
                            <option value="">--- Select Type ---</option>
                            <option value="ROA">ROA</option>
                            <option value="NVQ">NVQ</option>
                          
                        </select>
                    </div>
                </div>
                 <!--<div class="control-group">
                    <label class="control-label" for="centers">Competency Standard</label>
                    <div class="controls">
                        <select name="comS" id="comS" required>
                             @foreach($Competency as $cs)
                            <option value="{{$cs->code}}">{{$cs->name}} - {{$cs->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>-->
                <br/> 
                <div class="control-group">
                    <div class="controls">
                        <button type="submit"  class="btn btn-primary"">
                                <i class="icon-ok bigger-100"></i>View</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    </div>
                </div>   
            </form>
            <div id="aaaa">
            @if(isset($trainees))
            <table>
                <tr>
                    <td>@if($CertificateType == 'ROA')
                        <form> 
                            <input type="hidden" value="{{$CSID}}" name="CS_ID" id="CS_ID"/>
                            <button type="submit" id="upload" class="btn btn-success">
                            <i class="icon-print bigger-200"></i>Print ROA Certificate</button>
                            <span id='img4'></span>
                        </form> 
                        @endif

                    </td>
                    <td>
                        @if($CertificateType == 'NVQ')
                        <form > 
                            <input type="hidden" value="{{$CSID}}" name="CS_ID" id="CS_ID"/>
                            <button type="button"  id="upload1" class="btn btn-success">
                            <i class="icon-print bigger-100"></i>Print NVQ Student List</button>
                            <span id='img4'></span>
                        </form> 
                        @endif
                    </td>
                  <!--  <td>  
                        <form action="ScheduleFinalAssessment" method='GET'> 
                        <input type="hidden" value="{{$CSID}}" name="CS_ID" id="CS_ID"/>
                        <button type="submit"  class="btn btn-info">
                        <i class="icon-plus bigger-100"></i>Schedule Final-Assessment</button>
                        <span id='img4'></span>
                        </form> 
                    </td>-->
                    
                </tr>
            </table>
            <input type="hidden" id="CSID" name="CSID" value="{{$CSID}}" />
            <input type="hidden" id="CertificateType" name="CertificateType" value="{{$CertificateType}}" />
          
            
             
            

             @endif
           <!-- <h5 style="color: #777777;">@if(isset($CourseCode))CourseCode:&nbsp;&nbsp;{{$CourseCode}}@endif</h5>
            <h5 style="color: #777777;">@if(isset($BatchCode))BatchCode:&nbsp;&nbsp;{{$BatchCode}}@endif</h5>-->
             @if(isset($trainees))

             @if($CertificateType == 'ROA')
            
            <table id='sample-table-2' class='table table-striped table-bordered table-hover' align='center'>
                <thead>
                <tr align="center">
                     <th class='center'>No</th>
                     <th class='center'>Center Name</th>
                     <th class='center'>Student Name</th>
                     <th class='center'>NIC</th>
                     <th class='center'>Course Name</th>
                     <th class='center'>CourseCode</th>
                     <th class='center'>Unit Code</th>
                     <th class='center'>Unit Name</th>
                     <th class='center'>Print Status</th>
                     <th class='center'>
                                  <label>(Select All)
                                    <input name='select_all[]' value='' type='checkbox'>
                                    <span class='lbl'> &nbsp;</span>
                                    </label></th>
                        </th>


                  
                </tr>
            </thead>
            <tbody>
                 <?php $SerialNo=1
                  ?>
               
                @foreach($trainees as $t)
                <tr>
                     <td>{{$SerialNo++}}</td>
                     <td>{{$t->OrgaName}}</td>
                     <td>{{$t->NameWithInitials}}</td>
                     <td>{{$t->NIC}}</td>
                     <td>{{$t->CourseName}}</td>
                     <td>{{$t->CourseCode}}</td>
                     <td>{{$t->code}}</td>
                     <td>{{$t->name}}</td>
                     @if($t->PrintCertificate == 0)
                     <td class='center'><font color="blue"> <i class="icon-print bigger-130"></i></font></td>
                     @else
                     <td class='center'><font color="red"> <i class="icon-ok bigger-130"></i></font></td>
                     @endif
                     @if($t->PrintCertificate == 0)
                    <td class="center"><label>
                        <input name="trainee_ids[]"  class="abc" value="{{$t->id}}" type="checkbox" />
                        <span class="lbl"> &nbsp;</span>
                        </label>
                    </td>
                    @else
                    <td class="center"><label>
                        <input name="trainee_ids[]"  class="abc" value="{{$t->id}}" type="checkbox" checked/>
                        <span class="lbl"> &nbsp;</span>
                        </label>
                    </td>
                    @endif
                     
                     
                </tr>
                @endforeach
               
               
                

                 
               
            </tbody>
            </table>
            @else

            <table id='sample-table-3' class='table table-striped table-bordered table-hover' align='center'>
                <thead>
                <tr align="center">
                     <th class='center'>No</th>
                     <th class='center'>Center Name</th>
                     <th class='center'>Student Name</th>
                     <th class='center'>NIC</th>
                     <th class='center'>Course Name</th>
                     <th class='center'>CourseCode</th>
                     <th class='center'>Qualification Package</th>
                    
                   
                </tr>
                </thead>  
                <tbody>
                
                 <?php $SerialNo=1
                  ?>
               
                @foreach($trainees as $t)
                <tr>
                     <td>{{$SerialNo++}}</td>
                     <td>{{$t->OrgaName}}</td>
                     <td>{{$t->NameWithInitials}}</td>
                     <td>{{$t->NIC}}</td>
                     <td>{{$t->CourseName}}</td>
                     <td>{{$t->CourseCode}}</td>
                     <td>{{$t->PackageCode}}</td>
                    
                         
                     
                     
                </tr>
                @endforeach
               
               </tbody>
            </table>


                @endif
             @endif
            <!--PAGE CONTENT ENDS-->
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(applicant, formobj)
    {
        bootbox.confirm("Are you sure you want to remove " + applicant, function(result)
        {
        if (result)
        {
        formobj.submit();
        }
        });
                return false;
    }
    
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
                    null,
                  {"bSortable": false},
                

           
    ]});
    $('#sample-table-3').dataTable({
    "aoColumns": [
            {"bSortable": false},
             null,
            null,
             null,
             null,
               null,
                 null,
                   
                

           
    ]});

     $('#sample-table-2 th input:checkbox').on('click', function() {
                                var a = this;
                                $(this).closest('table').find('tr td:nth-child(10) input:checkbox')
                                        .each(function() {
                                            this.checked = a.checked;
                                            //$(this).closest('tr').troggleClass('selected');
                                        });

                            });
      

       $('#sample-table-3 th input:checkbox').on('click', function() {
                                var a = this;
                                $(this).closest('table').find('tr td:nth-child(9) input:checkbox')
                                        .each(function() {
                                            this.checked = a.checked;
                                            //$(this).closest('tr').troggleClass('selected');
                                        });

                            });
      


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


</script>

<script>
$('#center').change(function(){

        //alert('dg');
       var center = document.getElementById('center').value; 
      
       var msg = '--- Select Course ---';
       var All = 'All';
        $("#Course").html('');
       $.ajax  ({
                    url: "{{url::to('GetNominatedCourses')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Course").append("<option value=''>" + msg + "</option>");
                       // $("#Course").append("<option value='All'>" + All + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Course").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
  


    $('#upload').click(function()
    {
      
        var CS_ID = $("#CS_ID").val(); 
      // alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintAssessorAssignedLetter')}}",
                        data: {CS_ID: CS_ID},
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
    $('#upload1').click(function()
    {

        //var ifOneSelected = false;
       // var selectedTraineeids = [];
       // selectedTraineeids = $('input[name="trainee_ids[]"]').serializeArray();
       // alert(selectedTraineeids);
        
      

      /*  if (selectedTraineeids.length > 0) {
            ifOneSelected = true;
        }
        else {
            bootbox.alert('Please Select At Least One Trainee!');
        }*/
      
        var CS_ID = $("#CS_ID").val(); 
        //var selectedTraineeids = $("#trainee_ids").val(); 
      //alert(trainee_ids);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintNVQStudentList')}}",
                        data: {CS_ID: CS_ID},
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
    


</script>
