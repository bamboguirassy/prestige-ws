import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class <?= $entity_class_name ?> extends BamboObject {
    <?=  $entity_identifier ?>: any;
    <?php foreach ($entity_fields as $field): ?>
    <?php if($field['fieldName']!='id'){ ?>
                <?= $field['fieldName'] ?>: string;
                <?php } ?>
    <?php endforeach; ?>
    
    constructor() {
        super();
    }
}
