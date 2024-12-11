<script type="text/javascript"> 

function check_validate_enrol(value)
{
    if(value==''){ $('#sponsors-Modal_enrol #banner_error_msg_title').show(); }
    else{ $('#sponsors-Modal_enrol #banner_error_msg_title').hide(); }
        
}
    function popup_fun_enrol(id=false){
        
        
        
    if(id==false){ $('#sponsors-Modal_enrol #submitOrder').text('ADD'); }else{ $('#sponsors-Modal_enrol #submitOrder').text('UPDATE'); }        
        
        
       // $('#sponsors-Modal').modal('show');
    }
    
$('#sponsors-Modal_enrol').on('show.bs.modal', function (e) {
    $('#sponsors-Modal_enrol input[name="temp_id"]').remove();
    var button = e.relatedTarget;
    //console.log(button);
    var id = false;
    if($(button).attr('is-edit')){ 
        //console.log($(button).attr('dat-title'));
        $('#sponsors-Modal_enrol #banner_title_name').val($(button).attr('dat-title'));
        $('#sponsors-Modal_enrol .image-upload-wrap').hide();
        $('#sponsors-Modal_enrol .file-upload-image').attr('src', $(button).attr('img-src'));
        $('#sponsors-Modal_enrol .file-upload-content').show();
        if($(button).attr('data-edit'))
        {
            id = $(button).attr('data-edit'); 
            $('#sponsors-Modal_enrol #form_raw_data').append('<input type="hidden" name="temp_id"  value="'+id+'" />');
        }
       // $('.image-title').html($(button).attr('dat-title'));
    }else{
        
        $('#sponsors-Modal_enrol .file-upload-input').replaceWith($('#sponsors-Modal_enrol .file-upload-input').clone());
         $('#sponsors-Modal_enrol .file-upload-input').val('');
        $('#sponsors-Modal_enrol .file-upload-content').hide();
        $('#sponsors-Modal_enrol .image-upload-wrap').show();
        $('#sponsors-Modal_enrol input[name="temp_id"]').remove();
        
    }
    $('#sponsors-Modal_enrol #form_raw_data').append('<input type="hidden" name="index_count"  value="'+$(button).attr('index-count')+'" />');
    popup_fun_enrol(id);
});


$("#sponsors-Modal_enrol").on('hide.bs.modal', function(){
   // console.log('hide call');
  $('#sponsors-Modal_enrol #form_raw_data').html('');
  $('#sponsors-Modal_enrol #banner_title_name').val('');
  $('#sponsors-Modal_enrol #uploaded_image').attr('src', '#');
  removeUpload_enrol();
});

$("#sponsors-Modal_enrol").on('hidden.bs.modal', function(){
   // console.log('hide call');
    $('#sponsors-Modal_enrol #form_raw_data').html('');
    $('#sponsors-Modal_enrol #banner_title_name').val('');
    $('#sponsors-Modal_enrol #uploaded_image').attr('src', '#');
    removeUpload_enrol();
});


