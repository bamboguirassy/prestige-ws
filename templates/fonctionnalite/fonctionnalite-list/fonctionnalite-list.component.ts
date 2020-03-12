import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { FonctionnaliteService } from '../fonctionnalite.service';
import { Fonctionnalite } from '../fonctionnalite';
import { fonctionnaliteColumns } from '../fonctionnalite.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { FonctionnaliteNewComponent } from '../fonctionnalite-new/fonctionnalite-new.component';
import { FonctionnaliteEditComponent } from '../fonctionnalite-edit/fonctionnalite-edit.component';
import { FonctionnaliteShowComponent } from '../fonctionnalite-show/fonctionnalite-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-fonctionnalite-list',
  templateUrl: './fonctionnalite-list.component.html',
  styleUrls: ['./fonctionnalite-list.component.css'],
  providers: [DialogService]
})
export class FonctionnaliteListComponent extends BamboAbstractListComponent<Fonctionnalite> implements OnInit, OnDestroy {

  constructor(public fonctionnaliteSrv: FonctionnaliteService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(fonctionnaliteSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = fonctionnaliteColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des fonctionnalites' }
    ]);
    // set resource name
    this.resourceName = fonctionnaliteSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(FonctionnaliteNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Fonctionnalite) => {
      if (item) {
        this.items.unshift(item);
        this.fonctionnaliteSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(FonctionnaliteShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(FonctionnaliteEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Fonctionnalite) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.fonctionnaliteSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
