<?php

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

// RESGATE DOS DADOS, MONTAGEM DO PEDIDO
if($method === "GET") {

    $bordasQuery = $conn->query("SELECT * FROM bordas;");

    $bordas = $bordasQuery->fetchAll();

    $massasQuery = $conn->query("SELECT * FROM massas;");

    $massas = $massasQuery->fetchAll();

    $saboresQuery = $conn->query("SELECT * FROM sabores;");

    $sabores = $saboresQuery->fetchAll();

    
// CRIAÇÃO DO PEDIDO    
} else if ($method === "POST") {

    $data = $_POST;

    $borda = $data["borda"];
    $massa = $data["massa"];
    $sabores = $data["sabores"];

    // validação de sabores máximos

if (count($sabores) > 3)  {
        
    $_SESSION["msg"] = "Você só pode escolher no máximo 3 sabores!";
    $_SESSION["status"] = "warning";

} else {

    // salvando borda e massa na pizza
    $stmt = $conn->prepare("INSERT INTO pizzas (borda_id, massa_id) VALUES (:borda, :massa)");

    // filtrando inputs 
    $stmt ->bindParam(":borda", $borda, PDO::PARAM_INT);
    $stmt ->bindParam(":massa", $massa, PDO::PARAM_INT);
    
    $stmt->execute();

    // resgatando id da ultima pizza
    $pizzaId = $conn->lastInsertId();

    $stmt = $conn->prepare("INSERT INTO pizza_sabor (pizza_id, sabor_id) VALUES (:pizza, :sabor)");
    // repetição até terminar de salvar todos os sabores
    foreach($sabores as $sabor) {

        //filtrndo inputs
        $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
        $stmt->bindParam(":sabor", $sabor, PDO::PARAM_INT);

        $stmt->execute();
    }

    // criar o pedido da pizza
    $stmt = $conn->prepare("INSERT INTO pedidos (pizza_id, status_id) VALUES (:pizza, :status)");

    // status -> sempre inicio com 1
    $statusId = 1;

    //filtrar inputs
    $stmt->bindParam(":pizza", $pizzaId);
    $stmt->bindParam(":status", $statusId);

    $stmt->execute();

    // Exibir mensagem de succeso
    $_SESSION["msg"] = "Pedido realizado com sucesso";
    $_SESSION["status"] = "success";

}
header("Location: ..");
}

?>