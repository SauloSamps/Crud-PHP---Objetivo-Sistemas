<?php
require_once("db.php");

function selectAll(){
    global $mysqli;
    $data = array();
    $stmt = $mysqli->prepare("SELECT * FROM cliente"); // Avoid using *. Select specific queries. This opens a mySQL queries
    $stmt->execute(); // run prepared query
    $result = $stmt->get_result(); // get result of prepared query
    if ($result->num_rows === 0){ // if result empty, print empty
        echo("No rows");
    }
    while($row = $result->fetch_assoc()){ // get associative array of each row
        $data[] = $row; // print the whole row
    }
    $stmt->close(); // close statement
    return $data;
}

function selectSingle($id = NULL){
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM cliente WHERE id = ?"); // Avoid using *. Select specific queries. This opens a mySQL queries
    $stmt->bind_param("i", $id);
    $stmt->execute(); // run prepared query
    $result = $stmt->get_result(); // get result of prepared query
    if ($result->num_rows === 0){ // if result empty, print empty
        echo("No rows");
    }
    $row = $result->fetch_assoc(); // get associative array of each row
    $stmt->close(); // close statement
    return $row;
}

function insert($nome = NULL, $observacao = NULL, $phone = NULL){
    $phone = (string)$phone;
    global $mysqli;

    $stmt_telefone = $mysqli->prepare("INSERT INTO cliente_telefone (telefone) VALUES (?)");
    $stmt_telefone->bind_param("s", $phone);
    $stmt_telefone->execute();

    $id_cliente_telefone = $mysqli->insert_id;

    $stmt_cliente = $mysqli->prepare("INSERT INTO cliente (nome, obeservacao, cliente_telefone_id_cliente_telefone) VALUES (?, ?, ?)");
    $stmt_cliente->bind_param("ssi", $nome, $observacao, $id_cliente_telefone);
    $stmt_cliente->execute();

    $stmt_telefone->close();
    $stmt_cliente->close();

    header("Location: /estagio-php-crud/index.php");
}

function delete($id){
    global $mysqli;
    $stmt_telefone = $mysqli -> prepare("DELETE FROM cliente_telefone WHERE id=?");
    $stmt_telefone -> bind_param("i", $id);
    $stmt_telefone -> execute();
    $stmt_telefone -> close();




    header("Location: /crud-php/index.php");
}


