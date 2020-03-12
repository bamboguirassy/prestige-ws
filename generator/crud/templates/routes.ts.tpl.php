import { Route } from '@angular/router';
import { <?= $entity_class_name ?>ListComponent } from './<?= strtolower($entity_class_name) ?>-list/<?= strtolower($entity_class_name) ?>-list.component';

const <?= $entity_var_singular ?>Routes: Route = {
    path: '<?= strtolower($entity_class_name) ?>',
    children: [
        { path: '', component: <?= $entity_class_name ?>ListComponent }
    ]
};

export { <?= $entity_var_singular ?>Routes };
