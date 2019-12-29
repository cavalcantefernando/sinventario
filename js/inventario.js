$(document).ready( function(){
	listaFiliais();
	$("#filiais").change( function(){
		if( $("#filiais").val() != '' ){
			listaProdutos( $("#filiais").val() );	
		}else{
			$("#lista-produtos").html( '' );
		}
	});

	$("#exportar").click( function(){
		if( $("#filiais").val() != '' ){
			$("#tb-lista-produtos").table2csv( 'download', {filename: 'relatorio-estoque-negativo.csv'});	
		}else{
			alert( ' Favor selecionar uma filial ' );
		}		
	});
});
function listaFiliais(){
	$.ajax({
		url: 'lib/ajax.php',
		data: {
			act: 'lista-filiais'
		},
		success: function( data ){
			data = JSON.parse( data );
			if( data.sucesso ){
				$("#filiais").html( data.tag );			
			}else{
				$("#filiais").html( data.msg );
			}
		}
	});	
}

function listaProdutos( id ){
	$.ajax({
		url: 'lib/ajax.php',
		data: {
			act: 'lista-produtos',
			id: id, 
		},
		success: function( data ){
			data = JSON.parse( data );
			if( data.sucesso ){
				$("#lista-produtos").html( data.tag );
				$(function(){
					$('[data-toggle="popover"]').popover()
				});				
			}else{
				$("#lista-produtos").html( '<tr><td colspan="3"><center> '+ data.msg +' </center></td></tr>' );
			}
		}
	});
}