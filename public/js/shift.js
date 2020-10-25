$(function(){

     // $('#submit').prop('disabled', true);

// $('select[name="work_type_id"]').each(function() {
// 	if ($(this).val() == 0) {
// 		$('#submit').prop('disabled', true);
// 	return false;
// 	}
// });
// $('select[name="work_type_id"]').each(function() {
//      var apply = $(this).attr('id');
// 	if (apply == true) {
// 		$('#submit').prop('disabled', false);
// 	return true;
// 	}
// });

	
     
     //ステータス（status_descriptions_id)が1もしくは3ならば、承認中なので入力ができない。
     //ステータス（status_descriptions_id)が２もしくは空欄ならば、入力が可能。
     
     var status = $('input[name="status_descriptions_id"]').val();
          switch(status){
               case '1':
               alert('現在申請中です');
               break;
               case '2':
               alert('管理者より差し戻しがされています');
               break;
               case '3':
               alert('承認が完了しました。編集が必要な場合は管理者へ問い合わせください');     
               $('select, input[name="comments"]').prop('disabled', true);
               break;
          }
          
          
     
    var column = '';
    var value = '';
    var date = '';
    var data = '';
    var id = '';
    
    //何かの項目に対して変更が加えられたら
   $('select, input').on('change', function(){
     //オプションのセレクトがどの項目（勤務形態〜コメント）かを判断するために取得
         column = $(this).attr('name');
     //選択した値（例：勤務形態ならwork_type_idの値、開始時間なら9:00:00など）
         value = $(this).val();
     //項目がどの年月日の情報に対してかを特定するためにdata-date(年月日）取得
         date = $(this).data('date'); 
      //すでにDBにテーブルが存在する勤怠レコードへ記入があった場合はstore処理でIDを特定するために取得
         if($(this).data('id') != undefined){
              id = $(this).data('id');

              data = {
               "user_id": $(document).find('input[name="user_id"]').val(),
               "column": column,
               "values": value,
               "date": date,
               "id": id
              }
     //該当するレコードが存在しない場合は、idは取得できず、store処理後に新たにIDが付与される。  
         }else{
          data = {
               "user_id": $(document).find('input[name="user_id"]').val(),
               "column": column,
               "values": value,
               "date": date
           } 
          }
          var error_w = $('select[data-date="' + date + '"][name="work_type_id"]').val();
          var error_s = $('select[data-date="' + date + '"][name="start_time"]').val();
          var error_e = $('select[data-date="' + date + '"][name="end_time"]').val();
          var error_r = $('select[data-date="' + date + '"][name="rest_time"]').val();
          var error_t = $('select[data-date="' + date + '"][name="total"]').val();
          
          //ユーザーが入力した値が出勤形態だった場合、想定できるパターンは、
               //・すでに総勤務時間が入力されていおり、かつその値が0以上になっている場合、
          if($(this).attr('name') == 'work_type_id'){
               
               if(value == 2 || value == 3){
                    if(error_t != '00:00:00'){
                         alert('有給・欠勤は総勤務時間が0です、どちらかを変更してください');
                         return false;
                         
                    }
               }else if(value == 4){
                    if(error_t > '08:00:00'){
                         alert('早退の勤務時間は8時間以内です');
                         return false;
                         
                    }
               }
          }
          if($(this).attr('name') == 'start_time'){
               if(error_t == 2 || error_t == 3){
                    if(value != '0'){
                         alert('有給・半休の選択がされています。有給・半休は出勤・退勤・休憩・総勤務時間は0時間です');
                         return false;
                        
                    }
               }
          }
          if($(this).attr('name') == 'end_time'){
               if(error_t == 2 || error_t == 3){
                    if(value != '0'){
                         alert('有給・半休の選択がされています。有給・半休は出勤・退勤・休憩・総勤務時間は0時間です');
                         return false;
                        
                    }
               }
          }
          if($(this).attr('name') == 'rest_time'){
               if(error_t == 2 || error_t == 3){
                    if(value != '0'){
                         alert('有給・半休の選択がされています。有給・半休は出勤・退勤・休憩・総勤務時間は0時間です');
                         return false;
                        
                    }
               }
          }
          //ユーザーが入力した値が総勤務時間（total）であった場合、その状況で想定できるパターンは、
               //・全ての項目を選択した後に入力する
               //・全ての項目がvalue="0"の時に、入力する
               //・虫食いに入力されている途中で入力する
          if($(this).attr('name') === 'total'){
          //同年月日の他の項目とのバランスから入力がオペレーションに反していないかチェック             
          //勤務形態が出勤の場合、最低実働時間は8時間。それ以下の場合はエラーを出してajax通信を止める。
               if(error_w == 1){
                    if(value == '1:00:00' || value == '2:00:00' || value == '3:00:00' || value == '4:00:00' || value == '5:00:00' || value == '6:00:00' || value == '7:00:00'){
                    // if(value < '08:00:00'){
                         alert('実働は8時間以上が必要です。');
                         return false;
                         
                    }
          //勤務形態が有給の場合、休憩時間は0の必要がある     
               }else if(error_w == 2){
                    if(value != '00:00:00'){
                         alert('有給を選択した場合は、出勤・退勤・休憩時間は入力ができません');
                         return false;   
                         
                    }
                    //勤務形態が欠勤の場合、開始・終了・休憩時間は0の必要がある
               }else if(error_w == 3){
                    if(error_s != 0 && error_e != 0 && error_r != 0){
                         alert('欠勤を選択した場合は、出勤・退勤・休憩時間は入力ができません');
                         return false;
                         
                    }
               }
         }

     $.ajax({
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/user/shifts/index/store',
        dataType: 'json',
        cache: false,
        data: JSON.stringify(data),
        context:this
        }).done(function(data){
          $(this).attr('data-id', data);
          location.reload();

        });
      })
     $('#submit').on('click', function(){
          
          var data = {
               "date": $(document).find('#first_day').val() 
          }
 
          $.ajax({
               headers: {
                   'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               type: 'post',
               url: '/user/shifts/index/store/monthly',
               dataType: 'json',
               cache: false,
               data: JSON.stringify(data),
               context:this
               }).done(function(data){
                 alert('申請完了');
                 $('#submit').prop('disabled', true);

                 location.reload();
               });
     });

    // $('#submit').on('click',function(){
      
    //     var type = $("#type").val();
    //     var start = $("#start").val();
    //     var end = $("#end").val();
    //     var rest = $("#rest").val();
    //     var total = $("#total").val();
    
    //     (type == '')?alert("勤務形態が未入力です"):true;
    //     (start == '')?alert("勤務開始時刻が未入力です"):true;
    //     (end == '')?alert("退勤時刻が未入力です"):true;
    //     (rest == '')?alert("休憩時間が未入力です"):true;
    //     (type.length != 2)?alert("漢字２文字で記入"):true;
    //     (start.match(/^\d{1,2}\:\d{2}$/))?true:alert('勤務時間は時刻形式で記入');
    //     (end.match(/^\d{1,2}\:\d{2}$/))?true:alert('退勤時間は時刻形式で記入');
    //     (rest.match(/^\d{1,2}\:\d{2}$/))?true:alert('休憩時間は時刻形式で記入');
    // });
    
    });