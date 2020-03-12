import { Component, OnInit, OnDestroy } from '@angular/core';
import { Fonctionnalite } from '../fonctionnalite';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { FonctionnaliteService } from '../fonctionnalite.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './fonctionnalite-show.component.html',
  styleUrls: ['./fonctionnalite-show.component.css']
})
export class FonctionnaliteShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Fonctionnalite;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public fonctionnaliteSrv: FonctionnaliteService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, fonctionnaliteSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


