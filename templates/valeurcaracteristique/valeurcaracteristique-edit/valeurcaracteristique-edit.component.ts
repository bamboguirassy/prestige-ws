import { Component, OnInit } from '@angular/core';
import { BamboAbstractEditComponent } from 'src/app/shared/components/bambo-abstract-edit/bambo-abstract-edit.component';
import { ValeurCaracteristiqueService } from '../valeurcaracteristique.service';
import { DynamicDialogRef, DynamicDialogConfig } from 'primeng/api';
import { ValeurCaracteristique } from '../valeurcaracteristique';
import { ConnectionService } from 'ng-connection-service';


@Component({
  templateUrl: './valeurcaracteristique-edit.component.html',
  styleUrls: ['./valeurcaracteristique-edit.component.css']
})
export class ValeurCaracteristiqueEditComponent extends BamboAbstractEditComponent<ValeurCaracteristique> implements OnInit {

  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public valeurCaracteristiqueSrv: ValeurCaracteristiqueService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, valeurCaracteristiqueSrv, connectionService);
  }

  ngOnInit() {}

  prepareUpdate() {}

}
