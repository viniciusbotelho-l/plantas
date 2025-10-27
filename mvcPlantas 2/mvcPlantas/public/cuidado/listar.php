<div class="container">
    <div class="list-header">
        <h1 class="list-title">Lista de Cuidados</h1>
        <a href="/mvcPlantas/cuidado/formulario" class="btn-new">+ Novo Cuidado</a>
    </div>

    <?php if (isset($_GET['info']) && $_GET['info'] == '1'): ?>
        <div class="alert alert-success">
            ✓ Cuidado cadastrado/atualizado com sucesso!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['info']) && $_GET['info'] == 'deleted'): ?>
        <div class="alert alert-warning">
            Cuidado excluído com sucesso!
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
                    <th>Usuário</th>
                    <th>Planta</th>
                    <th>Tipo de Cuidado</th>
                    <th>Frequência (dias)</th>
                    <th class="col-actions">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($parametro as $c): ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($c["id"]) ?></td>
                        <td><?= htmlspecialchars($c["usuario_id"]) ?></td>
                        <td><?= htmlspecialchars($c["planta_id"]) ?></td>
                        <td><?= htmlspecialchars($c["tipo_cuidado"]) ?></td>
                        <td><?= htmlspecialchars($c["frequencia"]) ?></td>
                        <td class="col-actions">
                            <a href="/mvcPlantas/cuidado/alterar-form?id=<?= $c["id"] ?>" class="btn-action">Editar</a>
                            <span class="btn-separator">|</span>
                            <button onclick="confirmarExclusao(<?= $c['id'] ?>)" class="btn-action">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>Nenhum cuidado cadastrado.</p>
            <p>Clique em "+ Novo Cuidado" para começar.</p>
        </div>
    <?php endif; ?>

    <div class="list-footer">
        <a href="/mvcPlantas/" class="btn-back">Voltar ao início</a>
    </div>
</div>

<script>
    function confirmarExclusao(id) {
        if (confirm('Tem certeza que deseja excluir este cuidado?')) {
            window.location.href = '/mvcPlantas/cuidado/excluir?id=' + id;
        }
    }
</script>