<link rel="stylesheet" href="/mvcPlantas/public/assets/css/forms.css?v=1.0">

<h1><?= ($parametro['cuidado'] != null) ? 'Editar Cuidado' : 'Novo Cuidado' ?></h1>

<?php if (isset($_GET['erro'])): ?>
    <div class="form-alert">
        ✗ <?= htmlspecialchars($_GET['erro']) ?>
    </div>
<?php endif; ?>

<form method="POST" action="/mvcPlantas/cuidado/<?= ($parametro['cuidado'] != null) ? 'alterar' : 'inserir' ?>">
    
    <label for="usuario_id">Usuário:</label>
    <select name="usuario_id" id="usuario_id" required>
        <option value="">Selecione um usuário...</option>
        <?php foreach($parametro['usuarios'] as $u): ?>
            <option value="<?= $u['id'] ?>" 
                <?= ($parametro['cuidado'] && $parametro['cuidado'][0]['usuario_id'] == $u['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($u['nome']) ?> (<?= htmlspecialchars($u['email']) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label for="planta_id">Planta:</label>
    <select name="planta_id" id="planta_id" required>
        <option value="">Selecione uma planta...</option>
        <?php foreach($parametro['plantas'] as $p): ?>
            <option value="<?= $p['id'] ?>"
                <?= ($parametro['cuidado'] && $parametro['cuidado'][0]['planta_id'] == $p['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['nome_popular']) ?> (<?= htmlspecialchars($p['nome_cientifico']) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label for="tipo_cuidado">Tipo de Cuidado:</label>
    <select name="tipo_cuidado" id="tipo_cuidado" required>
        <option value="">Selecione um tipo...</option>
        <?php 
        $tipos = ['Regar', 'Adubar', 'Podar', 'Trocar de vaso', 'Limpar folhas', 'Pulverizar água'];
        foreach($tipos as $tipo): 
            $selected = ($parametro['cuidado'] && $parametro['cuidado'][0]['tipo_cuidado'] == $tipo) ? 'selected' : '';
        ?>
            <option <?= $selected ?>><?= $tipo ?></option>
        <?php endforeach; ?>
    </select>

    <label for="frequencia">Frequência (em dias):</label>
    <input 
        type="number" 
        id="frequencia"
        name="frequencia"
        value="<?= ($parametro['cuidado'] != null) ? htmlspecialchars($parametro['cuidado'][0]["frequencia"]) : "7" ?>"
        required
        min="1"
        max="365"
    />

    <?php if ($parametro['cuidado'] != null): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($parametro['cuidado'][0]["id"]) ?>"/>
    <?php endif; ?>

    <button type="submit">Salvar</button>
</form>

<p>
    <a href="/mvcPlantas/cuidado/lista">Voltar à lista</a>
</p>