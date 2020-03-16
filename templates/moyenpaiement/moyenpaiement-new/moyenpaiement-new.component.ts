import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { MoyenPaiement } from '../moyenpaiement';
import { MoyenPaiementService } from '../moyenpaiement.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-moyenpaiement-new',
  templateUrl: './moyenpaiement-new.component.html',
  styleUrls: ['./moyenpaiement-new.component.css'],
  providers: [DialogService]
})
export class MoyenPaiementNewComponent extends BamboAbstractNewComponent<MoyenPaiement> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public moyenPaiementSrv: MoyenPaiementService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, moyenPaiementSrv, connectionService);
    this.item = new MoyenPaiement();
  }

  ngOnInit() {}

  prepareCreation() {}

}
