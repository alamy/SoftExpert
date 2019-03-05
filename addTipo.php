<?php
    require 'banco.php';

    include 'header.php';
     $pdo = Banco::conectar();
    ?>

        <div class="container">
            <div clas="span10 offset1">
                <div class="row">
                    <h3 class="well"> Adicionar Tipo </h3>
                    <form class="form-horizontal" action="addTipo.php" method="post">
                        
                        <div class="row <?php echo !empty($nomeTipoErro)?'error ' : '';?>">
                            <label class="control-label">Nome do Tipo</label>
                            <div class="controls">
                                <input size="50" name="nomeTipo" type="text" placeholder="Tipo" required="" value="<?php echo !empty($nomeTipo)?$nomeTipo: '';?>">
                                <?php if(!empty($nomeTipoErro)): ?>
                                    <span class="help-inline"><?php echo $nomeTipoErro;?></span>
                                <?php endif;?>
                            </div>
                        </div>

                         <div class="row<?php echo !empty($descricaoErro)?'error ' : '';?>">
                            <label class="control-label">Descrição</label>
                            <div class="controls">
                                <input size="50" name="descricao" type="text" placeholder="Descreva esse tipo de produto" required="" value="<?php echo !empty($descricao)?$descricao: '';?>">
                                <?php if(!empty($descricaoErro)): ?>
                                    <span class="help-inline"><?php echo $descricaoErro;?></span>
                                <?php endif;?>
                            </div>
                        </div>
                     
                        
                        <div class="row <?php echo !empty($percentualErro)?'error ': '';?>">
                            <label class="control-label">Percentual de Impostos</label>
                            <div class="controls">
                                <input size="35" name="percentual"  type="number" step="0.05" placeholder="0.0%" required="" value="<?php echo !empty($percentual)?$pecentual: '';?>">
                                <?php if(!empty($percentualErro)): ?>
                                <span class="help-inline"><?php echo $percentualErro;?></span>
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
        
   

<?php
    
    if(!empty($_POST))
    {
        //Acompanha os erros de validação
        $nomeTipoErro = null;
        $percentualErro = null;
        $descricaoErro = null;
       
        
        
        $nomeTipo = $_POST['nomeTipo'];
        $percentual = $_POST['percentual'];
        $descricao = $_POST['descricao'];
        
        
        //Validaçao dos campos:
        $validacao = true;
        if(empty($nomeTipo))
        {
            $nomeTipoErro = 'Por favor digite um nome para esse Tipo de produto!';
            $validacao = false;
        }
        
        if(empty($percentual))
        {
            $percentualErro = 'è de suma imprtancia que tenha um % nesse imposto cadastrado!';
            $validacao = false;
        }

        if(empty($descricao))
        {
            $descricaoErro = 'Por favor descreva esse tipo de produto!';
            $validacao = false;
        }
        
        //Inserindo no Banco:
        if($validacao)
        {
           
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tipo (nomeTipo, percentual, descricao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nomeTipo,$percentual,$descricao));
            Banco::desconectar();
            header("Location: addTipo.php");
        }
    }
?>

<table class="striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nome do tipo</th>
                            <th>Descrição</th>
                            <th>Percentual Impostos</th>
                            
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM tipo ORDER BY id DESC';
                        
                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['nomeTipo'] . '</td>';
                            echo '<td>'. $row['descricao'] . '</td>';
                            echo '<td>'. $row['percentual'] . '</td>';
                            
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