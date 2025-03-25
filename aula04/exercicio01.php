<?php
    $pessoa = array("nome" => "Wesley", "idade" => "17", "cidade" => "Ribeirão Pires");

    $pessoa["profissao"] = "Estudante";

    $amigos = ["Lucas", "Tiago", "Pedro"];

    $dados = array_merge($pessoa, $amigos);
    print_r($dados);
?>