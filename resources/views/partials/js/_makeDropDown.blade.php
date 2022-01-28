<script type="text/javascript">
    function bindDdlWithData(ddlId, data, dataValueField, dataTextField, insertBlankRow, blankRowValueField, blankRowTextField) {
    $('#' + ddlId).empty();
        var dataLength = data.length;
        if (dataLength > 0) {
            var originalDDL = $("#" + ddlId);
            if (insertBlankRow)
            { originalDDL.append("<option value='" + blankRowValueField + "'>" + blankRowTextField + "</option>"); }
            for (i = 0; i < dataLength; i++) {
                originalDDL.append("<option value='" + data[i][dataValueField] + "'>" + data[i][dataTextField] + "</option>");
            }
            if ($("#" + ddlId).parent().children("ddlValue").length > 0) {
                var valToSelect = $("#" + ddlId).parent().children("ddlValue").html();
                if (valToSelect.length > 0) {
                    $("#" + ddlId).val(valToSelect);
                }
                else
                { var ddl = document.getElementById(ddlId); ddl.selectedIndex = 0; }
            }
            else
            { var ddl = document.getElementById(ddlId); ddl.selectedIndex = 0; }
        }
    }


    function bindDdlWithDataAndSetValue(ddlId, data, dataValueField, dataTextField, insertBlankRow, blankRowValueField, blankRowTextField, value_to_be_selected ) {
        var ddl = $('#' + ddlId);
        var dataLength = data.length;
        if (dataLength > 0) {
            ddl.empty();
            if(insertBlankRow) ddl.append("<option value='" + blankRowValueField + "'>" + blankRowTextField + "</option>");
            for (i = 0; i < dataLength; i++) {
                ddl.append("<option value='" + data[i][dataValueField] + "'>" + data[i][dataTextField] + "</option>");
            }
            ddl.val((value_to_be_selected)?value_to_be_selected:blankRowValueField)
        }
    }

</script>
