<script type="text/javascript">
function getFeatureListAsPerSelectedGroup({ sourceElementId,routeIdentifier,ddlId,value_to_be_selected,dataValueField='id', dataTextField='name', insertBlankRow=true, blankRowValueField='', blankRowTextField='select' } = {})
{
    var key = $("#"+sourceElementId).val();
    var _token = $('input[name="_token"]').val();
    if (key > 0) {
        $.ajax({
            url: "{{ route('dynamicdependent') }}",
            method: "POST",
            data: {
                key: key,
                _token: _token,
                dependent: routeIdentifier
            },
            success: function(data) {
                bindDdlWithDataAndSetValue(ddlId, data, dataValueField, dataTextField, insertBlankRow, blankRowValueField, blankRowTextField,value_to_be_selected);
            }
        });
    }
}
</script>
{{--

'dependent' used to remove requirement of writing new route in lieu of 'dynamicdependent' everytime

 --}}
