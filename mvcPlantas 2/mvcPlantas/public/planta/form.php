<link rel="stylesheet" href="/mvcPlantas/public/assets/css/forms.css?v=1.0">

<h1><?= ($parametro != null) ? 'Editar Planta' : 'Nova Planta' ?></h1>

<?php if (isset($_GET['erro'])): ?>
    <div class="form-alert">
        ✗ <?= htmlspecialchars($_GET['erro']) ?>
    </div>
<?php endif; ?>

<form method="POST" action="/mvcPlantas/planta/<?= ($parametro != null) ? 'alterar' : 'inserir' ?>">
    
    <label for="nome_cientifico">Nome Científico:</label>
    <input 
        type="text" 
        id="nome_cientifico"
        name="nome_cientifico"
        value="<?= ($parametro != null) ? htmlspecialchars($parametro[0]["nome_cientifico"]) : "" ?>"
        required
        maxlength="150"
    />

    <label for="nome_popular">Nome Popular:</label>
    <input 
        type="text" 
        id="nome_popular"
        name="nome_popular"
        value="<?= ($parametro != null) ? htmlspecialchars($parametro[0]["nome_popular"]) : "" ?>"
        required
        maxlength="100"
    />

    <?php if ($parametro != null): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($parametro[0]["id"]) ?>"/>
    <?php endif; ?>

    <button type="submit">Salvar</button>
</form>

<p>
    <a href="/mvcPlantas/planta/lista">Voltar à lista</a>
</p>