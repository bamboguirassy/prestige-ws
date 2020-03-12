import { Component, OnInit, OnDestroy } from '@angular/core';
import { Modele } from '../modele';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ModeleService } from '../modele.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './modele-show.component.html',
  styleUrls: ['./modele-show.component.css']
})
export class ModeleShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: Modele;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public modeleSrv: ModeleService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, modeleSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


