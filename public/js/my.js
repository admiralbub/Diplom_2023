$( document ).ready(function() {
	$('#example').DataTable();


	$("#send_donation").on('click',function(){
    	var amount = $('#amount').val();
        var user_id = $('#user_id').val();
        var project_id = $('#project_id').val();
        var csrf =  $('input[name="_token"]').attr('value');
        if(amount=="") {
            $(".error_block").html("<p>You have not filled in the fields</p>");
            $(".error_block").show();
            $(".t-form__successbox").hide();
               return false;
        }

        $.ajax({
            url: '/add_donation',
            method: 'post',
            dataType: 'json',
            data: {
            	_token: csrf,
                amount: amount,
                user_id:user_id,
                project_id:project_id,
            },
            success: function(data){
               if(data.check==2) {
                    $(".error_block").html("<p>An error occurred, sorry for the inconvenience</p>");
                    $(".error_block").show();
                    $(".t-form__successbox").hide();
                    return false;
               }
               if(data.check==1) {
                    $(".error_block").html("<p>Connection timeout</p>");
                    $(".error_block").show();
                    $(".t-form__successbox").hide();
                    return false;
               }
               if(data.check==3) {
                    $(".error_block").html("<p>An unknown error occurred</p>");
                    $(".error_block").show();
                    $(".t-form__successbox").hide();
                    return false;
               }
               if(data.check==0) {
                    window.location.href = data.redirect_url;
                    return false;
               }
               

              
            }
        });
	});
});




