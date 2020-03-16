import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { Reglement } from '../reglement';
import { ReglementService } from '../reglement.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-reglement-new',
  templateUrl: './reglement-new.component.html',
  styleUrls: ['./reglement-new.component.css'],
  providers: [DialogService]
})
export class ReglementNewComponent extends BamboAbstractNewComponent<Reglement> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public reglementSrv: ReglementService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, reglementSrv, connectionService);
    this.item = new Reglement();
  }

  ngOnInit() {}

  prepareCreation() {}

}
