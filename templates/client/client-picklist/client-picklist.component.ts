import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { ClientService } from '../client.service';
import { DialogService } from 'primeng/api';
import { ClientNewComponent } from '../client-new/client-new.component';
import { Client } from '../client';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-client-picklist',
  templateUrl: './client-picklist.component.html',
  styleUrls: ['./client-picklist.component.css'],
  providers: [DialogService]
})
export class ClientPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public clientSrv: ClientService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(clientSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
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

}
