<script type="text/javascript">
   function employeeSelect2DropDown(elementID,minimumInputLength=3,employeeType='all',section='ABCD'){
        $(elementID).select2({
            dropdownParent: $('#hrms-model'),
            minimumInputLength: minimumInputLength,
            placeholder: 'Select an Employee ',
            ajax: {
                url: "{{ route('dynamicdependent') }}",

                method: "POST",
                data: function (params) {
                    return {
                        _token: $('input[name="_token"]').val(),
                        term: params.term,// search term
                        dependent: 'employee_id',
                        employeeType: employeeType,
                        section: section,
                    };
                },

                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name + ":" + item.id,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    }

    $(document).ready(function() {
        let section= $( "#section" ).val();
        let employeeType= $( "#employeeType" ).val();

        $('#section').on('change', function() {
           section= this.value;
           employeeType= $( "#employeeType" ).val();
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section);
        });


        $('#employeeType').on('change', function() {
           section= $( "#section" ).val();
           employeeType= this.value;
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section);
        });

        employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType='all',section='all');


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
