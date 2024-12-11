$(document).ready(function(){

    $('input, select').each(function(key, val){
        // console.log(val);
        if($(val).attr('mask'))
        {

             $(val).mask($(val).attr('mask'));

        }
         if($(val).attr('pattern') && $(val).attr('pattern')!='')
        {
            var patt = new RegExp($(val).attr('pattern'));

            $(val).mask('Z',{translation:  {'Z': {pattern: patt, recursive: true}}});
        }
    });

});
