<script>
function getWorkName(elementid,targetid) {
  var x = document.getElementById(elementid);
  x.value = x.value.toUpperCase();
  let _token   = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    url: '{{route('admin.alert-projects.workName')}}',
    type:"POST",
    data:{
          work_code:x.value,
          _token: _token
        },
    success:function(response){
       var element = document.getElementById(targetid);
        if(response.db_status==='ok') {
            element.classList.remove("alert-danger");
            element.classList.add("alert-success");
        }else{
            element.classList.remove("alert-success");
            element.classList.add("alert-danger");
        }
        element.innerHTML = response.work_name;
      },
  });
}

function getBondlist(elementid,targetid) {
  var x = document.getElementById(elementid);
  x.value = x.value.toUpperCase();
  let _token   = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    url: '{{route('admin.workBonds')}}',
    type:"POST",
    data:{
          work_code:x.value,
          _token: _token
        },
    success:function(response){
        $('select[name="'+targetid+'"]').find('option').not(':first').remove();
        if(response.db_status==='ok') {
            var bondList=response.bondList
            for (var j = 0; j < bondList.length; j++) {
                $('select[name="'+targetid+'"]').append($('<option/>', {
                    value: bondList[j].id,
                    text: bondList[j].bond_no+' ,dated: '+bondList[j].bond_date.substring(0,bondList[j].bond_date.indexOf("T")),
                    id: bondList[j].id
                }));
            }
            $('select[name="'+targetid+'"]').val({{isset($alertProject->bond_id)?$alertProject->bond_id:''}})
        }else{}

        },
  });
}

function workAndBond(elementid,targetidForWorkName,targetidForBondList ) {
    getWorkName(elementid,targetidForWorkName);
    getBondlist(elementid,targetidForBondList)
}
</script>
