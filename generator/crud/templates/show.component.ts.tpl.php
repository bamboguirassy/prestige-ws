import { Component, OnInit, OnDestroy } from '@angular/core';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './<?= strtolower($entity_class_name) ?>-show.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-show.component.css']
})
export class <?= $entity_class_name ?>ShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: <?= $entity_class_name ?>;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, <?= $entity_var_singular ?>Srv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


