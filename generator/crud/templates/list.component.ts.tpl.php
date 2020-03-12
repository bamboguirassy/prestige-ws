import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { <?= $entity_var_singular ?>Columns } from '../<?= strtolower($entity_class_name) ?>.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { <?= $entity_class_name ?>NewComponent } from '../<?= strtolower($entity_class_name) ?>-new/<?= strtolower($entity_class_name) ?>-new.component';
import { <?= $entity_class_name ?>EditComponent } from '../<?= strtolower($entity_class_name) ?>-edit/<?= strtolower($entity_class_name) ?>-edit.component';
import { <?= $entity_class_name ?>ShowComponent } from '../<?= strtolower($entity_class_name) ?>-show/<?= strtolower($entity_class_name) ?>-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-list',
  templateUrl: './<?= strtolower($entity_class_name) ?>-list.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-list.component.css'],
  providers: [DialogService]
})
export class <?= $entity_class_name ?>ListComponent extends BamboAbstractListComponent<<?= $entity_class_name ?>> implements OnInit, OnDestroy {

  constructor(public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(<?= $entity_var_singular ?>Srv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = <?= $entity_var_singular ?>Columns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des <?= $entity_var_plural ?>' }
    ]);
    // set resource name
    this.resourceName = <?= $entity_var_singular ?>Srv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
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

  openDetailDialog() {
    this.dialogService.open(<?= $entity_class_name ?>ShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(<?= $entity_class_name ?>EditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: <?= $entity_class_name ?>) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.<?= $entity_var_singular ?>Srv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
