<?php
    include_once("templates/header.php");
    include_once("process/pizza.php");
?>

    <div id="main-banner">
        <h1>Faça seu Pedido</h1>
    </div>
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Monte a pizza como desejar:</h2>
                    <form action="process/pizza.php" method="POST" id="pizza-form">
                        <div class="form-group">
                            <label for="borda">Borda:</label>
                            <select name="borda" id="borda" class="form-control">
                                <option value="">Selecione a borda</option>
                                <?php foreach($bordas as $borda): ?>
                                    <option value="<?= $borda['id']?>"><?= $borda["tipo"] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="massa">Massa:</label>
                            <select name="massa" id="massa" class="form-control">
                                <option value="">Selecione a massa</option>
                                <?php foreach($massas as $massa): ?>
                                    <option value="<?= $massa['id']?>"><?= $massa["tipo"] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sabores">Sabores: (Máximo 3)</label>
                            <div>
                             <?php foreach($sabores as $sabor): ?>
                                <div class="form-check">
                                    <input 
                                        class="form-check-input sbor-checkbox"
                                        type="checkbox"
                                        name="sabores[]"
                                        value="<?= $sabor['id']?>"
                                        id="sabor<?= $sabor['id']?>"
                                    >
                                    <label for="sabor<?= $sabor['id'] ?>" class="form-check-label">
                                        <?= $sabor["nome"] ?>
                                    </label>
                                </div>
                             <?php endforeach ?>  
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Fazer Pedido!">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once("templates/footer.php");
?>
