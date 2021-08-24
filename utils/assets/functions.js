function limitLines(obj, e) { /* Limit number of row of a textarea */
    let keynum, lines = obj.value.split('\n').length;

    // IE
    if(window.event) {
        keynum = e.keyCode;
        // Netscape/Firefox/Opera
    } else if(e.which) {
        keynum = e.which;
    }

    if(keynum == 13 && lines == obj.rows) {
        return false;
    }
}

var xhr2 = !! ( window.FormData && ("upload" in ($.ajaxSettings.xhr()) )); /*Check if formData is supported by browser*/

$("#ritratto").change(function (){
     var preview= $("#ritratto_img");
     if (this.files && this.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
             preview.attr('src', e.target.result);
         }
         reader.readAsDataURL(this.files[0]);
     }else{
         preview.attr(src, '');
     }
});/* Select image and preview it*/

var intervalId = window.setInterval(function(){
        table.ajax.reload();
        draw_table(table);
    }, 10000); /* Effect those istructions every 5 seconds*/

function draw_table(my_table){
    reset= true;
    my_table.draw();
    reset= false;
    my_table.draw();
} /* Redraw datatable with custom filtes*/

$.fn.dataTable.ext.search.push(function( settings, data, dataIndex, rowData, counter ) {
        if (reset){
            return true;
        }

        var pubblico= $("#public").val();

        //console.log($(rowData[0]).prop("checked"));

        var checked= ($("#vis_r"+dataIndex).attr("visibile")=="si") ? true : false;

        if (((pubblico=="pub")&&(!checked)) ||
            ((pubblico=="priv")&&(checked)))
            return false;
        var username= $("#username").val().toLowerCase();
        //console.log(username);
        //console.log(data[1].toLowerCase().startsWith(username));

        if (((username.length>0))&&(!data[2].toLowerCase().startsWith(username)))
            return false;

        return true;
    }/*Custom datatable filter*/