function add_file_enrol()
{
    if($('#sponsors-Modal_enrol #banner_title_name').val()=='')
    {
        $('#sponsors-Modal_enrol #banner_error_msg_title').show();
        return false;
    }
    if($('#sponsors-Modal_enrol #uploaded_image').attr('src')=='#' || $('#sponsors-Modal_enrol #uploaded_image').attr('src')=='')
    {
        $('#sponsors-Modal_enrol #error_msg_show').html('This field is required.').show();
        return false;
    }
    else
    {
       
        $('#sponsors-Modal_enrol #banner_error_msg_title').hide();
        $('#sponsors-Modal_enrol #error_msg_show').hide();
        
    var id = false;
    var index_count = $('#sponsors-Modal_enrol input[name="index_count"]').val();
    var imgUrl = $('#sponsors-Modal_enrol #uploaded_image').attr('src');
    
    console.log(index_count);
    console.log($('#enroll-search-tab a[index-count="'+index_count+'"]').attr('image-type'));
    
    var simplea = "'"+$('#enroll-search-tab a[index-count="'+index_count+'"]').attr('image-type')+"'"; 
    
    //------- update right menu data and slider
    
    $('#enroll-search-tab #title_cont-'+index_count).html($('#sponsors-Modal_enrol #banner_title_name').val());
    
    //----------end update right menu data and slider    
  
    // add form input field "id" page id  if edit 
    if($('#sponsors-Modal_enrol input[name="temp_id"]').length>0){ 

        id = $('#sponsors-Modal_enrol input[name="temp_id"]').val(); 

        $('form#hidden_form_enrol input[name="id['+index_count+']"]').remove();

        if($('form#hidden_form_enrol input[name="upload_data['+index_count+'][id]"]').length<=0)
           { 
                $('#hidden_form_enrol').append('<input type="hidden" name="upload_data['+index_count+'][id]" value="'+id+'" />'); 
           }
        
        if($('form#hidden_form_enrol input[name="page_id"]').length<=0)
        { 
            $('#hidden_form_enrol').append('<input type="hidden" name="page_id" value="'+$('a[data-edit="'+id+'"]').attr('page-id')+'" />'); 
        }            
            
    }
    else{        
        //inner_btn-
        $('#enroll-search-tab #inner_btn_'+index_count).html('<a href="javascript:void(0);" image-type="'+$('#enroll-search-tab a[index-count="'+index_count+'"]').attr('image-type')+'" is-edit="1" index-count="'+index_count+'" dat-title="'+$('#sponsors-Modal_enrol #banner_title_name').val()+'" img-src="'+imgUrl+'" page-id="2" data-toggle="modal" data-target="#sponsors-Modal_enrol"  class="mr-3_ hover-black-child_"><span class="fa fa-pencil fs-17_ txt-blue"></span></a>'+ 
        '<a href="javascript:delete_row_enrol('+index_count+', '+simplea+')" class="ml-3_ hover-black-child_"><span class="fs-17_ txt-red fa fa-trash-o"></span></a>');    
    }
    
   
        
        if($('form#hidden_form_enrol input[name="upload_data['+index_count+'][title]"]').length<=0)
        {
            $('#hidden_form_enrol').append('<input type="hidden" name="upload_data['+index_count+'][title]" value="'+$('#sponsors-Modal_enrol #banner_title_name').val()+'" />'); 

        }else{
            $('form#hidden_form_enrol input[name="upload_data['+index_count+'][title]"]').val($('#sponsors-Modal_enrol #banner_title_name').val());
        }
        $('#enroll-search-tab a[index-count="'+index_count+'"]').attr('dat-title', $('#sponsors-Modal_enrol #banner_title_name').val());
  
    
    
//   /$('#hidden_form_enrol').append('<input type="hidden" name="upload_data['+index_count+'][title]" value="'+$('#sponsors-Modal_enrol #banner_title_name').val()+'" />'); 
    
    
    if(imgUrl.toLowerCase().indexOf(";base64,") >= 0)
    {
       // var block = imgUrl.split(";");
       // var contentType = block[0].split(":")[1];
       // var realData = block[1].split(",")[1];
       // var blob = b64toBlob(realData, contentType);
       // console.log(blob);  
        
        if($('form#hidden_form_enrol input[name="upload_data['+index_count+'][image]"]').length<=0)
        {
            $('#hidden_form_enrol').append('<input type="hidden" name="upload_data['+index_count+'][image]" value="'+imgUrl+'" />'); 
        }else{
            $('form#hidden_form_enrol input[name="upload_data['+index_count+'][image]"]').val(imgUrl);
        }
        
        
        $('#enroll-search-tab a[index-count="'+index_count+'"]').attr('img-src', imgUrl);
               
    }else{
        console.log('not exists');
    }
    
    //$('form#hidden_form_login').submit();
    if(index_count<=4)
    {
         if($('form#hidden_form_enrol input[name="upload_data['+index_count+'][image_type]"]').length<=0)
        {
            $('#hidden_form_enrol').append('<input type="hidden" name="upload_data['+index_count+'][image_type]" value="Slider" />');
        }else{
            $('form#hidden_form_enrol input[name="upload_data['+index_count+'][image_type]"]').val('Slider');
        }
        update_slider_enrol();
    }else
    {
       // console.log(id);
      //  console.log(imgUrl);
        var ind_count = $('#sponsors-Modal_enrol #form_raw_data input[name="index_count"]').val()
        $('#enroll-search-tab #simple_id_'+(ind_count-4)).attr('src', imgUrl);
        
        if($('form#hidden_form_enrol input[name="upload_data['+index_count+'][image_type]"]').length<=0)
        {
            $('#hidden_form_enrol').append('<input type="hidden" name="upload_data['+index_count+'][image_type]" value="Simple" />');
        }else{
            $('form#hidden_form_enrol input[name="upload_data['+index_count+'][image_type]"]').val('Simple');
        }
    }
    $("#sponsors-Modal_enrol").modal("hide");
    
    }
    
}



