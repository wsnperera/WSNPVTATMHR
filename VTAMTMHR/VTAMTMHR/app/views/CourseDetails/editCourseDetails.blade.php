@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Course Details<small><i class="icon-double-angle-right"></i>Edit</small></h1>
                <a href='viewCourseDetails'> << Back </a>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Institute : </label>
                    <div class="controls">
                        <input type="text" readonly="true" required="true" value="{{ProjectN::getInstitute()->InstituteName}}" required="true"/>
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course List Code : </label>
                    <div class="controls">
                        <input type="text" name="CourseListCode" required="true" value="{{$CourseDetails->CourseListCode}}"/>
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Name : </label>
                    <div class="controls">
                        <input type="text" name="CourseName" required="true" value="{{$CourseDetails->CourseName}}"/>
                        <span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">TVC Course Code : </label>
                    <div class="controls">
                        <select name="TVCCourseCodeID">
                            <option value="1" @if($CourseDetails->TVCCourseCodeID==1) selected="true" @endif >EEC1</option>
                            <option value="2" @if($CourseDetails->TVCCourseCodeID==2) selected="true" @endif >CFC2</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">List Code : </label>
                    <div class="controls">
                        <select name="CourseType" required="true">
                            <option value="Part" @if($CourseDetails->CourseType=='Part') selected="true" @endif>Part Time</option>
                            <option value="Full" @if($CourseDetails->CourseType=='Full') selected="true" @endif>Full Time</option>
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Trade : </label>
                    <div class="controls">
                        <select name="TradeId" required="true">
                            @foreach($trades as $t)
                                <option value="{{$t->TradeId}}" @if($CourseDetails->TradeId==$t->TradeId) selected="true" @endif>{{$t->TradeName}}</option>     
                            @endforeach
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Is NVQ ? : </label>
                    <div class="controls">
                        <select name="Nvq" id="Nvq" required="true">
                            <option value="NVQ" @if($CourseDetails->Nvq=='NVQ') selected="true" @endif>Yes</option>
                            <option value="NON-NVQ" @if($CourseDetails->Nvq=='NON-NVQ') selected="true" @endif>No</option>
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Level : </label>
                    <div class="controls">
                        <select name="CourseLevel" id="CourseLevel" required="true">
                            @if($CourseDetails->Nvq=='NVQ')
                                @for($c=1;$c<8;$c++)
                                    <option value="{{$c}}" @if($CourseDetails->CourseLevel==$c) selected="true" @endif>Level {{$c}}</option>
                                @endfor
                            @else
                                <option @if($CourseDetails->CourseLevel=='Certificate') selected="true" @endif>Certificate</option>
                                <option @if($CourseDetails->CourseLevel=='Diploma') selected="true" @endif>Diploma</option>
                                <option @if($CourseDetails->CourseLevel=='Higher Diploma') selected="true" @endif>Higher Diploma</option>
                                <option @if($CourseDetails->CourseLevel=='Degree') selected="true" @endif>Degree</option>
                            @endif
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Program Type : </label>
                    <div class="controls">
                        <select name="ProgramType" required="true">
                            <option @if($CourseDetails->ProgramType=='General') selected="true" @endif>General</option>
                            <option @if($CourseDetails->ProgramType=='Special') selected="true" @endif>Special</option>
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Entry Qualification : </label>
                    <div class="controls">
                        <select name="Qualification_ID" required="true">
                            @foreach($EntryQualifications as $qu)
                                <option value="{{$qu->Qualification_ID}}" @if($CourseDetails->Qualification_ID==$qu->Qualification_ID) selected="true" @endif>{{$qu->qualification}}</option>
                            @endforeach
                        </select><span class="lbl" style="color: red"><b>*</b></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Duration : </label>
                    <div class="controls">
                        <input type="number" name="Duration" min="0" required="true" value="{{$CourseDetails->Duration}}"/>
                        <span class="lbl" style="color: red"><b>*</b></span><span class="label label-important arrowed-in">Part - Enter in Hours / Full - Enter in Months</span>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" value="Edit" class="btn btn-default"/>
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
      
           
               
               
               
      
        
        

    
