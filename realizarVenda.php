   <?php
   
   require 'banco.php';
          $pdo = Banco::conectar();
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlBuscarProd = "SELECT * FROM produto where id = ?";
        $q = $pdo->prepare($sqlBuscarProd);
        $q->execute(array($_POST['produto']));
        $prod = $q->fetch(PDO::FETCH_ASSOC);
       
      
       
        $sqlTipo = "SELECT * FROM tipo where nomeTipo = ?";
        $b = $pdo->prepare($sqlTipo);
        $b->execute(array($prod['nome']));
        $tipo = $b->fetch(PDO::FETCH_ASSOC);

        //Acompanha os erros de validação
        $clienteErro = null;
        $produtoErro = null;
        $pagamentoErro = null;

        $quantidade = $_POST['quantidade'];
        $cliente = $_POST['cliente'];
        $pagamento = $_POST['pagamento'];
        
        $tipoPagamento = $_POST['tipoPagamento'];
        
        
        
        //Validaçao dos campos:
        $validacao = true;
        if(empty($cliente))
        {
            $clienteErro = 'Por favor digite o nome do cliente';
            $validacao = false;
        }
        
        if(empty($produto))
        {
            $produtoErro = 'è de suma imprtancia que tenha um % nesse imposto cadastrado!';
            $validacao = false;
        }

        if(empty($pagamento))
        {
            $pagamentoErro = 'Por favor descreva esse tipo de pagamento!';
            $validacao = false;
        }

        if(empty($quantidade))
        {
            $quantidadeErro = 'Por favor a quantidade!';
            $validacao = false;
        }
        
        //Inserindo no Banco:
        if($validacao)
        {
   
      $quantidade = $_POST['quantidade'];
        $cliente = $_POST['cliente'];
        $pagamento = $_POST['pagamento'];
        $tipoPagamento = $_POST['tipoPagamento'];

       
       

       

        
       
        $valorImposto = ($prod['valor']) / 100;
       
        
        $valorDaVenda = ($produtos + $valorImposto) * $quantidade;
        $troco = $prod['valor'] - $pagamento;

    }



        

         var_dump($_POST['produto']);
         var_dump($tipo['nomeTipo']);
         var_dump($prod['nome']);
         

        include 'header.php';


        
?>

        <div class="container">           
            <div class="span10 offset1">
                <div class="row">
                    <h3 class="well"> Realizar a Venda </h3>
                </div>
                
               <table>
                    

                    <tbody>
                      <tr>
                        <td>Cliente</td>
                        <td><?php echo $cliente; ?></td>
                       
                      </tr>
                      <tr>
                        <td>Produto</td>
                        <td><?php echo $prod["nome"]; ?></td>
                        
                      </tr>
                      <tr>
                        <td>Pagamento</td>
                        <td><?php echo $pagamento; ?></td>
                        
                      </tr>
                      <tr>
                        <td>Troco</td>
                        <td><?php echo $troco; ?></td>
                       
                      </tr>
                      <tr>
                        <td>Tipo de pagamento</td>
                        <td><?php echo $tipoPagamento; ?></td>
                        
                      </tr>
                      <tr>
                        <td>Valor de Impostos</td>
                        <td><?php echo $valorImposto; ?></td>
                       
                      </tr>
                      <tr>
                        <td>valorDaVenda</td>
                        <td><?php echo $valorDaVenda; ?></td>
                        
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </body>
</html>