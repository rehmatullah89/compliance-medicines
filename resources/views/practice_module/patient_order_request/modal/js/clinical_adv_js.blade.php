<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script type="text/javascript"> 



    function check_validate(value)

    {

        if(value==''){ $('#clinical-Modal #banner_error_msg_title').show(); }

        else{ $('#clinical-Modal #banner_error_msg_title').hide(); }

            

    }

        function popup_fun(id=false){

            

            

            

        if(id==false){ $('#clinical-Modal #submitOrder').text('ADD'); }else{ $('#clinical-Modal #submitOrder').text('UPDATE'); }        

            

            

           // $('#clinical-Modal').modal('show');

        }

        

    $('#clinical-Modal').on('show.bs.modal', function (e) {

        $('#order_edit_Modal').addClass('v-hidden-opacity');

        $('#clinical_form2 input[name="temp_id"]').remove();

        var button = e.relatedTarget;

        console.log(button);

        var id = false;

        if($(button).attr('is-edit')){ 

            //console.log($(button).attr('dat-title'));

            $('#clinical-Modal #clinical_message').val($(button).attr('dat-title'));

            $('#clinical-Modal .image-upload-wrap').hide();

            $('#clinical-Modal .file-upload-image').attr('src', $(button).attr('file-src'));

            $('#clinical-Modal .file-upload-content').show();

            if($(button).attr('data-edit'))

            {

                id = $(button).attr('data-edit'); 

                $('#clinical-Modal #form_raw_data').append('<input type="hidden" name="temp_id"  value="'+id+'" />');

            }

           // $('.image-title').html($(button).attr('dat-title'));

          

          

        }else{

            

            $('#clinical-Modal .file-upload-input').replaceWith($('#clinical-Modal .file-upload-input').clone());

            $('#clinical-Modal .file-upload-input').val('');

            $('#clinical-Modal .file-upload-content').hide();

            $('#clinical-Modal .image-upload-wrap').show();

            $('#clinical-Modal input[name="temp_id"]').remove();

            

        }

    //    $('#clinical-Modal #form_raw_data').append('<input type="hidden" name="index_count"  value="'+$(button).attr('index-count')+'" />');

        popup_fun(id);

    });

    

    

    $("#clinical-Modal").on('hide.bs.modal', function(){

       // console.log('hide call');

      $('#clinical-Modal #form_raw_data').html('');

      $('#clinical-Modal #banner_title_name').val('');

      $('#clinical-Modal #uploaded_image').attr('src', '#');

      removeUpload();

    });

    

    $("#clinical-Modal").on('hidden.bs.modal', function(){

       // console.log('hide call');

       $('#order_edit_Modal').removeClass('v-hidden-opacity');

        $('#clinical-Modal #form_raw_data').html('');

        $('#clinical-Modal #banner_title_name').val('');

        $('#clinical-Modal #uploaded_image').attr('src', '#');

        removeUpload();

    });

    



    function submit_form()

    {

      if($('#clinical-Modal #uploaded_image').html() == '')

    {

        $('#clinical-Modal #error_msg_show').html('This field is required.').show();

        return false;

    }else{

      $('#clinical-Modal #error_msg_show').hide();

    }

    $('.file-upload-btn,.remove-image').hide();

    $('#loading_small').show();

        var formData = new FormData($('form#clinical_form2')[0]);

        $('#submitOrder').prop(':disbaled', true);

        $('#loading_small_login').show();

        $.ajax({

            url:"{{ url('clinical-addupdate') }}",

            data: formData,// the formData function is available in almost all new browsers.

            type:"POST",

            cache: false,

            contentType: false,

            processData: false,

            error:function(err){

                console.error(err);

                $('#submitOrder').prop(':disbaled', false);

                $('#loading_small_login').hide();

            },

            success:function(data){

            //    $('#clinical-Modal').modal('hide');

            if(data.status){

              toastr.success(data.message);

                removeUpload();

            }else{

              toastr.error(data.message);

            }

               

            },

            complete:function(){

                console.log("Request finished.");

                $('#submitOrder').prop(':disbaled', false);

                $('.file-upload-btn,.remove-image').show();

                 $('#loading_small').hide();

            }

        });

        

    }







    $('#patientMessage').on('show.bs.modal', function (e) {

        $('#order_edit_Modal').addClass('v-hidden-opacity');

        var button = e.Target;

        console.log(button);

    });

    

    

    $("#patientMessage").on('hidden.bs.modal', function(){

       // console.log('hide call');

       $('#order_edit_Modal').removeClass('v-hidden-opacity');

      $('#patientMessage #orderMessage').val('');



    });

    





