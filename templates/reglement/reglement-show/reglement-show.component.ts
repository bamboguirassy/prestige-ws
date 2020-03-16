import { Component, OnInit, OnDestroy } from '@angular/core';
import { Reglement } from '../reglement';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ReglementService } from '../reglement.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './reglement-show.component.html',
  styleUrls: ['./reglement-show.component.css']
})
export class ReglementShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Reglement;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public reglementSrv: ReglementService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, reglementSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


