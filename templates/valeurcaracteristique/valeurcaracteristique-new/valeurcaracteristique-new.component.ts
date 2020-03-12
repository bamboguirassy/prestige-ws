import { Component, OnInit } from '@angular/core';
import { DynamicDialogRef, DynamicDialogConfig, DialogService } from 'primeng/api';
import { ValeurCaracteristique } from '../valeurcaracteristique';
import { ValeurCaracteristiqueService } from '../valeurcaracteristique.service';
import { BamboAbstractNewComponent } from 'src/app/shared/components/bambo-abstract-new/bambo-abstract-new.component';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-valeurcaracteristique-new',
  templateUrl: './valeurcaracteristique-new.component.html',
  styleUrls: ['./valeurcaracteristique-new.component.css'],
  providers: [DialogService]
})
export class ValeurCaracteristiqueNewComponent extends BamboAbstractNewComponent<ValeurCaracteristique> implements OnInit {


  constructor(public ref: DynamicDialogRef, public dialogConfig: DynamicDialogConfig,
              public valeurCaracteristiqueSrv: ValeurCaracteristiqueService,
              public connectionService: ConnectionService) {
    super(ref, dialogConfig, valeurCaracteristiqueSrv, connectionService);
    this.item = new ValeurCaracteristique();
  }

  ngOnInit() {}

  prepareCreation() {}

}
