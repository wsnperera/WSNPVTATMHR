@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
              <!--  <a href={{url('')}}> << Back to Assessor View</a>-->
                <h1>Certificate Delivery<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"  id='NewModule'/>

             <div class="control-group">
                    <div class="controls">
                         <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
                    </div>
                </div>     
           
               
              
              <div class="control-group">
                    <label class="control-label" for="centers">EPF No</label>
                    <div class="controls">
                       <input type="text" name="EPF" id="EPF" />
                      <button id="getEPF" name="getEPF" type="button" class="btn btn-small btn-success"><i class="icon-user bigger-50"></i>Check Officer</button>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label" for="centers">Name</label>
                    <div class="controls">
                       <input type="text" name="Ename" id="Ename" value="" readonly />
                      
                    </div>
                </div>
                <hr/>

              <div id="ncc_id1">
                <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center[]" id="center1" required>
                            <option value="">---Select Center---</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" for="CourseCode">Course</label>
                        <div class="controls">
                           
                               <select name="CourseList[]" id="CourseListCode1" onclick="dale_ncc(1)" required>
                                    <option value="0">--- Select Course ---</option>
                          
                                </select>
                             
                               <button  class="btn btn-warning" style="margin: 0; height: 30px; border: 0; visibility: hidden" type="button" id="add_ncc"><i class="icon-plus bigger-100"></i>Add Course</button>
                               <button class="btn btn-danger" style="margin: 0; height: 30px; border: 0; visibility: hidden" type="button" id="remove_ncc"><i class="icon-remove bigger-100"></i>Remove Course</button>


                                
                            
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="CourseCode">No Of Certificates</label>
                        <div class="controls">
                          <input type="text" name="NoofCertifi[]" id="CertifiNo1" required>
                        </div>
                      </div>
                      <hr/>
                </div>
                <div id="ncc_id2" style="visibility: hidden">
                  <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center[]" id="center2" >
                            <option value="">---Select Center---</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                   <div class="control-group">
                        <label class="control-label" for="CourseCode">Course</label>
                         <div class="controls">
                           
                          
                             <select name="CourseList[]" id="CourseListCode2" >
                                    <option value="0">--- Select Course ---</option>
                          
                                </select>
                         </div>
                     </div>
                      <div class="control-group">
                        <label class="control-label" for="CourseCode">No Of Certificates</label>
                        <div class="controls">
                          <input type="text" name="NoofCertifi[]" id="CertifiNo2">
                        </div>
                      </div>
                      <hr/>
                </div>
                <div id="ncc_id3" style="visibility: hidden">
                  <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center[]" id="center3" >
                            <option value="">---Select Center---</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                  <div class="control-group">
                        <label class="control-label" for="CourseCode">Course</label>
                         <div class="controls">
                           
                           
                             <select name="CourseList[]" id="CourseListCode3"  >
                                    <option value="0">--- Select Course ---</option>
                          
                                </select>
                         </div>
                     </div>
                      <div class="control-group">
                        <label class="control-label" for="CourseCode">No Of Certificates</label>
                        <div class="controls">
                          <input type="text" name="NoofCertifi[]" id="CertifiNo3">
                        </div>
                      </div>
                      <hr/>
                </div>
                <div id="ncc_id4" style="visibility: hidden">
                  <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center[]" id="center4" >
                            <option value="">---Select Center---</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                  <div class="control-group">
                        <label class="control-label" for="CourseCode">Course</label>
                         <div class="controls">
                           
                    
                             <select name="CourseList[]" id="CourseListCode4"  >
                                    <option value="0">--- Select Course ---</option>
                          
                                </select>
                         </div>
                     </div> 
                      <div class="control-group">
                        <label class="control-label" for="CourseCode">No Of Certificates</label>
                        <div class="controls">
                          <input type="text" name="NoofCertifi[]" id="CertifiNo4">
                        </div>
                      </div>
                      <hr/>
                </div>
                <div id="ncc_id5" style="visibility: hidden">
                  <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center[]" id="center5" >
                            <option value="">---Select Center---</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                  <div class="control-group">
                        <label class="control-label" for="CourseCode">Course</label>
                         <div class="controls">
                           
                            
                             <select name="CourseList[]" id="CourseListCode5"  >
                                    <option value="0">--- Select Course ---</option>
                          
                                </select>
                         </div>
                     </div> 
                      <div class="control-group">
                        <label class="control-label" for="CourseCode">No Of Certificates</label>
                        <div class="controls">
                          <input type="text" name="NoofCertifi[]" id="CertifiNo5">
                        </div>
                      </div>
                      <hr/>
                </div>
                <div id="ncc_id6" style="visibility: hidden">
                  <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center[]" id="center6" >
                            <option value="">---Select Center---</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="control-group">
                       <label class="control-label" for="CourseCode">Course</label>
                       <div class="controls">
                           
                          
                             <select name="CourseList[]" id="CourseListCode6"  >
                                    <option value="0">--- Select Course ---</option>
                          
                                </select>
                         </div>
                    </div>
                     <div class="control-group">
                        <label class="control-label" for="CourseCode">No Of Certificates</label>
                        <div class="controls">
                          <input type="text" name="NoofCertifi[]" id="CertifiNo6">
                        </div>
                      </div>
                      <hr/>
                </div>
                 
                <input type="hidden" name="dale_ncc_id" id="dale_ncc_id" value="1"/>
               
                <div class="control-group">
                    <div class="controls">
                         <button type="submit" class="btn btn-primary ">Save</button>
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

            $.gritter.add({title: "", text: "Assessor Renominated Successfully", class_name: "gritter-info gritter-center"});

    @endif


    $('#getEPF').click(function()
    {
      
        var EPF = $("#EPF").val(); 
      //alert(EPF);
      
           $("#Ename").html('');
                $.ajax  ({
                    url: "{{url::to('GetCertificateOfficer')}}",
                    data: { EPF: EPF},
                    dataType: "json",
                 
                   success: function(result)
                    {
                        $.each(result, function(i, item)
                        {

                            // document.getElementById('Ename').value = item.Initials;
                             document.getElementById('Ename').value = item.Initials + ' ' + item.LastName;

                                   

                        });
                      

                    }


                    
                });
        


       
    });
    
      


      
