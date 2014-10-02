<?php 

require_once("inc/configuration.php");

$a = new Animal();

$a->andar();
if($a->estaVivo){
	echo "vivo!";
}else{
	echo "morto";
}

$b = new Cobra();


$b->estaVivo = false;

$b->andar();



if($b->estaVivo){
	echo "vivo!";
}else{
	echo "morto";
}


$sql = new Sql();

$linhas = $sql->arrays("SELECT * FROM tb_pessoas ORDER BY despessoa");



//$page = new Page();

//$page->setTpl("index");

?>
<meta charset="utf-8">