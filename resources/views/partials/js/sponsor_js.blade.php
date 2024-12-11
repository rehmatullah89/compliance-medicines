<script type="text/javascript"> 
if(localStorage.getItem("imported") =="yes")
{
  $('#spns-tab').click();
  localStorage.removeItem("imported");
}
function check_validate(value)
{
    if(value==''){ $('#sponsors-Modal #banner_error_msg_title').show(); }
    else{ $('#sponsors-Modal #banner_error_msg_title').hide(); }
        
}
    function popup_fun(id=false){
        
        
        
    if(id==false){ $('#sponsors-Modal #submitOrder').text('ADD'); }else{ $('#sponsors-Modal #submitOrder').text('UPDATE'); }        
        
        
       // $('#sponsors-Modal').modal('show');
    }
    
$('#sponsors-Modal').on('show.bs.modal', function (e) {
    $('#sponsors-Modal input[name="temp_id"]').remove();
    var button = e.relatedTarget;
    //console.log(button);
    var id = false;
    if($(button).attr('is-edit')){ 
        //console.log($(button).attr('dat-title'));
        $('#sponsors-Modal #banner_title_name').val($(button).attr('dat-title'));
        $('#sponsors-Modal .image-upload-wrap').hide();
        $('#sponsors-Modal .file-upload-image').attr('src', $(button).attr('img-src'));
        $('#sponsors-Modal .file-upload-content').show();
        if($(button).attr('data-edit'))
        {
            id = $(button).attr('data-edit'); 
            $('#sponsors-Modal #form_raw_data').append('<input type="hidden" name="temp_id"  value="'+id+'" />');
        }
       // $('.image-title').html($(button).attr('dat-title'));
      
      
    }else{
        
        $('#sponsors-Modal .file-upload-input').replaceWith($('#sponsors-Modal .file-upload-input').clone());
        $('#sponsors-Modal .file-upload-input').val('');
        $('#sponsors-Modal .file-upload-content').hide();
        $('#sponsors-Modal .image-upload-wrap').show();
        $('#sponsors-Modal input[name="temp_id"]').remove();
        
    }
    $('#sponsors-Modal #form_raw_data').append('<input type="hidden" name="index_count"  value="'+$(button).attr('index-count')+'" />');
    popup_fun(id);
});


$("#sponsors-Modal").on('hide.bs.modal', function(){
   // console.log('hide call');
  $('#sponsors-Modal #form_raw_data').html('');
  $('#sponsors-Modal #banner_title_name').val('');
  $('#sponsors-Modal #uploaded_image').attr('src', '#');
  removeUpload();
});

$("#sponsors-Modal").on('hidden.bs.modal', function(){
   // console.log('hide call');
    $('#sponsors-Modal #form_raw_data').html('');
    $('#sponsors-Modal #banner_title_name').val('');
    $('#sponsors-Modal #uploaded_image').attr('src', '#');
    removeUpload();
});

$("#sponsors-import-drug").on('hidden.bs.modal', function(){
    $('#sponsors-import-drug .file-upload-content #uploaded_file').html('');
    $('#sponsors-import-drug .file-upload-content').hide();
    $('#sponsors-import-drug .image-upload-wrap').show();
    $('#sponsors-import-drug .file-upload-input').val('');
});


