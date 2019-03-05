   <?php
  
    require 'banco.php';
    $id = null;
    if(!empty($_GET['id']))
    {
        $id = $_REQUEST['id'];
    }
    
    if(null==$id)
    {
        header("Location: index.php");
    }
    else 
    {
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM vendas where id = ?";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $venda = $q->fetch(PDO::FETCH_ASSOC);
       Banco::desconectar();
    }

  include 'header.php';
?>
        <div class="container">           
            <div class="span10 offset1">
                <div class="row">
                    <h3 class="well"> Visualizar a Venda </h3>
                </div>
                
               <table>
                    

                    <tbody>
                      <tr>
                        <td>Cliente</td>
                        <td><?php echo $venda['cliente']; ?></td>
                       
                      </tr>
                      <tr>
                        <td>Produto</td>
                        <td><?php echo $venda['produto']; ?></td>
                        
                      </tr>
                      <tr>
                        <td>Pagamento</td>
                        <td><?php echo $venda['pagamento']; ?></td>
                        
                      </tr>
                      <tr>
                        <td>Troco</td>
                        <td><?php echo $venda['troco']; ?></td>
                       
                      </tr>
                      <tr>
                        <td>Tipo de pagamento</td>
                        <td><?php echo $venda['tipoPagamento']; ?></td>
                        
                      </tr>
                      <tr>
                        <td>Valor de Impostos</td>
                        <td><?php echo $venda['valorImposto']; ?></td>
                       
                      </tr>
                      <tr>
                        <td>valorDaVenda</td>
                        <td><?php echo $venda['valorDaVenda']; ?></td>
                        
                      </tr>
                    </tbody>
                  </table>

                  <?php  include 'footer.php';?>