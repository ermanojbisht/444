<script type="text/javascript">
       function employeeSelect2DropDown(elementID,minimumInputLength=3,employeeType='all',section='ABCD'){
           
           alert(elementID);

            $(elementID).select2({
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
</script>