function add_file()
{
    if($('#sponsors-Modal #banner_title_name').val()=='')
    {
        $('#sponsors-Modal #banner_error_msg_title').show();
        return false;
    }
    if($('#sponsors-Modal #uploaded_image').attr('src')=='#' || $('#sponsors-Modal #uploaded_image').attr('src')=='')
    {
        $('#sponsors-Modal #error_msg_show').html('This field is required.').show();
        return false;
    }
    else
    {
       
        $('#sponsors-Modal #banner_error_msg_title').hide();
        $('#sponsors-Modal #error_msg_show').hide();
        
    var id = false;
    var index_count = $('#sponsors-Modal input[name="index_count"]').val();
    var imgUrl = $('#sponsors-Modal #uploaded_image').attr('src');
    
    console.log(index_count);
    console.log($('#login-page-tab a[index-count="'+index_count+'"]').attr('image-type'));
    
    var simplea = "'"+$('#login-page-tab a[index-count="'+index_count+'"]').attr('image-type')+"'"; 
    
    //------- update right menu data and slider
    
    $('#login-page-tab #title_cont-'+index_count).html($('#sponsors-Modal #banner_title_name').val());
    
    //----------end update right menu data and slider
    
  
    // add form input field "id" page id  if edit 
    if($('#sponsors-Modal input[name="temp_id"]').length>0){ 
        
            id = $('#sponsors-Modal input[name="temp_id"]').val(); 
           
            $('form#hidden_form_login input[name="id['+index_count+']"]').remove();
            
            if($('form#hidden_form_login input[name="upload_data['+index_count+'][id]"]').length<=0)
            { 
             $('#hidden_form_login').append('<input type="hidden" name="upload_data['+index_count+'][id]" value="'+id+'" />'); 
            }
            
            
            
            if($('form#hidden_form_login input[name="page_id"]').length<=0)
            { 
                $('#hidden_form_login').append('<input type="hidden" name="page_id" value="'+$('a[data-edit="'+id+'"]').attr('page-id')+'" />'); 
            }  
            
    }
    else{
        
        //inner_btn-
        
        $('#login-page-tab #inner_btn_'+index_count).html('<a href="javascript:void(0);" image-type="'+$('#login-page-tab a[index-count="'+index_count+'"]').attr('image-type')+'" is-edit="1" index-count="'+index_count+'" dat-title="'+$('#sponsors-Modal #banner_title_name').val()+'" img-src="'+imgUrl+'" page-id="1" data-toggle="modal" data-target="#sponsors-Modal"  class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a>'+ 
        '<a href="javascript:delete_row('+index_count+', '+simplea+')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a>');
    
    }
    
   
   if($('form#hidden_form_login input[name="upload_data['+index_count+'][title]"]').length<=0)
    {
        $('#hidden_form_login').append('<input type="hidden" name="upload_data['+index_count+'][title]" value="'+$('#sponsors-Modal #banner_title_name').val()+'" />'); 
        
    }else{
        $('form#hidden_form_login input[name="upload_data['+index_count+'][title]"]').val($('#sponsors-Modal #banner_title_name').val());
    }
    
   $('#login-page-tab a[index-count="'+index_count+'"]').attr('dat-title', $('#sponsors-Modal #banner_title_name').val());
    
    if(imgUrl.toLowerCase().indexOf(";base64,") >= 0)
    {
       // var block = imgUrl.split(";");
       // var contentType = block[0].split(":")[1];
       // var realData = block[1].split(",")[1];
       // var blob = b64toBlob(realData, contentType);
       // console.log(blob);  
       if($('form#hidden_form_login input[name="upload_data['+index_count+'][image]"]').length<=0)
        {
            $('#hidden_form_login').append('<input type="hidden" name="upload_data['+index_count+'][image]" value="'+imgUrl+'" />'); 
        }else{
            $('form#hidden_form_login input[name="upload_data['+index_count+'][image]"]').val(imgUrl);
        }
        $('#login-page-tab a[index-count="'+index_count+'"]').attr('img-src', imgUrl);
               
    }else{
        console.log('not exists');
    }
    
    //$('form#hidden_form_login').submit();
    if(index_count<=4)
    {
        if($('form#hidden_form_login input[name="upload_data['+index_count+'][image_type]"]').length<=0)
        {
            $('#hidden_form_login').append('<input type="hidden" name="upload_data['+index_count+'][image_type]" value="Slider" />');
        }else{
            $('form#hidden_form_login input[name="upload_data['+index_count+'][image_type]"]').val('Slider');
        }
        update_slider();
    }else
    {
       // console.log(id);
      //  console.log(imgUrl);
        var ind_count = $('#form_raw_data input[name="index_count"]').val()
        $('#login-page-tab #simple_id_'+(ind_count-4)).attr('src', imgUrl);
        if($('form#hidden_form_login input[name="upload_data['+index_count+'][image_type]"]').length<=0)
        {
            $('#hidden_form_login').append('<input type="hidden" name="upload_data['+index_count+'][image_type]" value="Simple" />');
        }else{
            $('form#hidden_form_login input[name="upload_data['+index_count+'][image_type]"]').val('Simple');
        }
    }
    $("#sponsors-Modal").modal("hide");
    
    }
    
}



