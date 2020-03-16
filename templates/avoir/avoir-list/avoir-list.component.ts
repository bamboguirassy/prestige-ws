import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { AvoirService } from '../avoir.service';
import { Avoir } from '../avoir';
import { avoirColumns } from '../avoir.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { AvoirNewComponent } from '../avoir-new/avoir-new.component';
import { AvoirEditComponent } from '../avoir-edit/avoir-edit.component';
import { AvoirShowComponent } from '../avoir-show/avoir-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-avoir-list',
  templateUrl: './avoir-list.component.html',
  styleUrls: ['./avoir-list.component.css'],
  providers: [DialogService]
})
export class AvoirListComponent extends BamboAbstractListComponent<Avoir> implements OnInit, OnDestroy {

  constructor(public avoirSrv: AvoirService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(avoirSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = avoirColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des avoirs' }
    ]);
    // set resource name
    this.resourceName = avoirSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(AvoirNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Avoir) => {
      if (item) {
        this.items = [item, ...this.items];
        this.avoirSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(AvoirShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(AvoirEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Avoir) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.avoirSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
