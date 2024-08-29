<?php

function validateCNPJ($cnpj){
	if(empty($cnpj)){
		return false;
	}
  
	$cnpj = preg_replace('/[^0-9]/','',$cnpj);
  
  	if(strlen($cnpj) != 14){
		return false;
	}

    if (preg_match('/(\d)\1{13}/', $cnpj)){
    	return false;
	}

	$b = [6,5,4,3,2,9,8,7,6,5,4,3,2];
    
	for($i = 0,$n = 0;$i < 12;$n += $cnpj[$i] * $b[++$i]);
    
	if($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)){
        return false;
    }

    for($i = 0,$n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);
    
	if($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)){
        return false;
    }
  
	return true;
}

function forcePassword($senha){
	$arr_min = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","w","x","y","z");
	$arr_mai = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","W","X","Y","Z");
	$arr_num = array("1","2","3","4","5","6","7","8","9","0");
	$arr_cae = array("$","#","@",".","_");

	$verif_min = 0;
	$verif_mai = 0;
	$verif_num = 0;
	$verif_cae = 0;

	$qtde_caracteres = strlen($senha);

	for($i=0;$i<$qtde_caracteres;$i++){

	  if(in_array($senha[$i],$arr_min)){
		$verif_min += 1;
	  }

	  if(in_array($senha[$i],$arr_mai)){
		$verif_mai += 1;
	  }

	  if(in_array($senha[$i],$arr_num)){
		$verif_num += 1;
	  }

	  if(in_array($senha[$i],$arr_cae)){
		$verif_cae += 1;
	  }
	}

	if($verif_min > 0){
	  $retorno_min = "S";
	}else{
	  $retorno_min = "N";
	}

	if($verif_mai > 0){
	  $retorno_mai = "S";
	}else{
	  $retorno_mai = "N";
	}
	
	if($verif_num > 0){
	  $retorno_num = "S";
	}else{
	  $retorno_num = "N";
	}
	
	if($verif_cae > 0){
	  $retorno_cae = "S";
	}else{
	  $retorno_cae = "N";
	}
	
	$parametro = array_count_values(array($retorno_min,$retorno_mai,$retorno_num,$retorno_cae));
	
	return $parametro["S"];
  }