import { Component, OnInit, OnDestroy } from '@angular/core';
import { VenteProduit } from '../venteproduit';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { VenteProduitService } from '../venteproduit.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './venteproduit-show.component.html',
  styleUrls: ['./venteproduit-show.component.css']
})
export class VenteProduitShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: VenteProduit;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public venteProduitSrv: VenteProduitService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, venteProduitSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


