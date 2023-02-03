@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Competency Standards <small><i class="icon-double-angle-right"></i>Create Competency Standard</small></h1>

            </div>
            <form class="form-horizontal" action="" method="POST">

                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Competency Standard : </label>
                    <div class="controls">
                        <input type="text" name="competency" id="competency"   />
                    </div>
                </div>
                <div id="addElements" >
                    <div class="control-group">
                        <label class="control-label" for="CourseListCode">Models : </label>
                        <div class="controls">
                            <input type="text" name="model[]"    id="model"/>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <input type="button" value="Add New Module" class="btn btn-small btn-primary" id="Add" /> &nbsp;&nbsp;&nbsp;&nbsp; 
                        <input type="Submit" value="Save" class="btn btn-small btn-primary" />
                    </div>
                </div> 
                <div id="AAnewElementsAA" class="hidden" value="0">
                    <div class="abcdef">
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" name="model[]"    id="model"/>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>
<script>

    @if (isset($done))
            bootbox.alert("Added Successfully.");
    // $.gritter.add({title: "", text: " Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
</script>
<script type="text/javascript">
            $("#Add").click(function() {
        alert();
        var html1 = $("#AAnewElementsAA").html();
        alert(html1);
        var myArray = $('.abcdef');
        var count = myArray.length;
        var mod0 = "";
        var mod = "";

        var ddelete = 0;
        $.each(myArray, function($key, $value) {
            if (!($key === 0 || $key === (count - 1))) {
                mod = $($value).find("select")[0].value;

                if (mod === "") {
                    $value.remove();
                    ddelete++;
                }
            } else if ($key === 0) {
                mod0 = $($value).find("select")[0].value;

            }
        });

        if (ddelete === 0 && (mod0 !== "")) {
            $("#addElements").append(html1);

        }
    });





















