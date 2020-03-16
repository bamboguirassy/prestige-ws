import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { MoyenPaiementService } from '../moyenpaiement.service';
import { MoyenPaiement } from '../moyenpaiement';
import { moyenPaiementColumns } from '../moyenpaiement.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { MoyenPaiementNewComponent } from '../moyenpaiement-new/moyenpaiement-new.component';
import { MoyenPaiementEditComponent } from '../moyenpaiement-edit/moyenpaiement-edit.component';
import { MoyenPaiementShowComponent } from '../moyenpaiement-show/moyenpaiement-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-moyenpaiement-list',
  templateUrl: './moyenpaiement-list.component.html',
  styleUrls: ['./moyenpaiement-list.component.css'],
  providers: [DialogService]
})
export class MoyenPaiementListComponent extends BamboAbstractListComponent<MoyenPaiement> implements OnInit, OnDestroy {

  constructor(public moyenPaiementSrv: MoyenPaiementService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(moyenPaiementSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = moyenPaiementColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des moyenPaiements' }
    ]);
    // set resource name
    this.resourceName = moyenPaiementSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(MoyenPaiementNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: MoyenPaiement) => {
      if (item) {
        this.items = [item, ...this.items];
        this.moyenPaiementSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(MoyenPaiementShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(MoyenPaiementEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: MoyenPaiement) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.moyenPaiementSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
