@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Course Details<small><i class="icon-double-angle-right"></i>Create</small></h1>
                <a href='viewCourseDetails'> << Back </a>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Institute : </label>
                    <div class="controls">
                        <input type="text" readonly="true" required="true" value="{{ProjectN::getInstitute()->InstituteName}}" required="true"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                    <div class="controls">
                        <input type="text" name="CourseListCode" required="true"/><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Name : </label>
                    <div class="controls">
                        <input type="text" name="CourseName" required="true"/><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">TVC Course Code : </label>
                    <div class="controls">
                        <select name="TVCCourseCodeID">
                            <option></option>
                            <option value="1">EEC1</option>
                            <option value="2">CFC2</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Type : </label>
                    <div class="controls">
                        <select name="CourseType" required="true">
                            <option></option>
                            <option value="Part">Part Time</option>
                            <option value="Full">Full Time</option>
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Trade : </label>
                    <div class="controls">
                        <select name="TradeId" required="true">
                            <option></option>
                            @foreach($trades as $t)
                                <option value="60">{{$t->TradeName}}</option>     
                            @endforeach
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Is NVQ ? : </label>
                    <div class="controls">
                        <select name="Nvq" id="Nvq" required="true">
                            <option></option>
                            <option value="NVQ">Yes</option>
                            <option value="NON-NVQ">No</option>
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Level : </label>
                    <div class="controls">
                        <select name="CourseLevel" id="CourseLevel" required="true">
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Program Type : </label>
                    <div class="controls">
                        <select name="ProgramType" required="true">
                            <option></option>
                            <option>General</option>
                            <option>Special</option>
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Entry Qualification : </label>
                    <div class="controls">
                        <select name="Qualification_ID" required="true">
                            <option></option>
                            @foreach($EntryQualifications as $qu)
                                <option value="{{$qu->Qualification_ID}}">{{$qu->qualification}}</option>
                            @endforeach
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Duration : </label>
                    <div class="controls">
                        <input type="number" name="Duration" min="0" required="true"/><span class="lbl" style="color: red"><b>*</b></span>
                        <span class="label label-important arrowed-in">Part - Enter in Hours / Full - Enter in Months</span>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" value="Create" class="btn btn-default"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="span4">
            @if($errors->has())
                @foreach($errors->all() as $msg)
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('includes.footer')
<script type='text/javascript'>
    $('#Nvq').change(function() 
    {
        if ($(this).val() == 'NVQ') 
        {
            $("#CourseLevel").html('');
            for (var i = 1; i <= 7; i++)
            {
                $("#CourseLevel").append('<option value="'+i+'">Level ' + i + '</option>');
            }
        }
        if ($(this).val() === 'NON-NVQ')
        {
            $("#CourseLevel").html('');
            $("#CourseLevel").append('<option>Certificate</option><option>Diploma</option><option>Higher Diploma</option><option>Degree</option>');
        }
    });
</script>
      
           
               
               
               
      
        
        

    
