import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { ReglementService } from '../reglement.service';
import { Reglement } from '../reglement';
import { reglementColumns } from '../reglement.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { ReglementNewComponent } from '../reglement-new/reglement-new.component';
import { ReglementEditComponent } from '../reglement-edit/reglement-edit.component';
import { ReglementShowComponent } from '../reglement-show/reglement-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-reglement-list',
  templateUrl: './reglement-list.component.html',
  styleUrls: ['./reglement-list.component.css'],
  providers: [DialogService]
})
export class ReglementListComponent extends BamboAbstractListComponent<Reglement> implements OnInit, OnDestroy {

  constructor(public reglementSrv: ReglementService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(reglementSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = reglementColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des reglements' }
    ]);
    // set resource name
    this.resourceName = reglementSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ReglementNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Reglement) => {
      if (item) {
        this.items = [item, ...this.items];
        this.reglementSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(ReglementShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(ReglementEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Reglement) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.reglementSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