function update_slider()
{
     $('#login-page-tab .carousel-inner').html('');
     $('#login-page-tab .carousel-indicators').html('');
     var vclass = '';
     var vcls = '';
   // console.log($('#slider_data_container a[is-edit="1"]').length);
    $('#login-page-tab #slider_data_container a[is-edit="1"]').each(function(index, value){
       // console.log(index);
        if(index==0){ vclass = 'active'; vcls = 'active'; }else if(index==1){ vclass = 'carousel-item-next'; vcls = ''; }else{ vclass = ''; vcls = ''; }
      $('#login-page-tab .carousel-inner').append('<div id="slide_id_'+$(value).attr('index-count')+'" class="carousel-item '+vclass+'" data-interval="2000">'+
                                        '<span class="item-count">'+$(value).attr('index-count')+'</span> <img class="d-block w-100" src="'+$(value).attr('img-src')+'"> '+ 
                                  '</div>');
                          
                          
       $('#login-page-tab .carousel-indicators').append('<li id="bult_id_'+$(value).attr('index-count')+'" data-target="#sponsor_main2-page-carousel" class="'+vcls+'" data-slide-to="'+index+'"></li>');
    });
    
    
}
function submit_form()
{
    $('#save_btn_login').prop(':disbaled', true);
    $('#loading_small_login').show();
    $.ajax({
        url:"{{ url('sponsor-addupdate') }}",
        data: $('form#hidden_form_login').serialize(),// the formData function is available in almost all new browsers.
        type:"POST",
        error:function(err){
            console.error(err);
            $('#save_btn_login').prop(':disbaled', false);
            $('#loading_small_login').hide();
        },
        success:function(data){
            $('form#hidden_form_login input').each(function(key, val){
                if($(val).attr('name')!='_token' && $(val).attr('name')!='page_id'){ $(val).remove(); }
                
            });
            console.log(data);
            console.log(data.message);
            console.log(data['message']);
            toastr.success(data.message);
            $('#save_btn_login').prop(':disbaled', false);
            $('#loading_small_login').hide();
        },
        complete:function(){
            console.log("Request finished.");
            $('#save_btn_login').prop(':disbaled', false);
        }
    });
    
}

function delete_row(id, type=false)
{
   
    if($('#login-page-tab a[index-count="'+id+'"]').attr('data-edit'))
    {
        $('#hidden_form_login').append('<input type="hidden" name="delete[]" value="'+$('a[index-count="'+id+'"]').attr('data-edit')+'" />'); 
    }
   
    var sl_delete = false;

     var ht_clon = $('#empty_clon').html();
     if(type!='Simple')
     {
        ht_clon = ht_clon.replace(/Replace_Str/g, $('#login-page-tab #row_'+id).attr('tab-val')+')');
    }else{ ht_clon = ht_clon.replace(/Replace_Str/g, '1)'); }
     ht_clon = ht_clon.replace(/rep_index_count/g , $('#login-page-tab #row_'+id).attr('tab-val'));
     ht_clon = ht_clon.replace(/rep_type/g, type); 
     $('#login-page-tab #row_'+id).html(ht_clon);
     console.log($('#login-page-tab a[index-count="'+id+'"]').attr('data-edit'));
    
      
      
    if(id<=4 && type!='Simple')
    {
       $('#login-page-tab #slide_id_'+id).remove();
       $('#login-page-tab #bult_id_'+id).remove();
       update_slider();
       setTimeout(function(){ 
           $("#login-page-tab #sponsor_main2-page-carousel").carousel(0);
       }, 1000);
   }else
   {
       var totle_slider_imgs = 4;
     //  alert(id+"   "+totle_slider_imgs);
       $('#login-page-tab #simple_id_'+(id - totle_slider_imgs) ).attr('src', '#');
   }
   
    $( "#login-page-tab input[name*='upload_data["+id+"]']" ).remove();
    //$('.carousel-inner').find('div.carousel-item').addClass('active');
    
    //rep_type
   // console.log($('#row_'+id).next('span#count_text').html());
   // $('#row_'+id).next('span#count_text').html($('#row_'+id).attr('tab-val')+')');
}