function update_slider_enrol()
{
     $('#enroll-search-tab .carousel-inner').html('');
     $('#enroll-search-tab .carousel-indicators').html('');
     var vclass = '';
     var vcls = '';
   // console.log($('#slider_data_container a[is-edit="1"]').length);
    $('#enroll-search-tab #slider_data_container a[is-edit="1"]').each(function(index, value){
       // console.log(index);
        if(index==0){ vclass = 'active'; vcls = 'active'; }else if(index==1){ vclass = 'carousel-item-next'; vcls = ''; }else{ vclass = ''; vcls = ''; }
      $('#enroll-search-tab .carousel-inner').append('<div id="slide_id_'+$(value).attr('index-count')+'" class="carousel-item '+vclass+'" data-interval="2000">'+
                                        '<span class="item-count">'+$(value).attr('index-count')+'</span> <img class="d-block w-100" src="'+$(value).attr('img-src')+'"> '+ 
                                  '</div>');
                          
                          
       $('#enroll-search-tab .carousel-indicators').append('<li id="bult_id_'+$(value).attr('index-count')+'" data-target="#sponsor_main2-page-carousel" class="'+vcls+'" data-slide-to="'+index+'"></li>');
    });
    
    
}
function submit_form_enrol()
{
    $('#save_btn_enrol').prop(':disbaled', true);
    $('#loading_small_enrol').show();
    $.ajax({
        url:"{{ url('sponsor-addupdate') }}",
        data: $('form#hidden_form_enrol').serialize(),// the formData function is available in almost all new browsers.
        type:"POST",
        error:function(err){
            console.error(err);
            $('#save_btn_enrol').prop(':disbaled', false);
            $('#loading_small_enrol').hide();
        },
        success:function(data){
            $('form#hidden_form_enrol input').each(function(key, val){
                if($(val).attr('name')!='_token' && $(val).attr('name')!='page_id'){ $(val).remove(); }
                
            });
            toastr.success(data.message);
            $('#save_btn_enrol').prop(':disbaled', false);
            $('#loading_small_enrol').hide();
        },
        complete:function(){
            console.log("Request finished.");
            $('#save_btn_enrol').prop(':disbaled', false);
        }
    });
    
}

function delete_row_enrol(id, type=false)
{
   
    if($('#enroll-search-tab a[index-count="'+id+'"]').attr('data-edit'))
    {
        $('#hidden_form_enrol').append('<input type="hidden" name="delete[]" value="'+$('#enroll-search-tab a[index-count="'+id+'"]').attr('data-edit')+'" />'); 
    }
   
    var sl_delete = false;

     var ht_clon = $('#empty_clon_enrol').html();
     if(type!='Simple')
     {
        ht_clon = ht_clon.replace(/Replace_Str/g, $('#enroll-search-tab #row_'+id).attr('tab-val')+')');
    }else{ ht_clon = ht_clon.replace(/Replace_Str/g, '1)'); }
     ht_clon = ht_clon.replace(/rep_index_count/g , $('#enroll-search-tab #row_'+id).attr('tab-val'));
     ht_clon = ht_clon.replace(/rep_type/g, type); 
     $('#enroll-search-tab #row_'+id).html(ht_clon);
     console.log($('#enroll-search-tab a[index-count="'+id+'"]').attr('data-edit'));
    
      
      
    if(id<=4 && type!='Simple')
    {
       $('#enroll-search-tab #slide_id_'+id).remove();
       $('#enroll-search-tab #bult_id_'+id).remove();
       update_slider();
       setTimeout(function(){ 
           $("#enroll-search-tab #sponsor_main2-page-carousel").carousel(0);
       }, 1000);
   }else
   {
       var totle_slider_imgs = 4;
     //  alert(id+"   "+totle_slider_imgs);
       $('#enroll-search-tab #simple_id_'+(id - totle_slider_imgs) ).attr('src', '#');
   }
   
    $( "#enroll-search-tab input[name*='upload_data["+id+"]']" ).remove();
    //$('.carousel-inner').find('div.carousel-item').addClass('active');
    
    //rep_type
   // console.log($('#row_'+id).next('span#count_text').html());
   // $('#row_'+id).next('span#count_text').html($('#row_'+id).attr('tab-val')+')');
}



