<div class="container">
    <div class="list-header">
        <h1 class="list-title">Lista de Usuários</h1>
        <a href="/mvcPlantas/usuario/formulario" class="btn-new">+ Novo Usuário</a>
    </div>

    <?php if (isset($_GET['info']) && $_GET['info'] == '1'): ?>
        <div class="alert alert-success">
            ✓ Usuário cadastrado/atualizado com sucesso!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['info']) && $_GET['info'] == 'deleted'): ?>
        <div class="alert alert-warning">
            ⚠ Usuário excluído com sucesso!
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
                    <th>Nome</th>
                    <th>Email</th>
                    <th class="col-actions">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($parametro as $u): ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($u["id"]) ?></td>
                        <td><strong><?= htmlspecialchars($u["nome"]) ?></strong></td>
                        <td><?= htmlspecialchars($u["email"]) ?></td>
                        <td class="col-actions">
                            <a href="/mvcPlantas/usuario/alterar-form?id=<?= $u["id"] ?>" class="btn-action">Editar</a>
                            <span class="btn-separator">|</span>
                            <button onclick="confirmarExclusao(<?= $u['id'] ?>, '<?= htmlspecialchars($u['nome']) ?>')" class="btn-action">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>Nenhum usuário cadastrado.</p>
            <p>Clique em "+ Novo Usuário" para começar.</p>
        </div>
    <?php endif; ?>

    <div class="list-footer">
        <a href="/mvcPlantas/" class="btn-back">Voltar ao início</a>
    </div>
</div>

<script>
    function confirmarExclusao(id, nome) {
        if (confirm('Tem certeza que deseja excluir o usuário "' + nome + '"?\n\nAtenção: Só é possível excluir se não houver cuidados associados.')) {
            window.location.href = '/mvcPlantas/usuario/excluir?id=' + id;
        }
    }
</script>