function GetFormattedDate() {
    var todayTime = new Date();
    var month = todayTime.getMonth() + 1;
    var day = todayTime.getDate();
    var year = todayTime.getFullYear();
   var  hour = todayTime.getHours();
       var  minute = todayTime.getMinutes();
       var  second = todayTime.getSeconds();
    return month + "/" + day + "/" + year +' '+hour+':'+minute+':'+second;
}


    

    function readURL(input) {

        // debugger;

        var $preview =  $('#clinical-Modal .file-upload-image');

        console.log(input);

        console.log(input.files);

       var _URL = window.URL || window.webkitURL;

      if (input.files && input.files[0]) {

    if(input.files[0].type == "application/pdf"){

        var files = input.files;



  var fileReader = new FileReader();

  console.log('outside on load');

  fileReader.onload = function(e){

      console.log(e);

    $('#clinical-Modal .image-upload-wrap').hide();

                    $('#clinical-Modal .file-upload-image').addClass('fa fa-file-pdf-o').empty().html(files[0].name);

                    $('#clinical-Modal .file-upload-content').show();

      console.log('inside on load');

      $preview.on('click',function(){

          console.log('hit click event');

    //    window.location.href=e.target.result;

      });

    // $preview.attr("href", e.target.result);

    $preview.show();

  };

  fileReader.readAsDataURL(files[0]);


}
else{
   var img = new Image();

            img.onload = function() {

                //alert(this.width + " X " + this.height);

                

                

                var row_ind = $('#clinical-Modal #form_raw_data input[name="index_count"]').val();

  

                 $('#clinical-Modal #error_msg_show').html('').hide();

               // if(this.width==check_width && this.height==check_height){

                    var reader = new FileReader();

    

                    reader.onload = function(e) {

                    $('#clinical-Modal .image-upload-wrap').hide();

                    $('#clinical-Modal .file-upload-image').removeClass('fa fa-file-pdf-o').empty().append('<img style="height:100px;width:100px" src='+e.target.result+'>');

                    $('#clinical-Modal .file-upload-content').show();

                    

                    //$('.image-title').html(input.files[0].name);

                    };

    

                    reader.readAsDataURL(input.files[0]);



                

                

            };

            img.onerror = function() {

                alert( "not a valid file: " + input);

            };

            img.src = _URL.createObjectURL(input.files[0]);
}

//   fileReader.readAsDataURL(files[0]);

    

//         var reader = new FileReader();

//         reader.onload = function() {

//                 //alert(this.width + " X " + this.height);

//   console.log(reader);

//                  $('#clinical-Modal #error_msg_show').html('').hide();

//                // if(this.width==check_width && this.height==check_height){

//                     $('#clinical-Modal .image-upload-wrap').hide();

//                     $('#clinical-Modal .file-upload-image').html(e.target.result);

//                     $('#clinical-Modal .file-upload-content').show();

                    

//                     //$('.image-title').html(input.files[0].name);

    

//                     reader.readAsDataURL(input.files[0]);

                

//             };

//             reader.onerror = function() {

//                 alert( "not a valid file: " + input);

//             };

//             reader.src = _URL.createObjectURL(input.files[0]);

    

    

      } else {

        removeUpload();

      }

    }



  /*  

    function readURLPDF(input) {

        console.log(input);

        console.log(input.files);

       var _URL = window.URL || window.webkitURL;

      if (input.files && input.files[0]) {

    

        if(input.files[0].type == "application/pdf"){

		var fileReader = new FileReader();  

		fileReader.onload = function() {

			var pdfData = new Uint8Array(this.result);

			// Using DocumentInitParameters object to load binary data.

			var loadingTask = pdfjsLib.getDocument({data: pdfData});

			loadingTask.promise.then(function(pdf) {

			  console.log('PDF loaded');

			  

			  // Fetch the first page

			  var pageNumber = 1;

			  pdf.getPage(pageNumber).then(function(page) {

				console.log('Page loaded');

				

				var scale = 1.5;

				var viewport = page.getViewport({scale: scale});



				// Prepare canvas using PDF page dimensions

				var canvas = $("#pdfViewer")[0];

				var context = canvas.getContext('2d');

				canvas.height = viewport.height;

				canvas.width = viewport.width;



				// Render PDF page into canvas context

				var renderContext = {

				  canvasContext: context,

				  viewport: viewport

				};

				var renderTask = page.render(renderContext);

				renderTask.promise.then(function () {

				  console.log('Page rendered');

				});

			  });

			}, function (reason) {

			  // PDF loading error

			  console.error(reason);

			});

		};

		fileReader.readAsArrayBuffer(input.files[0]);

        }

      } else {

        removeUpload();

      }

    }

*/