function readURL(input) {
    console.log(input);
   var _URL = window.URL || window.webkitURL;
  if (input.files && input.files[0]) {

var row_ind = $('#sponsors-Modal #form_raw_data input[name="index_count"]').val();
//if($('#login-page-tab #row_'+row_ind).attr('img-width')==this.width && $('#login-page-tab #row_'+row_ind).attr('img-height')==this.height)


    var resize_height = $('#login-page-tab #row_'+row_ind).attr('img-height');
    var resize_width = $('#login-page-tab #row_'+row_ind).attr('img-width');
    var item = input.files[0];

  var reader = new FileReader();

  reader.readAsDataURL(item);
  reader.name = item.name;//get the image's name
  reader.size = item.size; //get the image's size
  reader.onload = function(event) {
    var img = new Image();//create a image
    img.src = event.target.result;//result is base64-encoded Data URI
    img.name = event.target.name;//set name (optional)
    img.size = event.target.size;//set size (optional)
    img.onload = function(el) {
        $('#sponsors-Modal #error_msg_show').html('').hide();
        var elem = document.createElement('canvas');//create a canvas
        //scale the image to 600 (width) and keep aspect ratio
        var scaleFactor = resize_height / el.target.height;
        elem.height = resize_height;
        elem.width = el.target.width * scaleFactor;
        elem.width = resize_width;
        //draw in canvas
        var ctx = elem.getContext('2d');
        ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
        //get the base64-encoded Data URI from the resize image
        var srcEncoded = ctx.canvas.toDataURL(el.target, 'image/jpeg', 0);

        //assign it to thumb src
        //document.querySelector('#image').src = srcEncoded;
      
        $('#sponsors-Modal .image-upload-wrap').hide();
        $('#sponsors-Modal .file-upload-image').attr('src', srcEncoded);
        $('#sponsors-Modal .file-upload-content').show();

      /*Now you can send "srcEncoded" to the server and
      convert it to a png o jpg. Also can send
      "el.target.name" that is the file's name.*/

    };
    img.onerror = function() {
        alert( "not a valid file: " + file.type);
    };
    img.src = _URL.createObjectURL(input.files[0]);
  
  };
  

  } else {
    removeUpload();
  }
}



