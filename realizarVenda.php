   <?php
     include 'header.php';
      

      require 'banco.php';
          $pdo = Banco::conectar();
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlBuscarProd = "SELECT * FROM produto where id = ?";
        

        $q = $pdo->prepare($sqlBuscarProd);
        $q->execute(array($_POST['produto']));
        $prod = $q->fetch(PDO::FETCH_ASSOC);
       
        //Acompanha os erros de validação
        $clienteErro = null;
        $produtoErro = null;
        $pagamentoErro = null;

        $quantidade = $_POST['quantidade'];
        $cliente = $_POST['cliente'];
        $pagamento = $_POST['pagamento'];
        $impostosInt = $prod['tipo'];
        $produto = $prod['valor'];
        $nomeProduto =$prod["nome"];
        
         
        $tipoPagamento = $_POST['tipoPagamento'];
        
        $valorImposto = ($impostosInt * $produto) / 100;
       
        
        $valorDaVenda = ($produto + $valorImposto) * $quantidade;
        $troco = $prod['valor'] - $pagamento;
  $submit = true;
   if($submit){
               $sql2 = "INSERT INTO vendas (cliente, produto, pagamento, troco, tipoPagamento, valorImposto, valorDaVenda) VALUES(?,?,?,?,?,?,?)";
              $a = $pdo->prepare($sql2);
              $a->execute(array($cliente,$nomeProduto,$pagamento, $troco, $tipoPagamento, $valorImposto, $valorDaVenda));
              Banco::desconectar();
              header("Location: addTipo.php");
            }
          
  ?>

      
<?php  include 'footer.php'









;?>