/*

    

    function readURLImage(input) {

        console.log(input);

        console.log(input.files);

       var _URL = window.URL || window.webkitURL;

      if (input.files && input.files[0]) {

    

    

        var img = new Image();

            img.onload = function() {

                //alert(this.width + " X " + this.height);

                

                

                var row_ind = $('#clinical-Modal #form_raw_data input[name="index_count"]').val();

  

                 $('#clinical-Modal #error_msg_show').html('').hide();

               // if(this.width==check_width && this.height==check_height){

                    var reader = new FileReader();

    

                    reader.onload = function(e) {

                    $('#clinical-Modal .image-upload-wrap').hide();

                    $('#clinical-Modal .file-upload-image').attr('src', e.target.result);

                    $('#clinical-Modal .file-upload-content').show();

                    

                    //$('.image-title').html(input.files[0].name);

                    };

    

                    reader.readAsDataURL(input.files[0]);



                

                

            };

            img.onerror = function() {

                alert( "not a valid file: " + input);

            };

            img.src = _URL.createObjectURL(input.files[0]);

    

    

      } else {

        removeUpload();

      }

    }

    

*/





    function removeUpload() {

      $('#clinical-Modal .file-upload-input').replaceWith($('#clinical-Modal .file-upload-input').clone());

       $('#clinical-Modal .file-upload-input').val('');

      $('#clinical-Modal .file-upload-content').hide();

      $('#clinical-Modal .image-upload-wrap').show();

      $('#clinical-Modal .file-upload-image').html('');

      $('#clinical-Modal .file-upload-image').onclick = '';

    }

    

    

        $('#clinical-Modal .image-upload-wrap').bind('dragover', function () {

                $('#clinical-Modal .image-upload-wrap').addClass('image-dropping');

        });

        $('#clinical-Modal .image-upload-wrap').bind('dragleave', function () {

        $('#clinical-Modal .image-upload-wrap').removeClass('image-dropping');

        });

    

    

    function reset_form()

    {

        

            var id = $('#clinical-Modal #form_raw_data input[name="temp_id"]').val();

           // console.log(id);

            if(id){

                var attr = $('a[data-edit="'+id+'"]');

                console.log($(attr).attr('img-src'));

                $('#clinical-Modal #banner_title_name').val($(attr).attr('dat-title'));            

                $('#clinical-Modal .image-upload-wrap').hide();

                $('#clinical-Modal .file-upload-image').attr('src', $(attr).attr('img-src'));

                $('#clinical-Modal .file-upload-content').show();

            }

            else{

                $('#clinical-Modal #banner_title_name').val('');

                $('#clinical-Modal .file-upload-input').replaceWith($('#clinical-Modal .file-upload-input').clone());

                $('#clinical-Modal .file-upload-content').hide();

                $('#clinical-Modal .image-upload-wrap').show();

                $('#clinical-Modal input[name="temp_id"]').remove();

            }

    }

    


    $('#send_download_link').click(function(){
      $('#send_download_link').prop(':disbaled', true);

     $('#pat_mobile').val();

        $.ajax({

            url:"{{ url('send-message') }}/"+$('#pat_mobile').val(),

           

            type:"get",

            error:function(err){

                console.error(err);

                $('#send_download_link').prop(':disbaled', false);

                $('#loading_small_login').hide();

            },

            success:function(data){

            //    $('#clinical-Modal').modal('hide');

                console.log(data);
                toastr.success('App link has been sent successfully');

            },

            complete:function(){

                console.log("Request finished.");

                $('#sendMessage').prop(':disbaled', false);

            }

        });

      // alert('yes inside');

    });

      

                

                

                

    </script>

    