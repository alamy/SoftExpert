<?php
    require 'banco.php';

    include 'header.php';
    ?>

        <div class="jumbotron">
        <div class="container">
            <div class="row">
                <h1> Desafio Softex</h1>
                <p>Desenvolva um programa para um mercado que permita o cadastro dos produtos, dos tipos de cada produto, dos valores percentuais de imposto dos tipos de produtos, a tela de venda, onde será informado os produtos e quantidades adquiridos, o sistema deve apresentar o valor de cada item multiplicado pela quantidade adquirida e a quantidade pago de imposto em cada item, um totalizador do valor da compra e um totalizador do valor dos impostos.</p>
            </div>
            </br>
            <div class="row">
                <p>
                    <a href="create.php" class="btn btn-success">Adicionar Produto</a>
                </p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Sexo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM produtos ORDER BY id DESC';
                        
                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['nome'] . '</td>';
                            echo '<td>'. $row['telefone'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['sexo'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn btn-primary" href="read.php?id='.$row['id'].'">Listar</a>';
                            echo ' ';
                            echo '<a class="btn btn-warning" href="update.php?id='.$row['id'].'">Atualizar</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Excluir</a>';
                            echo '</td>';
                            echo '<tr>';
                        }
                        Banco::desconectar();
                        ?>
                    </tbody>                   
                </table>               
            </div>
        </div>
        </div>
    </body>
</html>
