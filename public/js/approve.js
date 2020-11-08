$(function(){

    var value = '';
    var id = '';
    // var data = '';
    
    $('select').on('change', function(){
        //選択された申請状態を表すstatus_description_idを取得
        value = $(this).val();
        //誰のどの申請情報が選択されたのかを表すmanagement_id(=monthly_id)を取得
        id = $(this).attr('id');
        //各申請に対する申請状態を管理するshift_approvalテーブルに変更内容を渡すdataを格納
        data = {
            "status_descriptions_id" : value,
            "managements_id" : id
        }
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
                alert('ステータスが変更されました');
                
            })
            .fail(function(xhr, textStatus, errorThrown) {
                console.log("NG:" + xhr.status);
            });
    });
});