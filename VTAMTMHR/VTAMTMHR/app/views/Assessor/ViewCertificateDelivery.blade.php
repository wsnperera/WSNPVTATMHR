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
                            View & Enter Certificate Delivery Details 
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
                            <option value="">---Select Center---</option>
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
                            <option value="0">--- Select Course ---</option>
                          
                        </select>
                    </div>
                </div>
                <br/> 
                <div class="control-group">
                    <div class="controls">
                     
                        <button type="submit"  class="btn btn-primary"">
                                <i class="icon-eye-open bigger-100"></i>View</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    
                     
                    </div>
                </div>   
            </form>
             <table>
                <tr>
                    
          
            <td>
                        <form action="CreateCertificateDelivery" method='GET'> 
                            <button type="submit"  class="btn btn-success">
                            <i class="icon-plus bigger-100"></i>Create Certificate Delivery Details</button>
                            <span id='img4'></span>
                        </form> 
                    </td>
                     </tr>
            </table>
            <div id="aaaa">
          
           
                   
                   
                 <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class='center'>No</th>
                        <th class='center'>Center</th>
                        <th class='center'>Course Name</th>
                        <th class='center'>Officer Name</th>
                        <th class='center'>No Of Certificates Issued</th>
                        <th class='center'>Date Issued</th>
                        <th class='center'>Print Certificate Delivery Letter</th>
                        
                       
                        
                </tr>
                </thead>
                    <tbody>

                  <?php 
                  $SerialNo=1;
                  ?>
                @if(isset($courses))
                @foreach($courses as $t)

               
                <tr>
                   
                    <td class="center">{{$SerialNo++}}</td>
                    <td class="center">{{$t->OrgaName}}</td>
                    <td>{{$t->CourseName}}</td>
                    <td class="center">{{$t->Initials}} {{$t->LastName}}</td>
                    <td class="center">{{$t->NoOfCertificates}}</td>
                    <td class="center">{{$t->DateIssued}}</td>
                    @if($t->PrintHandOverLetter == 0)
                    <td class="center">
                        <input type="hidden" id="Certificateid" name="Certificateid" value="{{$t->id}}">
                        <button id="upload" name="getEPF" value="{{$t->id}}" type="button" class="btn btn-small btn-info"><i class="icon-user bigger-50"></i>Print</button>
                    </td>
                    @else
                    <td class='center'> <font color="red"><i class="icon-ok bigger-130"></i></font></td>
                    @endif
                   
                  
                    
                </tr>

             
                @endforeach

               
                @endif
            </tbody>
            </table>
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
               {"bSortable": false},
           
            
           
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


</script>

<script>
$('#center').change(function(){

        //alert('dg');
       var center = document.getElementById('center').value; 
      
       var msg = '--- Select Course ---';
        $("#Course").html('');
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Course").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Course").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
  


    $('#upload').click(function()
    {
      
        var Certificateid = $("#Certificateid").val(); 
      // alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintCertificateOfficer')}}",
                        data: {Certificateid: Certificateid},
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
