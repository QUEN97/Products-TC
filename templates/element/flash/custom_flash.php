<?php
// Este archivo está para personalizar el diseño de los mensajes Flash con Tailwind
?>
<?php if ($messages): ?>
    <div class="space-y-4">
        <?php foreach ($messages as $type => $message): ?>
            <div class="alert alert-<?= h($type) ?>">
                <div class="px-4 py-2 text-white <?= $type === 'success' ? 'bg-green-500' : ($type === 'error' ? 'bg-red-500' : 'bg-yellow-500') ?> rounded-lg shadow-lg">
                    <?php echo h($message); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>