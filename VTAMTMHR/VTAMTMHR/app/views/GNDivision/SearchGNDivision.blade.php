@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('viewGNDivisionVTA')}}"> << Back to GN Division </a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                GN Division		
                <small>
                    <i class="icon-double-angle-right"></i>
                    Search
                </small>			
            </h1>
        </div>
        <form name='search' action="{{url('searchGNDivisionVTA')}}" method='get'>
            Search GN Division By DS Division Name/GN Division Name<input type='text' name="SearchKey"/>   <input type='submit' value='Search'/>
        </form>

        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#No#</th>
                        <th>District Name</th>
                        <th>DS Division Name</th>
                        <th>GN Division Code</th>
                        <th>GN Division Name</th>
                        <th>Remove</th>	
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @if(isset($GNDivision))
                    @foreach($GNDivision as $gn)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{GNDivision::getDistrictName($gn->DSDivisionCode)}}</td>
                        <td>@if(!is_null($gn->getDSDivision)){{$gn->getDSDivision->ElectorateName}}@endif </td>
                        <td>@if($user->hasPermission('editGNDivisionVTA'))<a href="{{url('editGNDivisionVTA?id='.$gn->GNDivisionCode)}}">{{$gn->GNDivisionCode}}</a>
                            @else {{$gn->GNDivisionCode}} @endif</td>
                        <td>{{$gn->GNDivisionName}} </td>  
                        <td>@if($user->hasPermission('deleteGNDivisionVTA'))
                            <form id="deleteform"  action="{{url('deleteGNDivisionVTA?id='.$gn->GNDivisionCode)}}" method="POST" onsubmit="return doConfirm('{{$gn->GNDivisionName}}', this)">
                                <input type="hidden" name='id' value="{{$gn->GNDivisionCode}}" />
                                <button type="submit" class="btn btn-grey btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                            </form>@endif
                        </td>
                    </tr>
                    @endforeach
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

                            function doConfirm(GNDivision, formobj){
                            bootbox.confirm("Are you sure you want to remove " + GNDivision, function(result)  {
                            if (result){
                            formobj.submit();
                            }
                            });
                            return false; // by default do nothing hack :D
                            }

                            $('#sample-table-2').dataTable({
                            "bPaginate":false,
                                    "aaSorting":[],
                                    "aoColumns": [
                                    {"bSortable": false}, null, null, null, null, {"bSortable": false}
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