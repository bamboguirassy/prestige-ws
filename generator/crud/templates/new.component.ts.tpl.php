import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-new',
  templateUrl: './<?= strtolower($entity_class_name) ?>-new.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-new.component.css'],
  providers: [DialogService]
})
export class <?= $entity_class_name ?>NewComponent extends BamboAbstractNewComponent<<?= $entity_class_name ?>> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, <?= $entity_var_singular ?>Srv, connectionService);
    this.item = new <?= $entity_class_name ?>();
  }

  ngOnInit() {}

  prepareCreation() {}

}
