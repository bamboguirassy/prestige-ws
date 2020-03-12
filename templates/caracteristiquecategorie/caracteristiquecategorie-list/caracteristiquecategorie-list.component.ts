import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { CaracteristiqueCategorieService } from '../caracteristiquecategorie.service';
import { CaracteristiqueCategorie } from '../caracteristiquecategorie';
import { caracteristiqueCategorieColumns } from '../caracteristiquecategorie.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { CaracteristiqueCategorieNewComponent } from '../caracteristiquecategorie-new/caracteristiquecategorie-new.component';
import { CaracteristiqueCategorieEditComponent } from '../caracteristiquecategorie-edit/caracteristiquecategorie-edit.component';
import { CaracteristiqueCategorieShowComponent } from '../caracteristiquecategorie-show/caracteristiquecategorie-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-caracteristiquecategorie-list',
  templateUrl: './caracteristiquecategorie-list.component.html',
  styleUrls: ['./caracteristiquecategorie-list.component.css'],
  providers: [DialogService]
})
export class CaracteristiqueCategorieListComponent extends BamboAbstractListComponent<CaracteristiqueCategorie> implements OnInit, OnDestroy {

  constructor(public caracteristiqueCategorieSrv: CaracteristiqueCategorieService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(caracteristiqueCategorieSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = caracteristiqueCategorieColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des caracteristiqueCategories' }
    ]);
    // set resource name
    this.resourceName = caracteristiqueCategorieSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(CaracteristiqueCategorieNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: CaracteristiqueCategorie) => {
      if (item) {
        this.items = [item, ...this.items];
        this.caracteristiqueCategorieSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(CaracteristiqueCategorieShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(CaracteristiqueCategorieEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: CaracteristiqueCategorie) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.caracteristiqueCategorieSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
