<script type="text/javascript">
       function getDDLSelectedText(ddlId) {
            var ddl = document.getElementById(ddlId);
            if (ddl.selectedIndex == -1) {
                if (ddl[0].value == "0" || ddl[0].value == "") {
                    if (ddl[0].text) {
                        return ddl[0].text;
                    } else
                        return "";
                } else {
                    return "";
                }
            } else
                return ddl[ddl.selectedIndex].text;
        }


    
</script>