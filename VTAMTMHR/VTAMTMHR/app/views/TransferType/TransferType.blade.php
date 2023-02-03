@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('viewTransferType')}}"> << Back to Appointment Type </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
           Appointment Type		
            <small>
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
        <div class="row-fluid">
            <form name='search' action="{{url('findTransferType')}}" method='get'>
<!--                Search Center <input type='text' name="serachkey" placeholder="Search by Cenetr Code OR District..."/>   <input type='submit' value='Search'/> &nbsp;-->
               @if($user->hasPermission('createTransferType'))
               <a href="{{url('createTransferType')}}"><input class="btn-small" type="button" value="Create TransferType"/></a>
               @endif
            </form>
            
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                   <tr>
                        <th rowspan="2">#No#</th>
                        <th colspan="2" style="text-align:center;">Changes</th>
                        <th rowspan="2">Institute Name</th>
                        <th rowspan="2">Appointment Type</th>
                        <th rowspan="2">Available</th>
                        <th rowspan="2">Priority</th>
                    </tr>
                    <tr>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                 </thead>
                 
                 <tbody>
                     <?php $i=0;?>
                    @if(isset ($TransferType))
                    @foreach ($TransferType as $tt)
                    <tr>
                        <td><?php $i++; echo$i;?></td>
                        <td>@if($user->hasPermission('editTransferType'))
                            <a href="{{url('editTransferType?id='.$tt->T_ID)}}"><i class="icon-pencil icon-2x icon-only infobox-green2"></i></a>
                            @else 
                            @endif
                        </td>
                        <td>@if($user->hasPermission('deleteTransferType'))
                            <form id="deleteform"  action="{{url('deleteTransferType')}}" method="POST" onsubmit="return doConfirm('{{$tt->TransferType}}', this)">
                                <input type="hidden" name='tid' value="{{$tt->T_ID}}" />
                                <button type="submit" class="btn btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                           </form>@endif   
                         </td>
                        <td>@if(!is_null($tt->getInstitute)){{$tt->getInstitute->InstituteName}}@endif</a></td>
                        <td>{{$tt->TransferType}}</td>
                        <td>@if($tt->Available == '1') Yes @else No @endif</td>
                        <td>{{$tt->Priority}}</td>
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
                function doConfirm(TransferType, formobj) {
                bootbox.confirm("Are you sure you want to remove '" + TransferType + "' Appointment Type", function(result) {
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
    {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false}
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
