import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { MoyenPaiementService } from '../moyenpaiement.service';
import { DialogService } from 'primeng/api';
import { MoyenPaiementNewComponent } from '../moyenpaiement-new/moyenpaiement-new.component';
import { MoyenPaiement } from '../moyenpaiement';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-moyenpaiement-picklist',
  templateUrl: './moyenpaiement-picklist.component.html',
  styleUrls: ['./moyenpaiement-picklist.component.css'],
  providers: [DialogService]
})
export class MoyenPaiementPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public moyenPaiementSrv: MoyenPaiementService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(moyenPaiementSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(MoyenPaiementNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: MoyenPaiement) => {
      if (item) {
        this.items = [item, ...this.items];
        this.moyenPaiementSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
