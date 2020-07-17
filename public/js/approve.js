$(function(){

    var value = '';
    var id = '';
    var data = '';
    
    $('select').on('change', function(){
        value = $(this).val();
        id = $(this).attr('id');
        console.log(value);
        data = {
            "status_descriptions_id" : value,
            "managements_id" : id
        }
        console.log(data);
        $.ajax({
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/approval/store',
            dataType: 'json',
            cache: false,
            data: JSON.stringify(data),
            context:this
            }).done(function(data){
                console.log(data);
              location.reload();
    
            });
        
    });
});