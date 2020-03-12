import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './<?= strtolower($entity_class_name) ?>-edit.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-edit.component.css']
})
export class <?= $entity_class_name ?>EditComponent extends BamboAbstractEditComponent<<?= $entity_class_name ?>> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, <?= $entity_var_singular ?>Srv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