function readURL__old(input) {
    console.log(input);
   var _URL = window.URL || window.webkitURL;
  if (input.files && input.files[0]) {


    var img = new Image();
        img.onload = function() {
            //alert(this.width + " X " + this.height);
            
            
            var row_ind = $('#sponsors-Modal #form_raw_data input[name="index_count"]').val();
           
            if($('#login-page-tab #row_'+row_ind).attr('img-width')==this.width && $('#login-page-tab #row_'+row_ind).attr('img-height')==this.height)
            {
             $('#sponsors-Modal #error_msg_show').html('').hide();
           // if(this.width==check_width && this.height==check_height){
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#sponsors-Modal .image-upload-wrap').hide();
                $('#sponsors-Modal .file-upload-image').attr('src', e.target.result);
                $('#sponsors-Modal .file-upload-content').show();
                
                //$('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);
            }else
            {
                $('#sponsors-Modal #error_msg_show').html('Image should be '+$('#login-page-tab #row_'+row_ind).attr('img-width')+'x'+$('#login-page-tab #row_'+row_ind).attr('img-height')+' pixels');
                toastr.error('Error', 'Image should be '+$('#login-page-tab #row_'+row_ind).attr('img-width')+'x'+$('#login-page-tab #row_'+row_ind).attr('img-height')+' pixels');
            }
          //  }
            
            
        };
        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(input.files[0]);


  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('#sponsors-Modal .file-upload-input').replaceWith($('#sponsors-Modal .file-upload-input').clone());
   $('#sponsors-Modal .file-upload-input').val('');
  $('#sponsors-Modal .file-upload-content').hide();
  $('#sponsors-Modal .image-upload-wrap').show();
}


    $('#sponsors-Modal .image-upload-wrap').bind('dragover', function () {
            $('#sponsors-Modal .image-upload-wrap').addClass('image-dropping');
    });
    $('#sponsors-Modal .image-upload-wrap').bind('dragleave', function () {
    $('#sponsors-Modal .image-upload-wrap').removeClass('image-dropping');
    });


function reset_form()
{
    
        var id = $('#sponsors-Modal #form_raw_data input[name="temp_id"]').val();
       // console.log(id);
        if(id){
            var attr = $('a[data-edit="'+id+'"]');
            console.log($(attr).attr('img-src'));
            $('#sponsors-Modal #banner_title_name').val($(attr).attr('dat-title'));            
            $('#sponsors-Modal .image-upload-wrap').hide();
            $('#sponsors-Modal .file-upload-image').attr('src', $(attr).attr('img-src'));
            $('#sponsors-Modal .file-upload-content').show();
        }
        else{
            $('#sponsors-Modal #banner_title_name').val('');
            $('#sponsors-Modal .file-upload-input').replaceWith($('#sponsors-Modal .file-upload-input').clone());
            $('#sponsors-Modal .file-upload-content').hide();
            $('#sponsors-Modal .image-upload-wrap').show();
            $('#sponsors-Modal input[name="temp_id"]').remove();
        }
}




function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

  var blob = new Blob(byteArrays, {type: contentType});
  return blob;
}
    function readURL_drug(input) {

        // debugger;

        var $preview =  $('#sponsors-import-drug .file-upload-image');

        console.log(input);

        console.log(input.files);

       var _URL = window.URL || window.webkitURL;

      if (input.files && input.files[0]) {
        var _validFileExtensions = ["xls", "xlsx"];
        var ext=input.files[0].name.split('.').pop();
        if(_validFileExtensions.includes(ext.toLowerCase()))
        {

        

          var files = input.files;

          var fileReader = new FileReader();

          console.log('outside on load');

          fileReader.onload = function(e){

              console.log(e);

            $('#sponsors-import-drug .image-upload-wrap').hide();

                            $('#sponsors-import-drug .file-upload-image').html(files[0].name);

                            $('#sponsors-import-drug .file-upload-content').show();

              console.log('inside on load');

              $preview.on('click',function(){

                  console.log('hit click event');

            //    window.location.href=e.target.result;

              });

            // $preview.attr("href", e.target.result);

            $preview.show();

          };

          fileReader.readAsDataURL(files[0]);


    }else{
      toastr.error("Only xls and xlsx is allowed");
    }

    

      } 
      else {

        // removeUpload();

      }

    }           
    
    function import_drug()

    {

      if($('#sponsors-import-drug #uploaded_file').html() == '')

    {

        $('#clinical-Modal #error_msg_show').html('This field is required.').show();

        return false;

    }else{

      $('#clinical-Modal #error_msg_show').hide();

    }

    $('.file-upload-btn,.remove-image').hide();

    // $('#loading_small').show();
// console.log($('#file-import-btn')[0].files[0]);
        var formData = new FormData($('form#drug_import_form')[0]);

        $('#submitOrder2').prop('disabled', true);

        // $('#loading_small_login').show();

        $.ajax({

            url:"{{ url('import/drug') }}",

            data: formData,// the formData function is available in almost all new browsers.

            type:"POST",

            cache: false,

            contentType: false,

            processData: false,

            error:function(err){

                console.error(err);

                $('#submitOrder2').prop('disabled', false);

                $('#loading_small_login').hide();

            },

            success:function(data){

            //    $('#clinical-Modal').modal('hide');

            if(data.status){

              toastr.success(data.message);

                // removeUpload();
                setTimeout(function(){
                
                localStorage.setItem("imported", "yes");
                location.reload();
            }, 2000);

            }else{
              var str='';
             $.each(data.error,function(k,value){
                
                var keys=Object.keys(value);
                
                keys.forEach(function(key){
                  
                  value[key].forEach(function(v){
                    console.log(v)
                    str+=v+ '<br />'
                  })
                  
                })
                // for(var temp in value)
                // {
                //   console.log(value[temp][0]);
                // }
              });
              
              toastr.error(str);

            }

               

            },

            complete:function(){

                console.log("Request finished.");

                $('#submitOrder2').prop('disabled', false);

                $('.file-upload-btn,.remove-image').show();


                 // $('#loading_small').hide();

            }

        });

        

    }        
            
            
</script>
