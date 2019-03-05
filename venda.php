<?php
    require 'banco.php';

    include 'header.php';
     $pdo = Banco::conectar();
    ?>

        <div class="container">
            <div clas="span10 offset1">
                <div class="row">
                    <h3 class="well"> Realizar Venda </h3>
                    <form class="form-horizontal" action="realizarVenda.php" method="post">
                        
                        <div class="row <?php echo !empty($clienteErro)?'error ' : '';?>">
                              <div class="input-field col s12">
                                <input size="50" name="cliente" id="cliente" type="text" required="" value="<?php echo !empty($cliente)?$cliente: '';?>">
                                <?php if(!empty($clienteErro)): ?>
                                    <span class="help-inline"><?php echo $clienteErro;?></span>
                                <?php endif;?>
                                <label for="cliente">Clientes</label>
                            </div>
                        </div>

                         <div class="row <?php echo !empty($descricaoErro)?'error ' : '';?>">
                          
                            <h6 for="produtot">Produtos</h6>
                                 <?php
                       
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM produto ORDER BY id DESC';
                        
                        foreach($pdo->query($sql)as $row)
                        {
                                    echo "<label class='col s3'><input name='produto' value='".$row['id']."' type='radio' /><span>".$row['nome']."</span>
                                </label>";

                            }?>
                                     
                        </div>

                         <div class="row <?php echo !empty($quantidadeErro)?'error ' : '';?>">
                              <div class="input-field col s12">
                                <input size="50" name="quantidade" id="quantidade" type="number" required="" value="<?php echo !empty($quantidade)?$quantidade: '';?>">
                                <?php if(!empty($clienteErro)): ?>
                                    <span class="help-inline"><?php echo $clienteErro;?></span>
                                <?php endif;?>
                                <label for="quantidade">quantidade</label>
                            </div>
                        </div>


                        <div class="row <?php echo !empty($percentualErro)?'error ': '';?>">
                             <h6>Tipo de pagamento</h6>
                             
                                <label class="col s3">
                                    <input name="tipoPagamento" value="credito" type="radio" checked />
                                    <span>Cartão de credito</span>
                                </label>

                                <label class="col s3">
                                    <input name="tipoPagamento" value="debito" type="radio" />
                                    <span>Debito</span>
                                </label>

                                <label class="col s3">
                                    <input name="tipoPagamento" value="dinheiro" type="radio" />
                                    <span>Dinheiro</span>
                                </label>

                              
                       
                        </div>
                     
                        
                        <div class="row <?php echo !empty($pagamentoErro)?'error ': '';?>">
                            
                             <div class="input-field col s12">
                                <input size="35" name="pagamento" id="pagamento" type="number" step="0.05"  required="" value="<?php echo !empty($pagamento)?$pagamento: '';?>">
                                <?php if(!empty($pagamentoErro)): ?>
                                <span class="help-inline"><?php echo $percentualErro;?></span>
                                <?php endif;?>
                                <label for="pagamento">Valor Pago</label>
                        </div>
                        </div>
                        
                        
                        
                       
                        <div class="form-actions">
                            <br/>
                
                            <button type="submit" class="btn btn-success">Realizar Venda</button>
                            <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        
                        </div>
                    </form>
                </div>
        </div>

         <?php
    
    if(!empty($_POST))
    {
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

        $id = $_REQUEST['produto'];
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlBuscarProd = "SELECT * FROM produto where id = ?";
        $q = $pdo->prepare($sqlBuscarProd);
        $q->execute(array($id));
        $produto = $q->fetch(PDO::FETCH_ASSOC);

        $tipoId = $produto['nome'];
        $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlBuscarTipo = "SELECT * FROM tipo where nomeTipo = ?";
        $b = $pdo2->prepare($sqlBuscarTipo);
        $b->execute(array($tipoId));
        $tipo = $b->fetch(PDO::FETCH_ASSOC);
           
        $valorImposto = ($produto['valor'] * $tipo['percentual']) / 100;
       
        $produtos = $produto['valor'];
        $valorDaVenda = ($produtos + $valorImposto) * $quantidade;
        
           $pdo3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO vendas (cliente, produto, pagamento, troco, tipoPagamento, valorImposto, valorDaVenda) VALUES(?,?,?,?,?,?,?)";
            $a = $pdo3->prepare($sql);
            $a->execute(array($cliente,$produto,$pagamento,$troco,$tipoPagamento,$valorImposto,$valorDaVenda));
            Banco::desconectar();
            header("Location: venda.php");
        }
    }
?>
        
 



            <table class="striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Valor da venda</th>
                            <th>Tipo de Pagamento</th>
                            <th>Troca</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM vendas ORDER BY id DESC';
                        
                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['cliente'] . '</td>';
                            echo '<td>'. $row['produto'] . '</td>';
                            echo '<td>'. $row['pagamento'] . '</td>';
                            echo '<td>'. $row['tipoPagamento'] . '</td>';
                            
                            echo '<td width=250>';
                                
                            echo ' ';
                            echo '<a class="waves-effect waves-light btn-small indigo accent-4" href="update.php?id='.$row['id'].'">Atualizar</a>';
                            echo ' ';
                            echo '<a class="waves-effect waves-light btn-small deep-orange darken-4" href="deleteTipo.php?id='.$row['id'].'">Excluir</a>';
                            echo '</td>';
                            echo '<tr>';
                        }
                        Banco::desconectar();
                        ?>
                    </tbody>                   
                </table>      

              


 </body>
</html>