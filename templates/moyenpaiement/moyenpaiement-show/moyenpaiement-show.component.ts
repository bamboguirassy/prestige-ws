import { Component, OnInit, OnDestroy } from '@angular/core';
import { MoyenPaiement } from '../moyenpaiement';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { MoyenPaiementService } from '../moyenpaiement.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './moyenpaiement-show.component.html',
  styleUrls: ['./moyenpaiement-show.component.css']
})
export class MoyenPaiementShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: MoyenPaiement;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public moyenPaiementSrv: MoyenPaiementService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, moyenPaiementSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


