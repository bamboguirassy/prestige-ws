import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { ValeurCaracteristiqueService } from '../valeurcaracteristique.service';
import { ValeurCaracteristique } from '../valeurcaracteristique';
import { valeurCaracteristiqueColumns } from '../valeurcaracteristique.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { ValeurCaracteristiqueNewComponent } from '../valeurcaracteristique-new/valeurcaracteristique-new.component';
import { ValeurCaracteristiqueEditComponent } from '../valeurcaracteristique-edit/valeurcaracteristique-edit.component';
import { ValeurCaracteristiqueShowComponent } from '../valeurcaracteristique-show/valeurcaracteristique-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-valeurcaracteristique-list',
  templateUrl: './valeurcaracteristique-list.component.html',
  styleUrls: ['./valeurcaracteristique-list.component.css'],
  providers: [DialogService]
})
export class ValeurCaracteristiqueListComponent extends BamboAbstractListComponent<ValeurCaracteristique> implements OnInit, OnDestroy {

  constructor(public valeurCaracteristiqueSrv: ValeurCaracteristiqueService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(valeurCaracteristiqueSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = valeurCaracteristiqueColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des valeurCaracteristiques' }
    ]);
    // set resource name
    this.resourceName = valeurCaracteristiqueSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ValeurCaracteristiqueNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: ValeurCaracteristique) => {
      if (item) {
        this.items = [item, ...this.items];
        this.valeurCaracteristiqueSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(ValeurCaracteristiqueShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(ValeurCaracteristiqueEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: ValeurCaracteristique) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.valeurCaracteristiqueSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
