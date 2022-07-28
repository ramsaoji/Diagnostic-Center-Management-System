
    $(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
    });

/////////////////////////////////////////////////////


    var active;

    $(document).ready(function () {

    const todayDate = new Date();
    var todayM = todayDate.getMonth();
    var todayD = todayDate.getDate();
    var pastD = todayD - 3;
    var todayY = todayDate.getFullYear();

    
        $(".dateFilter").datepicker({ maxDate: todayDate, minDate: new Date(todayY, todayM, pastD), dateFormat: "yy-mm-dd"});

        $("#search_dr").keyup(function (e) {
        
        var code = e.which;

        if (code == 40) { //key down                     
            active++;

            if (active >= $('#drList ul li').length)
                active = 0;//$('#drList ul li').length;

            switchActiveElement();
            console.log(active);
        } else if (code == 38) { //key up
            active--;
            if (active < 0)
                active = $('#drList ul li').length - 1;

            switchActiveElement();
            console.log(active);
        } else if (code == 13) { //enter key
            selectOption($('.active'));

    
        } else {
            var query = $("#search_dr").val();

            if (query.length > 0) {
                $.ajax(
                    {
                        url: 'ajax-dr-search.php',
                        method: 'POST',
                        data: {
                            // search: 1,
                            query: query
                        },
                        success: function (data) {
                            $('#drList').fadeIn("fast");
                            $('#drList').html(data);
                            active = -1 
                            if (code = 38)
                            active = $('#drList ul li').length; 
                        },
                        dataType: 'text'
                    }
                );
            }
            else{
                $('#drList').fadeOut(); 
            }  
        }
        
    });

    $(document).on('click', '#drList li', function(){

            $('#search_dr').val($(this).text());
            // $('#search_dr_id').val($(this).attr('value'));
            $('#drList').fadeOut();
        });
        $(document).on('click', function(){ 
            $('#drList').fadeOut();  
        });
        
});

function switchActiveElement() {
    $('.active').removeAttr('class');
    $('#drList ul li:eq('+active+')').attr('class', 'active');
}

function selectOption(caller) {
    var country = caller.text();
    $("#search_dr").val(country);
    $("#drList").html("");
    $('#drList').fadeOut(); 
        
}


/////////////////////////////////////////////////////

    function scan_master_sub(data) {
    
    const ajaxreq1 = new XMLHttpRequest();
    ajaxreq1.open('GET','http://localhost/hospital/admin/main/get_master_sub_scan_type.php?selectvalue='+data,'TRUE');

    ajaxreq1.send();

    ajaxreq1.onreadystatechange = function(){
        if(ajaxreq1.readyState == 4 && ajaxreq1.status == 200){

            $sub_master_scan = ajaxreq1.responseText;
            document.getElementById('sub_master_scan').innerHTML = $sub_master_scan;
            document.getElementById('sub_master_scan').value = $sub_master_scan;
            
        }
    }
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});



/////////////////////////////////////////////////////


    function scan_sub_child(data) {
    
    const ajaxreq1 = new XMLHttpRequest();
    ajaxreq1.open('GET','http://localhost/hospital/admin/main/get_child_scan_type.php?selectvalue='+data,'TRUE');

    ajaxreq1.send();

    ajaxreq1.onreadystatechange = function(){
        if(ajaxreq1.readyState == 4 && ajaxreq1.status == 200){

            $sub_child_scan = ajaxreq1.responseText;

            document.getElementById('sub_child_scan').innerHTML = $sub_child_scan;
            document.getElementById('sub_child_scan').value = $sub_child_scan;
        }
    }
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});


/////////////////////////////////////////////////////

    function original_price(data) {

    const ajaxreq1 = new XMLHttpRequest();
    ajaxreq1.open('GET','http://localhost/hospital/admin/main/get_original_price.php?selectvalue='+data,'TRUE');

    ajaxreq1.send();

    ajaxreq1.onreadystatechange = function(){
        if(ajaxreq1.readyState == 4 && ajaxreq1.status == 200){

            $original_price = ajaxreq1.responseText;

            document.getElementById('oprice').value = $original_price;

        }
    }
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

/////////////////////////////////////////////////////

