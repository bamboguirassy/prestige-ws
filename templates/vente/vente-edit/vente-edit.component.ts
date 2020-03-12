import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { VenteService } from '../vente.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Vente } from '../vente';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './vente-edit.component.html',
  styleUrls: ['./vente-edit.component.css']
})
export class VenteEditComponent extends BamboAbstractEditComponent<Vente> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public venteSrv: VenteService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, venteSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
