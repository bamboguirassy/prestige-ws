import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { MoyenPaiementService } from '../moyenpaiement.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { MoyenPaiement } from '../moyenpaiement';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './moyenpaiement-edit.component.html',
  styleUrls: ['./moyenpaiement-edit.component.css']
})
export class MoyenPaiementEditComponent extends BamboAbstractEditComponent<MoyenPaiement> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public moyenPaiementSrv: MoyenPaiementService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, moyenPaiementSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
