import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { VenteProduitService } from '../venteproduit.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { VenteProduit } from '../venteproduit';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './venteproduit-edit.component.html',
  styleUrls: ['./venteproduit-edit.component.css']
})
export class VenteProduitEditComponent extends BamboAbstractEditComponent<VenteProduit> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public venteProduitSrv: VenteProduitService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, venteProduitSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
