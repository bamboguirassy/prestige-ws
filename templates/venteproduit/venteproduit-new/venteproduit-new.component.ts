import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { VenteProduit } from '../venteproduit';
import { VenteProduitService } from '../venteproduit.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-venteproduit-new',
  templateUrl: './venteproduit-new.component.html',
  styleUrls: ['./venteproduit-new.component.css'],
  providers: [DialogService]
})
export class VenteProduitNewComponent extends BamboAbstractNewComponent<VenteProduit> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public venteProduitSrv: VenteProduitService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, venteProduitSrv, connectionService);
    this.item = new VenteProduit();
  }

  ngOnInit() {}

  prepareCreation() {}

}
