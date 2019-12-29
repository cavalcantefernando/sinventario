<?php
class sVarejo
{
	private function conn()
	{
		$host 	= "[HOST DO BANCO DE DADOS]";
		$dbname = "svarejo";
		$user 	= "[USUARIO DO BANCO DE DADOS]";
		$pass 	= "[SENHA DO USUARIO DO BANCO DE DADOS]";

		try {
			$conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8", $user, $pass);
			return $conn;
		} catch (Exception $e) {
			return false;
		}
	}

	private function retornaConexaoV11($id_filial)
	{
		if ($conn = $this->conn()) {
			$sql = "SELECT sv_host, sv_dbname, sv_user, sv_pass FROM sv_filiais WHERE id_filial = " . $id_filial;
			if ($rs = $conn->query($sql)) {
				if ($rs->rowCount() == 1) {
					$ln = $rs->fetchAll();
					try {
						$c = new PDO("mysql:host=" . $ln[0]['sv_host'] . ";dbname=" . $ln[0]['sv_dbname'] . ";charset=utf8", $ln[0]['sv_user'], $ln[0]['sv_pass']);

						return $c;
					} catch (Exception $e) {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function listaFiliais()
	{
		$tag = "";
		if ($conn = $this->conn()) {
			$sql = "SELECT * FROM sv_filiais WHERE sv_tipoFilial = 'LJ'";

			if ($rs = $conn->query($sql)) {
				if ($rs->rowCount() > 0) {
					$a = "<option value=''> -----------------  </option>";
					while ($ln = $rs->fetch(PDO::FETCH_ASSOC)) {
						$a .= "<option value='" . $ln['id_filial'] . "'>" . $ln['sv_filial'] . "</option>";
					}

					$tag = [
						'sucesso' 	=> true,
						'tag'		=> $a
					];
				} else {
					$tag = [
						'sucesso' 	=> false,
						'tag' 		=> '<option> Nenhuma filial cadastrada! </option>'
					];
				}
			} else {
				$tag = [
					'sucesso' 	=> false,
					'tag' 		=> '<option> Erro ao buscar informações no banco de dados! </option>'
				];
			}
		} else {
			$tag = [
				'sucesso' 	=> false,
				'tag' 		=> '<option> Erro ao conectar com banco de dados! </option>'
			];
		}
		return json_encode($tag);
	}

	public function listaProdutos($id_filial)
	{
		$tag = "";
		if ($conn = $this->retornaConexaoV11($id_filial)) {
			$sql = "SELECT cod_pr1, nom_pr1, qua_es1, id__pr1 FROM cadastrosprodutos
    						LEFT JOIN cadastrosprodutosestoques ON id__pr1 = pro_es1
						WHERE qua_es1 < 0 AND evi_es1 = 1 ORDER BY cod_pr1 ASC";
			if ($rs = $conn->query($sql)) {
				if ($rs->rowCount() > 0) {
					$m = "";
					while ($ln = $rs->fetch(PDO::FETCH_ASSOC)) {
						$m .= "<tr>";
						$m .= "<td>" . $ln['cod_pr1'] . "</td>";
						$m .= "<td>" . $ln['nom_pr1'] . "</td>";
						$m .= "<td>" . round($ln['qua_es1'], 2) . "</td>";
						$m .= $this->verificaPendenciaEntrada($ln['id__pr1'], $id_filial);
						$m .= "</tr>";
					}
					$tag = [
						'sucesso'	=> true,
						'tag'	 	=> $m
					];
				} else {
					$tag = [
						'sucesso'	=> false,
						'msg'		=> 'Nenhum produto negativo!'
					];
				}
			} else {
				$tag = [
					'sucesso'	=> false,
					'msg'		=> 'Erro ao buscar produtos 2!'
				];
			}
		} else {
			$tag = [
				'sucesso'	=> false,
				'msg'		=> 'Erro ao buscar produtos 1!'
			];
		}

		return json_encode($tag);
	}

	public function verificaPendenciaEntrada($produto, $filial)
	{
		$m = "";
		if ($conn = $this->retornaConexaoV11($filial)) {
			$sql = "SELECT cod_df2, qu1_df2, qux_df2 FROM oppedidoscomprasdetalhes							
							WHERE cod_df2 in (
								SELECT cod_df1
									FROM oppedidoscomprascabecalhos 
									WHERE exc_df1 = 1
									AND bai_df1 = 2
									AND dba_df1 is null
									AND emp_df1 <> 1
						    )
						    AND pro_df2 = " . $produto . "";
			if ($rs = $conn->query($sql)) {
				if ($rs->rowCount() > 0) {
					while ($ln = $rs->fetch(PDO::FETCH_ASSOC)) {
						$m .= "<td>";
						$m .= $ln['cod_df2'];
						$m .= "</td>";
						$m .= "<td>";
						$m .= $ln['qu1_df2'] * $ln['qux_df2'];
						$m .= "</td>";
					}
				} else {
					$m = '<td> --- </td><td> --- </td>';
				}
			} else {
				$m = "<td> Erro ao procurar pedidos! </td><td></td>";
			}
		} else {
			$m = "<td> Erro ao procurar pedidos! </td><td></td>";
		}

		return $m;
	}
}
