<div class="container">
    <div class="list-header">
        <h1 class="list-title">Lista de Plantas</h1>
        <a href="/mvcPlantas/planta/formulario" class="btn-new">+ Nova Planta</a>
    </div>

    <?php if (isset($_GET['info']) && $_GET['info'] == '1'): ?>
        <div class="alert alert-success">
            ✓ Planta cadastrada/atualizada com sucesso!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['info']) && $_GET['info'] == 'deleted'): ?>
        <div class="alert alert-warning">
            ⚠ Planta excluída com sucesso!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger">
            ✗ <?= htmlspecialchars($_GET['erro']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($parametro)): ?>
        <table>
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th>Nome Científico</th>
                    <th>Nome Popular</th>
                    <th class="col-actions">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($parametro as $p): ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($p["id"]) ?></td>
                        <td><em><?= htmlspecialchars($p["nome_cientifico"]) ?></em></td>
                        <td><strong><?= htmlspecialchars($p["nome_popular"]) ?></strong></td>
                        <td class="col-actions">
                            <a href="/mvcPlantas/planta/alterar-form?id=<?= $p["id"] ?>" class="btn-action">Editar</a>
                            <span class="btn-separator">|</span>
                            <button onclick="confirmarExclusao(<?= $p['id'] ?>, '<?= htmlspecialchars($p['nome_popular']) ?>')" class="btn-action">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>Nenhuma planta cadastrada.</p>
            <p>Clique em "+ Nova Planta" para começar.</p>
        </div>
    <?php endif; ?>

    <div class="list-footer">
        <a href="/mvcPlantas/" class="btn-back">Voltar ao início</a>
    </div>
</div>

<script>
    function confirmarExclusao(id, nome) {
        if (confirm('Tem certeza que deseja excluir a planta "' + nome + '"?\n\nAtenção: Só é possível excluir se não houver cuidados associados.')) {
            window.location.href = '/mvcPlantas/planta/excluir?id=' + id;
        }
    }
</script>