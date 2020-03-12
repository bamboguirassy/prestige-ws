import { Component, OnInit, OnDestroy } from '@angular/core';
import { BreadcrumbService } from 'src/app/shared/layouts/breadcrumb.service';
import { BamboAbstractListComponent } from 'src/app/shared/components/bambo-abstract-list/bambo-abstract-list.component';
import { ClientService } from '../client.service';
import { Client } from '../client';
import { clientColumns } from '../client.columns';
import { Router } from '@angular/router';
import { ConfirmationService, DialogService } from 'primeng/api';
import { ClientNewComponent } from '../client-new/client-new.component';
import { ClientEditComponent } from '../client-edit/client-edit.component';
import { ClientShowComponent } from '../client-show/client-show.component';
import { BamboAuthService } from 'src/app/shared/services/bambo-auth.service';
import { BamboConnectionStatusService } from 'src/app/shared/services/bambo-connection-status.service';

@Component({
  selector: 'app-client-list',
  templateUrl: './client-list.component.html',
  styleUrls: ['./client-list.component.css'],
  providers: [DialogService]
})
export class ClientListComponent extends BamboAbstractListComponent<Client> implements OnInit, OnDestroy {

  constructor(public clientSrv: ClientService, public breadcrumbService: BreadcrumbService,
              public router: Router, public confirmationService: ConfirmationService,
              public dialogService: DialogService, public authSrv: BamboAuthService,
              public connectionService: BamboConnectionStatusService) {
    super(clientSrv, breadcrumbService, router, confirmationService, dialogService, authSrv, connectionService);
    // set columns
    this.columns = clientColumns;
    // set breadcum
    this.breadcrumbService.setItems([
      { label: 'Configuration' },
      { label: 'Liste des clients' }
    ]);
    // set resource name
    this.resourceName = clientSrv.getResourceName();
  }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ClientNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Client) => {
      if (item) {
        this.items = [item, ...this.items];
        this.clientSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });

  }

  openDetailDialog() {
    this.dialogService.open(ClientShowComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto'}
    });
  }

  openEditFormDialog() {
    const ref = this.dialogService.open(ClientEditComponent, {
      data: { item: this.selectedItem },
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });

    ref.onClose.subscribe((item: Client) => {
      if (item) {
        const index = this.items.indexOf(item, 0);
        if (index > -1) {
          this.items[index] = item;
        }
        this.clientSrv.httpSrv.notificationSrv.success('Mise à jour effectuée');
      }
    });

  }

}
