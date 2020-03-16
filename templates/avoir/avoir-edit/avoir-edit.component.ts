import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { AvoirService } from '../avoir.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { Avoir } from '../avoir';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './avoir-edit.component.html',
  styleUrls: ['./avoir-edit.component.css']
})
export class AvoirEditComponent extends BamboAbstractEditComponent<Avoir> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public avoirSrv: AvoirService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, avoirSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