function readURL_enrol(input) {
    console.log(input);
   var _URL = window.URL || window.webkitURL;
  if (input.files && input.files[0]) {

var row_ind = $('#sponsors-Modal_enrol #form_raw_data input[name="index_count"]').val();
//if($('#login-page-tab #row_'+row_ind).attr('img-width')==this.width && $('#login-page-tab #row_'+row_ind).attr('img-height')==this.height)


    var resize_height = $('#enroll-search-tab #row_'+row_ind).attr('img-height');
    var resize_width = $('#enroll-search-tab #row_'+row_ind).attr('img-width');
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
        $('#sponsors-Modal_enrol #error_msg_show').html('').hide();
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
      
        $('#sponsors-Modal_enrol .image-upload-wrap').hide();
        $('#sponsors-Modal_enrol .file-upload-image').attr('src', srcEncoded);
        $('#sponsors-Modal_enrol .file-upload-content').show();

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

function readURL_enrol__old(input) {
    console.log(input);
   var _URL = window.URL || window.webkitURL;
  if (input.files && input.files[0]) {


    var img = new Image();
        img.onload = function() {
           // alert(this.width + " X " + this.height);
            
            var row_ind = $('#sponsors-Modal_enrol #form_raw_data input[name="index_count"]').val();
            
            if($('#enroll-search-tab #row_'+row_ind).attr('img-width')==this.width && $('#enroll-search-tab #row_'+row_ind).attr('img-height')==this.height)
            {
             $('#sponsors-Modal_enrol #error_msg_show').html('').hide();
           // if(this.width==check_width && this.height==check_height){
           console.log('read working');
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#sponsors-Modal_enrol .image-upload-wrap').hide();
                $('#sponsors-Modal_enrol .file-upload-image').attr('src', e.target.result);
                $('#sponsors-Modal_enrol .file-upload-content').show();
                
                //$('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);
            }else
            {
                $('#sponsors-Modal_enrol #error_msg_show').html('Image should be '+$('#enroll-search-tab #row_'+row_ind).attr('img-width')+'x'+$('#enroll-search-tab #row_'+row_ind).attr('img-height')+' pixels');
                toastr.error('Error', 'Image should be '+$('#enroll-search-tab #row_'+row_ind).attr('img-width')+'x'+$('#enroll-search-tab #row_'+row_ind).attr('img-height')+' pixels');
            }
          //  }
            
            
        };
        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(input.files[0]);


  } else {
    removeUpload_enrol();
  }
}

function removeUpload_enrol() {
  $('#sponsors-Modal_enrol .file-upload-input').replaceWith($('#sponsors-Modal_enrol .file-upload-input').clone());
  $('#sponsors-Modal_enrol .file-upload-input').val('');
  $('#sponsors-Modal_enrol .file-upload-content').hide();
  $('#sponsors-Modal_enrol .image-upload-wrap').show();
}
        $('#sponsors-Modal_enrol .image-upload-wrap').bind('dragover', function () {
		$('#sponsors-Modal_enrol .image-upload-wrap').addClass('image-dropping');
	});
	$('#sponsors-Modal_enrol .image-upload-wrap').bind('dragleave', function () {
	$('#sponsors-Modal_enrol .image-upload-wrap').removeClass('image-dropping');
});


function reset_form_enrol()
{
    
        var id = $('#sponsors-Modal_enrol #form_raw_data input[name="temp_id"]').val();
       // console.log(id);
        if(id){
            var attr = $('a[data-edit="'+id+'"]');
            console.log($(attr).attr('img-src'));
            $('#sponsors-Modal_enrol #banner_title_name').val($(attr).attr('dat-title'));            
            $('#sponsors-Modal_enrol .image-upload-wrap').hide();
            $('#sponsors-Modal_enrol .file-upload-image').attr('src', $(attr).attr('img-src'));
            $('#sponsors-Modal_enrol .file-upload-content').show();
        }
        else{
            $('#sponsors-Modal_enrol #banner_title_name').val('');
            $('#sponsors-Modal_enrol .file-upload-input').replaceWith($('#sponsors-Modal_enrol .file-upload-input').clone());
            $('#sponsors-Modal_enrol .file-upload-content').hide();
            $('#sponsors-Modal_enrol .image-upload-wrap').show();
            $('#sponsors-Modal_enrol input[name="temp_id"]').remove();
        }
}




function b64toBlob_enrol(b64Data, contentType, sliceSize) {
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
            
            
            
            
</script>
