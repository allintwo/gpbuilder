

//var loadingdiv = document.getElementById('loading');
var loadingdiv = $('#loading');

//loadingdiv.removeClass('spinner');

var gbapiurl = "https://localhost/gpbuilder/api.php";

let qsssr = document.getElementById('qsssr');
let qbtnss = document.getElementById('qbtnss');

qbtnss.addEventListener('click',function (){
    gb_get_list_data();
    gb_get_single_data();

})


function gbbuild_data(q)
{
    let gbpostdata = {
        'q':q,
        'whoami':'GOD',
        'action':'get_single_data'
    };

    loadingdiv.addClass('spinner');
    $.post(gbapiurl, gbpostdata, function(result){
        $("#gbalerts").html(result['html']);
        // loadingdiv.style.display = 'none';
        loadingdiv.removeClass('spinner');
    });
}




function gb_get_single_data()
{

    let queryx = $('#qsssr').val();

    let gbpostdata = {
        'q':queryx,
        'whoami':'GOD',
        'action':'get_single_data'
    };

    loadingdiv.addClass('spinner');
    $.post(gbapiurl, gbpostdata, function(result){
        $("#gbalerts").html(result['html']);
        // loadingdiv.style.display = 'none';
        loadingdiv.removeClass('spinner');
    });

}

function gb_get_list_data()
{

    let queryx = $('#qsssr').val();

    let gbpostdata = {
        'q':queryx,
        'whoami':'GOD',
        'action':'getlist'
    };

    loadingdiv.addClass('spinner');
    $.post(gbapiurl, gbpostdata, function(result){
        $("#gbalerts").html(result['html']);
        // loadingdiv.style.display = 'none';
        loadingdiv.removeClass('spinner');
    });

}