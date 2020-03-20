import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { FournisseurService } from '../fournisseur.service';
import { DialogService } from 'primeng/api';
import { FournisseurNewComponent } from '../fournisseur-new/fournisseur-new.component';
import { Fournisseur } from '../fournisseur';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-fournisseur-picklist',
  templateUrl: './fournisseur-picklist.component.html',
  styleUrls: ['./fournisseur-picklist.component.css'],
  providers: [DialogService]
})
export class FournisseurPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public fournisseurSrv: FournisseurService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(fournisseurSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(FournisseurNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: Fournisseur) => {
      if (item) {
        this.items = [item, ...this.items];
        this.fournisseurSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
