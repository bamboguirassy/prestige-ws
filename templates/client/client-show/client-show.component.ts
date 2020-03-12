import { Component, OnInit, OnDestroy } from '@angular/core';
import { Client } from '../client';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ClientService } from '../client.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './client-show.component.html',
  styleUrls: ['./client-show.component.css']
})
export class ClientShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Client;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public clientSrv: ClientService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, clientSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


