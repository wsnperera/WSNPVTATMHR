@include('includes.bar')
<a href="{{url('viewGNDivisionVTA')}}"> << Back to GN Division </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    GN Division		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <!--Write your code here start-->
            <form class="form-horizontal" action="{{url('editGNDivisionVTA')}}" method="POST" />

            <div class="control-group">
                <div class="controls">
                    <input type="hidden" name="GNDivisionCode" value="{{$GNDivision->GNDivisionCode}}"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="District">District Name</label>
                <div class="controls">
                    <select id="DistrictCode">
                        <option @if($GNDivision->DSDivisionCode== "") selected @endif value="">---Select---</option>
                        @if($DistrictCodevalue != "")
                        @foreach ($District as $d)
                        <option @if($d->DistrictCode== $DistrictCodevalue) selected  value="{{$d->DistrictCode}}" @endif>{{$d->DistrictName}}</option>
                        @endforeach
                        @endif
                    </select>
                    <span id="ajax_img3"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DSDivisionCode">DS Division Name</label>
                <div class="controls">
                    <select name="DSDivisionCode"  id="ElectorateCode"> 
                        <option @if($GNDivision->DSDivisionCode== '') selected @endif value="">---Select---</option>
                        @foreach ($Electorate as $Electorate)
                        <option @if($Electorate->ElectorateCode== $GNDivision->DSDivisionCode) selected  value="{{$Electorate->ElectorateCode}}" @endif>{{$Electorate->ElectorateName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="GNDivisionName">GN Division Name</label>
                <div class="controls">
                    <input type="text" name="GNDivisionName" value="{{$GNDivision->GNDivisionName}}"/>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Update</button>
                </div>
            </div>
            </form>

            <!--/span 4 for error handling -->





            @if($errors->has())
            @foreach($errors->all() as $msg)

            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong> <i class="icon-remove"></i>{{$msg}}</strong>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

@include('includes.footer')
<script type="text/javascript">
    $("#DistrictCode").change(function () {

        var dc = document.getElementById('DistrictCode').value;
        $.ajax({
            url: "{{url::to('EleGNDivisionjaxVTA')}}",
            data: {DistrictCode: dc},
            beforeSend: function () {
                document.getElementById('ajax_img3').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
            },
            success: function (result)
            {
                document.getElementById('ElectorateCode').innerHTML = result;
            },
            complete: function () {
                document.getElementById('ajax_img3').innerHTML = "";
            }
        });
    });

</script>


