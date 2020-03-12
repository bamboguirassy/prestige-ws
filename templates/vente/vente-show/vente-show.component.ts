import { Component, OnInit, OnDestroy } from '@angular/core';
import { Vente } from '../vente';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { VenteService } from '../vente.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './vente-show.component.html',
  styleUrls: ['./vente-show.component.css']
})
export class VenteShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Vente;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public venteSrv: VenteService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, venteSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


