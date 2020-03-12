import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { ClientService } from '../client.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Client } from '../client';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './client-edit.component.html',
  styleUrls: ['./client-edit.component.css']
})
export class ClientEditComponent extends BamboAbstractEditComponent<Client> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public clientSrv: ClientService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, clientSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
