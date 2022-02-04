<script type="text/javascript">
    $(document).ready(function() {
        let section= $( "#section" ).val();
        let employeeType= $( "#employeeType" ).val();
        let removeLogged= $( "#removeLogged" ).val();

        $('#section').on('change', function() {
           section= this.value;
           employeeType= $( "#employeeType" ).val();
           removeLogged= $( "#removeLogged" ).val();
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section,removeLogged);
        });


        $('#employeeType').on('change', function() {
           section= $( "#section" ).val();
           employeeType= this.value;
           removeLogged= $( "#removeLogged" ).val();
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section,removeLogged);
        });

        employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType='all',section='all',removeLogged);


        $('#employee_id').change(function(event) {
            $.ajax({
                url: '{{route('employee.basicData')}}',
                type: 'POST',
                //dataType: 'default',//causes error if data is not in jSON format
                data: {employee_id: $('#employee_id').val(),_token : $('meta[name="csrf-token"]').attr('content')},
                success: function (result,status,xhr) {
                    $('#employee_detail_div').html(result)
                },
                error: function (xhr,status,error) {
                    console.log("error",error,status);

                }
            });
        });

    });
</script>
