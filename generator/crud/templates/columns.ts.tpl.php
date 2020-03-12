export const <?= $entity_var_singular ?>Columns = [
<?php foreach ($entity_fields as $field): ?>
<?php if($field['fieldName']!='id'){ ?>
    { header: '<?= ucfirst($field['fieldName']) ?>', field: '<?= $field['fieldName'] ?>', dataKey: '<?= $field['fieldName'] ?>' },
<?php } ?>
        <?php endforeach; ?>
];
