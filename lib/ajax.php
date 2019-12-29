<?php
	if( isset( $_GET['act'] ) ){
		require_once( "svarejo.class.php" );
		$sv = new sVarejo();
		switch ( $_GET['act'] ) {
			case 'lista-filiais':
				echo $sv->listaFiliais();
				break;
			case 'lista-produtos':
				echo $sv->listaProdutos( $_GET['id'] );
				break;
			default:
				# code...
				break;
		}
	}
?>