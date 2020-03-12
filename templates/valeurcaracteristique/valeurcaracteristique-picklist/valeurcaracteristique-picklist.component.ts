import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { ValeurCaracteristiqueService } from '../valeurcaracteristique.service';
import { DialogService } from 'primeng/api';
import { ValeurCaracteristiqueNewComponent } from '../valeurcaracteristique-new/valeurcaracteristique-new.component';
import { ValeurCaracteristique } from '../valeurcaracteristique';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-valeurcaracteristique-picklist',
  templateUrl: './valeurcaracteristique-picklist.component.html',
  styleUrls: ['./valeurcaracteristique-picklist.component.css'],
  providers: [DialogService]
})
export class ValeurCaracteristiquePicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public valeurCaracteristiqueSrv: ValeurCaracteristiqueService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(valeurCaracteristiqueSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(ValeurCaracteristiqueNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: ValeurCaracteristique) => {
      if (item) {
        this.items = [item, ...this.items];
        this.valeurCaracteristiqueSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
