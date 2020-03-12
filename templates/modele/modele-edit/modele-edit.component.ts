import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { ModeleService } from '../modele.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Modele } from '../modele';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './modele-edit.component.html',
  styleUrls: ['./modele-edit.component.css']
})
export class ModeleEditComponent extends BamboAbstractEditComponent<Modele> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public modeleSrv: ModeleService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, modeleSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
