import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { VenteProduitService } from '../venteproduit.service';
import { VenteProduit } from '../venteproduit';
import { venteProduitColumns } from '../venteproduit.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { VenteProduitNewComponent } from '../venteproduit-new/venteproduit-new.component';
import { VenteProduitEditComponent } from '../venteproduit-edit/venteproduit-edit.component';
import { VenteProduitShowComponent } from '../venteproduit-show/venteproduit-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-venteproduit-list',
  templateUrl: './venteproduit-list.component.html',
  styleUrls: ['./venteproduit-list.component.css'],
  providers: [DialogService]
})
export class VenteProduitListComponent extends BamboAbstractListComponent<VenteProduit> implements OnInit, OnDestroy {

  constructor(public venteProduitSrv: VenteProduitService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(venteProduitSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = venteProduitColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des venteProduits' }
    ]);
    // set resource name
    this.resourceName = venteProduitSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(VenteProduitNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: VenteProduit) => {
      if (item) {
        this.items = [item, ...this.items];
        this.venteProduitSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(VenteProduitShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(VenteProduitEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: VenteProduit) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.venteProduitSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
