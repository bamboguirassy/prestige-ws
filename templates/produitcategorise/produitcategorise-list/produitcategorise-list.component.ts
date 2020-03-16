import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { ProduitCategoriseService } from '../produitcategorise.service';
import { ProduitCategorise } from '../produitcategorise';
import { produitCategoriseColumns } from '../produitcategorise.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { ProduitCategoriseNewComponent } from '../produitcategorise-new/produitcategorise-new.component';
import { ProduitCategoriseEditComponent } from '../produitcategorise-edit/produitcategorise-edit.component';
import { ProduitCategoriseShowComponent } from '../produitcategorise-show/produitcategorise-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-produitcategorise-list',
  templateUrl: './produitcategorise-list.component.html',
  styleUrls: ['./produitcategorise-list.component.css'],
  providers: [DialogService]
})
export class ProduitCategoriseListComponent extends BamboAbstractListComponent<ProduitCategorise> implements OnInit, OnDestroy {

  constructor(public produitCategoriseSrv: ProduitCategoriseService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(produitCategoriseSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = produitCategoriseColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des produitCategorises' }
    ]);
    // set resource name
    this.resourceName = produitCategoriseSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ProduitCategoriseNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: ProduitCategorise) => {
      if (item) {
        this.items = [item, ...this.items];
        this.produitCategoriseSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(ProduitCategoriseShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(ProduitCategoriseEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: ProduitCategorise) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.produitCategoriseSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
