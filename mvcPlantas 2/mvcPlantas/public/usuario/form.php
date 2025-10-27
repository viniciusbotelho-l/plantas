<link rel="stylesheet" href="/mvcPlantas/public/assets/css/forms.css?v=1.0">

<h1><?= ($parametro != null) ? 'Editar Usuário' : 'Novo Usuário' ?></h1>

<?php if (isset($_GET['erro'])): ?>
    <div class="form-alert">
        ✗ <?= htmlspecialchars($_GET['erro']) ?>
    </div>
<?php endif; ?>

<form method="POST" action="/mvcPlantas/usuario/<?= ($parametro != null) ? 'alterar' : 'inserir' ?>">
    
    <label for="nome">Nome:</label>
    <input 
        type="text" 
        id="nome"
        name="nome"
        value="<?= ($parametro != null) ? htmlspecialchars($parametro[0]["nome"]) : "" ?>"
        required
        maxlength="100"
    />

    <label for="email">Email:</label>
    <input 
        type="email" 
        id="email"
        name="email"
        value="<?= ($parametro != null) ? htmlspecialchars($parametro[0]["email"]) : "" ?>"
        required
        maxlength="100"
    />

    <?php if ($parametro != null): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($parametro[0]["id"]) ?>"/>
    <?php endif; ?>

    <button type="submit">Salvar</button>
</form>

<p>
    <a href="/mvcPlantas/usuario/lista">Voltar à lista</a>
</p>