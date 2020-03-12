import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Client } from '../client';
import { ClientService } from '../client.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-client-new',
  templateUrl: './client-new.component.html',
  styleUrls: ['./client-new.component.css'],
  providers: [DialogService]
})
export class ClientNewComponent extends BamboAbstractNewComponent<Client> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public clientSrv: ClientService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, clientSrv, connectionService);
    this.item = new Client();
  }

  ngOnInit() {}

  prepareCreation() {}

}
