import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { CategorieProduitService } from '../categorieproduit.service';
import { CategorieProduit } from '../categorieproduit';
import { categorieProduitColumns } from '../categorieproduit.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { CategorieProduitNewComponent } from '../categorieproduit-new/categorieproduit-new.component';
import { CategorieProduitEditComponent } from '../categorieproduit-edit/categorieproduit-edit.component';
import { CategorieProduitShowComponent } from '../categorieproduit-show/categorieproduit-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-categorieproduit-list',
  templateUrl: './categorieproduit-list.component.html',
  styleUrls: ['./categorieproduit-list.component.css'],
  providers: [DialogService]
})
export class CategorieProduitListComponent extends BamboAbstractListComponent<CategorieProduit> implements OnInit, OnDestroy {

  constructor(public categorieProduitSrv: CategorieProduitService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(categorieProduitSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = categorieProduitColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des categorieProduits' }
    ]);
    // set resource name
    this.resourceName = categorieProduitSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(CategorieProduitNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: CategorieProduit) => {
      if (item) {
        this.items.unshift(item);
        this.categorieProduitSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(CategorieProduitShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(CategorieProduitEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: CategorieProduit) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.categorieProduitSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
