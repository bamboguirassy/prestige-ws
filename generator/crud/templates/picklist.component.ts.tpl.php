import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { DialogService } from 'primeng/api';
import { <?= $entity_class_name ?>NewComponent } from '../<?= strtolower($entity_class_name) ?>-new/<?= strtolower($entity_class_name) ?>-new.component';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-picklist',
  templateUrl: './<?= strtolower($entity_class_name) ?>-picklist.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-picklist.component.css'],
  providers: [DialogService]
})
export class <?= $entity_class_name ?>PicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(<?= $entity_var_singular ?>Srv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(<?= $entity_class_name ?>NewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: <?= $entity_class_name ?>) => {
      if (item) {
        this.items = [item, ...this.items];
        this.<?= $entity_var_singular ?>Srv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
