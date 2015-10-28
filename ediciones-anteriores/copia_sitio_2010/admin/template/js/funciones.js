function ask(obj){

    if (confirm("Seguro que quiere eliminarlo?"))
	return true;
    else
	return false;


}
//funcion para hacer los combo dependientes
function makeSublist(parent,child,isSubselectOptional,childVal)
{
    $("body").append("<select style='display:none' id='"+parent+child+"'></select>");
    $('#'+parent+child).html($("#"+child+" option"));
    var parentValue = $('#'+parent).attr('value');
    $('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());

    childVal = (typeof childVal == "undefined")? "" : childVal ;
    $("#"+child+' option[value="'+ childVal +'"]').attr('selected','selected');

    $('#'+parent).change(
	function()
	{
	    var parentValue = $('#'+parent).attr('value');
	    $('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());
	    if(isSubselectOptional) $('#'+child).prepend("<option value=''> -- Seleccione -- </option>");
	    $('#'+child).trigger("change");
	    $('#'+child).focus();
	}
	);
};

var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos()
{
    var x;
    var y;

    x=$("body .ajax");
    x.click(presionEnlace);
}

function presionEnlace()
{
    var pagina=$(this).attr("href");
    var x=$("#wrapper");
    var y=$("#preloader");
    x.ajaxStart(inicioEnvio);
    x.load(pagina);
    x.ajaxStop(paroEnvio);
    return false;
}

function inicioEnvio()
{
    var x=$("#preloader");
    var y=$("#wrapper");
    y.css({
	'opacity' : 0.3
    });
    x.css("display","block");
}

function paraEnvio(){
    var x=$("#preloader");
    x.hider();
}

$(document).ready(function(){
    $('body #mensaje').click(function(){
	$("body #mensaje").slideUp();
    });
    //calentario
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#datepicker').datepicker({
	changeMonth: true,
	changeYear: true
    })
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#datepicker2').datepicker({
	changeMonth: true,
	changeYear: true
    })

    //tabs
    $("#tabs").tabs();
    $("#tabs2").tabs();

    makeSublist('familia','subfamilia', false, '');
    //makeSublist('subfamilia','', false, '');

    //checkbox para los permisos de usuarios
    lis = $('ul.accesos li:has(ul)');
    checkboxes = $('input[type=checkbox]', lis);

    checkboxes.bind('click', function(e){
	$(this).siblings('ul').find('input[type=checkbox]')
	.attr('checked', $(this).attr('checked'))
    })


    childrens = $('input[type=checkbox]', lis);
    childrens.bind('click', function(e){

	// Click en un hijo, y checkear los padres
	if($(this).attr('checked')){
	    $(this).parents('li.hijos').children('input[type=checkbox]').attr('checked', 'checked');
	}

    });
});