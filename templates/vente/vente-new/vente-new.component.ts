import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Vente } from '../vente';
import { VenteService } from '../vente.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-vente-new',
  templateUrl: './vente-new.component.html',
  styleUrls: ['./vente-new.component.css'],
  providers: [DialogService]
})
export class VenteNewComponent extends BamboAbstractNewComponent<Vente> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public venteSrv: VenteService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, venteSrv, connectionService);
    this.item = new Vente();
  }

  ngOnInit() {}

  prepareCreation() {}

}
