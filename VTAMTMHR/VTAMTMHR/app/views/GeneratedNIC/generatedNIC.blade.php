@include('includes.bar')
<div class="page-content">
    
    <div class="row-fluid">
        
        <div class="span4">
            <div class="page-header position-relative">
                <h1>Generated NIC<small><i class="icon-double-angle-right"></i>Generate</small></h1>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Date Of Birth : </label>
                        <div class="controls">
                                <input type="date" name="dob" id="dob" />
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Gender : </label>
                        <div class="controls">
                            <select name="gender" id="gender">
                                <option></option>
                                <option value="0">Male</option>
                                <option value="500">Female</option>
                            </select>
                        </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button onclick="no()" class="btn btn-small btn-primary">Generate</button>
                    </div>
                </div>
            </div>
        </div>
         <div class="span4">
            <div class="page-header position-relative">
                <h1><small></small></h1>
            </div>
            <div class="control-group">
                <br>
                <div class="control-group" id="gen"></div>
                <div class="control-group" id="nic" style="background-color: gray">
                </div>
            </div>
         </div>
    </div>
</div>
@include('includes.footer')
<script type='text/javascript'>
    function no()
    {
        if($('#dob').val()=='' || $('#gender').val()=='')
        {
            alert('please Enter Date Of Birth and Gender');
            $("#nic").html(null);
        }
        else
        {
            $.ajax
            ({
                beforeSend: function() 
                {
                    document.getElementById('gen').innerHTML = "<br><br><img height='80%' width='50%' src=\"{{Url('assets/images/abc.gif')}}\"/>";
                    $("#nic").html(null);
                },
                type: "POST",
                url: 'ajaxGetGeneratedNIC',
                data:{ dob : $('#dob').val(),gender : $('#gender').val()},
                success: function(result)
                {
                    $("#nic").html(result);
                },
                complete: function() 
                {
                    document.getElementById('gen').innerHTML = "";
                },
            });
        }
     }
</script>
      
           
               
               
               
      
        
        

    
