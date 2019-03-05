<?php
    require 'banco.php';

    include 'header.php';
    $pdo = Banco::conectar();
    $tipo = 'SELECT * FROM tipo ORDER BY id DESC';
    ?>

        <div class="container">
            <div clas="span10 offset1">
                <div class="row">
                    <h3 class="well"> Adicionar Produto </h3>
                    <form class="form-horizontal" action="addProd.php" method="post">
                        
                        <div class="control-group <?php echo !empty($nomeErro)?'error ' : '';?>">
                            <label class="control-label">Nome do Produto</label>
                            <div class="controls">
                                <input size= "50" name="nome" type="text" placeholder="Nome do produto" required="" value="<?php echo !empty($nome)?$nome: '';?>">
                                <?php if(!empty($nomeErro)): ?>
                                    <span class="help-inline"><?php echo $nomeErro;?></span>
                                <?php endif;?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="">
                            <h6>Tipo do Produto</h6>
                             <?php                    
                                 foreach($pdo->query($tipo)as $row)
                                    {                    
                                     echo ' <label><input name="tipo" type="radio" value="'. $row['percentual'] .'" /> <span>'. $row['nomeTipo'] . '</span></label>';                    
                                     }            
                                    ?>   
                            </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($valorErro)?'error ': '';?>">
                            <label class="control-label">Valor do Produto</label>
                            <div class="controls">
                                <input size="35" name="valor" type="number" placeholder="00,00R$" required="" value="<?php echo !empty($valor)?$valor: '';?>">
                                <?php if(!empty($valorErro)): ?>
                                <span class="help-inline"><?php echo $valorErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($quantidadeErro)?'error ': '';?>">
                            <label class="control-label">Quantidade em estoque</label>
                            <div class="controls">
                                <input size="40" name="quantidade" type="text" placeholder="0" required="" value="<?php echo !empty($Quantidade)?$Quantidade: '';?>">
                                <?php if(!empty($quantidadeErro)): ?>
                                <span class="help-inline"><?php echo $quantidadeErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        
                       
                        <div class="form-actions">
                            <br/>
                
                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        
                        </div>
                    </form>
                </div>
        </div>
        <script type="text/javascript">
             $(document).ready(function(){
                $('select').formSelect();
              });
        </script>
   

<?php
    
    if(!empty($_POST))
    {
        //Acompanha os erros de validação
        $nomeErro = null;
        $tipoErro = null;
        $valorErro = null;
        $quantidadeErro = null;
        
        
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $valor = $_POST['valor'];
    
        $quantidade = $_POST['quantidade'];
        
        
        //Validaçao dos campos:
        $validacao = true;
        if(empty($nome))
        {
            $nomeErro = 'Por favor digite o seu nome do produto!';
            $validacao = false;
        }
        
        if(empty($tipo))
        {
            $tipoErro = 'Por favor escolha um tipo!';
            $validacao = false;
        }
        
        if(empty($valor))
        {
            $valorErro = 'É muito importante informar um valor para seu produto!';
            $validacao = false;
        }
        
        if(empty($quantidade))
        {
            $quantidadeErro = 'quantidade minima tem que ser 1';
            $validacao = false;
        }
       
        
       
        
        //Inserindo no Banco:
        if($validacao)
        {
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO produto (nome, tipo, valor, quantidade, indice) VALUES(?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome,$tipo,$valor,$quantidade,$indice));
            Banco::desconectar();
            header("Location: addProd.php");
        }
    }
?>
        
        <table class="striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Quantidade</th>
                            
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM produto ORDER BY id DESC';
                        
                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
                            echo '<td>'. $row['nome'] . '</td>';
                            echo '<td>'. $row['tipo'] . '</td>';
                            echo '<td>'. $row['valor'] . '</td>';
                            echo '<td>'. $row['quantidade'] . '</td>';
                        
                            echo '<td width=250>';
                           
                            echo ' ';
                            echo '<a class="waves-effect waves-light btn-small indigo accent-4" href="update.php?id='.$row['id'].'">Atualizar</a>';
                            echo ' ';
                            echo '<a class="waves-effect waves-light btn-small deep-orange darken-4" href="delete.php?id='.$row['id'].'">Excluir</a>';
                            echo '</td>';
                            echo '<tr>';
                        }
                        Banco::desconectar();
                        ?>
                    </tbody>                   
                </table>         

<?php  include 'footer.php';?>