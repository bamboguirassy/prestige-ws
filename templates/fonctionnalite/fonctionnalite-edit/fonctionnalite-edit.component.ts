import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { FonctionnaliteService } from '../fonctionnalite.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Fonctionnalite } from '../fonctionnalite';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './fonctionnalite-edit.component.html',
  styleUrls: ['./fonctionnalite-edit.component.css']
})
export class FonctionnaliteEditComponent extends BamboAbstractEditComponent<Fonctionnalite> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public fonctionnaliteSrv: FonctionnaliteService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, fonctionnaliteSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
