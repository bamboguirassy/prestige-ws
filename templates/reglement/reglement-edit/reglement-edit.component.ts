import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { ReglementService } from '../reglement.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Reglement } from '../reglement';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './reglement-edit.component.html',
  styleUrls: ['./reglement-edit.component.css']
})
export class ReglementEditComponent extends BamboAbstractEditComponent<Reglement> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public reglementSrv: ReglementService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, reglementSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
