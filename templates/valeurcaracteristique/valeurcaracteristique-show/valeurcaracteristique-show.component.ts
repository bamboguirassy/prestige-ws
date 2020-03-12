import { Component, OnInit, OnDestroy } from '@angular/core';
import { ValeurCaracteristique } from '../valeurcaracteristique';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ValeurCaracteristiqueService } from '../valeurcaracteristique.service';
import { BamboAbstractShowComponent } from 'src/app/shared/components/bambo-abstract-show/bambo-abstract-show.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  templateUrl: './valeurcaracteristique-show.component.html',
  styleUrls: ['./valeurcaracteristique-show.component.css']
})
export class ValeurCaracteristiqueShowComponent extends BamboAbstractShowComponent implements OnInit, OnDestroy {
  item: ValeurCaracteristique;

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public valeurCaracteristiqueSrv: ValeurCaracteristiqueService,
              public connectionService: ConnectionService) {
                super(ref, dialogConfig, valeurCaracteristiqueSrv, connectionService);
              }

  ngOnInit() {
    super.ngOnInit();
  }

  ngOnDestroy() {
    super.ngOnDestroy();
  }

}