function dale_ncc(x) 
{
    var a = parseInt(x);
                                  
    document.getElementById('add_ncc').style.visibility = 'visible';


}

 $('#add_ncc').click(function() {
                                    var s = parseInt($('#dale_ncc_id').val());
                                    //alert(s);
                                    if(s == 1)
                                    {
                                      document.getElementById('ncc_id2').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 2;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 2)
                                    {
                                      document.getElementById('ncc_id3').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 3;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 3)
                                    {
                                      document.getElementById('ncc_id4').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 4;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 4)
                                    {
                                      document.getElementById('ncc_id5').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 5;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 5)
                                    {
                                      document.getElementById('ncc_id6').style.visibility = 'visible';
                                      document.getElementById('dale_ncc_id').value = 6;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                  
                                });
  $('#remove_ncc').click(function() {
                                    var s = parseInt($('#dale_ncc_id').val());
                                    if(s == 1)
                                    {
                                      
                                    }
                                     else if(s == 2)
                                    {
                                      document.getElementById('ncc_id2').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 1;
                                      document.getElementById('remove_ncc').style.visibility = 'hidden';
                                    }
                                     else if(s == 3)
                                    {
                                      document.getElementById('ncc_id3').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 2;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 4)
                                    {
                                      document.getElementById('ncc_id4').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 3;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 5)
                                    {
                                      document.getElementById('ncc_id5').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 4;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }
                                    else if(s == 6)
                                    {
                                      document.getElementById('ncc_id6').style.visibility = 'hidden';
                                      document.getElementById('dale_ncc_id').value = 5;
                                      document.getElementById('remove_ncc').style.visibility = 'visible';
                                    }

                                    
                                });



  $('#center1').change(function(){

        //alert('dg');
       var center = document.getElementById('center1').value; 
      
       var msg = '--- Select Course ---';
        $("#CourseListCode1").html('');
         
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode1").append("<option value=''>" + msg + "</option>");
                        
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode1").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");
                            



                        });
                                        
                        
                        }


                    
                });
        


       
    });

   $('#center2').change(function(){

        //alert('dg');
       var center = document.getElementById('center2').value; 
      
       var msg = '--- Select Course ---';
        $("#CourseListCode2").html('');
         
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode2").append("<option value=''>" + msg + "</option>");
                        
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode2").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");
                            



                        });
                                        
                        
                        }


                    
                });
        


       
    });
    $('#center3').change(function(){

        //alert('dg');
       var center = document.getElementById('center3').value; 
      
       var msg = '--- Select Course ---';
        $("#CourseListCode3").html('');
         
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode3").append("<option value=''>" + msg + "</option>");
                        
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode3").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");
                            



                        });
                                        
                        
                        }


                    
                });
        


       
    });
   $('#center4').change(function(){

        //alert('dg');
       var center = document.getElementById('center4').value; 
      
       var msg = '--- Select Course ---';
        $("#CourseListCode4").html('');
         
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode4").append("<option value=''>" + msg + "</option>");
                        
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode4").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");
                            



                        });
                                        
                        
                        }


                    
                });
        


       
    });

    $('#center5').change(function(){

        //alert('dg');
       var center = document.getElementById('center5').value; 
      
       var msg = '--- Select Course ---';
        $("#CourseListCode5").html('');
         
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode5").append("<option value=''>" + msg + "</option>");
                        
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode5").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");
                            



                        });
                                        
                        
                        }


                    
                });
        


       
    });

     $('#center6').change(function(){

        //alert('dg');
       var center = document.getElementById('center6').value; 
      
       var msg = '--- Select Course ---';
        $("#CourseListCode6").html('');
         
       $.ajax  ({
                    url: "{{url::to('getFinalAssessedCourse')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseListCode6").append("<option value=''>" + msg + "</option>");
                        
                         $.each(result, function(i, item)
                        {



                            $("#CourseListCode6").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");
                            



                        });
                                        
                        
                        }


                    
                });
        


       
    });

    </script>


